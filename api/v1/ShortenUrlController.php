<?php
namespace Api\v1;

use Api\v1\ShortenUrlService;
use Api\v1\URLModel;
use Api\V1\ValidateURL;

class ShortenUrlController {

    private $shortenUrlService;
    public function __construct(ShortenUrlService $shortenUrlService ){
        $this->shortenUrlService = $shortenUrlService;
    }

    public  function get_all() {
        $urlModel = new URLModel();
        $response = $this->shortenUrlService->getShortenedURLCollection($urlModel);
        echo json_encode($response->get_collection(), JSON_PRETTY_PRINT);
    }

    /**
     * in the future, this method will be refactor, to accept an argument, the argument would be the custom allias the user provided.
     * @return void
     */
    public function create() {
        $data = (array) json_decode(file_get_contents("php://input"), true);

        $validateURL = new ValidateURL($data);
        if(!$validateURL->validate()) {
            
            http_response_code(400);
            echo json_encode([
                "message" => "Failed to save.",
                "error: " => $validateURL->failure_message()
            ]);
            return;
        } 

        $urlModel = new URLModel();

        $urlModel->set_originalUrl($data['long_url']);
        $urlModel->set_shortCode($this->shortenUrlService->generate());
        $this->shortenUrlService->shortenURL($urlModel);
        
        http_response_code(201);
        echo json_encode([
            "message" => "short url created.",
            "id" => $urlModel->get_id(),
            "short_url" => $urlModel->get_shortCode()
        ]);
    }
 
    public function get_by_code($code){
        $response = $this->shortenUrlService->getShortenedURL($code);

        if (!$response) {
            http_response_code(404);
            echo json_encode([
                'message' => 'The shortened URL is not found in the database'
            ]);
        } else {
            echo json_encode($response->get_collection(), JSON_PRETTY_PRINT);
        }
    }


    public function get_and_paginate() 
    {
        // $_GET['page'] ?? 1; //this is called Null Coalescing Operator. this is to simplify isset();
        $urlModel = new URLModel();
        $urlModel->set_page($_GET['page'] ?? 1);
        $urlModel->set_rows($_GET['rows'] ?? 10);

        $response = $this->shortenUrlService->getWithPagination($urlModel);

        echo json_encode($response->get_collection());
    }

    public function patch($code){
        $long_url = (array) json_decode(file_get_contents("php://input"), true);

        $validateURL = new ValidateURL($long_url);
        if(!$validateURL->validate()) {
            
            http_response_code(400);
            echo json_encode([
                "error" => "Failed to save.",
                "message" => $validateURL->failure_message()
            ]);
            return;
        } 

        $urlModel = new URLModel();
        $urlModel->set_originalUrl($long_url['long_url']);
        $urlModel->set_shortCode($code);

        if(!$this->shortenUrlService->isShortCodeExist($code)){
            http_response_code(404);
            echo json_encode([
                "message" => "Nothing Updated. Code $code does not exist."
            ]);
            return;
        }

        $row = $this->shortenUrlService->updateShortenURL($urlModel);

        http_response_code(200);
        echo json_encode([
            "message" => "long link for $code is updated.",
            "rows" => $row
        ]);
    }

    public function delete($code){
        $urlModel = new URLModel();
        $urlModel->set_shortCode($code);
        
        if(!$this->shortenUrlService->isShortCodeExist($code)){
            http_response_code(404);
            echo json_encode([
                "message" => "Nothing deleted. Code $code does not exist."
            ]);
            return;
        }
        $id = $this->shortenUrlService->deleteShortenURL($urlModel); 

        http_response_code(200);
        echo json_encode([
            "message" => "Deleted.",
            "rows" => $id
        ]);
    }

}