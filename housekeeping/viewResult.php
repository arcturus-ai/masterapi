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
			"time"             			=> $time,
			"remark"                    => $remark,
			"event_handel"              => $event_handel,
			"response_time"             => $response_time
		);
		// if($row["Department"] == 'PICKLING' or $row["Department"] == 'ECL' or $row["Department"] == '6Hi' or $row["Department"] == 'RGM' or $row["Department"] == 'TM' or $row["Department"] == 'BAF' or $row["Department"] == 'SB Area' or $row["Department"] == 'CPL'){
		// 	print_r($row["Department"]);
		// 	$camArr["itemCount"] = $totalPages;
		// }
		array_push($camArr["body"], $e);

		// print_r($camArr["body"][0]['Department']);
	}
	echo json_encode($camArr);
	// echo json_encode(array( "success" => 1,"message" => "success","result" =>json_encode($camArr) ));
}
else{
	http_response_code(404);
	echo json_encode(
		array("message" => "No record found.")
	);
}
?>