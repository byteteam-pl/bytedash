<?php

namespace Byte;

use Closure;

class Middleware
{
    private $next;

    public function __construct($next)
    {
        $this->next = $next;
    }

    public function handle($request)
    {
        $response = call_user_func($this->next, $request);
        return $response;
    }
}

$middlewareStack = [];

$middlewareStack[] = new Middleware(function ($request) {
    return new Response();
});

$request = new Request();

foreach ($middlewareStack as $middleware) {
    $requestHandler = function ($request) use ($middleware) {
        return $middleware->handle($request);
    };
    $middleware->next = $requestHandler;
}

$response = call_user_func($requestHandler, $request);
/// TODO