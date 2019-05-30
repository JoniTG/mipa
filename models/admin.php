<?php
class AdminModel extends Model
{
  public function Index()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    $this->query("SELECT * FROM `users` WHERE `fullName` = :name AND `pass` = :pass");
    $this->bind(':name', $_SESSION['fullName']);
    $this->bind(':pass', $_SESSION['pass']);

    return $this->resultset();
  }

  public function login()
  {
    if($_POST['userName'] != NULL && $_POST['pass'] != NULL)
    {
      $this->query("SELECT * FROM `users` WHERE `fullName` = :user AND `pass` = :pass AND `rank` > 0");
      $this->bind(':user', $_POST['userName']);
      $this->bind(':pass', $_POST['pass']);
      $rows = $this->numRows();

      if($rows > 0)
      {
        $_SESSION['fullName'] = $_POST['userName'];
        $_SESSION['pass']     = $_POST['pass'];

        header("Location: ".ROOT_URL."Admin/");
        exit();
        return true;
      }

      return false;
    }

    return true;
  }

  public function logout()
  {
    session_destroy();
    header("Location: ".ROOT_URL."Admin/login/");
    if(exit())
      return true;
    return;
  }

  // public function execl()
  // {
  //   header('Content-type: application/excel');
  //
  //   switch ($_GET['id']) {
  //     case 1:
  //       $filename = 'filename.xls';
  //       header('Content-Disposition: attachment; filename='.$filename);
  //
  //       $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
  //       <head>
  //           <!--[if gte mso 9]>
  //           <xml>
  //               <x:ExcelWorkbook>
  //                   <x:ExcelWorksheets>
  //                       <x:ExcelWorksheet>
  //                           <x:Name>Sheet 1</x:Name>
  //                           <x:WorksheetOptions>
  //                               <x:Print>
  //                                   <x:ValidPrinterInfo/>
  //                               </x:Print>
  //                           </x:WorksheetOptions>
  //                       </x:ExcelWorksheet>
  //                   </x:ExcelWorksheets>
  //               </x:ExcelWorkbook>
  //           </xml>
  //           <![endif]-->
  //       </head>
  //
  //       <body>
  //          <table><tr><td>Cell 1</td><td>Cell 2</td></tr></table>
  //       </body></html>';
  //
  //       echo $data;
  //       break;
  //
  //     default:
  //       // code...
  //       break;
  //   }
  // }

  /* ##################################
   *          Rides methods
   * ##################################
  */
  public function rides()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    $this->query("SELECT * FROM `rides`
                  WHERE `deliverTime` > NOW() - INTERVAL 3 HOUR
                  OR `driverID` = 0");

    $active = $this->resultset();

    $this->query("SELECT * FROM `rides` ORDER BY `ID` DESC");
    $all = $this->resultset();

    $array = array($active, $all);
    return $array;
  }

  public function Edit()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    if($_GET['id'] != NULL && $_POST['fullName'] != NULL && $_POST['driverID'] != NULL)
    {
      $this->query("UPDATE `rides` SET `driverID` = :driver,
                  `lastAction` = CURDATE(), `deliverTime` = CURRENT_TIMESTAMP
                  WHERE `ID` = :id");

      $this->bind(':driver', $_POST['driverID']);
      $this->bind(':id', $_GET['id']);

      if($this->execute())
      {
          header("Location: ".ROOT_URL."Admin/rides/");
          exit();
          return true;
      }

      return false;
    }

    return;
  }

  public function Delete()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    if($_GET['id'] == 0)
    {
      $this->query("DELETE FROM `rides`");
      if($this->execute())
      {
        header("Location: ".ROOT_URL."Admin/rides/");
        exit();
        return true;
      }
      return false;
    }

    $this->query("DELETE FROM `rides` WHERE `ID` = :id");
    $this->bind(':id', $_GET['id']);
    if($this->execute())
    {
      header("Location: ".ROOT_URL."Admin/rides/");
      exit();
      return true;
    }

    return false;

  }

  /* ##################################
   *          Drivers methods
   * ##################################
  */
  public function drivers()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    $this->query("SELECT * FROM `users`");
    return $this->resultset();
  }

  public function DelUser()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    $this->query("DELETE FROM `users` WHERE `ID` = :id");
    $this->bind(':id', $_GET['id']);
    if($this->execute())
    {
      header("Location: ".ROOT_URL."Admin/drivers/");
      exit();
      return true;
    }

    return false;
  }

  public function promotion()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    $this->query("UPDATE `users` SET `rank` = 1 WHERE `ID` = :id");
    $this->bind(':id', $_GET['id']);

    if($this->execute())
    {
      header("Location: ".ROOT_URL."Admin/drivers/");
      exit();
      return true;
    }

    return false;
  }

  public function demotion()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    $this->query("UPDATE `users` SET `rank` = 0 WHERE `ID` = :id");
    $this->bind(':id', $_GET['id']);

    if($this->execute())
    {
      header("Location: ".ROOT_URL."Admin/drivers/");
      exit();
      return true;
    }

    return false;
  }

  public function EditRate()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    $new = $_POST['rate'];

    $this->query("SELECT * FROM `users` WHERE `ID` = :id");
    $this->bind(':id', $_GET['id']);
    $driver = $this->resultset();

    if($driver[0]['rates'] > 0)
    {
      $newRate = $new*$driver[0]['rates'];
      $this->query("UPDATE `users` SET `rate` = :rate WHERE `ID` = :id");
      $this->bind(':rate', $newRate);
      $this->bind(':id', $_GET['id']);
    } else {
      $this->query("UPDATE `users` SET `rate` = :rate, `rates` = 1 WHERE `ID` = :id");
      $this->bind(':rate', $new);
      $this->bind(':id', $_GET['id']);
    }

    if($this->execute())
    {
      header("Location: ".ROOT_URL."Admin/drivers/");
      exit();
      return true;
    }

    return false;
  }

  public function message()
  {
    if(!$this->Check())
    {
      header("Location: ".ROOT_URL."Admin/login/");
      exit();
      return;
    }

    $this->query("SELECT `token` FROM `fcm-users`");
    $tokens = $this->resultset();
    // var_dump($tokens);

    if(isset($_POST['sub']))
    {
      $title   = $_POST['title'];
      $type    = $_POST['type'];
      $message = $_POST['message'];

      $fcm  = new FcmModel();
      $url    = 'http://mipanooy.mobi';

      switch ($type) {
        case '1':
          $fcm->Notification($tokens, $message, $url);
          header("Location: ".ROOT_URL."Admin/");
          exit();
          break;

        case '2':
          $this->query("INSERT INTO `admin-message` (`subject`, `content`, `date`)
                        VALUES (:title, :content, CURDATE())");
          $this->bind(':title', $title);
          $this->bind(':content', $message);
          $this->execute();

          header("Location: ".ROOT_URL."Admin/");
          exit();
          break;

        case '3':
          $this->query("INSERT INTO `admin-message` (`subject`, `content`, `date`)
                        VALUES (:title, :content, CURDATE())");
          $this->bind(':title', $title);
          $this->bind(':content', $message);
          $this->execute();

          $fcm->Notification($tokens, $message, $url);

          header("Location: ".ROOT_URL."Admin/");
          exit();
          break;

        default:
          // code...
          break;
      }
    }

    return;
  }

  public function Check()
  {
    if(isset($_SESSION['pass']))
    {
      $this->query("SELECT * FROM `users` WHERE `fullName` = :name AND `pass` = :pass AND `rank` > 0");
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
