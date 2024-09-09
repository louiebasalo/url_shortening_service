<?php

namespace Api\V1;

class ValidateURL {
    private $failure;
    private $input;

    public function __construct($input){
        $this->input = $input;
    }

    public function validate() : bool
    {
        if(empty($this->input)) {
            $this->failure = "No Original url given.";
            return false;
        }
        if(preg_match('/^https?:\/\//', $this->input['long_url']) === 0){
            $this->failure = "Original URL should start with http:// or https://";
            return false;
        }
        if(preg_match('/https?:\/\/'.$_SERVER['HTTP_HOST'].'/', $this->input['long_url'])){
            $this->failure = "The entered url cannot have the same host as this webservice";
            return false;
        }

        return true;
    }
    public function failure_message() : string
    {
        return $this->failure;
    }
}