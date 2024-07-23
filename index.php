<?php

use app\Database;
use App\RedirectController;
use App\ShortenUrlController;

spl_autoload_register(function($class){
    require __DIR__ . "/$class.php";
});

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/",$_SERVER["REQUEST_URI"]);

if ($parts[1] == 'shorturl')
{
    $id = $parts[3] ?? null;

    $controller = new ShortenUrlController();
    $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);

} else {
    $redirect = new RedirectController();
    $redirect($parts[1]);
}



// $controller->processRequest();



// $parts =

// $controller->processRequest();


//later na lang ning routes, functional requirements sa ta
/*
Route::get('/', function() {
    
});

or try this
Route::get('/', '{$className}::staticMethod');
*/
