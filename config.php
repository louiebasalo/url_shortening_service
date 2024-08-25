<?php

class Config {
    
    public function __invoke(){
        return [
            'DB_HOST' => 'localhost',
            'DB_USER' => 'root',
            'DB_PASS' => '',
            'DB_NAME' => 'url_shortener',
            'MY_URL' => 'http://localhost:8000/' //Should be separated in the future for bigger projects.
        ];
    }
}