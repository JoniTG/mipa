<?php
header('Content-Type: text/html; charset=utf-8');

if($_GET['controller'] != 'admin' && $_GET['controller'] != 'Admin'):
?>
<!DOCTYPE html>
<html>
  <head></head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0,viewport-fit=cover"/>
    <title>Mipanooy</title>

    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL; ?>assets/styles/mipanooy.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_URL; ?>assets/styles/loader.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <script src="<?php echo ROOT_URL; ?>assets/scripts/jquery.min.js"></script>
    <script src="<?php echo ROOT_URL; ?>assets/scripts/webAppBridge.js"></script>
  </head>

  <?php
  require $view;

  $phone = "";
  if(isset($_SESSION['phone']))
  {
    $phone = $_SESSION['phone'];
  }
  ?>

  <script type="text/javascript">
    $(document).ready(function () {
      function Details() {
        var phone = localStorage.getItem("phone");
        var pass  = localStorage.getItem("pass");

        if((phone === "undefined") || (pass === "undefined"))
          phone = "<?php echo $phone; ?>";

        return phone;
      }

      // send login details to native
      if (window.callNativeApp) {
        var phone = localStorage.getItem("phone");
        if (phone) {
          callNativeApp("logpros", "onUserLogin", { phone: phone });
        }
      }
    });
  </script>
</html>
<?php
else:
  include 'AdminMain.php';
endif;
?>
