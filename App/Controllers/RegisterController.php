<?Php
use Byte\Account;
use Byte\HttpKernel;
use Byte\Request;
@session_start();
require 'App/Config/config.php';

$args = Request::createFromGlobals();
$email = $args->query->post['email'];
$password1 = $args->query->post['password1'];
$password2 = $args->query->post['password2'];
if(HttpKernel::checkCSRF($args->query->post['byte_csrf'])) {
    $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $config['captcha']['privateKey'] . '&response=' . $args->query->post['g-recaptcha-response']);
    $response = json_decode($check);
    if ($response->success == false) {
        Request::setSession('byte-error', 'register-captcha');
        header('Location: /register');
    } else {
        if(Account::checkAccountExist($email, $config)) {
            Request::setSession('byte-error', 'register-404');
            header('Location: /register');            
        } else {
            if($password1 == $password2) {
                if(Account::RegisterAccount($email, $password1, $config)) {
                    Request::setSession('byte-error', 'register-200');
                    header('Location: /login');
                } else {
                    Request::setSession('byte-error', 'account-500');
                    header('Location: /register');
                }
            } else {
                Request::setSession('byte-error', 'register-400');
                header('Location: /register');
            }
        }
    }
} else {
    Request::setSession('byte-error', 'register-401');
    header('Location: /register');
}