<?php
namespace Route;

require_once './../helper/helper.php';
use function Helper\controller_x_function;
use Api\v1\ShortenUrlController;
require_once '../autoload.php';

class Route {

    public static $routes = array();

    // public function __construct(){
    //     self::$notFond = function() {
    //         http_response_code(404);
    //         echo json_encode(['Resource Not Found.']);
    //     };
    // }

    private static function addRoute(string $uri, string $method, $controller)  
    {
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
        // var_dump(self::$routes);
        // echo $requestUri;
        foreach(self::$routes as $route)
        {
            if($requestUri === $route['uri'] && $requestMethod === $route['method']){
                $controller = self::parse_controller($route['controller']);
                $instance = new $controller['controller']();
                $function = strval($controller['function']);
                echo $instance->$function();
                return;
            }
        }
        // call_user_func(self::$notFond);

    }

    private static function parse_controller($cf) : array
    {
        list($controller, $function) = explode('@', $cf);
        return ['controller' => '\\api\\v1\\'.$controller, 'function'  => $function];
    }


}