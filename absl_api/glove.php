<?php
include_once("config.php");
if($_SERVER['REQUEST_METHOD']=='POST'){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$project = $_POST['project'];
	$page= $_POST['page'];
	$row_page = $_POST['row_page'];
	$data = null;
	$site = '';
	$totalPages = 0;
	// $con=mysqli_connect("localhost","root","pass","l&mhi");
	if(($username== "l&tmhi") && ($password == "L&tP0wermHi@03092021" )){
	    $begin = ($page*$row_page)-$row_page;
	    $massege = "NO data available !";
	    $success = 0;
		if ($project == 'HO'){
			$site = $_POST['site'];
			$massege = "please enter site name !";
			if($site == 'Ghatampur' or $site == 'Khurja' or $site == 'Buxar'){
			    $sql="SELECT sum(glove) as glove FROM ai_safety Where Project = '$site'";
        		$result=mysqli_query($con,$sql);
        		$glove_tot=array();
        		while($row=mysqli_fetch_assoc($result)){
        		$glove_tot[]=$row;
        		}
        		$sql="SELECT * FROM ai_safety Where Project = '$site' and boot";
        		$result=mysqli_query($con,$sql);
        		$totalItems=array();
        		while($row=mysqli_fetch_assoc($result)){
        		$totalItems[]=$row;
        		}
				$massege = "Successfully Data fetch !";
				$success = 1;
				$sql="SELECT * FROM ai_safety Where Project  = '$site' and glove > 0 ORDER BY time Desc LIMIT {$begin},{$row_page}";
				$result=mysqli_query($con,$sql);
				$glove=array();
				while($row=mysqli_fetch_assoc($result)){
				$glove[]=$row;
				}
				
			    $sql="select sum(events = 0) as 'close',sum(events = 1) as 'open' FROM ai_safety where Project  = '$site' and glove ORDER BY time Desc LIMIT {$begin},{$row_page}";
				$result=mysqli_query($con,$sql);
				$open_close=array();
				while($row=mysqli_fetch_assoc($result)){
				$open_close[]=$row;
				
				}
				$totalPages = ceil(count($totalItems) / $row_page);
			    header('Content-Type:Application/json');
		        echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $glove,"totalPages"=>$totalPages,"currentpage"=>$page),"glove_total"=>$glove_tot,"Open Close"=>$open_close));
				
			}else{
			    header('Content-Type:Application/json');
		        echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $boot,"totalPages"=>$totalPages,"currentpage"=>$page),"glove_total"=>$glove_tot,"Open Close"=>$open_close));

			}
		
			
		}else{
		    $sql="SELECT sum(glove>0) as glove FROM ai_safety Where Project = '$project'";
    		$result=mysqli_query($con,$sql);
    		$glove_tot=array();
    		while($row=mysqli_fetch_assoc($result)){
    		$glove_tot[]=$row;
    		
    		}
    		$sql="SELECT * FROM ai_safety Where Project = '$project' and boot";
    		$result=mysqli_query($con,$sql);
    		$totalItems=array();
    		while($row=mysqli_fetch_assoc($result)){
    		$totalItems[]=$row;
    		
    		}
		    $massege = "Successfully Data fetch !";
		    $success = 1;
			$sql="SELECT * FROM ai_safety Where Project  = '$project' and glove > 0 ORDER BY time Desc LIMIT {$begin},{$row_page}";
			$result=mysqli_query($con,$sql);
			$glove=array();
			while($row=mysqli_fetch_assoc($result)){
			$glove[]=$row;
		
			}
			$sql="select sum(events = 0) as 'close',sum(events = 1) as 'open' FROM ai_safety where Project  = '$project' and glove ORDER BY time Desc LIMIT {$begin},{$row_page}";
			$result=mysqli_query($con,$sql);
			$open_close=array();
			while($row=mysqli_fetch_assoc($result)){
			$open_close[]=$row;
			
			}
			$totalPages = ceil(count($totalItems) / $row_page);
		    header('Content-Type:Application/json');
		    echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $glove,"totalPages"=>$totalPages,"currentpage"=>$page),"glove_total"=>$glove_tot,"Open Close"=>$open_close));
		}
		

	}else{
		echo json_encode(array( "success" => $success,"message" => "Something is wrong , please try again!") );
	}
}else{
	echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
}

?>