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
	    $sql="SELECT * FROM ai_safety";
		$result=mysqli_query($con,$sql);
		$data=array();
		while($row=mysqli_fetch_assoc($result)){
		$totalItems[]=$row;
		
		}
	    $massege = "NO data available !";
	    $success = 0;
		if ($project == 'Admin'){
			$site = $_POST['site'];
			$massege = "please enter site name !";
			
// 			echo "======================".count($totalItems);
			if($site == 'TND' or $site == 'Utility' or $site == 'RMHS' or $site == 'Sinter Plant' or $site == 'RMBB' or $site == 'Coke Plant' or $site == 'BPP' or $site == 'SMS' or $site == 'Blast Furnace' or $site == 'LCP' or $site == 'HSM' or $site == 'CRM' or $site == 'Pellet Plant'){
				$massege = "Successfully Data fetch !";
				$success = 1;
				$sql="SELECT * FROM ai_safety where Department = '$site' ORDER BY time Desc LIMIT {$begin},{$row_page}";
				$result=mysqli_query($con,$sql);
				$data=array();
				while($row=mysqli_fetch_assoc($result)){
				$data[]=$row;
				
				}
				$totalPages = ceil(count($totalItems) / $row_page);
			    header('Content-Type:Application/json');
		        echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));
				// header('Content-Type:Application/json');
				// echo json_encode($data);
			}else{
				header('Content-Type:Application/json');
		        echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));

			}
		
			
		}else{
		    $massege = "Successfully Data fetch !";
		    $success = 1;
			$sql="SELECT * FROM ai_safety where Department = '$project' ORDER BY time Desc LIMIT {$begin},{$row_page}";
			$result=mysqli_query($con,$sql);
			$data=array();
			while($row=mysqli_fetch_assoc($result)){
			$data[]=$row;
		
			}
			$totalPages = ceil(count($totalItems) / $row_page);
		    header('Content-Type:Application/json');
		    echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));
		}
		

	}else{
		echo json_encode(array( "success" => $success,"message" => "Something is wrong , please try again!") );
	}
}else{
	echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
}

?>