<?php
namespace api\v1;

class URLModel {
    
    private int $id, $page, $rows, $click;
    private string $shortCode, $originalURL;
    private $collection = [];

    /**
     * decided not to pass arguments in the constructor because I want the instance of this model class to be mutable.
     * for future native PHP projects, I can probably use a 1 model for data represntation and at the same time data persistence like Laravel's, with methods like save() and find(), there I can use method chaining.
     */
    public function __construct(){

    }

    public function set_id(int $id){
        $this->id = $id;
    }

    public function get_id() : int {
        return $this->id;
    }
    public function set_shortCode(string $shortCode){
        $this->shortCode = $shortCode;
    }

    public function get_shortCode() : string
    {
        return $this->shortCode;
    }

    public function set_originalUrl(string $originalUrl){
        $this->originalURL = $originalUrl;
    }

    public function get_originalUrl() : string
    {
        return $this->originalURL;
    }

    public function set_clicks(int $click){
        $this->click = $click;
    }

    public function get_clicks() : int
    {
        return $this->click;
    }

    public function set_page(int $page){
        $this->page = $page;
    }

    public function get_page() : int 
    {
        return $this->page;
    }

    public function set_rows(int $rows){
        $this->rows = $rows;
    }

    public function get_rows() : int 
    {
        return $this->rows;
    }
    public function set_collection(array $collection){
        $this->collection = $collection;
    }   

    public function get_collection() : array 
    {
        return $this->collection;
    }
}


