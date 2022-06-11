<?php

namespace App\Controllers;

use App\Models\Citas as ModelsCitas;

//use \Core\View;

//use App\Models\User;

class Citas extends \Core\Controller
{
    public function indexAction()
    {
        $devicename = $_GET["devicename"];
        $issue = $_GET["issue"];
        $apptmntdate = $_GET["apptmntdate"] . " " . $_GET["apptmnttime"];

        $apptmntdate = strtotime($apptmntdate);
        $apptmntdate = date('Y-m-d H:i:s', $apptmntdate);
        $userToken = $_GET["usertoken"];
        $cita = new ModelsCitas(array('devicename' => $devicename, 'issue' => $issue, 'apptmntdate' => $apptmntdate, 'usertoken' => $userToken));
        $saved = $cita->saveNewApptmnt();
        if ($saved == true) {
            http_response_code(200);
            echo json_encode(array_merge(["status" => "success"], ['token' => $cita->token, 'apptmntdate' => $cita->apptmntdate, 'devicename' => $cita->devicename, 'issue' => $cita->issue,'devicestatus'=>'Pending']));
        } else {
            // http_response_code(400);
            http_response_code(200);
            echo json_encode(["status" => "failed"]);
        }
    }

    public function userappointmentsAction()
    {
        $userToken = $_GET["usertoken"];
        $apptmnts = ModelsCitas::getUserApptmnts($userToken);
        if (!empty($apptmnts)) {
            http_response_code(200);
            array_unshift($apptmnts, ["status" => "success"]);
            echo json_encode($apptmnts);
        } else {
            http_response_code(200);
            echo json_encode(["status" => "failed"]);
        }
    }

    public function getappointmentAction()
    {
        $token = $_GET["token"];
        $userToken = $_GET["usertoken"];

        $apptmnt = ModelsCitas::getOne($token, $userToken);
        if (!empty($apptmnt)) {
            http_response_code(200);
            echo json_encode(array_merge(["statusRequest" => "success"], $apptmnt));
        } else {
            http_response_code(200);
            echo json_encode(["statusRequest" => "failed"]);
        }
    }

    public function getlatestapptmntsAction(){
        $userToken= $_GET["usertoken"];
        $apptmnts = ModelsCitas::getLatestApptmnts($userToken);
        if (!empty($apptmnts)) {
            http_response_code(200);
            array_unshift($apptmnts, ["status" => "success"]);
            echo json_encode($apptmnts);
        } else {
            http_response_code(200);
            echo json_encode(["status" => "failed"]);
        }
    }


    public function getfinishedapptmntsAction(){
        $userToken= $_GET["usertoken"];
        $apptmnts = ModelsCitas::getFinishedApptmnts($userToken);
        if (!empty($apptmnts)) {
            http_response_code(200);
            array_unshift($apptmnts, ["status" => "success"]);
            echo json_encode($apptmnts);
        } else {
            http_response_code(200);
            echo json_encode(["status" => "failed"]);
        }
    }
}
