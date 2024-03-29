<?php

namespace App\Controllers;


use App\Models\User;
use Exception;

class Signup extends \Core\Controller
{
    public function indexAction()
    {
        $name= $_GET["name"];
        $email= $_GET["email"];
        $password= $_GET["password"];
        $user = new User(array('name' => $name, 'email' => $email, 'password' => $password));
        $saved=$user->saveNewUser();
        if ($saved==true) {
            http_response_code(200);
            echo json_encode(["status" => "success"]);
        } else {
            // http_response_code(400);
            http_response_code(200);
            echo json_encode(["status" => "failed"]);
        }
    }
}
