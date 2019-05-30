<?php
include '../config.php';
if($_POST['name'] != NULL && $_POST['pass'] != NULL && $_POST['phone'] != NULL)
{
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $name  = $_POST['name'];
  $pass  = $_POST['pass'];
  $phone = $_POST['phone'];

  $user = mysqli_query($con, "SELECT * FROM `users` WHERE `fullName` = '".$name."' AND `pass` = '".$pass."'");
  $rows = mysqli_num_rows($user);

  if($rows > 0)
  {
    echo 1;
    setcookie("phone", $phone, 0, '/');
    setcookie("pass", $pass, 0, '/');
  }
  else
    echo 0;

  mysqli_close($con);
}
