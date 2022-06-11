<?php

namespace App\Models;

use PDO;
use Utils\TokenManager;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
    public function __construct($data=[])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        $this->token=TokenManager::generateToken('users','userToken',32);
    }
    public function saveNewUser()
    {
        $this->validate();
        if (empty($this->errors)) {
            $password_hash=password_hash($this->password, PASSWORD_DEFAULT);
            $sql = 'INSERT INTO users (usertoken, name, email, password) VALUES (:token, :name, :email, :password)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':token' => $this->token,
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => $password_hash
            ]);
        }
        return false;
        
    }
    public static function updateUser($name, $email, $token, $description)
    {
        
        if (empty(self::validateUpdate($name,$email))) {
            $sql = 'UPDATE users SET name=:name, email=:email, description=:description WHERE usertoken=:token';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':token' => $token,
                ':name' => $name,
                ':email' => $email,
                // ':profilephoto' => $profilePhoto,
                ':description' => $description
            ]);
        }
        return false;
        
    }

    public function validate()
    {
        //name
        if ($this->name=="") {
            $this->errors[]="Name is required";
        }

        //email
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)==false) {
            $this->errors[]="Email is invalid";
        }

        if ($this->emailExists($this->email)) {
            $this->errors[]="Email is already in use";
        }

        //password
        if ($this->password == "") {
            $this->errors[]="Password must not be empty";
        }
    }
    public static function validateUpdate($name, $email)
    {
        $errors=[];
        //name
        if ($name=="") {
            $errors[]="Name is required";
        }

        //email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)==false) {
            $errors[]="Email is invalid";
        }
        return $errors;
    }

    protected function emailExists($email)
    {
        return static::findByEmail($email);
    }
    public static function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public static function findByEmailAssoc($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt;
    }

    public static function authenticate($email, $password)
    {
        $stmt=static::findByEmailAssoc($email);
        if ($stmt->rowCount()>=1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }
}
