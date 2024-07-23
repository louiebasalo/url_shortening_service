<?php
namespace Route;

class Route {

    private static $routes = [];
    private static $notFond;

    public function __construct(){
        self::$notFond = function() {
            http_response_code(404);
            echo json_encode(['Resource Not Found.']);
        };
    }

    private static function addRoute(string $uri, string $method, $callback)  
    {
        self::$routes = [
            'uri' => $uri,
            'method' => $method,
            'callback' => $callback
        ];
    }

    public static function get(string $uri, $callback)
    {
        self::addRoute($uri, 'GET', $callback);
    }

    public static function post(string $uri, $callback)
    {
        self::addRoute($uri, 'GET', $callback);
    }

    public static function patch(string $uri, $callback)
    {
        self::addRoute($uri, 'GET', $callback);
    }

    public static function delete(string $uri, $callback)
    {
        self::addRoute($uri, 'GET', $callback);
    }

    public function setNoutFound(){

    }

    public static function routeRequest(){
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach(self::$routes as $route)
        {
            if($requestUri === $route['uri'] && $requestMethod === $route['method']){
                call_user_func($route['callback']);
                return;
            }
        }
        call_user_func(self::$notFond);
    }


}