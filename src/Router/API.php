<?php
namespace Src\Router;

class API
{
    public $pattern;
    public $controllerName;

    public function __construct($pattern, $controllerName)
    {
        $this->pattern = $pattern;
        $this->controllerName = $controllerName;
    }
}
    