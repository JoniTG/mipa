<?php
include '../config.php';
if($_POST['phone'] != NULL && $_POST['mail'] != NULL)
{
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $phone = $_POST['phone'];
  $mail  = $_POST['mail'];

  $query = mysqli_query($con, "SELECT * FROM `users` WHERE `phone` = '".$phone."' OR `email` = '".$mail."'");
  $rows  = mysqli_num_rows($query);

  if($rows > 0)
  {
    $json = array(
      'phone' => '000',
      'mail'  => '000'
    );
  } else {
    $json = array(
      'phone' => '',
      'mail'  => ''
    );
  }

  echo json_encode($json);

  mysqli_close($con);
}
