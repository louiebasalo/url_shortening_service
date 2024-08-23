<?php

/**
 * Route definition
 */

require_once '../route/Route.php';

use Route\Route;

Route::get("/api/v1", "ShortenUrlController@get_all");
// /api/v1/{id} here {id} is called 'path parameter'
Route::get("/api/v1/{code}", "ShortenUrlController@get_by_code"); 
Route::post("/api/v1/create","ShortenUrlController@create");
Route::patch("/api/v1/{code}/update","ShortenUrlController@patch");
Route::delete("/api/v1/{code}/delete","ShortenUrlController@delete");


// var_dump(Route::$routes);
