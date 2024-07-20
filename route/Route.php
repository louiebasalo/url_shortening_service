<?php
namespace Route;

class Route {

    private $routes = array();

    private function add(string $uri, string $method)  
    {
        $this->routes = [
            'uri' => $uri
        ];
    }

    public static function get()
    {

    }

}