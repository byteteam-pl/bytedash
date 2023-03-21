<?php
use Byte\HttpKernel;
use Byte\Request;
use Byte\Translate;
$Translate = new Translate;
@session_start();
require 'App/Config/config.php';

if(Request::getSession('logged', FALSE)) {
  header('Location: /dash');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/css/login.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
</head>

<body>
    <script>
    MicroModal.init({
        onShow: (modal) => console.info(`${modal.id} is shown`), // [1]
        onClose: (modal) => console.info(`${modal.id} is hidden`), // [2]
        openTrigger: "data-custom-open", // [3]
        closeTrigger: "data-custom-close", // [4]
        openClass: "is-open", // [5]
        disableScroll: true, // [6]
        disableFocus: false, // [7]
        awaitOpenAnimation: false, // [8]
        awaitCloseAnimation: false, // [9]
        debugMode: true, // [10]
    });
    </script>
    <div class="language">
        <img src="https://www.countryflagicons.com/FLAT/64/<?php if(strtoupper(Request::getSession('language', "EN")) == "EN") { echo 'GB';} else { echo strtoupper(Request::getSession('language', "EN")); }?>.png"
            class="flag" onclick="MicroModal.show('modal-1');" alt="" />
    </div>
    <div class="box">
        <div class="container">
            <img src="assets/img/logo.png" alt="" class="logo" />
            <h2><?php echo $Translate->getTranslate('welcome-login');?></h2>
            <?php
              echo $Translate->getTranslate(Request::getSession('byte-error', FALSE));
            unset($_SESSION['byte-error']);
            ?>
            <span><?php echo $Translate->getTranslate('welcome-subtext-login');?></span>
            <form action="/login" method="POST">
                <input autocomplete="username" type="email" name="email"
                    placeholder="<?php echo $Translate->getTranslate('email-form');?>" />
                <input autocomplete="current-password" type="password" name="password" placeholder="**********" />
                <input type="hidden" name="byte_csrf" value="<?php echo HttpKernel::generateCSRF();?>">
                <button type="submit" class="btn-primary"><?php echo $Translate->getTranslate('login');?></button>
            </form>
            <a href="password/reset"><?php echo $Translate->getTranslate('password-forgot');?></a>
        </div>
    </div>
    <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">Język</h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close
                        style="cursor: pointer"></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <p>Zmień język na ten, który tobie odpowiada!</p>
                </main>
                <footer class="modal__footer">
                    <button onclick="location.href='?language=PL'" class="modal__btn modal__btn-danger">Polski</button>
                    <button onclick="location.href='?language=EN'" class="modal__btn modal__btn-primary">
                        English
                    </button>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>