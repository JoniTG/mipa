<?php
/**
 * Created by Yoni @jan. 18th
 * All the methods for the user controller
 */
class UserModel extends Model
{

  public function profile()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."user/login/");
      exit();
      return;
    }

    $this->query("SELECT * FROM `users` WHERE `phone` = :phone AND `pass` = :pass");
    $this->bind(':phone', $_SESSION['phone']);
    $this->bind(':pass', $_SESSION['pass']);
    return $this->resultset();
  }

  public function Index()
  {
    if($this->Check())
    {
      $this->query("SELECT * FROM `rides`
                    WHERE `deliverTime` > NOW() - INTERVAL 3 HOUR
                    OR `driverID` = 0
                    ORDER BY `area` DESC, `ID` DESC");

      $rows  = $this->numRows();
      $rides = $this->resultset();

      $this->query("SELECT * FROM `admin-message`
                    WHERE `date` = CURDATE() ORDER BY `ID` DESC");
      $adminMessage = $this->resultset();

      if($rows > 0)
        return array($rides, $adminMessage);
      return array(false, $adminMessage);
    } else {
      header("Location: ".ROOT_URL."user/login/");
    }

    return false;
  }

  public function sum()
  {
    if($this->Check())
    {
      $this->query("SELECT * FROM `users` WHERE `phone` = :phone");
      $this->bind(':phone', $_SESSION['phone']);
      $user = $this->resultset();

      // All
      $this->query("SELECT * FROM `rides` WHERE `driverID` = :id");
      $this->bind(':id', $user[0]['ID']);
      $allNum = $this->numRows();
      $all    = $this->resultset();

      $this->query("SELECT SUM(`price`) FROM `rides` WHERE `driverID` = :id");
      $this->bind(':id', $user[0]['ID']);
      $allMoney = $this->resultset();

      if($allMoney[0]['SUM(`price`)'] == NULL)
        $allMoney[0]['SUM(`price`)'] = 0;

      // Month
      $this->query("SELECT * FROM `rides` WHERE `driverID` = :id
                    AND `month` = :month");
      $this->bind(':id', $user[0]['ID']);
      $this->bind(':month', date("n"));
      $monthNum = $this->numRows();
      $month    = $this->resultset();

      $this->query("SELECT SUM(`price`) FROM `rides` WHERE `driverID` = :id
                    AND `month` = :month");
      $this->bind('id', $user[0]['ID']);
      $this->bind(':month', date("n"));
      $monthMoney = $this->resultset();

      if($monthMoney[0]['SUM(`price`)'] == NULL)
        $monthMoney[0]['SUM(`price`)'] = 0;

      $rides = array(
        "queries" => array(
          "allRides" => $all,
          "month"    => $month
        ),

        "month" => array(
          "num"   => $monthNum,
          "money" => $monthMoney[0]['SUM(`price`)']
        ),

        "all" => array(
          "num"   => $allNum,
          "money" => $allMoney[0]['SUM(`price`)']
        )
      );

      return $rides;
    } else {
      header("Location: ".ROOT_URL."user/login/");
      exit();

      return;
    }
  }

  public function register()
  {
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $msg  = "";

    if(($post['fullName'] != NULL) && ($post['phone'] != NULL)
    && ($post['pass'] != NULL) && ($post['check'] == '1') && ($post['confPass'] == $post['pass']))
    {
      $_SESSION['fullName'] = $post['fullName'];
      $_SESSION['phone']    = $post['phone'];
      $_SESSION['pass']     = $post['pass'];
      $_SESSION['email']    = $post['email'];

      header("Location: ".ROOT_URL."user/regt");
      exit();

      return true;
    } else {
      return false;
    }

    return;
  }

  public function login()
  {
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if(($post['phone'] != NULL) && ($post['pass'] != NULL))
    {
      $this->query("SELECT * FROM `users` WHERE `phone` = :phone AND `pass` = :pass");
      $this->bind(':phone', $post['phone']);
      $this->bind(':pass', $post['pass']);

      $rows = $this->numRows();
      if($rows > 0)
      {
        $user                 = $this->resultset();
        $_SESSION['fullName'] = $user[0]['fullName'];
        $_SESSION['phone']    = $post['phone'];
        $_SESSION['pass']     = $post['pass'];

        setcookie("fullName", $user[0]['fullName'], 0, '/');
        setcookie("phone", $post['phone'], 0, '/');
        setcookie("pass", $post['pass'], 0, '/');

        header("Location: ".ROOT_URL."user/");
        exit();

        return true;
      } else {
        return "000";
      }
    }

    return false;
  }

  public function logpros()
  {
    if(isset($_COOKIE['phone']) && isset($_COOKIE['pass']))
    {
      $this->query("SELECT * FROM `users` WHERE `phone` = :phone AND `pass` = :pass");
      $this->bind(':phone', $_COOKIE['phone']);
      $this->bind(':pass', $_COOKIE['pass']);

      $user = $this->resultset();

      $_SESSION['fullName'] = $user[0]['fullName'];
      $_SESSION['phone']    = $_COOKIE['phone'];
      $_SESSION['pass']     = $_COOKIE['pass'];

      header("Location: ".ROOT_URL."user/");
      exit();
    }

    return;
  }

  // Add photos
  public function regt()
  {
    $flag  = false;
    $flag2 = false;

    if(isset($_FILES['license']))
    {
       $fname  = $_FILES['license']['name'][0];
       $ftype  = $_FILES['license']['type'][0];
       $ftmp   = $_FILES['license']['tmp_name'][0];
       $ferror = $_FILES['license']['error'][0];
       $fsize  = $_FILES['license']['size'][0];

       $fnameT  = $_FILES['license']['name'][1];
       $ftypeT  = $_FILES['license']['type'][1];
       $ftmpT   = $_FILES['license']['tmp_name'][1];
       $ferrorT = $_FILES['license']['error'][1];
       $fsizeT  = $_FILES['license']['size'][1];

    	 if($ferror == 0 && $ferrorT == 0)
       {
    	    if(!empty($fname) && !empty($fnameT))
          {
    	       if($fsize <= 10485760 && $fsizeT <= 10485760)
             {
    	          if(($ftype == "image/jpg" || $ftype == "image/jpeg" || $ftype == "image/png")
                   && ($ftypeT == "image/jpg" || $ftypeT == "image/jpeg" || $ftypeT == "image/png"))
                {
    	              $location = "./models/taxi-img/";
    	              if(move_uploaded_file($ftmp, $location.$fname) && move_uploaded_file($ftmpT, $location.$fnameT))
                    {
                        $this->query("INSERT INTO `users` (`fullName`, `pass`, `phone`, `email`, `licence`, `car`)
                        VALUES (:fullName, :pass, :phone, :email, :license, :car)");

                        $this->bind(':fullName', $_SESSION['fullName']);
                        $this->bind(':pass', $_SESSION['pass']);
                        $this->bind(':phone', $_SESSION['phone']);
                        $this->bind(':email', $_SESSION['email']);
                        $this->bind(':license', ROOT_URL."models/taxi-img/".$fname);
                        $this->bind(':car', ROOT_URL."models/taxi-img/".$fnameT);
                        $flag2 = $this->execute();

                        header("Location: ".ROOT_URL."user");
                        exit();
    	                  $flag = true;
    	              } else {
                      $flag = false;
                    }
    	          } else {
                  $flag = false;
                }
    	       } else {
              $flag = false;
             }
    	     } else {
             $flag = false;
           }
    	   } else {
           $flag = false;
         }
    }

    if(isset($_POST['con']))
    {

    }

    if($flag2)
      return true;
    return false;
  }

  public function continueToMain()
  {
    echo 0;
    // $this->query("INSERT INTO `users` (`fullName`, `pass`, `phone`)
    // VALUES (:fullName, :pass, :phone)");
    //
    // $this->bind(':fullName', $_POST['fullName']);
    // $this->bind(':pass', $_POST['pass']);
    // $this->bind(':phone', $_POST['phone']);
    // $flag2 = $this->execute();
    //
    // if($flag2)
    //   echo 1;
    // else
    //   echo 0;
    return;
  }

  public function UpdatePic()
  {
    if(isset($_FILES['license']))
    {
       $fname  = $_FILES['license']['name'][0];
       $ftype  = $_FILES['license']['type'][0];
       $ftmp   = $_FILES['license']['tmp_name'][0];
       $ferror = $_FILES['license']['error'][0];
       $fsize  = $_FILES['license']['size'][0];

       $fnameT  = $_FILES['license']['name'][1];
       $ftypeT  = $_FILES['license']['type'][1];
       $ftmpT   = $_FILES['license']['tmp_name'][1];
       $ferrorT = $_FILES['license']['error'][1];
       $fsizeT  = $_FILES['license']['size'][1];

    	 if($ferror == 0 && $ferrorT == 0)
       {
    	    if(!empty($fname) && !empty($fnameT))
          {
    	       if($fsize <= 10485760 && $fsizeT <= 10485760)
             {
    	          if(($ftype == "image/jpg" || $ftype == "image/jpeg" || $ftype == "image/png")
                   && ($ftypeT == "image/jpg" || $ftypeT == "image/jpeg" || $ftypeT == "image/png"))
                {
    	              $location = "./models/taxi-img/";
    	              if(move_uploaded_file($ftmp, $location.$fname) && move_uploaded_file($ftmpT, $location.$fnameT))
                    {
                        $this->query("UPDATE `users` SET `licence` = :lic, `car` = :car
                          WHERE `phone` = :phone AND `pass` = :pass");

                        $this->bind(':lic', ROOT_URL."models/taxi-img/".$fname);
                        $this->bind(':car', ROOT_URL."models/taxi-img/".$fnameT);
                        $this->bind(':phone', $_SESSION['phone']);
                        $this->bind(':pass', $_SESSION['pass']);

                        $flag2 = $this->execute();

                        header("Location: ".ROOT_URL."user");
                        exit();
    	                  $flag = true;
    	              } else {
                      $flag = false;
                    }
    	          } else {
                  $flag = false;
                }
    	       } else {
              $flag = false;
             }
    	     } else {
             $flag = false;
           }
    	   } else {
           $flag = false;
         }
    }

    return;
  }

  public function settings()
  {
    return;
  }

  public function payment()
  {
    if($this->Check())
    {
      if(isset($_POST['sub']) && ($post['visa'] != NULL) && ($post['month'] != NULL)
      && ($post['year'] != NULL) && ($post['cvv'] != NULL))
      {
        $this->query("INSERT INTO `users` (`visa`, `month`, `year`, `cvv`) VALUES (:visa, :month, :year, :cvv)");

        $this->bind(':visa', $post['visa']); // TODO: hash or just 3 numbers
        $this->bind(':month', $post['month']);
        $this->bind(':year', $post['year']);
        $this->bind(':cvv', $post['cvv']);

        // TODO: Express cheackout

        return $this->execute();
      }
    }

    return false;
  }

  public function UpdatePayment()
  {
    if($this->Check())
    {
      $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      if(isset($_POST['sub']) && ($post['visa'] != NULL) && ($post['month'] != NULL)
      && ($post['year'] != NULL) && ($post['cvv'] != NULL))
      {
        $this->query("UPDATE `users` SET `visa` = :visa, `month` = :month, `year` = :year, `cvv` = :cvv
        WHERE `fullName` = :name AND `pass` = :pass");

        $this->bind(':visa', $post['visa']); // TODO: hash or just 3 numbers
        $this->bind(':month', $post['month']);
        $this->bind(':year', $post['year']);
        $this->bind(':cvv', $post['cvv']);
        $this->bind(':name', $_SESSION['fullName']);
        $this->bind(':pass', $_SESSION['pass']);

        // TODO: Express cheackout

        return $this->execute();
      }
    }

    return false;
  }

  public function cancel()
  {
    return;
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
    }

    if(isset($_COOKIE['pass']))
    {
      $this->query("SELECT * FROM `users` WHERE `phone` = :phone AND `pass` = :pass");
      $this->bind(':phone', $_COOKIE['phone']);
      $this->bind(':pass', $_COOKIE['pass']);

      $rows = $this->numRows();

      if($rows > 0)
      {
        $_SESSION['fullName'] = $_COOKIE['fullName'];
        $_SESSION['phone']    = $_COOKIE['phone'];
        $_SESSION['pass']     = $_COOKIE['pass'];

        return true;
      }
    }

    return false;
  }
}
