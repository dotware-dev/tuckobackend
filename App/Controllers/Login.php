<?php
    namespace App\Controllers;


    use App\Models\User;
    use Utils\TokenManager;

    class Login extends \Core\Controller
    {
        public function indexAction()
        {
            $email= $_GET["email"];
            $password= $_GET["password"];
            $user=User::authenticate($email,$password);
            if($user){
                http_response_code(200);
                echo json_encode(array_merge(["status" => "success"],$user));

            }else{
                http_response_code(200);
                echo json_encode(["status" => "failed"]);
            }
        }

        
    }
