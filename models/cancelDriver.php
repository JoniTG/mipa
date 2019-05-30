<?php
include '../config.php';
if($_POST['rideID'] != NULL && $_POST['fullName'] != NULL)
{
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $ride   = $_POST['rideID'];
  $name   = $_POST['fullName'];

  $query = mysqli_query($con, "SELECT * FROM `rides` WHERE `ID` = '".$ride."' AND `owner` = '".$name."'");
  $rows  = mysqli_num_rows($query);

  if($rows > 0)
    mysqli_query($con, "UPDATE `rides` SET `driverID` = 0, `lastAction` = CURDATE() WHERE `ID` = '".$ride."'");

  mysqli_close($con);
}
