<?php
namespace public;

use api\v1\Database;
use api\v1\ShortenUrlController;
use api\v1\ShortenUrlDao;
use api\v1\ShortenUrlService;
use route\Route;
use route\Router;
use Config;
use api\v1\Container;

require_once "./../route/api.routes.php";

header("Content-type: application/json; charset=UTF-8");


// $container->set(Database::class, function(){
//     return new Database(
//         host: "localhost", 
//         dbname: "url_shortener", 
//         user: "root", 
//         password: ""
//     );
// });


Router::dipatch($container);
