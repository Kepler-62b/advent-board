<?php

namespace Framework;

use Framework\Services\Helpers\LinkManager;
use Framework\Services\ParseURLService;
use Framework\Services\RouteService;
use Symfony\Component\HttpFoundation\Request;

class Kernel
{
    public function __construct()
    {
        try {
            $request = Request::createFromGlobals();
            $link = new LinkManager($request);
            $parseURL = new ParseURLService($request);
            $route = new RouteService($parseURL);
            return $route->routing();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
