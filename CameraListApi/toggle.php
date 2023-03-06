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
	$a = file_get_contents("php://input");
    if($item->toggel($a)){
		echo json_encode(array("success" => 1,"message" => "toggel button  update successfully!") );
    } else{
        echo json_decode(array("success" => 0,"message"=>"toggel button could not be update."));
    }
?>