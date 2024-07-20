<?php
namespace App;

use App\ShortenUrlDao;
use App\ShortenUrlService;

class RedirectController {

   
    // public static function redirect(string $short_code)
    // {
    //     $dao = new ShortenUrlDao();
    //     header('Location: '.$dao->get_original($short_code));
    // }

    public function __invoke($uri){
        $dao = new ShortenUrlDao();
        $data = $dao->get_by_short_code($uri);

        $click = new ShortenUrlService();
        $click->increment_click_counter($data);
        
        
        if(!$data){
            http_response_code(404);
            echo json_encode(["message" => "URI not found!"]);
            return;
        }
     
        // http_response_code(301);
        header("HTTP/1.1 301 Moved Permanently"); 
        header('Location: '.$data['original_url'], true, 301);
        header("Connection: close");
    }

}
