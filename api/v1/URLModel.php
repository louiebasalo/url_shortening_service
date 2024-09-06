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
I've searched many ways of implenting the model class. comparing native php examples, and Laravel's implementation of the model with eloquent (which I think is kind of an overkill for this project's purpose)
most of the examples have multiple instances of the model in one request, equevalent to the number of collection returned from DAO, but I don't want that so I decided to have all the property and at the same time to have an array property in this model and that is an associative array to hold dataset, since my DAO class is already providing a stractured collection. But I have a fealing this will introduce a problem in the future.
I am also considring using a model just for the single resource processing, but for operations that returns a collection like the getWithPagination() with a lot of data sets, transfering data directly from dao to srevice is also possible, but then that means an inconsistency in my implementation getting the data

Also,  I decided to use 1 isntance of the model for both request and response for space complexity, as I think this can be usefull in the future when this will be improved into a full url shortener service or when hosting to the web. char lang.

public function getShortenedURLs($originalUrl, $shortcode) {
        // Step 1: Create an instance and set initial properties
        $model = new UserModel();
        $model->set('original_url', $originalUrl);
        $model->set('shortcode', $shortcode);

        // Step 2: Pass the model to DAO for querying
        $queryData = $model->toArray();
        $results = $this->userDAO->fetchShortenedURLs($queryData);

        // Step 3: Update the same model with results if needed
        $model->setData($results); // Assuming setData can handle collections

        return $model;
    }
*/