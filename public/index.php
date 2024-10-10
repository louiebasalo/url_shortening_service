<?php
// namespace Public;

use route\Router;
use api\v1\Container;
use api\v1\Database;

require_once '../autoload.php';
require_once '../config.php';

$container = new Container();


$container->set(Database::class, function(){
    $config = new \Config();
    $config = $config();
    return new Database(
        host: $config['DB_HOST'], 
        dbname: $config['DB_NAME'], 
        user: $config['DB_USER'], 
        password: $config['DB_PASS']
    );
});


if (strpos($_SERVER['REQUEST_URI'], '/api') === 0 )
{
    require 'api.php';
} 
else { 
    require './../route/web.routes.php';
    Router::dipatch($container);
}
