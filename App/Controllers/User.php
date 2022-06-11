<?php
namespace App\Controllers;

use App\Models\User as ModelsUser;
use Core\Controller;

class User extends Controller
{
    public function updateAction()
    {
        $name=$_GET["name"];
        $email=$_GET["email"];
        $token=$_GET["token"];
        // $profilePhoto=$_GET["profilephoto"];
        $description=$_GET["description"];
        $saved=ModelsUser::updateUser($name,$email,$token,$description);
        if ($saved==true) {
            http_response_code(200);
            echo json_encode(["status" => "success"]);
        } else {
            http_response_code(200);
            echo json_encode(["status" => "failed"]);
        }
    }
}