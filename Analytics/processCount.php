<?php
error_reporting(E_ERROR|E_PARSE);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'Analytics.php';
$database = new Database();
$db = $database->getConnection();
$order = new Analytics($db);
$a = file_get_contents("php://input");
$data = $order->processCount($a);
$camArr = array();
$camArr["body"] = array();
foreach($data as $stmt){
    $itemCount = $stmt->rowCount();	
    if($itemCount > 0){
    	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    		extract($row);
    		$e = array(
    		    "Department"        => $Department,
    		    "ppe"               => $ppe,
    		    "RackIn"            => $RackIn,
    		    "RackOut"           => $RackOut,
    			"LockStatus"        => $LockStatus,
    			"UnLockStatus"      => $UnLockStatus,
    			"Tag"               => $Tag,
    			"UnTag"             => $UnTag,
    		    "MagneticFlesher"   => $MagneticFlesher,
    		    "Barricading"       => $Barricading,
    		    "PersonCount"     => $PersonCount,
    		);
            array_push($camArr["body"], $e);
    	}
    // 	echo json_encode($camArr["$Department"]);
        
    }
    else{
    	http_response_code(404);
    	echo json_encode(
    		array("message" => "No record found.")
    	);
    }
}
echo json_encode($camArr);
?>