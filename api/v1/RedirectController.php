<?php
namespace Api\v1;

use Api\v1\ShortenUrlDao;
use Api\v1\ShortenUrlService;

class RedirectController {

    private $shortenedURLService;
    public function __construct(ShortenUrlService $shortenedURLService){
        $this->shortenedURLService = $shortenedURLService;
    }

    public function __invoke($uri){
       
        $data = $this->shortenedURLService->getShortenedURLToRedirect($uri);

        if(!$data){
            http_response_code(404);
            echo json_encode(["message" => "URI not found!"]);
            return;
        }

        $this->shortenedURLService->increment_click_counter($data);
        
        // remove header
        header_remove('Cache-Control');
        header_remove('Last-Modified');
        header_remove('Expires');

        // set header to not allow caching
        header('Expires: Thu, 1 Jan 1970 00:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0',false);

        // http_response_code(301);
        header("HTTP/1.1 301 Moved Permanently"); 
        header('Location: '.$data->get_originalUrl(), true, 301);
        header("Connection: close");
    }

}
