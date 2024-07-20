<?php
namespace App;
use App\Database;
use PDO;

class ShortenUrlDao{

    private $connection;
    public function __construct(){
        $con = new Database("localhost","url_shortening_db","root","");
        $this->connection = $con->connect();
    }

    public function get_all() : array
    {

        return [];
    }

    public function create(array $data) : string
    {
        $sql = "INSERT INTO shorten_url (shorten_url, original_url)
                VALUE (:shorten_url , :original_url)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":shorten_url", $data["shorten_url"], PDO::PARAM_STR);
        $stmt->bindValue(":original_url", $data["original_url"], PDO::PARAM_STR);
        $stmt->execute();

        return $data['shorten_url'];
    }

    public function get_by_short_code(string $short_code) : array | false 
    {
        $sql = "SELECT original_url FROM shorten_url WHERE shorten_url = :shorten_url";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":shorten_url", $short_code, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);


        return $data;
    }

    // public 

    public function get_original(string $short_code) : string | false
    {
        $sql = "SELECT original_url FROM shorten_url WHERE shorten_url = :shorten_url";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":shorten_url", $short_code, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $data;
    }

    public function update(string $short_code) : int 
    {

        return 1;
    }

    public function delete(string $short_code) : int
    {
        return 1;
    }
}