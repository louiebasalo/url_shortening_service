<?php 
namespace Api\v1;

use Api\v1\ShortenUrlDao;
use Api\v1\URLModel;

class ShortenUrlService{

    private $dao;

    public function __construct(ShortenUrlDao $dao)
    {
        $this->dao = $dao;
    }

    public function getShortenedURL(string $shortCode) : URLModel | false
    {
        return $this->dao->get_by_short_code($shortCode);
    }

    public function getShortenedURLToRedirect(string $shortCode) : URLModel | false
    {
        return $this->dao->get_ShortCode($shortCode);
    }

    public function getShortenedURLCollection(URLModel $urlModel) :  URLModel 
    {
        return $this->dao->get_all($urlModel);;
    }
  
    public function getWithPagination(URLModel $urlModel) : URLModel
    {
        $urlModel->set_page( ($urlModel->get_page() < 1) ? 1 : $urlModel->get_page() );
        $urlModel->set_rows( ($urlModel->get_rows() < 10) ? 10 : $urlModel->get_rows() );
        return $this->dao->get_with_pagination($urlModel);
    }
    
    public function shortenURL(URLModel $urlModel) : int 
    {
        //retry logic
        if($this->isShortCodeExist($urlModel->get_shortCode())) return $this->shortenURL($urlModel); 

        return $this->dao->create($urlModel);
    }

    public function isShortCodeExist($shortCode) : bool
    {
        return $this->dao->is_shortCode_exist($shortCode);
    }

    public function updateShortenURL(URLModel $uRLModel) : int 
    {
        return $this->dao->update($uRLModel);
    }

    public function deleteShortenURL(URLModel $uRLModel) : int 
    {
        return $this->dao->delete($uRLModel);
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
    public function increment_click_counter(URLModel $uRLModel) : void
    {
        $this->dao->increment_click($uRLModel->get_shortCode(), $uRLModel->get_clicks()+1);
    }

}
