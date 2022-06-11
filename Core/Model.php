<?php
    namespace Core;

use PDO;
include_once dirname(__DIR__)."/config.php";

abstract class Model
{

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;
        if ($db===null) {
            $template='mysql:host=$host;dbname=$dbname';
            try {
                $db = new PDO(strtr($template, array(
                    '$host'=>Config::DB_HOST,
                    '$dbname'=>Config::DB_NAME
                )), Config::DB_USER, Config::DB_PASSWORD);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                // echo $e->getMessage();
                throw new \Exception($e->getMessage());
            }
        }
        return $db;
    }
}
