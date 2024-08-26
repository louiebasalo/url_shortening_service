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

    /**
     * in the future, this method will be refactor, to accept an argument, the argument would be the custom allias the user provided.
     * @return void
     */
    public function create() {
        $data = (array) json_decode(file_get_contents("php://input"), true);
        $shorten = new ShortenUrlService();
        $data['short_code'] = $shorten->generate();

        //retry logic
        if($this->dao->get_by_short_code($data['short_code'])) return $this->create(); 
        //replace above retry logic condition to use the mthod is_code_exists() in ShortenUrlService, 
        //after I applied the Dependency injection approve or the DI container approach. (singleton approach is also an option but let's just use the former 2)
        
        $this->dao->create($data);
        http_response_code(201);
        echo json_encode([
            'message' => 'short url created.',
            "short_url" => $data['short_code']
        ]);
    }
 
    public function get_by_code($code){
    $data = $this->dao->get_by_short_code($code);
    if (!$data) {
        http_response_code(404);
        echo json_encode([
            'message' => 'The shortened URL is not found in the database'
        ]);
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