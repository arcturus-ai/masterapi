    <?php
include_once("config.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$time = $_POST['time'];
	$camera = $_POST['Cameraname'];
	// $project = $_POST['project'];
	$site = '';
	$success = 0;
	$message  = "somethig missing ! try again !";
	if(($username== "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
		$success = 1;
        $message  = "Data fetch Successfully !!";
		$sql="select sum(events = 0) as 'close',sum(events = 1) as 'open' FROM ai_safety where CameraName = '$camera' and time  = '$time'";
		print_r($sql);
		$result=mysqli_query($con,$sql);
		$data=array();
		while($row=mysqli_fetch_assoc($result)){
		$data[]=$row;
		}
     
	    header('Content-Type:Application/json');
		echo json_encode(array("success" => $success,"message"=>$message,"result" =>array($data)));
	}else{
		echo json_encode(array("success" => $success,"message"=>$message,) );
	}
}else{
	echo json_encode(array( "success" => 0,"message" => "Error occured, please try again!") );
}
?>