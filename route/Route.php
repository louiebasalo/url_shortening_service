<?php
namespace Route;

use function Helper\controller_x_function;

class Route {

    private static $routes = array();

    // public function __construct(){
    //     self::$notFond = function() {
    //         http_response_code(404);
    //         echo json_encode(['Resource Not Found.']);
    //     };
    // }

    private static function addRoute(string $uri, string $method, $controller)  
    {
        echo "add";
        self::$routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller, 
        ];
    }

    public static function get(string $uri, string $conrtoller)
    {
        self::addRoute($uri, 'GET', $conrtoller );
    }

    public static function post(string $uri, $conrtoller)
    {
        self::addRoute($uri, 'POST', $conrtoller);
    }

    public static function patch(string $uri, $conrtoller)
    {
        self::addRoute($uri, 'PATCH', $conrtoller);
    }

    public static function delete(string $uri, $conrtoller)
    {
        self::addRoute($uri, 'DELETE', $conrtoller);
    }

    public static function routeRequest(){
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        var_dump(self::$routes);
        foreach(self::$routes as $route)
        {
            if($requestUri === $route['uri'] && $requestMethod === $route['method']){
                // call_user_func($route['controller']);
                return controller_x_function($route['controller']);
            }
        }
        // call_user_func(self::$notFond);

    }


}