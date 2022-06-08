<?php

namespace App\Models;

use PDO;
use Ramsey\Uuid\Uuid;

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
        $this->uuid=Uuid::uuid4();
    }
    public function saveUser()
    {
        $this->validate();
        if (empty($this->errors)) {
            $password_hash=password_hash($this->password, PASSWORD_DEFAULT);
            $sql = 'INSERT INTO user (uuid, name, email, password) VALUES (:uuid, :name, :email, :password)';
            $db = static::getDB();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':uuid' => $this->uuid->toString(),
                ':name' => $this->name,
                ':email' => $this->email,
                ':password' => $password_hash
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
        if ($this->password != $this->password_confirm) {
            $this->errors[]="Password must match";
        }
        $this->emailExists($this->email);
        if (strlen($this->password)<6) {
            $this->errors[]="Password must be at least 6 characters";
        }
        if (preg_match('/.*[a-z]+.*/i', $this->password)==0) {
            $this->errors[]="Password must contain at least one letter";
        }
        if (preg_match('/.*\d+.*/i', $this->password)==0) {
            $this->errors[]="Password must contain at least one number";
        }
    }

    protected function emailExists($email)
    {
        return static::findByEmail($email);
    }
    public static function findByEmail($email)
    {
        $sql = "SELECT * FROM user WHERE email = ?";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function authenticate($email, $password)
    {
        $user=static::findByEmail($email);
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }
}
