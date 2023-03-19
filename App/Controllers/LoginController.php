<?php
@session_start();
require 'App/Config/config.php';

use Byte\Request;
use Byte\Account;
use Byte\Response;

// Collecting Data into object
$args = Request::createFromGlobals();
$email = $args->query->post['email'];
$password = $args->query->post['password'];

$response = new Response();

/** @var array $config */
// Checking account exist
if(Account::checkAccountExist($email, $config)) {
    if(Account::authorizeAccount($email, $password, $config)) {
        if(Account::saveAccountSession($email, $password, $config)) {
            Account::saveLogin($email, $config);
            $response->setRedirect('/dash');
        } else {
            // Internal Server Error
            Request::setSession('byte-error', '500');
            $response->setRedirect('/login');
        }
    } else {
        // Forbidden
        Request::setSession('byte-error', '403');
        $response->setRedirect('/login');
    }
} else {
    // Account not found
    Request::setSession('byte-error', '404');
    $response->setRedirect('/login');
}
// Sending Reponse
$response->sendResponse();