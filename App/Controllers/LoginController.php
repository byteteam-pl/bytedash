<?php
use Byte\HttpKernel;
@session_start();
require 'App/Config/config.php';

use Byte\Request;
use Byte\Account;

// Collecting Data into object
$args = Request::createFromGlobals();
$email = $args->query->post['email'];
$password = $args->query->post['password'];


/** @var array $config */
// Checking account exist
if(HttpKernel::checkCSRF($args->query->post['byte_csrf'])) {
    if(Account::checkAccountExist($email, $config)) {
        if(Account::authorizeAccount($email, $password, $config)) {
            if(Account::saveAccountSession($email, $password, $config)) {
                Account::saveLogin($email, $config);
                header('Location: /dash');
            } else {
                // Internal Server Error
                Request::setSession('byte-error', 'account-500');
                header('Location: /login');
            }
        } else {
            // Forbidden
            Request::setSession('byte-error', 'account-403');
            header('Location: /login');
        }
    } else {
        // Account not found
        Request::setSession('byte-error', 'account-404');
        header('Location: /login');
    }
} else {
    // Invalid CSRF Token
    Request::setSession('byte-error', 'account-401');
    header('Location: /login');
}