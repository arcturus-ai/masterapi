<?php
error_reporting(E_ERROR|E_PARSE);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "config/database.php";
include_once "general.php";
$database = new Database();
$db = $database->getConnection();
$items = new General($db);
$stmt = $items->abc();
$sqlQuery = "Select * from ai_safety";
$result = $db->prepare($sqlQuery);
$result->execute();
$totalItems[]=$result;
$itemCount = $stmt->rowCount();	
$totalPages = $result->rowCount();
if($itemCount > 0){
	$camArr = array();
	$camArr["body"] = array();
	$camArr["itemCount"] = $totalPages;
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		
		$e = array(
		    "Department" 	   			=> $Department,
			"CameraName"       			=> $CameraName,
			"Event"            			=> $events,
            "Image"            			=> $image_path,
			"vest"          			=> $vest,
			"helmet"        			=> $helmet,
			"glove" 	    			=> $glove,
			"goggle" 					=> $goggle,
			"boot" 						=> $boot,
			"hazardous"         		=> $hazardous,
			"weldinggear"               => $weldinggear,
			"time"             			=> $time,
			"remark"                    => $remark,
			"event_handel"              => $event_handel,
			"response_time"             => $response_time
		);
		
		array_push($camArr["body"], $e);
	}
// 	echo json_encode($obj);
		echo json_encode(array( "success" => 1,"message" => "success","result" =>($camArr) ));
}
else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}
?>