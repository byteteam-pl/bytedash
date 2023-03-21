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
            'welcome-subtext-register' => "Zarejestruj się do panelu ByteDash. Jeżeli posiadasz już konto <a href='/login'>kliknij tutaj</a>, aby zalogować się.",
            'email-form' => "Twój Adres Email",
            'login' => "Zaloguj",
            'register' => "Zarejestruj się",
            'password' => "Hasło",
            "repeat-password" => "Powtórz Hasło",
            "password-forgot" => "Nie pamiętam hasła!",
            'account-401' => "Błędny Kod CSRF",
            "account-404" => "Konto nie zostalo znalezione",
            "account-403" => "Podane hasło jest błędne!",
            "account-500" => "Posiadamy małe problemy z serwerami! Spróbuj ponownie później!",
            "register-captcha" => "Rozwiąż zadanie Google Captcha",
            "register-404" => "Konto z podanym adresem E-Mail już istnieje!",
            "register-401" => "Błędny Kod CSRF",
            "register-400" => "Hasła nie są takie same!",
            "register-500" => "Posiadamy małe problemy z serwerami! Spróbuj ponownie później!",
            "register-200" => "Pomyślnie zarejestrowałeś konto! Sprawdź swój adres E-Mail aby zweryfikować konto!"
        ),
        'EN' => array(
            'welcome-login' => "Welcome in panel ByteDash",
            'welcome-subtext-login' => "Login into panel ByteDash. If you dont have account <a href='/register'>click here</a>, to create account.",
            'welcome-subtext-register' => "Register into panel ByteDash. If you already have account <a href='/login'>Click Here</a>, to login.",
            'email-form' => "Your Email Address",
            'login' => "Login",
            'register' => "Register",
            'password' => "Password",
            'repeat-password' => "Repeat Password",
            "password-forgot" => "I forgot password!",
            'account-401' => "Invalid CSRF Code",
            "account-404" => "Account not found",
            "account-403" => "Password is incorrect!",
            "account-500" => "We have some problem with our Servers! Please try again later!",
            "register-captcha" => "Complete Google Captcha task",
            "register-404" => "There is already account registered with this email address!",
            "register-401" => "Incorrect CSRF Code",
            "register-400" => "Passwords is not same!",
            "register-500" => "We have some problem with our Servers! Please try again later!",
            "register-200" => "Successifully created account! Checkout your email address to verify your account!"
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
    public function checkTranslateExist($language)
    {
        if($this->translateArray[$language]) {
            return true;
        } else {
            return false;
        }
    }

}