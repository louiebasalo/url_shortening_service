<?php
namespace Public;

use Api\v1\ShortenUrlController;
use Route\Route;
require_once "./../route/api.routes.php";

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/",$_SERVER["REQUEST_URI"]);
var_dump($parts);



Route::routeRequest();