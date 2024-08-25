<?php
namespace App;

use Api\v1\ShortenUrlDao;

class Controller {

    public function home()
    {
        $dao = new ShortenUrlDao();
        $data = $dao->get_all();
        include 'home.php';
    }

  
}