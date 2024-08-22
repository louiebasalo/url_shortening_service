<?php

/**
 * Route definition
 */

require_once '../route/Route.php';

use Route\Route;

Route::get("/api/v1", "ShortenUrlController@get_all");

// /api/v1/{id} here {id} is called 'path parameter'
Route::get("/api/v1/{code}", "ShortenUrlController@get_one"); 


var_dump(Route::$routes);

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$route = '/api/v1/{code}';
$regex = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route); // this patern /{[^}]+}/ is also working
$regex = '#^' . $regex . '$#';


echo "\n";
echo $regex;
echo "\n";

if(preg_match($regex,$requestUri, $match )){
    echo "here  ----";
    var_dump($match);
}



