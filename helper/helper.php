<?php

namespace Helper;

use Api\v1\ShortenUrlController;
use RecursiveDirectoryIterator;

/**
 * Summary of Helper\controller_x_function
 * @return void
 * executes the function in a conrtoller
 */
function controller_x_function(string $cf) : string | null
{
    list($controller, $function) = explode('@', $cf);
    
    if(!class_exists($controller) && !method_exists($controller, $function)){
        http_response_code(404);
        return "Conrtoller and function not found.";
    }

    echo "helper";
    return  $controller::get_all();
}
