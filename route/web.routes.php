<?php

/**
 * Route definition
 */

require_once '../route/Route.php';

use Api\v1\RedirectController;
use Route\Route;
use Api\v1\Database;
use Api\V1\Container;

Route::get("/", "Controller@home");
Route::get("/update",function () {
    echo "update form";
});

//this is another way, with anonymous function being stored the $routes array.
Route::get("/{code}", function ($code) {
    $container = new Container(); //the container object in index.php is out of scope, I created new container object here

    $container->set(Database::class, function(){
        $config = new \Config();
        $config = $config();
        return new Database(
            host: $config['DB_HOST'], 
            dbname: $config['DB_NAME'], 
            user: $config['DB_USER'], 
            password: $config['DB_PASS']
        );
    });

    $controller = $container->get(RedirectController::class);
    return $controller($code);
});