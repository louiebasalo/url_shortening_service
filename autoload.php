<?php

/**
 * Custom autoloader function
 * @param mixed $class
 * @return void
 */
function autoLoader($class){
    $baseDirs = [
        'api\\v1\\' => __DIR__.'/', 
        'app\\' => __DIR__.'/',
    ];

    foreach($baseDirs as $prefix => $baseDir){

        $file = $baseDir . str_replace('\\','/', $class).'.php';
        echo "\n *****".$file."*****";
        if(file_exists($file)){
            echo "\n file above found \n";
            require_once $file;
            break;
        }else {
            echo "\n file above not found. \n";
        }
    }
}

spl_autoload_register('autoLoader');

// spl_autoload_register(function($class){
//     include_once str_replace('\\', '/', $class).'.php';
// });