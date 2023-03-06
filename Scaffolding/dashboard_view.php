<?php
include_once("config.php");
if($_SERVER['REQUEST_METHOD']=='POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$project = $_POST['project'];
	$site = '';
	if(($username== "l&tmhi") && ($password == "L&tP0wermHi@03092021" )){
		if ($project == 'HO'){
		    $site = $_POST['site'];
			if($site == 'Ghatampur' or $site == 'Khurja' or $site == 'Buxar'){
				
				$sql = "SELECT SUM(helmet) as helmet,SUM(vest) as vest,SUM(glove)as glove,SUM(goggle) as goggle,SUM(boot) as boot,SUM(hazardous) as hazardous,SUM(harness) as harness from ai_safety where Project = '$site'";
				$result = mysqli_query($con,$sql);
				$data = array();
				while($row = mysqli_fetch_assoc($result)){
					
					$data[] =$row;
				
				}
				header('Content-Type:Application/json');
	            echo json_encode(array("success"=>1,"message"=>"Successfully data fetch ","result" => array( "data" => $data) ));
			}else{
				echo json_encode(array( "success" => 0,"message"=>"please enter the location") );
				}
		}else{
		    $sql = "SELECT SUM(helmet) as helmet,SUM(vest) as vest,SUM(glove)as glove,SUM(goggle) as goggle,SUM(boot) as boot,SUM(hazardous) as hazardous,SUM(harness) as harness from ai_safety where  Project = '$project'";
			$result = mysqli_query($con,$sql);
			$data = array();
			while($row = mysqli_fetch_assoc($result)){
				
				$data[] =$row;
			
				}
			header('Content-Type:Application/json');
	        echo json_encode(array("success"=>1,"message"=>"Successfully data fetch ","result" => array( "data" => $data) ));
			}	
	    

	}else{
		echo json_encode(array( "success" => 0,"message" => "Error occured, please try again!") );
	}
}else{
	echo json_encode(array( "success" => 0,"message" => "Error occured, please try again!") );
}

?>