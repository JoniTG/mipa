<?php
include '../config.php';
if(!empty($_POST['phone']) && !empty($_POST['pass']))
{
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  mysqli_set_charset($con, 'utf8');

  if(mysqli_connect_errno())
    die();

  $phone = $_POST['phone'];
  $pass  = $_POST['pass'];
  $rides = json_decode($_POST['rides']);

  $query = mysqli_query($con, "SELECT * FROM `users` WHERE `phone` = '".$phone."'
    AND `pass` = '".$pass."'");
  $rows  = mysqli_num_rows($query);

  if($rows > 0)
  {
    $open = mysqli_query($con, "SELECT * FROM `rides`
      WHERE `deliverTime` > NOW() - INTERVAL 3 HOUR
      OR `driverID` = 0
      ORDER BY `area` DESC, `ID` DESC");

    $new = array();
    while($temp = mysqli_fetch_assoc($open))
    {
      if(!ExistInArray($rides, $temp['ID']))
      {
        $new[] = $temp['ID'];
      }
    }

    echo json_encode($new);
  }

  mysqli_close($con);
}

function ExistInArray($rides, $openID)
{
  foreach ($rides as $value) {
    if($value == $openID)
      return true;
  }
  return false;
}
