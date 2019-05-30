<?php
include '../config.php';
if($_POST['rideID'] != NULL && $_POST['fullName'] != NULL)
{
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $id   = $_POST['rideID'];
  $name = $_POST['fullName'];

  $query = mysqli_query($con, "SELECT * FROM `rides` WHERE `ID` = '".$id."' AND `show` = 1");
  $rows  = mysqli_num_rows($query);

  if($rows > 0)
  {
    $user = mysqli_query($con, "SELECT * FROM `users` WHERE `fullName` = '".$name."' ");
    $user = mysqli_fetch_array($user);

    mysqli_query($con, "DELETE FROM `drive` WHERE `rideID` = '".$id."' AND `driverID` = '".$user['ID']."'");
    mysqli_query($con, "DELETE FROM `rides` WHERE `ID` = '".$id."' AND `owner` = '".$name."' ");
    mysqli_query($con, "DELETE FROM `messages` WHERE `rideID` = '".$id."'");
  }

  mysqli_close($con);
}
