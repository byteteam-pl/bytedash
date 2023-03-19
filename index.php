<?php

require 'App/Router/Router.php';
require 'App/Models/Autoload.php';

use Byte\Router;
use Byte\Database;
use Byte\Request;

$router = new Router;

$router->get('/', function () use ($router) {

    $router->render('home');
});

$router->set404(function () use ($router) {
    $router->render('404');
});

$router->run();
Request::runShield();
Request::generateRequest('Getting Access');

interface ControllerResolverInterface
{
    public function getController(Request $request, $name);
}
