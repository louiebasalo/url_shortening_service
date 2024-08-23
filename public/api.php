<?php
namespace Public;

use Api\v1\ShortenUrlController;
use Route\Router;
require_once "./../route/api.routes.php";

header("Content-type: application/json; charset=UTF-8");

// $parts = explode("/",$_SERVER["REQUEST_URI"]);
// var_dump($parts);
// echo "\n\n  with parse_url \n";
// $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// var_dump($requestUri);


/**
 * to be changed as Router::dispatch()
 * cha naaan
 */
Router::dipatch();
