<?php
namespace Public;

use Api\v1\RedirectController;
use Api\v1\ShortenUrlController;
use App\Controller;
use Route\Route;

const BASE_PATH = __DIR__.'/../';

spl_autoload_register(function($class){
    require BASE_PATH."$class.php";
});


$parts = explode("/",$_SERVER["REQUEST_URI"]);

if (strpos($_SERVER['REQUEST_URI'], '/api') === 0 )
{
    require 'api.php';
} 
else { 
    
}

