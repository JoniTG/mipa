<?php
include '../config.php';
if($_POST['msgID'] != NULL && $_POST['user'] != NULL)
{
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $msg   = $_POST['msgID'];
  $user  = $_POST['user'];

  $query = mysqli_query($con, "SELECT * FROM `messages` WHERE `ID` = '".$msg."' AND `driverID` = '".$user."'");
  $rows  = mysqli_num_rows($query);

  if($rows > 0)
    if(mysqli_query($con, "UPDATE `messages` SET `read` = 1 WHERE `ID` = '".$msg."'"))
        echo "test";

  mysqli_close($con);
} else {
  echo 'test';
}
