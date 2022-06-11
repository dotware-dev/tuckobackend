<?php

namespace App\Controllers;

use App\Models\Comments as ModelsComments;
use Exception;

class Comments extends \Core\Controller
{
    public function indexAction()
    {
        $name= $_GET["name"];
        $email= $_GET["email"];
        $token= $_GET["token"];
        $comment= $_GET["comment"];

        

        $comment = new ModelsComments(['name' => $name, 'email' => $email, 'token' => $token, 'comment' => $comment]);
        $saved=$comment->saveNewComment();
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