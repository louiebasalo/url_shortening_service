<?php
namespace App;
use App\Database;
use PDO;

class ShortenUrlDao{

    private $connection;
    public function __construct(){
        $con = new Database("localhost","url_shortener","root","");
        $this->connection = $con->connect();
    }

    public function get_all() : array
    {

        return [];
    }

    public function create(array $data) : string
    {
        $sql = "INSERT INTO shortened_url (short_code, long_url)
                VALUE (:short_code , :long_url)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":short_code", $data["short_code"], PDO::PARAM_STR);
        $stmt->bindValue(":long_url", $data["long_url"], PDO::PARAM_STR);
        $stmt->execute();

        return $data['short_code'];
    }

    public function get_by_short_code(string $short_code) : array | false 
    {
        $sql = "SELECT * FROM shortened_url WHERE short_code = :short_code";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":short_code", $short_code, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function click_event(string $short_code, int $click)
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

    public function update(string $short_code) : int 
    {

        return 1;
    }

    public function delete(string $short_code) : int
    {
        return 1;
    }
}