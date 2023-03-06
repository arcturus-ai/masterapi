<?php

if($_SERVER['REQUEST_METHOD']=='POST'){ 

	include_once("config.php");
   
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$api_key= $_POST['api_key'];
	$mobile= $_POST['mobile'];
	$company= $_POST['company'];
	$email= $_POST['email'];
	$user = $_POST['user'];

	if($name == '' || $username == '' || $password == ''){
			echo json_encode(array( "success" => 0,"message" => "Parameter missing!") );
	}
	else{
		 
		$query= "SELECT * FROM registration WHERE username='$username'";
		$result= mysqli_query($con, $query);
	 
		if(mysqli_num_rows($result) > 0){  
		   echo json_encode(array( "success" => 0,"message" => "Username already exist!") );
		}else{ 
		 $query = "INSERT INTO registration (name,username,password,mobile,company,api_key,email,user) VALUES ('$name','$username','$password','$mobile','$company','$api_key','$email','$user')";
		 if(mysqli_query($con,$query)){
			
			 $query= "SELECT * FROM registration WHERE username='$username'";
					$result= mysqli_query($con, $query);
					$emparray = array();
					if(mysqli_num_rows($result) > 0){  
					while ($row = mysqli_fetch_assoc($result)) {
						$emparray[] = $row;
					}
					}
			echo json_encode(array( "success" => 1,"message" => "Successfully registered!" , "result"=>array("data" => $emparray)) );
		 }
		 else{
			echo json_encode(array("success" => 0,"message" => "Error occured, please try again!") );
		}
	}
			mysqli_close($con);
 }
 } else{
	echo json_encode(array("success" => 0,"message" => "Error occured, please try again!") );
}

 ?>