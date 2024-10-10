<?php
/**
 * Route collections
 * Note! refactor this class to only perfoms route collections. transfer the dispatch/routeReqeust and parser functions to the Router class.
 */
namespace route;

require_once './../helper/helper.php';
use function Helper\controller_x_function;
use api\v1\ShortenUrlController;
use App\Controller;
require_once '../autoload.php';

class Route {

    public static $routes = [];
   
    private static function addRoute(string $uri, string $method, $controller)  
    {
        self::$routes[] = [
            'uri' => $uri,
            'method' => $method,
            'callback' => $controller, 
        ];
    }

    public static function get(string $uri, $conrtoller)
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

}