<?php
namespace App\Models;

class Post extends \Core\Model
{
    public static function getAll()
    {
        // $host='localhost';
        // $dbname='sample';
        // $user='root';
        // $pass='root';
        try {
            // $dbh = new \PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            // $stmt = $dbh->query("SELECT id,title,content FROM posts ORDER BY created_at");
            // $result=$stmt->fetchAll(\PDO::FETCH_ASSOC);
            // return $result;
            $db = static::getDB();
            $stmt = $db->query("SELECT id,title,content FROM posts ORDER BY created_at");
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            // echo $e->getMessage();
            throw new \Exception($e->getMessage());
        }
    }
    public static function getOne($id)
    {
        // $host='localhost';
        // $dbname='sample';
        // $user='root';
        // $pass='root';
        try {
            // $dbh = new \PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            // $stmt = $dbh->query("SELECT id,title,content FROM posts ORDER BY created_at");
            // $result=$stmt->fetchAll(\PDO::FETCH_ASSOC);
            // return $result;
            $db = static::getDB();
            $stmt = $db->prepare("SELECT id,title,content FROM posts WHERE id=:id");
            $stmt->execute(array(':id'=>$id));
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            // echo $e->getMessage();
            throw new \Exception($e->getMessage());
        }
    }
}
