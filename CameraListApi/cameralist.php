<?php
  class CameraList{
	private $conn;
	private $db_table = "cameras";
	public $Department;
	public $Name;
	public $NvrName;
	public $CameraName;
	public $IPAddress;
	public $user;
	public $pass;
	public  $vest;
	public	$helmet;
	public	$boot;
	public	$glove;
	public	$goggle;
	public	$Distance;
	public	$General;
	public function __construct($db){
		$this->conn = $db;
	}
	public function ExportFile($records) {
		$heading = false;
		if(!empty($records))
		  foreach($records as $row) {
			if(!$heading) {
			  // display field/column names as a first row
			  echo implode("\t", array_keys($row)) . "\n";
			  $heading = true;
			}
			echo implode("\t", array_values($row)) . "\n";
		  }
		exit;
	}
	
	public function getData(){
	    if($_SERVER["REQUEST_METHOD"]=="POST"){
	        $username = $_POST['username'];
			$password = $_POST['password'];
            if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
                
    			$sqlQuery = "Select  Distinct Name,time from ".$this->db_table." ORDER BY time Desc";
    			$stmt = $this->conn->prepare($sqlQuery);
    			$stmt->execute();
    			return $stmt;
    		
    		}else{
    			echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
    		}
	    }
	}
	
	public function camerastatus(){
	    if($_SERVER["REQUEST_METHOD"]=="POST"){
	        $username = $_POST['username'];
					$password = $_POST['password'];
					$depart = $_POST['Department'];
					if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){

	          if($depart!='Admin'){
	            $depart = str_replace('&', 'N', $depart);   
		    			$sqlQuery = "Select Name,Department,CameraName,IPAddress,time,user,pass from ".$this->db_table." where Department = '$depart' ORDER BY time Desc";
		    			$stmt = $this->conn->prepare($sqlQuery);
		    			$stmt->execute();
		    			return $stmt;

		    		}else{
			    				$sqlQuery = "Select Name,Department,CameraName,IPAddress,time,user,pass from ".$this->db_table." ORDER BY time Desc";
				    			$stmt = $this->conn->prepare($sqlQuery);
				    			$stmt->execute();
				    			return $stmt;

		    		}

		    }else{
	    			echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
	    		}
	    }
	}
	public function getCamList(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$project = $_POST['Department'];
			$page= $_POST['page'];
			$row_page = $_POST['row_page'];
			$site = '';
            if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
				$begin = ($page*$row_page)-$row_page;
				// echo "Begin =====".$begin;
				$sqlQuery = "Select * from ".$this->db_table;
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$totalItems[]=$stmt;
				if($project == "Admin"){
				// 	$site = $_POST['site'];
				// 	print_r("Ravi");
				// 	if($site == 'TND' or $site == 'Utility' or $site == 'RMHS' or $site == 'Sinter Plant' or $site == 'RMBB' or $site == 'Coke Plant' or $site == 'BPP' or $site == 'SMS' or $site == 'Blast Furnace' or $site == 'LCP' or $site == 'HSM' or $site == 'CRM' or $site == 'Pellet Plant'){
					$massege = "Successfully Data fetch !";
					$success = 1;
					$sqlQuery = "Select DISTINCT date(date_format(time, '%Y-%m-%d')) as time, Name from ".$this->db_table." ORDER BY time Desc LIMIT {$begin},{$row_page}";

					$stmt = $this->conn->prepare($sqlQuery);
					$stmt->execute();
					$totalPages = ceil(count($totalItems) / $row_page);
					// return json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $stmt,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					return $stmt;
				// 	}else{
				// 		header('Content-Type:Application/json');
				// 		echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));
				// 	}

				}elseif($project == 'PICKLING' or $project == 'ECL' or $project == '6Hi' or $project == 'RGM' or $project == 'TM' or $project == 'DAF' or $project == 'SB Area' or $project == 'CPL'){

				// 	$site = $_POST['site'];
					$massege = "Successfully Data fetch !";
					$success = 1;
					$sqlQuery = "Select  DISTINCT date(date_format(time, '%Y-%m-%d')) as time, Name  from ".$this->db_table." where Department = '$project'  ORDER BY time Desc LIMIT {$begin},{$row_page}";
					$stmt = $this->conn->prepare($sqlQuery);
					$stmt->execute();
					$totalPages = ceil(count($totalItems) / $row_page);
					header('Content-Type:Application/json');
					// return json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $stmt,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					return $stmt;
				}else{
				echo json_encode(array("message" => "No Data !") );
			    }
				
			// return $stmt;
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
		}
	}
	// CREATE
	public function createCamList(){
		if($_SERVER['REQUEST_METHOD']=='POST'){ 
			$department = $_POST['Department'];
			$area = $_POST['Area'];
			$nvr = $_POST['NvrName'];
			$camname = $_POST['CameraName'];
			$camloc = $_POST['CameraLocation'];
			$ip = $_POST['IPAddress'];
			$pn1 = $_POST['PanelNo1'];
			$pn2 = $_POST['PanelNo2'];
			$pn3 = $_POST['PanelNo3'];
			$pn4 = $_POST['PanelNo4'];
			$pn5 = $_POST['PanelNo5'];
			$user = $_POST['user'];
			$pass = $_POST['pass'];
			$sqlQuery = "INSERT INTO cameras(Department,CameraName,CameraLocation,IPAddress,user,pass) 
			VALUES ('$department','$area','$nvr','$camname','$camloc','$ip','$pn1','$pn2','$pn3','$pn4','$pn5','$user','$pass')";
			$stmt = $this->conn->prepare($sqlQuery);
			if($stmt->execute()){
			   return true;
			}
			return false;
		}else{
			echo json_encode(array("success" => 0,"message" => "Error occured, please try again!") );
		}
	}
	// READ single
	public function getSingleEmployee(){
		$sqlQuery = "SELECT
					id, 
					name, 
					email, 
					age, 
					designation, 
					created
				  FROM
					". $this->db_table ."
				WHERE 
				   id = ?
				LIMIT 0,1";
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->bindParam(1, $this->id);
		$stmt->execute();
		$dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$this->name = $dataRow['name'];
		$this->email = $dataRow['email'];
		$this->age = $dataRow['age'];
		$this->designation = $dataRow['designation'];
		$this->created = $dataRow['created'];
	}        
	// UPDATE
	public function updateCamlist(){
		if($_SERVER['REQUEST_METHOD']=='POST'){ 
			$depar = $_POST['Department'];
			$camname = $_POST['CameraName'];
			$ip = $_POST['IPAddress'];
			$cangeip = $_POST['ChangeIPAddress'];
			$user = $_POST['user'];
			$pass = $_POST['pass'];
			$sqlQuery ="UPDATE cameras SET Department = '$depar',CameraName = '$camname' , IPAddress = '$cangeip',user = '$user',pass = '$pass' WHERE IPAddress = '$ip'";
			$stmt = $this->conn->prepare($sqlQuery);
			if($stmt->execute()){
			   return true;
			}
			return false;
		}else{
			echo json_encode(array("success" => 0,"message" => "Error occured, please try again!") );
			}
		}
	
	// DELETE
	function deleteCamlist(){
		if($_SERVER['REQUEST_METHOD']=='POST'){ 
			$name = $_POST['FileName'];
			$sqlQuery = "DELETE FROM " . $this->db_table . " WHERE Name = '$name'";
			$stmt = $this->conn->prepare($sqlQuery);
		
		
			if($stmt->execute()){
				return true;
			}
			return false;
	}else{
		echo json_encode(array("success" => 0,"message" => "Error occured, please try again!") );
		}
	}
	function toggel($arr){
		$data = json_decode($arr);
		$query =  "Update cameras set vest = :vest ,helmet = :helmet ,boot= :boot,glove = :glove,goggle = :goggle,incompletescaffolding = :incompletescaffolding,withoutscaffolding = :withoutscaffolding,incorrectclimbingladder = :incorrectclimbingladder,	housekeeping = :housekeeping,General = :General,Scaffolding = :Scaffolding where CameraName in (:cam)";
		$stmt = $this->conn->prepare($query);
		$flag = true;
		foreach($data as $item){
			foreach($item as $item){
				$stmt->bindValue(':cam', $item->camera);
				$stmt->bindValue(':vest', $item->vest);
				$stmt->bindValue(':helmet', $item->helmet);
				$stmt->bindValue(':boot', $item->boot);
				$stmt->bindValue(':glove', $item->glove);
				$stmt->bindValue(':goggle', $item->goggle);
				$stmt->bindValue(':incompletescaffolding', $item->incompletescaffolding);
				$stmt->bindValue(':withoutscaffolding', $item->withoutscaffolding);
				$stmt->bindValue(':incorrectclimbingladder', $item->incorrectclimbingladder);
				$stmt->bindValue(':housekeeping', $item->housekeeping);
				// $stmt->bindValue(':Cranelatch', $item->Cranelatch);
				// $stmt->bindValue(':HandSignal', $item->HandSignal);
				// $stmt->bindValue(':hazardous', $item->hazardous);
				$stmt->bindValue(':General', $item->General);
				$stmt->bindValue(':Scaffolding', $item->Scaffolding);
				// print_r($stmt);
				if($stmt->execute()){
					continue;
				}
				else{
				   $arr = $stmt->errorInfo();
					$flag = false;
				
				}
			}
		}
		return true;
		
	}
	// Dump camera List 
	function orderDetails($arr){
		// print( count(get_object_vars($arr)));
		$data = json_decode($arr);
// 		print_r($data);
		// $query=  "INSERT INTO sparepartorderdetails (SparePartID, OrderID, Quantity, Price) VALUES($SparePartID,$qty,$Price,$OrderID)";
		$query =  "INSERT INTO cameras(Name,NvrName,Department,CameraName,CameraLocation,IPAddress,user,pass) VALUES
				  (:Name,:NvrName ,:Department, :CameraName,:CameraLocation, :IPAddress,  :user, :pass)";
		$stmt = $this->conn->prepare($query);	
		foreach($data as $item){
			foreach($item as $item)
			{	
				$CameraName = str_replace(' ', '_', $item->CameraName);
			  $stmt->bindValue(':Name', $item->Name);
			  $stmt->bindValue(':NvrName', $item->NvrName);
				$stmt->bindValue(':Department', $item->Department);
				$stmt->bindValue(':CameraName', $CameraName);
				$stmt->bindValue(':CameraLocation', $item->CameraLocation);
				$stmt->bindValue(':IPAddress', $item->IPAddress);
				$stmt->bindValue(':user', $item->user);
				$stmt->bindValue(':pass', $item->pass);
				if($stmt->execute()){
					continue;
				}
				else{
				   $arr = $stmt->errorInfo();
					print_r($arr);
				
				}
			}
		}
		return true;	
    }
	// TOGGLE STATUS
	public function tglstats(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$cam_ = $_POST['caminfo'];
			$page= $_POST['page'];
			$row_page = $_POST['row_page'];
			// $site = '';
            if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
				$begin = ($page*$row_page)-$row_page;
				// echo "Begin =====".$begin;
				$sqlQuery = "Select * from ".$this->db_table;
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$totalItems[]=$stmt;
				if($cam_ == "ALL"){
					// $site = $_POST['site'];
					// $massege = "please enter site name !";
					// if($site == 'HSM' or $site == 'SMS' or $site == 'XYZ'){
					// $massege = "Successfully Data fetch !";
					$success = 1;
					$sqlQuery = "Select * from ".$this->db_table."  where 1  ORDER BY Department Desc LIMIT {$begin},{$row_page}";
					$stmt = $this->conn->prepare($sqlQuery);
					$stmt->execute();
					$totalPages = ceil(count($totalItems) / $row_page);
					// return json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $stmt,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					return $stmt;
					// }else{
						// header('Content-Type:Application/json');
						// echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));	
					// }
				
				}else{
					$massege = "Successfully Data fetch !";
					$success = 1;
					$sqlQuery = "Select * from ".$this->db_table." where CameraName = '$cam_'  ORDER BY Department Desc LIMIT {$begin},{$row_page}";
					$stmt = $this->conn->prepare($sqlQuery);
					$stmt->execute();
					$totalPages = ceil(count($totalItems) / $row_page);
					header('Content-Type:Application/json');
					// return json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $stmt,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					return $stmt;
				}
			// return $stmt;
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
		}
	}
	function deleteCamInfo(){
		if($_SERVER['REQUEST_METHOD']=='POST'){ 
			$name = $_POST['Name'];
			$sqlQuery = "DELETE FROM " . $this->db_table . " WHERE Department = '$name'";
			$stmt = $this->conn->prepare($sqlQuery);
		
		
			if($stmt->execute()){
				return true;
			}
			return false;
	}else{
		echo json_encode(array("success" => 0,"message" => "Error occured, please try again!") );
		}
	}
	public function excelFile(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$project = $_POST['FileName'];
			$page= $_POST['page'];
			$row_page = $_POST['row_page'];
			$site = '';
            if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
				$begin = ($page*$row_page)-$row_page;
				// echo "Begin =====".$begin;
				$sqlQuery = "Select * from ".$this->db_table;
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$totalItems[]=$stmt;
				// if($project == "Admin"){
				if(true){
					$site = $_POST['site'];
					$massege = "please enter site name !";
					// if($site == 'HSM' or $site == 'SMS' or $site == 'XYZ'){
					if(true){
						$massege = "Successfully Data fetch !";
						$success = 1;
						$sqlQuery = "Select * from ".$this->db_table."  where Department = '$project'  ORDER BY Department Desc LIMIT {$begin},{$row_page}";
						$stmt = $this->conn->prepare($sqlQuery);
						$stmt->execute();
						$totalPages = ceil(count($totalItems) / $row_page);
						// return json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $stmt,"totalPages"=>$totalPages,"currentpage"=>$page) ));
						return $stmt;
					}else{
						header('Content-Type:Application/json');
						echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));	
					}
				
				}
				else{
					$site = $_POST['site'];
					$massege = "Successfully Data fetch !";
					$success = 1;
					$sqlQuery = "Select * from ".$this->db_table." where Department = '$site'  ORDER BY Department Desc LIMIT {$begin},{$row_page}";
					$stmt = $this->conn->prepare($sqlQuery);
					$stmt->execute();
					$totalPages = ceil(count($totalItems) / $row_page);
					header('Content-Type:Application/json');
					// return json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $stmt,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					return $stmt;
				}
			// return $stmt;
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
		}
	}
	public function preview(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$name = $_POST['Name'];
			$page= $_POST['page'];
			$row_page = $_POST['row_page'];
			$site = '';
            if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
				$begin = ($page*$row_page)-$row_page;
				// echo "Begin =====".$begin;
				$sqlQuery = "Select * from ".$this->db_table;
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$totalItems[]=$stmt;
				// if($project == "Admin"){
				if(true){
					$site = $_POST['site'];
					$massege = "please enter site name !";
					// if($site == 'HSM' or $site == 'SMS' or $site == 'XYZ'){
					if(true){
						$massege = "Successfully Data fetch !";
						$success = 1;
						$sqlQuery = "Select * from ".$this->db_table."  where Name = '$name'  ORDER BY Name Desc LIMIT {$begin},{$row_page}";
						$stmt = $this->conn->prepare($sqlQuery);
						$stmt->execute();
						$totalPages = ceil(count($totalItems) / $row_page);
						// return json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $stmt,"totalPages"=>$totalPages,"currentpage"=>$page) ));
						return $stmt;
					}else{
						header('Content-Type:Application/json');
						echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));	
					}
				
				}
				else{
					$site = $_POST['site'];
					$massege = "Successfully Data fetch !";
					$success = 1;
					$sqlQuery = "Select * from ".$this->db_table." where Department = '$site'  ORDER BY Department Desc LIMIT {$begin},{$row_page}";
					$stmt = $this->conn->prepare($sqlQuery);
					$stmt->execute();
					$totalPages = ceil(count($totalItems) / $row_page);
					header('Content-Type:Application/json');
					// return json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $stmt,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					return $stmt;
				}
			// return $stmt;
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
		}
	}
	public function expo(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$name = $_POST['FileName'];
			$export = $_POST['ExportType'];
			// $page= $_POST['page'];
			// $row_page = $_POST['row_page'];
			// $site = '';
			if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
				$sql_query = "SELECT * FROM ".$this->db_table." where Name = '$name'";
				// $sqlQuery = "Select * from ".$this->db_table." where Department = '$site'  ORDER BY Department Desc LIMIT {$begin},{$row_page}";
				$stmt = $this->conn->prepare($sql_query);
				$stmt->execute();
				$tasks = array();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$tasks[] = $row;
				}
				if(isset($_POST["ExportType"]))
				{
					switch($_POST["ExportType"])
					{
						case "export-to-excel" :
							// Submission from
							$filename = "phpflow_data_export_". ".xls";		 
							header("Content-Type: application/vnd.ms-excel");
							header("Content-Disposition: attachment; filename=\"$filename\"");
							$this->ExportFile($tasks);
							//$_POST["ExportType"] = '';
							exit();
							return true;
						default :
							die("Unknown action : ".$_POST["action"]);
							break;
							return false;
					}
				}
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
		}
	}
	public function Cam_fiter(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$project = $_POST['Department'];
			$cam = $_POST['CameraName'];
			$page= $_POST['page'];
			$row_page = $_POST['row_page'];
			$loc = '';
            if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
				$begin = ($page*$row_page)-$row_page;
				$sqlQuery = "Select * from ".$this->db_table;
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$totalItems[]=$stmt;
				if($project == "Admin"){
					$loc = $_POST['Location'];
				// 	print_r("Ravi");
					if($loc == 'PICKLING' or $loc == 'ECL' or $loc == '6Hi' or $loc == 'RGM' or $loc == 'TM' or $loc == 'DAF' or $loc == 'SB Area' or $loc == 'CPL'){
    					$massege = "Successfully Data fetch !";
    					$success = 1;
    					$sqlQuery = "Select * from ".$this->db_table." Where Department = '$loc' and CameraName  = '$cam' ORDER BY time Desc LIMIT {$begin},{$row_page}";
    					print_r($sqlQuery);
    					$stmt = $this->conn->prepare($sqlQuery);
    					$stmt->execute();
    					$totalPages = ceil(count($totalItems) / $row_page);
    					return $stmt;
					}elseif($loc == 'All'){
					    $massege = "Successfully Data fetch !";
    					$success = 1;
    					$sqlQuery = "Select * from ".$this->db_table." ORDER BY time Desc LIMIT {$begin},{$row_page}";
    					$stmt = $this->conn->prepare($sqlQuery);
    					$stmt->execute();
    					$totalPages = ceil(count($totalItems) / $row_page);
    					return $stmt;
						
					}else{
					    header('Content-Type:Application/json');
						echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					}

				}elseif($project == 'PICKLING' or $project == 'ECL' or $project == '6Hi' or $project == 'TM' or $project == 'DAF' or $project == 'SB Area' or $project == 'CPL'){
                    if ($cam !=''){
    					$massege = "Successfully Data fetch !";
    					$success = 1;
    					$sqlQuery = "Select * from ".$this->db_table." where Department = '$project'  and CameraName = '$cam' ORDER BY time Desc LIMIT {$begin},{$row_page}";
    					$stmt = $this->conn->prepare($sqlQuery);
    					$stmt->execute();
    					$totalPages = ceil(count($totalItems) / $row_page);
    					header('Content-Type:Application/json');
    					return $stmt;
                    }else{
                        
                        $massege = "Successfully Data fetch !";
    					$success = 1;
    					$sqlQuery = "Select * from ".$this->db_table." where Department = '$project' ORDER BY time Desc LIMIT {$begin},{$row_page}";
    					$stmt = $this->conn->prepare($sqlQuery);
    					$stmt->execute();
    					$totalPages = ceil(count($totalItems) / $row_page);
    					header('Content-Type:Application/json');
    					return $stmt;
                    }
				}
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
		}
	}
	
  }
?>