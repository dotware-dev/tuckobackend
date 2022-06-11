<?php

namespace App\Models;

use PDO;

class TokenDBManager extends \Core\Model
{
    public static function verifyTokenUniqueness($token, $table, $column)
    {
        $sql="SELECT * FROM $table WHERE $column = :token";
        $db=static::getDB();
        $stmt=$db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute([':token'=>$token]);
        return $stmt->fetch();
    }

    public static function retrieveToken($table, $columnCheck, $value, $tokenColumn)
    {
        $sql="SELECT $tokenColumn FROM $table WHERE $columnCheck = :value";
        $db=static::getDB();
        $stmt=$db->prepare($sql);
        $stmt->execute([':value'=>$value]);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public static function retrieveIdByToken($table, $tokenColumn, $token, $idColumn)
    {
        $sql="SELECT $idColumn FROM $table WHERE $tokenColumn = :token";
        $db=static::getDB();
        $stmt=$db->prepare($sql);
        $stmt->execute([':token'=>$token]);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
}
