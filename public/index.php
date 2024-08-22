<?php
// namespace Public;

use Api\v1\RedirectController;
use Api\v1\ShortenUrlController;
use App\Controller;
use Route\Route;

require_once '../autoload.php';

// const BASE_PATH = __DIR__.'/../';

// echo BASE_PATH;

echo "<br/>";
$parts = explode("/",$_SERVER["REQUEST_URI"]);

if (strpos($_SERVER['REQUEST_URI'], '/api') === 0 )
{
    require 'api.php';
} 
else { 
    require './../route/web.routes.php';
/**
 * to be changed as Router::dispatch()
 * cha naaan
 */
    Route::routeRequest();
}
