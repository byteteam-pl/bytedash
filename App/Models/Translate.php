<?php

namespace Byte;

/**
 * Translation Object
 */
class Translate {

    private $translateArray = array(
        'PL' => array(
            'welcome-login' => "Witamy w panelu ByteDash!",
            'welcome-subtext-login' => "Zaloguj się do panelu ByteDash. Jeśli nie masz konta <a href='/register'>kliknij tutaj</a>, aby się zarejestrować.",
            'email-form' => "Twój Adres Email",
            'login' => "Zaloguj",
            "password-forgot" => "Nie pamiętam hasła!",
            'account-401' => "Błędny Kod CSRF",
            "account-404" => "Konto nie zostalo znalezione",
            "account-403" => "Podane hasło jest błędne!",
            "account-500" => "Posiadamy małe problemy z serwerami! Spróbuj ponownie później!"
        ),
        'EN' => array(
            'welcome-login' => "Welcome in panel ByteDash",
            'welcome-subtext-login' => "Login into panel ByteDash. If you dont have account <a href='/register'>click here</a>, to create account.",
            'email-form' => "Your Email Address",
            'login' => "Login",
            "password-forgot" => "I forgot password!",
            'account-401' => "Invalid CSRF Code",
            "account-404" => "Account not found",
            "account-403" => "Password is incorrect!",
            "account-500" => "We have some problem with our Servers! Please try again later!"
        )
    );

    /**
     * Get Text translation
     *
     * @param string $text
     * 
     * @return string/boolean
     * 
     */
    public function getTranslate($text)
    {
        //echo self::$translateArray[Request::getSession('language', 'PL')][$text];
        return $this->translateArray[Request::getSession('language', 'PL')][$text] ?? FALSE;
    }

}