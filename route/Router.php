<?php

/**
 * decided to create this separate class.
 * purpose; dispatch request to the approriate controllers. it compares the current uri against the route collections and match them to dispatch 
 * 
 * add middleware someday
 */

 namespace Route;
 use Api\v1\Database;
 use Api\v1\URLModel;
 use Route\Route;
 use App\Controller;
 use Api\v1\ShortenUrlService;
 use Api\v1\ShortenUrlDao;
 use Api\v1\RedirectController;
 use Api\V1\Container;
 use ReflectionClass;
 
require_once '../autoload.php';

 class Router {

    public static function dipatch(Container $container){

        foreach(Route::$routes as $route)
        {   
            $currenturi = explode('?', $_SERVER['REQUEST_URI']);
            $regex = preg_replace('/\{[^\}]+\}/','([^/]+)',$route['uri']);
            $regex = "#^$regex$#";
            //create a separate function for comparing/maching
            if(preg_match($regex, $currenturi[0], $matches) && $_SERVER['REQUEST_METHOD'] === $route['method']){

                if(count($matches) > 1){
                    array_shift($matches);

                    if(is_callable($route['callback'])) {
                        return call_user_func($route['callback'],$matches[0]);
                    };

                    $controller = self::parse_controller($route['callback']);
                    $function = $controller['function'];
                    $controllerobj = $container->get($controller['controller']);

                    return $controllerobj->$function(strval($matches[0]));

                }else{

                    if(is_callable($route['callback'])) {
                        return call_user_func($route['callback'],$matches[0]); //2nd argument here becomes optional/not in use
                    };

                    $controller = self::parse_controller($route['callback']);
                    $function = $controller['function'];
                    $controllerobj = $container->get($controller['controller']);

                    return $controllerobj->$function();
                }
            }
        }

        http_response_code(404);
        header("Content-type: application/json; charset=UTF-8");
        $url = "http".(isset($_SERVER['HTTPS']) ? "s" : "")."://" . $_SERVER['HTTP_HOST'] . "" . $_SERVER['REQUEST_URI'];

        echo json_encode([
            "error" => "resource not found.",
            "message" => "the endpoint '$url' may not have existed."
        ]);
    }

    private static function parse_parameter() 
    {

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