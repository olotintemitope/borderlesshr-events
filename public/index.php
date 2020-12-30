<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use Laztopaz\Controller\{AdminEventsController, EventController, HomeController, AdminEventTypesController};
use Laztopaz\Lib\App;
use Laztopaz\Lib\Request;
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

Router::post('/auth/login', function (Request $request) {
    (new HomeController())->processLoginAction($request);
});

Router::get('/auth/logout', function () {
    (new HomeController())->logoutAction();
});

Router::get('/admin/event-types', function () {
    (new AdminEventTypesController())->eventTypesAction();
});

Router::get('/admin/event-type', function () {
    (new AdminEventTypesController())->eventTypeAction();
});

Router::post('/admin/event-type/create', function (Request $request) {
    (new AdminEventTypesController())->createEventTypeAction($request);
});

Router::get('/admin/event-type/edit/([0-9]*)', function (Request $request) {
    (new AdminEventTypesController())->editEventTypeAction($request);
});

Router::post('/admin/event-type/update/([0-9]*)', function (Request $request) {
    (new AdminEventTypesController())->updateEventTypeAction($request);
});

Router::get('/admin/events', function () {
    (new AdminEventsController())->eventsAction();
});

Router::get('/admin/event', function () {
    (new AdminEventsController())->eventAction();
});

Router::post('/admin/event/create', function (Request $request) {
    (new AdminEventsController())->createEventAction($request);
});

Router::get('/admin/event/edit/([0-9]*)', function (Request $request) {
    (new AdminEventsController())->editEventAction($request);
});

Router::post('/admin/event/update/([0-9]*)', function (Request $request) {
    (new AdminEventsController())->updateEventAction($request);
});

Router::get('/events', function () {
    (new EventController())->indexAction();
});

Router::get('/events/([a-z0-9-]*)', function (Request $request) {
    (new EventController())->viewAction($request);
});

App::run();
