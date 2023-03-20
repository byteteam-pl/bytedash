<?php

namespace Byte;

/**
 * Response Model
 */
class Response
{
    /**
     * Main Function executing on constructing Response Model
     *
     * @param string/bool $content
     * 
     */
    function __construct($content = FALSE)
    {
        if (!@$content == FALSE) {
            echo $content;
            die();
        }
        $this->headers = (object) [
            'set' => function ($header) {
                array_push($this->header, $header);
            },
            'unset' => function ($header) {
                array_diff($this->header, [$header]);
            },
            'get' => function ($header) {
                return $this->header[array_search($header, $this->header)];
            }
        ];
    }
    /**
     * Content
     *
     * @var string
     */
    private $content = '';
    /**
     * Status Code
     *
     * @var int
     */
    private $statusCode = 200;

    /**
     * Object of Headers
     *
     * @var object
     */
    public $headers;

    /**
     * To where redirect client
     *
     * @var bool/string
     */
    private $redirectUrl = FALSE;
    /**
     * What header is now set
     *
     * @var array
     */
    private $header = array();
    /**
     * Setting Website Content
     *
     * @param string $content
     * 
     * @return true
     * 
     */
    public function setContent($content)
    {
        $this->content = $content;
        return true;
    }
    /**
     * Setting Status Code
     *
     * @param int $code
     * 
     * @return true
     * 
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return true;
    }
    /**
     * Setting Max HTTP cache headers
     *
     * @param int $max
     * 
     * @return true
     * 
     */
    public function setMaxAge($max)
    {
        header('Cache-Control: max-age=' . $max);
        return true;
    }
    /**
     * Set client to redirect to other url address
     *
     * @param string $url
     * 
     * @return bool
     * 
     */
    public function setRedirect($url)
    {
        $this->redirectUrl = $url;
        return true;
    }
    /**
     * Sending response to the client
     *
     * @return bool
     * 
     */
    public function sendResponse()
    {
        for ($i = 0; $i < count($this->header); $i++) {
            header($this->header[$i]);
        }
        if (@$this->redirectUrl != FALSE) {
            header('Location: ' . $this->redirectUrl);
        }
        if (isset($this->content)) {
            echo $this->content;
        }
        http_response_code($this->statusCode);
    }
}