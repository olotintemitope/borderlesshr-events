<?php

require __DIR__ . '/../vendor/autoload.php';

use Laztopaz\Controller\HomeController;
use Laztopaz\Lib\App;
use Laztopaz\Lib\Router;
use Laztopaz\Lib\Response;


Router::get('/', function () {
   (new HomeController())->indexAction();
});

Router::get('/auth/login', function () {
    (new HomeController())->loginAction();
});
