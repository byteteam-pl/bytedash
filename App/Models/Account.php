<?php

namespace Byte;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * @author Francuz <contact@francuz.space>
 * @description Account Model to control all database data etc
 */
class Account
{
    public static function checkAccountExist($email, $config){
        $email = htmlspecialchars($email);
        $result = Database::Query("SELECT * FROM users WHERE email='$email'", $config);
        if($result->num_rows>0) {
            return true;
        } else {
            return false;
        }
    }
    public static function saveAccountSession($email, $password, $config) {
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        $result = Database::Query("SELECT * FROM users WHERE email='$email'", $config);
        if($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                if(password_verify($password, $row['password'])) {
                    Request::setSession('logged', TRUE);
                    Request::setSession('email', $row['email']);
                    Request::setSession('identifier', $row['identifier']);
                    Request::setSession('creationDate', $row['creationDate']);
                    Request::setSession('isAdmin', $row['isAdmin']);
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    public static function authorizeAccount($email, $password, $config) {
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        $result = Database::Query("SELECT * FROM users WHERE email='$email'", $config);
        if($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                if(password_verify($password, $row['password'])) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    public static function saveLogin($email, $config)
    {
        $ip = Request::getIP();
        $userAgent = Request::getServerVar('HTTP_USER_AGENT');
        $date = date('Y-m-d H:i:s');
        $result = Database::Query("INSERT INTO user_logins (email, ip, userAgent, datee) VALUES('$email', '$ip', '$userAgent', '$date')", $config);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
    public static function addVerify($email, $config)
    {
        $date = date('Y-m-d H:i:s');
        $identifier = Request::generateRandomString(20);
        $result = Database::Query("INSERT INTO users_verify (email, enablee, datee, identifier) VALUES('$email', '1', '$date', '$identifier')", $config);
        if($result) {
            return $identifier;
        } else {
            return false;
        }
    }
    public static function sendVerifyEmail($email, $config)
    {
        $result = self::addVerify($email, $config);
        if(!@$result) {
            return false;
        } else {
            require 'vendor/autoload.php';
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = $config['smtp']['ip'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $config['smtp']['noreply']; 
                $mail->Password   = $config['smtp']['password'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = $config['smtp']['port'];
            
                $mail->setFrom($config['smtp']['noreply'], 'No-Reply');
                $mail->addAddress($email);
            
            
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Verify Your Account | ByteDash';
                $mail->Body    = 'Verify your account by <a href="' . $config['website_url'] . '/account/' . $email . '/identifier=' . $result . '">Clicking here</a><br>If you dont creating account in ByteDash please contact with our support contact@xxxx.xxx or call to us +XX XXX XXX XXXX<br><br>ByteTeam.pl Copyright 2022-2023';
                
                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }
    public static function RegisterAccount($email, $password, $config)
    {
        if(self::sendVerifyEmail($email, $config)) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $date = date('Y-m-d H:i:s');
            $identifier = Request::generateRandomString(30);
            $result = Database::Query("INSERT INTO users (email, password, creationDate, identifier) VALUES('$email', '$password', '$date', '$identifier')", $config);
            if($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}