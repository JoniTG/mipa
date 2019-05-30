<?php
/**
 *
 */
class RideModel extends Model
{
  public function GiveRide()
  {
    if($this->Check())
    {
      $fcm  = new FcmModel();

      $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      if(($post['exit'] != NULL) && ($post['target'] != NULL) && ($post['date'] != NULL)
      && ($post['price'] != NULL))
      {
        $this->query("INSERT INTO `rides` (`area`, `exit`, `target`, `date`, `passengers`, `price`, `comments`, `owner`, `show`, `lastAction`, `month`)
        VALUES (:area, :exit, :target, :datet, :pass, :price, :comments, :owner, 1, CURDATE(), :month)");

        $this->bind(':area', $_POST['area']);
        $this->bind(':exit', $_POST['exit']);
        $this->bind(':target', $_POST['target']);
        $this->bind(':datet', $_POST['date']);
        $this->bind(':pass', $_POST['passengers']);
        $this->bind(':price', $_POST['price']);
        $this->bind(':comments', $_POST['comments']);
        $this->bind(':owner', $_SESSION['fullName']);
        $this->bind(':month', date("n"));
        // $flag = $this->execute();

        $_SESSION['GiveRide'] = 1;

        if($this->execute())
        {
          // Get the tokens without the giver
          $this->query("SELECT `token` FROM `fcm-users` WHERE `phone` != :phone");
          $this->bind(':phone', $_SESSION['phone']);
          $tokens = $this->resultset();

          $msg = 'מי פנוי לנסיעה?';

          // Send Notification
          $fcm->Notification($tokens, $msg, 'http://mipanooy.mobi/user');

          header("Location: ".ROOT_URL."user/");
          exit();
          return true;
        }
      }
    } else {
      header("Location: ".ROOT_URL."user/login/");
      exit();
    }

    return;
  }

  public function ChooseDriver()
  {
    $id = $_GET['id'];

    $this->query("SELECT * FROM `rides` WHERE `ID` = :id");
    $this->bind(':id', $id);

    return $this->resultset();
  }

  public function MyRides()
  {
    if($this->Check())
    {
      $this->query("SELECT * FROM `users` WHERE `phone` = :phone AND `pass` = :pass");
      $this->bind(':phone', $_SESSION['phone']);
      $this->bind(':pass', $_SESSION['pass']);
      $user = $this->resultset();

      $this->query("SELECT * FROM `rides`
                    WHERE (`owner` = :name AND `show` = 1)
                    OR ( (`driverID` = :id) AND (`lastAction` >= CURDATE() - INTERVAL DAYOFWEEK(curdate())+6 DAY) )
                    ORDER BY `lastAction` DESC, `ID` DESC");

      $this->bind(':name', $_SESSION['fullName']);
      $this->bind(':id', $user[0]['ID']);

      return $this->resultset();
    } else {
        header("Location: ".ROOT_URL."user/login/");
    }

    return false;
  }

  public function Check()
  {
    if(isset($_SESSION['pass']))
    {
      $this->query("SELECT * FROM `users` WHERE `fullName` = :name AND `pass` = :pass");
      $this->bind(':name', $_SESSION['fullName']);
      $this->bind(':pass', $_SESSION['pass']);

      $rows = $this->numRows();

      if($rows > 0)
        return true;
      return false;
    }

    return false;
  }
}
