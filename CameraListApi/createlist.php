<?php
error_reporting(E_ERROR|E_PARSE);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'cameralist.php';
$database = new Database();
$db = $database->getConnection();
$order = new CameraList($db);
$a = file_get_contents("php://input");
// print_r($a);

if($order->orderDetails($a)){

    http_response_code(200);
    echo json_encode(array("message" => "All rows of Order Details are inserted.",));
}
else{
    http_response_code(400);
    echo json_encode(array("message" => "Sorry! Error while inserting rows of order details"));
}
?>