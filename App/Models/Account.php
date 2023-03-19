<?php

namespace Byte;

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
        $result = Database::Query("SELECT * FROM users WHERE email='$email'");
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
        $userAgent = get_browser();
        $date = date('Y-m-d H:i:s');
        $result = Database::Query("INSERT INTO user_logins (email, ip, userAgent, date) VALUES('$email', '$ip', '$userAgent', '$date')", $config);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}
