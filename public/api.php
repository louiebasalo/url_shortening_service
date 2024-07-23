<?php
namespace Public;

use Route\Route;

header("Content-type: application/json; charset=UTF-8");

spl_autoload_register(function($class){
    require __DIR__ . "/$class.php";
});

$parts = explode("/",$_SERVER["REQUEST_URI"]);


echo "Entered the API entry point.";