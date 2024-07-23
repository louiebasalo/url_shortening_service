<?php
namespace  App;

use App\ShortenUrlRequest;
use App\ShortenUrlService;
use App\ShortenUrlDao;

class ShortenUrlController {

    public function __construct(){

    }

    public function processRequest(string $method, ?string $short_code) : void 
    {
        if($short_code){
            $this->resource_request($method, $short_code);
        } else {
            $this->collection_request($method);
        }
    }

    public function resource_request(string $method, string $short_code) : void
    {
        $dao = new ShortenUrlDao();
        $data = $dao->get_by_short_code($short_code);
        
        if (!$data) {
            http_response_code(404);
            echo json_encode([
                'message' => 'Shorten URL not found!'
            ]);
            return;
        }

        switch($method) {
            case "GET":
                echo json_encode($data, JSON_PRETTY_PRINT);
                break;
        }
    }
    public function collection_request(string $method) : void
    {
        if($method == 'POST')
        {
            $data = (array) json_decode(file_get_contents("php://input"), true);
            $dao = new ShortenUrlDao();
            $shorten = new ShortenUrlService();
            $data['short_code'] = $shorten->generate();
            $dao->create($data);
            http_response_code(201);
            echo json_encode([
                'message' => 'short url created.',
                "short url" => $data['short_code']
            ]);
        }else{
            echo "not a post request.";
        }
    }
    

}