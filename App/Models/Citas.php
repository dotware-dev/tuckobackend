<?php

namespace App\Models;

use DateTime;
use PDO;
use Utils\Helpers;
use Utils\TokenManager;

class Citas extends \Core\Model
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        $this->token = TokenManager::generateToken('appointments', 'apptmntToken', 7);
        $this->userId = TokenManager::retrieveIdByToken('users', 'usertoken', $this->usertoken, 'id');
    }
    public static function getAll()
    {
        $sql = "SELECT * FROM appointments ORDER BY apptmntDate DESC";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getOne($token,$userToken)
    {
        $userId = TokenManager::retrieveIdByToken('users', 'usertoken', $userToken, 'id');
        $sql = "SELECT * FROM appointments WHERE apptmntToken = :token AND userId = :userId";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([':token' => $token, ':userId' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function getUserApptmnts($userToken)
    {
        $userId=TokenManager::retrieveIdByToken('users', 'usertoken', $userToken, 'id');
        $sql = "SELECT apptmntToken FROM appointments WHERE userId = :userId AND status != 'Done' ORDER BY apptmntDate DESC";
        $db = static::getDB();  
        $stmt = $db->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saveNewApptmnt()
    {
        $this->validate();
        if (empty($this->errors)) {
            $sql = 'INSERT INTO appointments (apptmntToken, apptmntDate, userId, devicename, issue) VALUES (:token, :apptmntDate, :userId, :devicename, :issue)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':token' => $this->token,
                ':apptmntDate' => $this->apptmntdate,
                ':userId' => $this->userId,
                ':devicename' => $this->devicename,
                ':issue' => $this->issue
            ]);
        }
        return false;
    }
    public function validate()
    {
        //name
        if ($this->devicename == "") {
            $this->errors[] = "Name is required";
        }
        if ($this->issue == "") {
            $this->errors[] = "Issue is required";
        }
        $date=$this->apptmntdate;
        if ($this->apptmntdate == "" || empty($this->apptmntdate) || Helpers::validateDate($this->apptmntdate)) {
            $this->errors[] = "Date is required";
        }
    }

    

    public static function getLatestApptmnts($userToken)
    {
        $userId=TokenManager::retrieveIdByToken('users', 'usertoken', $userToken, 'id');
        $sql = "SELECT apptmntToken FROM appointments WHERE userId = :userId AND status != 'Done' ORDER BY apptmntDate DESC LIMIT 5";
        $db = static::getDB();  
        $stmt = $db->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getFinishedApptmnts($userToken)
    {
        $userId=TokenManager::retrieveIdByToken('users', 'usertoken', $userToken, 'id');
        $sql = "SELECT apptmntToken FROM appointments WHERE userId = :userId AND status = 'Finished' ORDER BY apptmntDate DESC";
        $db = static::getDB();  
        $stmt = $db->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
