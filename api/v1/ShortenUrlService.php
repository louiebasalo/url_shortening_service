<?php 
namespace Api\v1;

use Api\v1\ShortenUrlDao;

class ShortenUrlService{

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

    public function increment_click_counter($data)
    {
        echo $data['clicks'] + 1;
        $dao = new ShortenUrlDao();
        $dao->increment_click($data['short_code'], $data['clicks']+1);
    }

    public function is_code_exist($code) : bool
    {

        return true;
    }
}
