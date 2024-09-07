<?php
namespace Public;

use Api\v1\Database;
use Api\v1\ShortenUrlController;
use Api\v1\ShortenUrlDao;
use Api\v1\ShortenUrlService;
use Route\Route;
use Route\Router;
use Config;
use Api\V1\Container;

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
