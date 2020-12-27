<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use Laztopaz\Controller\HomeController;
use Laztopaz\Lib\App;
use Laztopaz\Lib\Router;

App::run();

Router::get('/', function () {
   (new HomeController())->indexAction();
});

Router::get('/auth/login', function () {
    (new HomeController())->loginAction();
});
