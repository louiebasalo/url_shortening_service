<?php 

namespace App;

class ShortenUrlService{
    private $domain = 'http://localhost:8000/';

    // public function shorten() :string
    // {
    //     return $this->domain.$this->generate();
    // }

    public function generate() : string 
    {
        $char = "abcdefghijklmnopqrstuvwxyz0123456789";
        $length = 6;
        $charlen = strlen($char);

        $random = '';
        for($i = 0; $i < $length; $i++)
        {
            $random .= $char[rand(0, $charlen-1)];
        }
        
        return $random;
    }

    

}
