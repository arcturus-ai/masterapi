    <?php
include_once("config.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$project = $_POST['Department'];
	$site = '';
	
	if(($username== "TaTaStEEl") && ($password == "TaTaStEEl@24052022" )){
	    $success = 0;
	    $message  = "somethig missing ! try again !";
	    $site = $_POST['site'];
		if ($project == 'Admin'  ){
	        if($site == 'TND' or $site == 'Utility' or $site == 'RMHS' or $site == 'Sinter Plant' or $site == 'RMBB' or $site == 'Coke Plant' or $site == 'BPP' or $site == 'SMS' or $site == 'Blast Furnace' or $site == 'LCP' or $site == 'HSM' or $site == 'CRM' or $site == 'Pellet Plant'){
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