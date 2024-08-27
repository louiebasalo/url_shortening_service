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
        '/' => __DIR__.'/'
    ];

    foreach($baseDirs as $prefix => $baseDir){

        $file = $baseDir . str_replace('\\',"/", $class).'.php';
        if(file_exists($file)){
            require_once $file;
            break;
        }else {
            echo "\n file above not found. \n";
        }
    }
}

spl_autoload_register('autoLoader');