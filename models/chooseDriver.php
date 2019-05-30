<?php
include '../config.php';
if($_POST['rideID'] != NULL && $_POST['fullName'] != NULL && $_POST['id'] != NULL)
{
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $ride   = $_POST['rideID'];
  $name   = $_POST['fullName'];
  $driver = $_POST['id'];

  $query = mysqli_query($con, "SELECT * FROM `rides` WHERE `ID` = '".$ride."' AND `owner` = '".$name."'");
  $rows  = mysqli_num_rows($query);

  if($rows > 0)
  {
      mysqli_query($con, "UPDATE `rides` SET `driverID` = '".$driver."',
                  `lastAction` = CURDATE(), `deliverTime` = CURRENT_TIMESTAMP
                  WHERE `ID` = '".$ride."'");

      mysqli_query($con, "INSERT INTO `messages` (`driverID`, `rideID`, `msgType`)
        VALUES ('".$driver."', '".$ride."', 1)");

      $user = mysqli_query($con, "SELECT `ID`, `fullName`, `phone`, `rate`, `rates`, `car`
                                  FROM `users` WHERE `ID` = '".$driver."'");
      $user = mysqli_fetch_array($user);

      $json = json_encode($user);
      echo $json;
  }

  mysqli_close($con);
}
