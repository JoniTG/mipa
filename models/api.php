<?php
/**
 *
 */
class ApiModel extends Model
{
  public function GetUser()
  {
    $id = $_GET['id'];
    $this->query("SELECT `fullName`, `phone` FROM `users` WHERE `ID` = :id");
    $this->bind(':id', $id);

    $user = $this->resultset();
    $json = json_encode($user[0]);
    return $json;
  }

  public function GetRide()
  {
    $id = $_GET['id'];
    $this->query("SELECT * FROM `rides` WHERE `ID` = :id");
    $this->bind(':id', $id);

    $ride = $this->resultset();
    $json = json_encode($ride[0]);
    return $json;
  }

  public function GetRides()
  {
    $this->query("SELECT * FROM `rides`");

    $rides = $this->resultset();
    $json  = json_encode($rides);
    return $json;
  }

  public function GetDriver()
  {
    $id = $_GET['id'];
    $this->query("SELECT * FROM `driver` WHERE `ID` = :id");
    $this->bind(':id', $id);

    $driver = $this->resultset();
    $json   = json_encode($driver[0]);
    return $json;
  }
}
