<?php
namespace Api\v1;

class URLModel {
    
    private int $id, $page, $rows, $click;
    private string $shortCode, $originalURL;
    private $collection = [];

    /**
     * Summary of __construct
     * decided not to pass arguments in the constructor because I want the instance of this model class to be mutable, so that I can use only 1 instance for both request and response

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


/* 
I've searched many ways of implenting the model class. comparing native php examples in the internet and Laravel's implementation of the model with eloquent (which I think is kind of an overkill for this project's purpose, and I could not follow the level of absraction -_-).
most of the examples have multiple instances of the model in one request, each for every enntry in the collection from DAO class, but I don't want that so I decided to use 1 isntance of the model for both request and response for space complexity and an array property for the request collection process such as getWithPagination(), by adding an array property, I can maintain the structure of this model and inforce the types of each property through the individual properties.

*/