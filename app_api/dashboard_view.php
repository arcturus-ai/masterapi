<?php
include_once("config.php");
if($_SERVER['REQUEST_METHOD']=='POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$project = $_POST['Department'];
	$site = '';
	if(($username== "TaTaStEEl") && ($password == "TaTaStEEl@24052022" )){
		if ($project == 'Admin'){
		    $site = $_POST['site'];
			if($site == 'TND' or $site == 'Utility' or $site == 'RMHS' or $site == 'Sinter Plant' or $site == 'RMBB' or $site == 'Coke Plant' or $site == 'BPP' or $site == 'SMS' or $site == 'Blast Furnace' or $site == 'LCP' or $site == 'HSM' or $site == 'CRM' or $site == 'Pellet Plant'){
				
				$sql = "SELECT SUM(helmet) as helmet,SUM(vest) as vest,SUM(glove)as glove,SUM(goggle) as goggle,SUM(boot) as boot,SUM(hazardous) as Restricted ,SUM(ppe) as PPE,SUM(Distance) as Distance_5mtr ,SUM(Koolcoat) as Koolcoat from ai_safety where Department = '$site'";
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
		    $sql = "SELECT SUM(helmet) as helmet,SUM(vest) as vest,SUM(glove)as glove,SUM(goggle) as goggle,SUM(boot) as boot,SUM(hazardous) as Restricted ,SUM(ppe) as PPE,SUM(Distance) as Distance_5mtr ,SUM(Koolcoat) as Koolcoat from ai_safety where Department = '$project'";
            		
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