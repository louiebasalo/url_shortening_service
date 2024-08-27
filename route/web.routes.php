<?php

/**
 * Route definition
 */

require_once '../route/Route.php';

use Route\Route;
use Api\v1\Database;
use Api\v1\ShortenUrlService;
use Api\v1\ShortenUrlDao;

Route::get("/", "Controller@home");
Route::get("/update",function () {
    echo "update form";
});

//this is another way, with anonymous function being stored the $routes array.
Route::get("/{code}", function ($code) {

    $config = new \Config();
    $config = $config();
    $db = new Database($config['DB_HOST'], $config['DB_NAME'], $config['DB_USER'], $config['DB_PASS']);
    $dao = new ShortenUrlDao($db->connect());
    $shortenURLService = new ShortenUrlService($dao);

    $redirect = new \api\v1\RedirectController($shortenURLService);
    $redirect($code);
});