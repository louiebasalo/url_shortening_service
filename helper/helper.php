<?php

namespace Helper;


function controller_x_function(string $cf) : string | null
{

    list($controller, $function) = explode('@', $cf);
    
    echo $controller;
    // echo $function;
    // if(class_exists($controller)){
    //     http_response_code(404);
    //     return "Conrtoller not found.";
    // }
    // if(!method_exists($controller, $function)){
    //     http_response_code(404);
    //     return "function not found.";
    // }

    $instance = new $controller();
    return  $instance->$function();

    // return null;
    
}
