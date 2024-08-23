<?php

/**
 * Route definition
 */

require_once '../route/Route.php';

use Route\Route;

Route::get("/", "Controller@home");
Route::get("/update",function () {
    echo "update form";
});

//this is another way, with anonymous function being stored the $routes array.
Route::get("/{code}", function ($code) {
    $redirect = new \api\v1\RedirectController();
    $redirect($code);
});