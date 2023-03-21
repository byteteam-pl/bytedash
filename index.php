<?php

@session_start();

require 'App/Router/Router.php';
require 'App/Models/Autoload.php';

use Byte\Router;
use Byte\Request;

$router = new Router;

$args = Request::createFromGlobals();
if(@$args->query->get['language'] != NULL) {
    Request::setSession('language', @$args->query->get['language']);
    if($Translate->checkTranslateExist(@$args->query->get['language'])) {
        Request::setSession('language', @$args->query->get['language']);
    } else {
        Request::setSession('language', 'EN');
    }
}


$router->get('/', function () use ($router) {
    $router->render('login');
});

$router->get('/login', function () use ($router) {
    $router->render('login');
});

$router->get('/register', function () use ($router) {
    $router->render('register');
});


$router->set404(function () use ($router) {
    $router->render('404');
});

// back-end

$router->post('/register', function () use ($router) {
    $router->runController('Register');
});

$router->post('/login', function () use ($router) {
    $router->runController('Login');
});

$router->get('/logout', function () use ($router) {
    Request::setSession('logged', FALSE);
    header('Location: /login');
});


Request::runShield();
Request::generateRequest('Getting Access');
$router->run();


interface ControllerResolverInterface
{
    public function getController(Request $request, $name);
}