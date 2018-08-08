<?php 

require 'vendor/autoload.php';
require 'core/bootstrap.php';

//Database
use Core\Router;
use Core\Request;

Router::load('app/routes.php')
	->direct(Request::uri(), Request::method());

?>