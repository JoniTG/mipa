<?php
// Login to the db
include '../config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');

if(mysqli_connect_errno())
  die();

// Import notifications handling page
include './sendNotification.php';

function notifyDriver($driver, $ride) {
  $user = mysqli_query($con, "SELECT * FROM `users` WHERE `ID` = '".$driver."'");
  $user = mysqli_fetch_array($user);
  $key  = 3;

  $token       = mysqli_query($con, "SELECT `token` FROM `fcm-users` WHERE `phone` = '".$user['phone']."'");
  $token       = mysqli_fetch_array($token);
  $tokensArray = array($token['token']);

  $msg             = 'נבחרת לביצוע הנסיעה!';
  $notificationUrl = 'http://mipanooy.mobi/rides/MyRides';


  // Send notification to the driver
  sendNotification($tokensArray, $msg, $notificationUrl, $key, $ride);
}

function notifyOwner($name, $ride) {
  $owner = mysqli_query($con, "SELECT * FROM `users` WHERE `fullName` = '".$name."'");
  $owner = mysqli_fetch_array($owner);
  $key   = 3;

  $token       = mysqli_query($con, "SELECT `token` FROM `fcm-users` WHERE `phone` = '".$owner['phone']."'");
  $token       = mysqli_fetch_array($token);
  $tokensArray = array($token['token']);

  $msg             = 'נבחר נהג לנסיעה שלך!';
  $notificationUrl = 'http://mipanooy.mobi/rides/ChooseDriver/'.$ride;

  // Send notifiction to the owner
  sendNotification($tokensArray, $msg, $notificationUrl, $key, $ride);
}

function notifyOthers($chosen, $ride) {
  $drivers = mysqli_query($con, "SELECT * FROM `drive` AS d INNER JOIN `users` AS u ON d.driverID = u.ID INNER JOIN `fcm-users` AS f ON u.phone = f.phone  WHERE d.rideID = '".$ride."' AND d.driverID != '".$chosen."'");
  $rows    = mysqli_num_rows($drivers);
  $key     = 3;

  if($rows > 0)
  {
    $tokensArray = array();
    while($driver = mysqli_fetch_array($drivers)) {
      $tokensArray[] = $driver['token'];
    }

    $msg             = 'נהג אחר נבחר לביצוע הנסיעה. פעם הבאה!';
    $notificationUrl = 'http://mipanooy.mobi/';

    sendNotification($tokensArray, $msg, $notificationUrl, $key, $ride);
  }

}

// SELECT all the open rides
$rides = mysqli_query($con, "SELECT * FROM `rides` WHERE `driverID` = 0");
while($temp = mysqli_fetch_assoc($rides))
{
  // Check if 1 driver at least suggested himself to the ride
  $drivers = mysqli_query($con, "SELECT * FROM `drive` WHERE `rideID` = '".$temp['ID']."'");
  $rows    = mysqli_num_rows($drivers);

  if($rows >= 1)
  {
    $min   = 0;
    $array = array(
      'drivers'  => array(),
      'lastRide' => array()
    );

    // Check the last ride that a driver took
    while($tmp = mysqli_fetch_assoc($drivers))
    {
      $lastRide = mysqli_query($con, "SELECT * FROM `rides`
                                      WHERE `driverID` = '".$tmp['driverID']."'
                                      ORDER BY `ID` DESC LIMIT 1");
      $row      = mysqli_num_rows($lastRide);
      $lastRide = mysqli_fetch_array($lastRide);

      // The system choose driver
      if($row == 0)
      {
        // Add driver to ride
        mysqli_query($con, "UPDATE `rides` SET `driverID` = '".$tmp['driverID']."',
                    `lastAction` = CURDATE(), `deliverTime` = CURRENT_TIMESTAMP
                    WHERE `ID` = '".$temp['ID']."'");

        mysqli_query($con, "INSERT INTO `messages` (`driverID`, `rideID`, `msgType`)
          VALUES ('".$tmp['driverID']."', '".$temp['ID']."', 1)");

        // Send notifictions
        notifyDriver($tmp['driverID'], $temp['ID']);
        notifyOwner($temp['owner'], $temp['ID']);
        notifyOthers($tmp['driverID'], $temp['ID']);
      } else {
        $array['drivers'][]  = $tmp['driverID'];
        $array['lastRide'][] = $lastRide['ID'];
      }

    }

    $min = min($array['lastRide']);
    $i   = 0;

    foreach ($array['lastRide'] as $value) {
      $i++;

      if($min == $value)
        break;
    }

    // System chose the driver
    $chosenDriver = $array['drivers'][$i];

    // Add driver to the ride
    mysqli_query($con, "UPDATE `rides` SET `driverID` = '".$chosenDriver."',
                `lastAction` = CURDATE(), `deliverTime` = CURRENT_TIMESTAMP
                WHERE `ID` = '".$temp['ID']."'");

    mysqli_query($con, "INSERT INTO `messages` (`driverID`, `rideID`, `msgType`)
      VALUES ('".$chosenDriver."', '".$temp['ID']."', 1)");

    // Send notifictions
    notifyDriver($chosenDriver, $temp['ID']);
    notifyOwner($temp['owner'], $temp['ID']);
    notifyOthers($chosenDriver, $temp['ID']);
  }
}
