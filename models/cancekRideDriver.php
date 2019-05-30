<?php
/*
 * For cancelDriver from index.php page
 */
include '../config.php';
if($_POST['rideID'] != NULL && $_POST['fullName'] != NULL)
{
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $ride = $_POST['rideID'];
  $name = $_POST['fullName'];

  $user = mysqli_query($con, "SELECT * FROM `users` WHERE `fullName` = '".$name."'");
  $user = mysqli_fetch_array($user);

  $query = mysqli_query($con, "SELECT * FROM `drive` WHERE `rideID` = '".$ride."' AND `driverID` = '".$user['ID']."'");
  $rows  = mysqli_num_rows($query);
  $query = mysqli_fetch_array($query);

  if($rows > 0)
    mysqli_query($con, "DELETE FROM `drive` WHERE `ID` = '".$query['ID']."'");

  mysqli_close($con);
}
