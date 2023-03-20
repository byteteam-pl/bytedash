<?php

namespace Byte;

use ControllerResolverInterface;
use Exception;
use Byte\Request;

/**
 * HttpKernel Interface Handler
 */
interface HttpKernelInterface
{
    public function handle(Request $request, $type);
}

/**
 * Http Kernel Class Object with implementing ControllerResolverInterface
 */
class HttpKernel extends Exception implements ControllerResolverInterface
{
    /**
     * Error Message Handling
     *
     * @return string
     * 
     */
    public function errorMessage()
    {
        $errorMsg = '[Byte-Framework] Error detected on line ' . $this->getLine() . ' in ' . $this->getFile()
            . ': <b>' . $this->getMessage() . '</b>';
        return $errorMsg;
    }
    /**
     * Check Controller is exist
     *
     * @param string $name
     * 
     * @return bool
     * 
     */
    public function checkController($name)
    {
        if (file_exists('App/Controllers/' . $name)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Getting Controller
     *
     * @param object Request $request
     * @param string $name
     * 
     * @return object/bool
     * 
     */
    public function getController(Request $request, $name)
    {
        if (self::checkController($name)) {
            require 'App/Controllers/' . $name;
            return new $name;
        } else {
            return false;
        }
    }
    /**
     * Handling Controller Constructing
     *
     * @param object Request $request
     * @param string $name
     * @param string $functionName
     * 
     * @return bool/self
     * 
     */
    public function controllerHandle(Request $request, $name, $functionName)
    {
        if (self::checkController($name)) {
            $functionName($request);
        } else {
            return false;
        }
    }
    /**
     * Generating CSRF Token To Forms
     *
     * 
     * @return string
     * 
     */
    public static function generateCSRF()
    {
        $token = bin2hex(random_bytes(64));
        Request::setSession('bc_sessions_csrf_token', $token);
        return $token;
    }
    /**
     * Checking CSRF Token Is Valid
     *
     * @param string $token
     * 
     * @return bool
     * 
     */
    public static function checkCSRF($token)
    {
        if ($token == Request::getSession('bc_sessions_csrf_token', 'none')) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Kernel Http Event Listener
 */
class KernelListener
{
    /**
     * Array of events
     *
     * @var array
     */
    private static $events = [];

    /**
     * Listening Event
     *
     * @param string $name
     * @param function $callback
     * 
     * @return null
     * 
     */
    public static function listen($name, $callback)
    {
        self::$events[$name][] = $callback;
    }

    /**
     * Triggering Event
     *
     * @param string $name
     * @param mixed $argument
     * 
     * @return function
     * 
     */
    public static function trigger($name, $argument = null)
    {
        foreach (self::$events[$name] as $event => $callback) {
            if ($argument && is_array($argument)) {
                call_user_func_array($callback, $argument);
            } elseif ($argument && !is_array($argument)) {
                call_user_func($callback, $argument);
            } else {
                call_user_func($callback);
            }
        }
    }
}