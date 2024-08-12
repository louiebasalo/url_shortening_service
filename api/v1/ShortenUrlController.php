<?php
namespace Api\v1;

use Api\v1\ShortenUrlService;
use Api\v1\ShortenUrlDao;

class ShortenUrlController {

    private $dao;
    public function __construct(){
        $this->dao = new ShortenUrlDao();
    }

    public  function get_all() : string{
        return "invoking get_all";
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
        // $dao = new ShortenUrlDao();
        $data = $this->dao->get_by_short_code($short_code);
        
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
            case "DELETE":
                $id = $this->dao->delete($short_code); 
                http_response_code(202);
                echo json_encode([
                    "message" => "Deleted.",
                    "rows" => $id
                ]);
                break;
            case "PATCH":
                $long_url = (array) json_decode(file_get_contents("php://input"), true);
                $row = $this->dao->update($short_code, $long_url['long_url']);
                http_response_code(201);
                echo json_encode([
                    "message" => "long link for $short_code is updated.",
                    "rows" => $row
                ]);
                break;
            default;
                http_response_code(405);
                header("Allow: GET, POST, PATCH, DELETE");
        }
    }
    public function collection_request(string $method) : void
    {
        if($method == 'POST')
        {
            $data = (array) json_decode(file_get_contents("php://input"), true);
            // $dao = new ShortenUrlDao();
            $shorten = new ShortenUrlService();
            $data['short_code'] = $shorten->generate();
            $this->dao->create($data);
            http_response_code(201);
            echo json_encode([
                'message' => 'short url created.',
                "short url" => $data['short_code']
            ]);
        }else{
            $dao = new ShortenUrlDao();
            echo json_encode($dao->get_all());
        }
    }
    

}