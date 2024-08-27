<?php 
namespace Api\v1;

use Api\v1\ShortenUrlDao;

class ShortenUrlService{

    private $dao;

    public function __construct(ShortenUrlDao $dao)
    {
        $this->dao = $dao;
    }

    public function getShortenedURL(string $shortCode) : array | false
    {
        return $this->dao->get_by_short_code($shortCode);
    }

    public function getShortenedURLCollection() : array 
    {
        return $this->dao->get_all();
    }
    
    public function shortenURL(array $data) : string 
    {
        return $this->dao->create($data);
    }

    public function updateShortenURL(string $shortCode, string $longURL) : int 
    {
        return $this->dao->update($shortCode, $longURL);
    }

    public function deleteShortenURL(string $shortCode) : int 
    {
        return $this->dao->delete($shortCode);
    }
    
    public function isShortCodeExist($shortCode) : bool
    {
        return $this->dao->is_shortCode_exist($shortCode);
    }

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

    /**
     * Summary of increment_click_counter
     * @param mixed $data
     * @return void
     */
    public function increment_click_counter($data)
    {
        $this->dao->increment_click($data['short_code'], $data['clicks']+1);
    }

}
