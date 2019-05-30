<?php
include '../config.php';
if($_POST['driverID'] != NULL && $_POST['rate'] != NULL)
{
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $id   = $_POST['driverID'];
  $rate = $_POST['rate'];
  $ride = $_POST['ride'];

  $user = mysqli_query($con, "SELECT * FROM `users` WHERE `ID` = '".$id."'");
  $rows = mysqli_num_rows($user);

  if($rows > 0)
  {
    $user = mysqli_fetch_array($user);
    $user['rates'] = $user['rates'] + 1;
    $user['rate']  = $user['rate'] + $rate;

    mysqli_query($con, "UPDATE `users` SET `rate` = '".$user['rate']."', `rates` = '".$user['rates']."' WHERE `ID` = '".$id."'");
    mysqli_query($con, "UPDATE `rides` SET `show` = 0 WHERE `ID` = '".$ride."'");
  }

  mysqli_close($con);
}
