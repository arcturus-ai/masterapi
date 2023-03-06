<?php

   if($_SERVER['REQUEST_METHOD']=='POST'){
  // echo $_SERVER["DOCUMENT_ROOT"];  // /home1/demonuts/public_html
//including the database connection file
       include_once("config.php");
       
        $email = $_POST['email'];
 	    $password = $_POST['password'];
 	
	 if( $email == '' || $password == '' ){
	        echo json_encode(array( "success" => 0,"message" => "Parameter missing!") );
	 }else{
	 	$query= "SELECT * FROM users WHERE email='$email' AND password='$password'";
	        $result= mysqli_query($con, $query);
	        if(mysqli_num_rows($result) > 0){  
	        $query= "SELECT * FROM users WHERE email='$email' AND password='$password'";
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