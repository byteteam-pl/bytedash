<?php

namespace Byte;

use stdClass;
use Byte\Database;
use Byte\Router;

/**
 * Http Model
 */
class Request
{
    /**
     * Getting All of the arguments
     *
     * @return object
     * 
     */
    public static function createFromGlobals()
    {
        $response = new stdClass();
        $query = new stdClass();
        $query->get = $_GET;
        $query->post = $_POST;
        $response->query = $query;
        $response->headers = getallheaders();
        return $response;
    }
    /**
     * Get Request Path
     *
     * @return string
     * 
     */
    public static function getPath()
    {
        return $_SERVER['REQUEST_URI'];
    }
    /**
     * Saving data into session variables
     *
     * @param string $varName
     * @param string $varValue
     * 
     * @return null
     * 
     */
    public static function setSession($varName, $varValue)
    {
        $_SESSION[$varName] = $varValue;
    }
    public static function getSession($varName, $otherOutput)
    {
        if (isset($_SESSION[$varName])) {
            return $_SESSION[$varName];
        } else {
            return $otherOutput;
        }
    }
    /**
     * Get Request Method Type like GET, POST, PUT, DELETE
     *
     * @return string
     * 
     */
    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    /**
     * Getting Server Variable
     *
     * @param string $varName
     * 
     * @return string/null
     * 
     */
    public static function getServerVar($varName)
    {
        return $_SERVER[$varName];
    }
    /**
     * Get Cookie By Name, when output is NULL give response like given argument $otherOutput
     *
     * @param string $cookieName
     * @param string $otherOutput
     * 
     * @return string
     * 
     */
    public static function getCookie($cookieName, $otherOutput)
    {
        $cookie = @$_COOKIE[$cookieName];
        if (isset($cookie)) {
            return $cookie;
        } else {
            return $otherOutput;
        }
    }

    /**
     * Check IP is trusted
     *
     * @param string $ip
     * 
     * @return bool
     * 
     */
    public static function checkTrustedIp($ip)
    {
        require 'App/Config/config.php';
        $result = Database::Query("SELECT * FROM trustedips WHERE ip='$ip'", $config);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Setting IP Into trusted IPs
     *
     * @param mixed $ip
     * 
     * @return bool
     * 
     */
    public static function setTrustedProxies($ip)
    {
        if (self::checkTrustedIp($ip)) {
            return true;
        } else {
            require 'App/Config/config.php';
            $date = date('Y-m-d H:i:s');
            $result = Database::Query("INSERT INTO trustedips (ip, creationDate) VALUES('$ip', '$date')", $config);
            return $result;
        }
    }
    /**
     * Get Client IP
     *
     * @return string/null
     * 
     */
    public static function getIP()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    /**
     * Black List IP
     *
     * @param string $ip
     * 
     * @return bool
     * 
     */
    public static function blackListIP($ip)
    {
        if (self::checkBlackListIP($ip)) {
            return true;
        } else {
            require 'App/Config/config.php';
            $date = date('Y-m-d H:i:s');
            $result = Database::Query("INSERT INTO blacklistips (ip, creationDate) VALUES('$ip','$date')", $config);
            return $result;
        }
    }
    /**
     * Check IP is blacklisted
     *
     * @param string $ip
     * 
     * @return bool
     * 
     */
    public static function checkBlackListIP($ip)
    {
        require 'App/Config/config.php';
        $result = Database::Query("SELECT * FROM blacklistips WHERE ip='$ip'", $config);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Generating Random String
     *
     * @param int $length
     * 
     * @return string
     * 
     */
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * 
     * Generating Request Identifier and log this
     *
     * @param string $ip
     * 
     * @return string
     * 
     */
    public static function generateRequest($note)
    {
        require 'App/Config/config.php';
        $ip = self::getIP();
        $requestId = self::generateRandomString(20);
        $fileHandle = fopen("Shield/logs.log", "a");
        $date = date('Y-m-d H:i:s');
        $txt = "[ACCESS LOG] [DATE] " . $date . " [URL] " . $config['website_url'] . '' . self::getPath() . ' [IP] ' . $ip . ' [RequestId] ' . $requestId . " [Note] " . $note . "\n";
        fwrite($fileHandle, $txt);
        fclose($fileHandle);
        return $requestId;
    }
    /**
     * Protecting your site before attackers
     *
     * @return bool
     * 
     */
    public static function runShield()
    {
        $ip = self::getIP();
        if (self::checkTrustedIp($ip)) {
            return true;
        } else {
            if (self::checkBlackListIP($ip)) {
                $requestId = self::generateRequest('IP is blacklisted');
                self::setSession('requestId', $requestId);
                $router = new Router();
                $router->render('shielderror');
                die();
            } else {
                if (self::checkAttack()) {
                    $requestId = self::generateRequest('Server Is Attacked');
                    self::setSession('requestId', $requestId);
                    self::setSession('error', 'attack');
                    $router = new Router();
                    $router->render('shielderror');
                    die();
                } else {
                }
            }
        }
    }
    /**
     * Check server have status `Attacked`
     *
     * @return bool
     * 
     */
    public static function checkAttack()
    {
        require 'App/Config/config.php';
        $result = Database::Query("SELECT * FROM protection", $config);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['attacked'] == '1') {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    /**
     * Set Server Is `Attacked`
     *
     * @return bool
     * 
     */
    public static function setAttack()
    {
        require 'App/Config/config.php';
        $result = Database::Query("UPDATE protection SET attack='1'", $config);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Unset Server Is Attacked
     *
     * @return bool
     * 
     */
    public static function unsetAttack()
    {
        require 'App/Config/config.php';
        $date = date('Y-m-d H:i:s');
        $result = Database::Query("UPDATE protection SET attack='0', dateLast='$date'", $config);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
