<?php
namespace Api\v1;

use Api\v1\ShortenUrlService;
use Api\v1\ShortenUrlDao;

class ShortenUrlController {

    private $dao;
    public function __construct(){
        $this->dao = new ShortenUrlDao();
    }

    public  function get_all() {
        $dao = new ShortenUrlDao();
        echo json_encode($dao->get_all());
    }

    public function create() {
        $data = (array) json_decode(file_get_contents("php://input"), true);
        $shorten = new ShortenUrlService();
        $data['short_code'] = $shorten->generate();
        $this->dao->create($data);
        http_response_code(201);
        echo json_encode([
            'message' => 'short url created.',
            "short url" => $data['short_code']
        ]);
    }
 
    public function get_by_code($code){
    $data = $this->dao->get_by_short_code($code);
    if (!$data) {
        http_response_code(404);
        echo json_encode([
            'message' => 'Shorten URL not found!'
        ]);
        return;
    }
    echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function patch($code){
    $long_url = (array) json_decode(file_get_contents("php://input"), true);
    $row = $this->dao->update($code, $long_url['long_url']);
    http_response_code(201);
    echo json_encode([
        "message" => "long link for $code is updated.",
        "rows" => $row
    ]);
    }

    public function delete($code){
    $id = $this->dao->delete($code); 
    http_response_code(202);
    echo json_encode([
        "message" => "Deleted.",
        "rows" => $id
    ]);
    }

}