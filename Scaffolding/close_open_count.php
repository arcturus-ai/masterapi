    <?php
include_once("config.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$project = $_POST['Department'];
	$site = $_POST['site'];
	if(($username== "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
	    $success = 0;
	    $message  = "somethig missing ! try again !";
	   
	    $site = str_replace('&', 'N', $site);
        if($site == "CPL 1N2"){
			    $site = "CPL 1 N2";
			}
		if ($project == 'Admin'  ){
			if($site == 'Pickling 1N2' or $site == 'ECL1N2' or $site == '6Hi mill 1 N 2' or $site == 'RGS' or $site == 'TM1 Mill' or $site == 'TM2 Mill' or $site == 'BAF' or $site == 'CPL 1 N2'){
    			$success = 1;
    	        $message  = "Data fetch Successfully !!";
    			$sql="select sum(events = 0) as 'close',sum(events = 1) as 'open' FROM ai_safety where Department = '$site'";
    			$result=mysqli_query($con,$sql);
    			$data=array();
    			while($row=mysqli_fetch_assoc($result)){
    			$data[]=$row;
    			}
	        }
		    else{
		        $success = 0;
	            $message  = "please enter location!";
		    }
		}else{
		    $site = str_replace('&', 'N', $site);
            if($site == "CPL 1N2"){
    		    $site = "CPL 1 N2";
    		}
		    $success = 1;
	        $message  = "Data fetch Successfully !";
			$sql="select sum(events = 0) as 'close',sum(events = 1) as 'open' FROM ai_safety where Department = '$project'";
			$result=mysqli_query($con,$sql);
			$data=array();
			while($row=mysqli_fetch_assoc($result)){
			$data[]=$row;
			}
		
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