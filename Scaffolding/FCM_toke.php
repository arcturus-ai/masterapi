<?php
// $con = mysqli_connect("localhost","arcturu_root","ravi@8448214581","arcturu_L&T");
// $sql = "SELECT * from registration";
// $result = mysqli_query($con,$sql);
// $data = array();
// while($row = mysqli_fetch_assoc($result)){
	
// 	$data[] =$row;
	
// }
// header('Content-Type:Application/json');
// echo json_encode($data);
// // echo json_encode(array( "status" => "true","message" => "Data fetched successfully! " , "data" => $data) );
if($_SERVER['REQUEST_METHOD']=='POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	if(($username== "l&tmhi") && ($password == "L&tP0wermHi@03092021" )){
		$con = mysqli_connect("localhost","arcturu_root","ravi@8448214581","arcturu_L&T");
	    $sql = "SELECT * from registration";
		$result = mysqli_query($con,$sql);
		$data = array();
		while($row = mysqli_fetch_assoc($result)){
			
			$data[] =$row;
			
		}
header('Content-Type:Application/json');
echo json_encode(array( "status" => "true","message" => "Data fetch Success!" , "data" => $data) );

	}else{
		echo json_encode(array( "status" => "false","message" => "Error occured, please try again!") );
	}
}else{
	echo json_encode(array( "status" => "false","message" => "sorry!") );
}


?>