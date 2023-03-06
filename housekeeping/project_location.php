<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(($username== "l&tmhi") && ($password == "L&tP0wermHi@03092021" )){
		$con = mysqli_connect("localhost","arcturu_root","ravi@8448214581","arcturu_L&T");
		$sql = "SELECT * from cameras";
		$result = mysqli_query($con,$sql);
		$data = array();
		while($row = mysqli_fetch_assoc($result)){
			
			$data[] =$row;
			
		}
        header('Content-Type:Application/json');
        echo json_encode(array( "success" => 1,"message" => "Data fetch Success!" , "result"=>array("data" => $data)) );

	}else{
		echo json_encode(array( "success" => 0,"message" => "Error occured, please try again!") );
	}
}else{
	echo json_encode(array( "success" => 0,"message" => "sorry!") );
}

?>