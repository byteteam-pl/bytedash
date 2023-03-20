<?Php
use Byte\HttpKernel;
use Byte\Request;
@session_start();
require 'App/Config/config.php';

$args = Request::createFromGlobals();
$email = $args->query->post['email'];
$password1 = $args->query->post['password1'];
$password2 = $args->query->post['password2'];
if(HttpKernel::checkCSRF($args->query->post['byte_csrf'])) {

} else {
    Request::setSession('byte-error', '401');
    header('Location: /register');
}