<?php

require_once '../route/Route.php';

use Route\Route;

Route::get("/api/v1/", "ShortenUrlController@get_all");
Route::get("/api/v1/{code}", "ShortenUrlController@get_one");


var_dump(Route::$routes);