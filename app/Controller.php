<?php
namespace App;

class Controller {

    public function __invoke(){
        require_once('home.php');
    }

    public function home()
    {
        echo 'you are at home';
    }
}