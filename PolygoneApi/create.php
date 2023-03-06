 <?php
    error_reporting(E_ERROR|E_PARSE);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once 'config/database.php';
    include_once 'Polygone.php';
    $database = new Database();
    $db = $database->getConnection();
    $item = new Ploygone($db);
    $data = json_decode(file_get_contents("php://input"));
    if($item->polygone()){
        echo json_encode(array("success" => 0,"message" => "Camera List created successfully.") );
    } else{
         echo json_encode(array("success" => 0,"message" => "Camera list could not be created.") );
    }
?>