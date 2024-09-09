<?php
namespace Api\v1;

use Api\v1\Database;
use Api\v1\URLModel;
use PDO;
use PDOException;

class ShortenUrlDao{

    private $connection;

    public function __construct(Database $Database){
        $this->connection = $Database->connect();
    }

    public function get_all(URLModel $urlModel) : URLModel
    {
        $sql = "SELECT * FROM shortened_url";
        $stmt = $this->connection->query($sql);

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            array_push($data,$row);
        }
        
        $newModelInstance = new URLModel();
        $newModelInstance->set_collection($data);

        return $newModelInstance;
    }

    public function get_with_pagination(URLModel $urlModel) : URLModel
    {
        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM shortened_url");
        $stmt->execute();
        $entries = $stmt->fetchColumn();
        $totalPage = ceil($entries / $urlModel->get_rows());

        $x = ($urlModel->get_page() - 1) * $urlModel->get_page();  //the offset
        $y = $urlModel->get_rows();  //the number of entries per page
        $sql = "SELECT * FROM shortened_url ORDER BY id asc LIMIT $x, $y";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        
        $collection_data = [];
        $data = [];

        $newModelInstance = new URLModel();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            array_push($collection_data,$row);
        }

        $data["meta-data"] = ['current_page' => $urlModel->get_page(), 'rows_per_page' => $y ,'total_page' => $totalPage, 'total_entries' => $entries];
        $data["collection"] = $collection_data;

        $newModelInstance->set_collection($data);
        return $newModelInstance;
    }

    public function create(URLModel $data) : int 
    {
        $sql = "INSERT INTO shortened_url (short_code, long_url)
            VALUE (:short_code , :long_url)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":short_code", $data->get_shortCode(), PDO::PARAM_STR);
        $stmt->bindValue(":long_url", $data->get_originalUrl(), PDO::PARAM_STR);
        $stmt->execute();
        $data->set_id($this->connection->lastInsertId());

        return $this->connection->lastInsertId();
    }

    public function get_by_short_code(string $short_code) : URLModel | false 
    {
        $sql = "SELECT * FROM shortened_url WHERE short_code = :short_code";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":short_code", $short_code, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return false;
        
        $newModelInstance = new URLModel();
        $newModelInstance->set_collection($data);

        return $newModelInstance;
    }

    public function get_ShortCode(string $short_code) : URLModel | false
    {
        $sql = "SELECT long_url, clicks, id FROM shortened_url WHERE short_code = :short_code";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":short_code", $short_code, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$res){
            return false;
        }
        $newModelInstance = new URLModel();
        $newModelInstance->set_originalUrl($res['long_url']);
        $newModelInstance->set_clicks($res['clicks']);
        $newModelInstance->set_id($res['id']);

        return $newModelInstance;
    }

    public function increment_click(string $short_code, int $click) : void
    {
        $sql = "UPDATE shortened_url
                SET clicks = :clicks
                WHERE short_code = :short_code
                ";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":clicks", $click, PDO::PARAM_INT);
        $stmt->bindValue(":short_code", $short_code, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function update(URLModel $uRLModel) : int 
    {   
        $sql = "UPDATE shortened_url SET long_url = :long_url WHERE short_code = :short_code";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':long_url', $uRLModel->get_originalUrl());
        $stmt->bindValue(':short_code', $uRLModel->get_shortCode());
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(URLModel $uRLModel) : int
    {
        $sql = 'DELETE FROM shortened_url WHERE short_code = :short_code';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':short_code',$uRLModel->get_shortCode());
        $stmt->execute();
        
        return $stmt->rowCount();
    }

    public function is_shortCode_exist($short_code) : bool
    {
        $sql = "SELECT short_code FROM shortened_url WHERE short_code = :short_code";
        $stmt  = $this->connection->prepare($sql);
        $stmt->bindValue(":short_code", $short_code, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$data) return false;

        return true;
    }
}