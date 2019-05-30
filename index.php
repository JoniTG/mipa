<?php
require 'config.php';
require 'classes/bootstrap.php';
require 'classes/controller.php';
require 'classes/model.php';

require 'controllers/fcm.php';
require 'controllers/home.php';
require 'controllers/users.php';
require 'controllers/rides.php';
require 'controllers/pages.php';
require 'controllers/admin.php';

require 'models/fcm.php';
require 'models/home.php';
require 'models/user.php';
require 'models/ride.php';
require 'models/page.php';
require 'models/admin.php';


$bootstrap  = new Bootstrap($_GET);
$controller = $bootstrap->createController();

if($controller)
{
  $controller->executeAction();
}
