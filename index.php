<?php

use app\Database;

spl_autoload_register(function($class){
    require __DIR__ . "/$class.php";
});


$database = new Database("localhost","url_shortening_db","root","");
// var_dump($database->connect());


?>