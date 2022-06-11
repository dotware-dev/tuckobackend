<?php

namespace App\Models;

use PDO;
use Utils\TokenManager;

class Comments extends \Core\Model
{
    public function __construct($data=[])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        
        $this->userId = TokenManager::retrieveIdByToken('users', 'usertoken', $this->token, 'id');
        $this->token=TokenManager::generateToken('comentarios','token',10);
    }

    public function saveNewComment()
    {
        $this->validate();
        if (empty($this->errors)) {
            $sql = 'INSERT INTO comentarios (token, userId, useremail, username, comment) VALUES (:token, :userId, :email, :name, :comment)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':token' => $this->token,
                ':userId' => $this->userId,
                ':email' => $this->email,
                ':name' => $this->name,
                ':comment' => $this->comment
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

        if($this->comment==""){
            $this->errors[]="Comment is required";
        }
    }
}
