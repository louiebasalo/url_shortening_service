<?php
namespace Api\v1;

use Api\v1\ShortenUrlService;
use Api\v1\ShortenUrlDao;

class ShortenUrlController {

    private $shortenUrlService;
    public function __construct(ShortenUrlService $shortenUrlService ){
        $this->shortenUrlService = $shortenUrlService;
    }

    public  function get_all() {

        echo json_encode($this->shortenUrlService->getShortenedURLCollection());
    }

    /**
     * in the future, this method will be refactor, to accept an argument, the argument would be the custom allias the user provided.
     * @return void
     */
    public function create() {
        $data = (array) json_decode(file_get_contents("php://input"), true);
        $data['short_code'] = $this->shortenUrlService->generate();

        //retry logic
        if($this->shortenUrlService->isShortCodeExist($data['short_code'])) return $this->create(); 
        
        $this->shortenUrlService->shortenURL($data);
        http_response_code(201);
        echo json_encode([
            'message' => 'short url created.',
            "short_url" => $data['short_code']
        ]);
    }
 
    public function get_by_code($code){
    $data = $this->shortenUrlService->getShortenedURL($code);
    if (!$data) {
        http_response_code(404);
        echo json_encode([
            'message' => 'The shortened URL is not found in the database'
        ]);
    }
    echo json_encode($data, JSON_PRETTY_PRINT);
    }


    public function get_and_paginate() 
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = isset($_GET['rows']) ? $_GET['rows'] : 10;
        echo json_encode($this->shortenUrlService->getWithPagination($currentPage, $perPage));
    }

    public function patch($code){
    $long_url = (array) json_decode(file_get_contents("php://input"), true);
    $row = $this->shortenUrlService->updateShortenURL($code, $long_url['long_url']);
    http_response_code(200);
    echo json_encode([
        "message" => "long link for $code is updated.",
        "rows" => $row
    ]);
    }

    public function delete($code){
    $id = $this->shortenUrlService->deleteShortenURL($code); 
    http_response_code(200);
    echo json_encode([
        "message" => "Deleted.",
        "rows" => $id
    ]);
    }

}