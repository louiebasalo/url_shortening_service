<?php

use Route\Route;
use Api\v1\ShortenUrlController;

Route::get('api/v1', "ShortenUrlController@$controller");