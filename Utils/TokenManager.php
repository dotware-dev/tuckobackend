<?php

namespace Utils;

use Utils\RandomStringGenerator;
use App\Models\TokenDBManager;

class TokenManager
{
    
    public static function generateToken($table, $column,$length = 32)
    {
        $generator = new RandomStringGenerator();
        $generatedToken= $generator->generate($length);
        while(static::verifyToken($generatedToken,$table,$column)){
            $generatedToken= $generator->generate($length);
        }
        return $generatedToken;
    }
    public static function verifyToken($token,$table,$column)
    {
        return TokenDBManager::verifyTokenUniqueness($token,$table,$column);
    }

    public static function retrieveToken($table, $columnCheck, $value, $tokenColumn)
    {
        return TokenDBManager::retrieveToken($table, $columnCheck, $value, $tokenColumn);
    }

    public static function retrieveIdByToken($table, $tokenColumn, $token, $idColumn)
    {
        return TokenDBManager::retrieveIdByToken($table, $tokenColumn, $token, $idColumn);
    }
}
