<?php
if($_SERVER['REQUEST_METHOD']=='POST'){ 

	include_once("config.php");
   
	$username = $_POST['username'];
	$close = $_POST['close'];
	$remark = $_POST['remark'];
	$tym = $_POST['tym'];
	$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
	$response_tym = $date->format('H:i:s');
	if($username == '' || $close == '' || $remark == ''){
			echo json_encode(array( "status" => "false","message" => "Parameter missing!") );
	}
	else{
		 
		$query= "update ai_safety set response_time = '$response_tym' , event_handel  = '$username' , events = '$close',remark = '$remark' where  time =  '$tym'";
		$result= mysqli_query($con, $query);
		if(mysqli_query($con,$query)){
			
			$query= "SELECT * FROM ai_safety WHERE time ='$tym'";
			$result= mysqli_query($con, $query);
			$emparray = array();
			if(mysqli_num_rows($result) > 0){  
				while ($row = mysqli_fetch_assoc($result)) {
					$emparray[] = $row;
				}
			}
			echo json_encode(array( "success" => 1,"message" => "Successfully Update !" , "result" =>array("data" => $emparray)) );
		 }
		 else{
			echo json_encode(array(  "success" => 0,"message" => "Error occured, please try again !") );
		}
		
	}
	mysqli_close($con);
}else{
		echo json_encode(array(  "success" => 0,"message" => "Error occured, please try again !") );
}
?>