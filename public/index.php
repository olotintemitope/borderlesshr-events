<?php

require __DIR__ . '/../vendor/autoload.php';

use Laztopaz\Lib\App;
use Laztopaz\Lib\Router;
use Laztopaz\Lib\Request;
use Laztopaz\Lib\Response;


Router::get('/', function () {
    echo "<h1>Hello World</h1>";
   // (new Home())->indexAction();
});
