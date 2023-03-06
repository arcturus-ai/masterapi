<?php
error_reporting(E_ERROR|E_PARSE);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once "config/database.php";
include_once "cameralist.php";
$database = new Database();
$db = $database->getConnection();
$items = new CameraList($db);
$stmt = $items->tglstats();
$itemCount = $stmt->rowCount();	

if($itemCount > 0){
	$camArr = array();
	$camArr["body"] = array();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$e = array(
			'CameraName'       	=> $CameraName,
			'vest'				=> $vest,
			'helmet'			=> $helmet,
			'boot'				=> $boot,
			'glove'				=> $glove,
			'goggle'			=> $goggle,
			'handguard'			=> $handguard,
			'legguard'			=> $legguard,
			'Handling'			=> $Handling,
			'Crane'			    => $Crane,
			'HandSignal'		=> $HandSignal,
			'Operation'			=> $Operation,
			'General'			=> $General,
			'hazardous'			=> $hazardous,
			
		);
		array_push($camArr["body"], $e);
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