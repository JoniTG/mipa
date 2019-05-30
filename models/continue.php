<?php
include '../config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($con, 'utf8');

if(mysqli_connect_errno())
  die();


mysqli_query($con, "INSERT INTO `users` (`fullName`, `pass`, `phone`, `email`)
                    VALUES ('".$_POST['fullName']."', '".$_POST['pass']."', '".$_POST['phone']."', '".$_POST['email']."')");
echo 1;

mysqli_close($con);
