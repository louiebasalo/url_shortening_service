<?php
// namespace Public;

use Api\v1\RedirectController;
use Api\v1\ShortenUrlController;
use App\Controller;
use Route\Router;

require_once '../autoload.php';

if (strpos($_SERVER['REQUEST_URI'], '/api') === 0 )
{
    require 'api.php';
} 
else { 
    require './../route/web.routes.php';
    Router::dipatch();
}
