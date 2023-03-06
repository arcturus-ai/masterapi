<?php
include_once("config.php");
if($_SERVER['REQUEST_METHOD']=='POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$project = $_POST['Department'];
	$page= $_POST['page'];
	$row_page = $_POST['row_page'];
	$data = null;
	$site = '';
	$totalPages = 0;
	// $con=mysqli_connect("localhost","root","pass","l&mhi");
	if(($username== "TaTaStEEl") && ($password == "TaTaStEEl@24052022" )){
	    $begin = ($page*$row_page)-$row_page;
	    $massege = "NO data available !";
	    $success = 0;
		if ($project == 'Admin'){
			$site = $_POST['site'];
			$massege = "please enter site name !";
			if($site == 'TND' or $site == 'Utility' or $site == 'RMHS' or $site == 'Sinter Plant' or $site == 'RMBB' or $site == 'Coke Plant' or $site == 'BPP' or $site == 'SMS' or $site == 'Blast Furnace' or $site == 'LCP' or $site == 'HSM' or $site == 'CRM' or $site == 'Pellet Plant'){
			    $sql="SELECT sum(vest) as vest FROM ai_safety Where Department = '$site'";
        		$result=mysqli_query($con,$sql);
        		$vest_tot=array();
        		while($row=mysqli_fetch_assoc($result)){
        		$vest_tot[]=$row;
        		}
        		$sql="SELECT * FROM ai_safety Where Department = '$site' and vest";
        		$result=mysqli_query($con,$sql);
        		$totalItems=array();
        		while($row=mysqli_fetch_assoc($result)){
        		$totalItems[]=$row;
        		}
				$massege = "Successfully Data fetch !";
				$success = 1;
				$sql="SELECT * FROM ai_safety Where Department  = '$site' and vest > 0 ORDER BY time Desc LIMIT {$begin},{$row_page}";
				$result=mysqli_query($con,$sql);
				$vest=array();
				while($row=mysqli_fetch_assoc($result)){
				$vest[]=$row;
				}
				
			    $sql="select sum(events = 0) as 'close',sum(events = 1) as 'open' FROM ai_safety where Department  = '$site' and vest ORDER BY time Desc LIMIT {$begin},{$row_page}";
				$result=mysqli_query($con,$sql);
				$open_close=array();
				while($row=mysqli_fetch_assoc($result)){
				$open_close[]=$row;
				
				}
				$totalPages = ceil(count($totalItems) / $row_page);
			    header('Content-Type:Application/json');
		        echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $vest,"totalPages"=>$totalPages,"currentpage"=>$page),"vest_total"=>$vest_tot,"Open Close"=>$open_close));
				
			}else{
			    header('Content-Type:Application/json');
		        echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $vest,"totalPages"=>$totalPages,"currentpage"=>$page),"vest_total"=>$vest_tot,"Open Close"=>$open_close));

			}
		
			
		}else{
		    $sql="SELECT sum(vest>0) as vest FROM ai_safety Where Department = '$project'";
    		$result=mysqli_query($con,$sql);
    		$vest_tot=array();
    		while($row=mysqli_fetch_assoc($result)){
    		$vest_tot[]=$row;
    		
    		}
    		$sql="SELECT * FROM ai_safety Where Department = '$project' and vest";
    		$result=mysqli_query($con,$sql);
    		$totalItems=array();
    		while($row=mysqli_fetch_assoc($result)){
    		$totalItems[]=$row;
    		
    		}
		    $massege = "Successfully Data fetch !";
		    $success = 1;
			$sql="SELECT * FROM ai_safety Where Department  = '$project' and vest > 0 ORDER BY time Desc LIMIT {$begin},{$row_page}";
			$result=mysqli_query($con,$sql);
			$vest=array();
			while($row=mysqli_fetch_assoc($result)){
			$vest[]=$row;
		
			}
			$sql="select sum(events = 0) as 'close',sum(events = 1) as 'open' FROM ai_safety where Department  = '$project' and vest ORDER BY time Desc LIMIT {$begin},{$row_page}";
			$result=mysqli_query($con,$sql);
			$open_close=array();
			while($row=mysqli_fetch_assoc($result)){
			$open_close[]=$row;
			
			}
			$totalPages = ceil(count($totalItems) / $row_page);
		    header('Content-Type:Application/json');
		    echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $vest,"totalPages"=>$totalPages,"currentpage"=>$page),"vest_total"=>$vest_tot,"Open Close"=>$open_close));
		}
		

	}else{
		echo json_encode(array( "success" => $success,"message" => "Something is wrong , please try again!") );
	}
}else{
	echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
}

?>