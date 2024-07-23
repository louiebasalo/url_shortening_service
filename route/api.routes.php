<?php

require_once '../route/Route.php';

use Route\Route;

Route::get("api/v1", "ShortenUrlController@get_all");

var_dump(Route::$routes);