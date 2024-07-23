<?php
namespace Public;

use Api\v1\RedirectController;
use Api\v1\ShortenUrlController;
use App\Controller;

spl_autoload_register(function($class){
    require __DIR__ . "/$class.php";
});


$parts = explode("/",$_SERVER["REQUEST_URI"]);

if (strpos($_SERVER['REQUEST_URI'], '/api') === 0 )
{
    require 'api.php';
} 
else { 
    echo "entered index.php";
}

