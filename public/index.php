<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use Laztopaz\Controller\HomeController;
use Laztopaz\Lib\App;
use Laztopaz\Lib\Request;
use Laztopaz\Lib\Response;
use Laztopaz\Lib\Router;

if (!isset($_SESSION)) {
    session_start();
}

Router::get('/', function () {
   (new HomeController())->indexAction();
});

Router::get('/auth/login', function () {
    (new HomeController())->loginAction();
});

Router::post('/auth/login', function (Request $request, Response $response) {
    (new HomeController())->processLoginAction($request);
});

Router::get('/auth/logout', function () {
    (new HomeController())->logoutAction();
});

App::run();
