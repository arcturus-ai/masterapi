<?php
    error_reporting(E_ERROR|E_PARSE);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once 'config/database.php';
    include_once 'cameralist.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new CameraList($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->CameraName = $data->CameraName;
    
    if($item->deleteCamlist()){
        echo json_encode(array("success" => 0,"message" => "Camera deleted.") );
    } else{
        echo json_encode(array("success" => 0,"message" => "Data could not be deleted.") );
    }
?>