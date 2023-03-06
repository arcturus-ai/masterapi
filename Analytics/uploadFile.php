<?php
error_reporting(E_ERROR|E_PARSE);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "config/database.php";
include_once "Analytics.php";
$database = new Database();
$db = $database->getConnection();
$items = new Analytics($db);
$stmt = $items->upLoadedFile();
$itemCount = $stmt->rowCount();	
if($itemCount > 0){
	$camArr = array();
	$camArr["body"] = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	    
		extract($row);
		$e = array(
		     $row
		    
		);
		array_push($camArr["body"], $e[0]);
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