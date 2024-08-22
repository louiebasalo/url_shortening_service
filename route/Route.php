<?php
/**
 * Route collections
 * Note! refactor this class to only perfoms route collections. transfer the dispatch/routeReqeust function to the Router class.
 */
namespace Route;

require_once './../helper/helper.php';
use function Helper\controller_x_function;
use Api\v1\ShortenUrlController;
use App\Controller;
require_once '../autoload.php';

class Route {

    public static $routes = [];
    static $notFond = [];
    public function __construct(){
        self::$notFond = function() {
            http_response_code(404);
            echo json_encode(['Resource Not Found.']);
        };
    }

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


    /**
     * to be moved to the class Router and to be renamed dispatch()
     * the matching functionality is to be moved to a separate method in the class Router
     * @return mixed
     */
    public static function routeRequest(){
        // $requestUri = $_SERVER['REQUEST_URI'];   --decided to remove this space wise.
        // $requestMethod = $_SERVER['REQUEST_METHOD'];
        // var_dump(self::$routes);


        foreach(self::$routes as $route)
        {
            if($_SERVER['REQUEST_URI'] === $route['uri'] && $_SERVER['REQUEST_METHOD'] === $route['method']){   // I think this checking operation should have a separate function.
                $controller = self::parse_controller($route['controller'], $route['uri']);
                $instance = new $controller['controller']();
                $function = strval($controller['function']);
                return $instance->$function();
            }
            else {
                echo 'wala';
            }
        }
        // call_user_func(self::$notFond);

    }

    /**
     * decided to put the '\\api\\v1\\' here as part of the return of this method because we are using namespace and we are instanciating the controller class dynamically.
     * and so, the in the autload.php the basedires assoc array only holds the value '/' so it won't go like this ..dir/app/v1/app/v1 
     * 
     * maybe use a parse_url() to parse the uri to get the paramteres
     * 
     * to be moved to the class Router
     * @param mixed $cf
     * @param mixed $uri
     * @return array
     */
    private static function parse_controller($cf, $uri) : array
    {
        
        list($controller, $function) = explode('@', $cf);
        if(strpos($_SERVER['REQUEST_URI'], '/api') === 0 )
        {
            return ['controller' => '\\api\\v1\\'.$controller, 'function'  => $function];
        } else {
            return ['controller' => '\\app\\'.$controller, 'function' => $function];
        }
        
    }


}