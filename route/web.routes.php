<?php

/**
 * Route definition
 */

require_once '../route/Route.php';

use Route\Route;

Route::get("/", "Controller@home");
