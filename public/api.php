<?php
namespace Public;

use Route\Route;
use Route\Router;
require_once "./../route/api.routes.php";

header("Content-type: application/json; charset=UTF-8");

Router::dipatch();
