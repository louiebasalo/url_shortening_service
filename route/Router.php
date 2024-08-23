<?php

/**
 * decided to create this separate class.
 * purpose; dispatch request to the approriate controllers. it compares the current uri against the route collections and match them to dispatch 
 * 
 * add middleware someday
 */

 namespace Route;
 use Route\Route;
 
require_once '../autoload.php';

 class Router {

    // static $notFond = [];
    // public function __construct(){
    //     self::$notFond = function() {
    //         http_response_code(404);
    //         echo json_encode(['Resource Not Found.']);
    //     };
    // }
    public static function dipatch(){

        foreach(Route::$routes as $route)
        {
            $regex = preg_replace('/\{[^\}]+\}/','([^/]+)',$route['uri']);
            $regex = "#^$regex$#";
            // var_dump($regex);

            if(preg_match($regex, $_SERVER['REQUEST_URI'], $matches) && $_SERVER['REQUEST_METHOD'] === $route['method']){
                if(count($matches) > 1){
                    // echo "\nif match with param \n";
                    array_shift($matches);
                    // echo strval($matches[0]) . "\n";
                    // var_dump($matches);
                    // echo "\n";
                    $controller = self::parse_controller($route['controller']);
                    $controllerInstance = new $controller['controller']();
                    $function = $controller['function'];

                    return $controllerInstance->$function(strval($matches[0]));
                }else{
                    echo "\nif match and without param \n";
                    $controller = self::parse_controller($route['controller']);
                    $controllerInstance = new $controller['controller']();
                    // $function = strval($controller['function']);
                    $function = $controller['function'];

                    return $controllerInstance->$function();
                }
            }
        }
        // call_user_func(self::$notFond);
    }

    /**
     * since our route definition action is in this form controller@function, this functions seprate these 2 strings and return them in one array
     * I have included the namepspace of a countroller in the controller element in the returned array, since we are autoloading a class using namespace.
     * Putting the \\api\\v1\\ in the baseDir array in autolad file will only take as a string for path, and since we need to use this string in the dispatch function I dicided to include it here instead, so that, dispatch function can use it as the path for namespace, and autoload can use it as well as the file path .
     * @param mixed $cf
     * @return array
     */
    private static function parse_controller($cf) : array
    {
        list($controller, $function) = explode('@', $cf);
        if(strpos($_SERVER['REQUEST_URI'], '/api') === 0 )
        {
            return ['controller' => "\\api\\v1\\$controller", 'function'  => $function];
        } else {
            return ['controller' => "\\app\\$controller", 'function' => $function];
        }
    }

 }