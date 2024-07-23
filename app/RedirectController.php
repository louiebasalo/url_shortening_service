<?php
namespace App;

use App\ShortenUrlDao;
use App\ShortenUrlService;

class RedirectController {

    public function __invoke($uri){
        $dao = new ShortenUrlDao();
        $data = $dao->get_by_short_code($uri);

        if(!$data){
            http_response_code(404);
            echo json_encode(["message" => "URI not found!"]);
            return;
        }

        $click = new ShortenUrlService();
        $click->increment_click_counter($data);
        
        // remove header
        header_remove('Cache-Control');
        header_remove('Last-Modified');
        header_remove('Expires');

        // set header
        header('Expires: Thu, 1 Jan 1970 00:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0',false);

        // http_response_code(301);
        header("HTTP/1.1 301 Moved Permanently"); 
        header('Location: '.$data['long_url'], true, 301);
        header("Connection: close");
    }

}
