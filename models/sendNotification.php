<?php
/**
 *
 */
include '../config.php';

function sendNotification($tokensArray, $msg, $notificationUrl, $key, $id) {
    // API access key from Google API's Console
    define('API_ACCESS_KEY', 'AIzaSyB7lbQ6Wc8FqEg4MVM12uPK15DuavsA27o');

    // notification fields
    $fields = json_encode(
      array(
        'registration_ids' => $tokensArray,
        'priority' => 10,
        'data' => array(
          'url' => $notificationUrl,
          'body'         => $msg,
        )
      )
    );

    $headers = array(
      'Authorization: key=' . API_ACCESS_KEY,
      'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    curl_close($ch);

    // Insert to the db
    $date = date('d/m/y h:i:s');

    $queryRes=mysqli_query("INSERT INTO `notification` (`msg`, `key`, `rideID`, `date`)
      VALUES ('".$msg."', '".$key."', '".$id."', '".$date."')");
}


if($_POST['rideID'] != NULL && $_POST['key'] != NULL) {
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $id   = $_POST['rideID'];
  $msg  = $_POST['message'];
  $key  = $_POST['key'];

  $ride = mysqli_query($con, "SELECT * FROM `rides` WHERE `ID` = '".$id."'");
  $rows = mysqli_num_rows($ride);

  if($rows > 0)
  {
    $ride  = mysqli_fetch_array($ride);
    $notificationUrl = '';
    if($key == 2)
    {
      $owner = $ride['owner'];

      // TODO: consider change the owner column to owner-phone
      // Get the owner details
      $user = mysqli_query($con, "SELECT * FROM `users` WHERE `fullName` = '".$owner."'");
      $user = mysqli_fetch_array($user);
      $notificationUrl = 'http://mipanooy.mobi/rides/ChooseDriver/'.$id;
    } elseif ($key == 3) {
      $driver = $ride['driverID'];

      // Get the driver details
      $user = mysqli_query($con, "SELECT * FROM `users` WHERE `ID` = '".$driver."'");
      $user = mysqli_fetch_array($user);
      $notificationUrl = 'http://mipanooy.mobi/rides/MyRides';
    }

    // Get the token
    $token = mysqli_query($con, "SELECT `token` FROM `fcm-users` WHERE `phone` = '".$user['phone']."'");
    $token = mysqli_fetch_array($token);
    $tokensArray = array($token['token']);
    error_log('tokensArray'.json_encode($tokensArray));

    // send the notification
    sendNotification($tokensArray, $msg, $notificationUrl, $key, $id);

    // send notification to not chosen drivers
    if($key == 3) {
      $drivers = mysqli_query($con, "SELECT * FROM `drive` AS d INNER JOIN `users` AS u ON d.driverID = u.ID INNER JOIN `fcm-users` AS f ON u.phone = f.phone  WHERE d.rideID = '".$id."' AND d.driverID != '".$user['ID']."'");
      $rows = mysqli_num_rows($drivers);
      if ($rows > 0) {
        $tokensArray = [];
        while($driver = mysqli_fetch_array($drivers)) {
          $tokensArray[] = $driver['token'];
        }
        sendNotification($tokensArray, 'נהג אחר נבחר לביצוע הנסיעה. פעם הבאה!', $notificationUrl, $key, $id);
      }
    }
  }
  mysqli_close($con);
}
