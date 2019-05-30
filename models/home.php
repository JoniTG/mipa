<?php
/**
 *
 */
class HomeModel extends Model
{
  public function Index()
  {
    if(isset($_COOKIE['pass']) && isset($_COOKIE['phone']) && isset($_COOKIE['fullName']))
    {
      $this->query("SELECT * FROM `users` WHERE `phone` = :phone AND `pass` = :pass");
      $this->bind(':phone', $_COOKIE['phone']);
      $this->bind(':pass', $_COOKIE['pass']);

      $rows = $this->numRows();

      if($rows > 0)
      {
          $_SESSION['fullName'] = $_COOKIE['fullName'];
          $_SESSION['pass']     = $_COOKIE['pass'];
          $_SESSION['phone']    = $_COOKIE['phone'];

          return true;
      }
    }

    return 0;
  }
}
