<?php

   if($_SERVER['REQUEST_METHOD']=='POST'){
  // echo $_SERVER["DOCUMENT_ROOT"];  // /home1/demonuts/public_html
//including the database connection file
       include_once("config.php");
       
        $username = $_POST['username'];
 	$password = $_POST['password'];
 	
	 if( $username == '' || $password == '' ){
	        echo json_encode(array( "success" => 0,"message" => "Parameter missing!") );
	 }else{
	 	$query= "SELECT * FROM registration WHERE username='$username' AND password='$password'";
	        $result= mysqli_query($con, $query);
		 
	        if(mysqli_num_rows($result) > 0){  
	         $query= "SELECT * FROM registration WHERE username='$username' AND password='$password'";
	                     $result= mysqli_query($con, $query);
		             $emparray = array();
	                     if(mysqli_num_rows($result) > 0){  
	                     while ($row = mysqli_fetch_assoc($result)) {
                                     $emparray[] = $row;
                                   }
	                     }
	           echo json_encode(array( "success" => 1,"message" => "Login successfully!", "result"=>array("data" => $emparray)) );
	        }else{ 
	        	echo json_encode(array("success" => 0,"message" => "Invalid username or password!") );
	        }
	         mysqli_close($con);
	 }
	} else{
			echo json_encode(array( "success" => 0,"message" => "Error occured, please try again!") );
	}
?>