<?php
 class Scaffolding{
	private $conn;
	private $db_table = "ai_safety";
	public $Department;
	public $Name;
	public $Area ;
	public $NvrName ;
	public $CameraName;
	public $EquipmentName;
	public $Event;
	public $Status;
	public $IsolationPoint;
	public $panel;
	public $RackIn;
	public $RackOut;
	public $RackInTime;
	public $RackOutTime;
	public $ppe;
	public $lockStatus;
	public $TagStatus;
	public $MagneticFlesher;
	public $Barricading;
	public $PersonCount;
	public $time;
	public $page;
	public $row_page;
	public $total_page = 0;
	public $site;
	public $cameraname = null;
	public $start = null;
	public $end  = null;
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
                $cameraname = $_POST['CameraName'];
                $dep = $_POST['Department'];
    			$start = $_POST['starttime'];
    			$end = $_POST['endtime'];
    		    $page= $_POST['page'];
    			$row_page = $_POST['row_page'];
                $begin = ($page*$row_page)-$row_page;
				$sqlQuery = "Select * from ".$this->db_table;
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$totalItems[]=$stmt;
                if($cameraname!=null and $start != null and $end != null){
                    // print_r("Hello1");
                    $sqlQuery = "Select * from ".$this->db_table. " WHERE CameraName = '$cameraname' and date BETWEEN '$start' and '$end' ORDER BY Department Desc LIMIT {$begin},{$row_page}";
        			$stmt = $this->conn->prepare($sqlQuery);
        			$stmt->execute();
        			$totalPages = ceil(count($totalItems) / $row_page);
        			return $stmt;
        			
                }elseif($cameraname != null and $start == null and $end == null){
                    print_r("Hello2");
        			$sqlQuery = "Select * from ".$this->db_table." Where CameraName = '$cameraname'  ORDER BY Department Desc LIMIT {$begin},{$row_page}";
        			$stmt = $this->conn->prepare($sqlQuery);
        			$stmt->execute();
        			$totalPages = ceil(count($totalItems) / $row_page);
        			return $stmt;
        			
                }elseif($cameraname == null and  $start != null and $end != null){
                    print_r("Hello3");
                    $sqlQuery = "Select * from ".$this->db_table." Where date BETWEEN '$start' and '$end' ORDER BY Department Desc LIMIT {$begin},{$row_page}";
        			$stmt = $this->conn->prepare($sqlQuery);
        			$stmt->execute();
        			$totalPages = ceil(count($totalItems) / $row_page);
        			return $stmt;
        			
        			
                }
                elseif($dep!=null and $start != null and $end != null){
                    print_r("Hello4");
                    // $sqlQuery = "Select * from ".$this->db_table;
                    $sqlQuery = "Select * from ".$this->db_table. " WHERE Department = '$dep' and date BETWEEN '$start' and '$end' ORDER BY Department Desc LIMIT {$begin},{$row_page}";
        			$stmt = $this->conn->prepare($sqlQuery);
        			$stmt->execute();
        			$totalPages = ceil(count($totalItems) / $row_page);
        			return $stmt;
        			
                }elseif($dep != null and $start == null and $end == null){
                    print_r("Hello5");
        			$sqlQuery = "Select * from ".$this->db_table." Where Department = '$dep'  ORDER BY Department Desc LIMIT {$begin},{$row_page}";
        			$stmt = $this->conn->prepare($sqlQuery);
        			$stmt->execute();
        			$totalPages = ceil(count($totalItems) / $row_page);
        			return $stmt;
        			
                }elseif($dep == null and  $start != null and $end != null){
                    print_r("Hello6");
                    $sqlQuery = "Select * from ".$this->db_table." Where date BETWEEN '$start' and '$end' ORDER BY Department Desc LIMIT {$begin},{$row_page}";
        			$stmt = $this->conn->prepare($sqlQuery);
        			$stmt->execute();
        			$totalPages = ceil(count($totalItems) / $row_page);
        			return $stmt;
        			
        			
                }
                else{
                    $sqlQuery = "Select * from ".$this->db_table." Where 1  ORDER BY Department Desc LIMIT {$begin},{$row_page}";
        			$stmt = $this->conn->prepare($sqlQuery);
        			$stmt->execute();
        			$totalPages = ceil(count($totalItems) / $row_page);
        			return $stmt;
        		
        		
                }
    		    
    		}else{
    			echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
    		}
	    }
	}
	

    public function view(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$camera = $_POST['CameraName'];
			$time =  $_POST['time'];
			$sqlQuery = "Select * from ".$this->db_table. " WHERE CameraName = '$camera' and time = '$time' Order by date DESC";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			return $stmt;
		}
	}
	public function search(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$camera = $_POST['CameraName'];
			$Department = $_POST['Department'];
			$sqlQuery = "Select * from ".$this->db_table. " WHERE CameraName Order by date DESC";
			if($Department !=null && $camera!=null){
			  $sqlQuery = "Select * from ".$this->db_table. " WHERE CameraName = '$camera' and Department = '$Department'  Order by date DESC";  
			}
			elseif($Department == null  && $camera!=null ){
			    $sqlQuery = "Select * from ".$this->db_table. " WHERE CameraName = '$camera' Order by date DESC";
			}
			elseif($Department != null  && $camera==null ){
			    $sqlQuery = "Select * from ".$this->db_table. " WHERE CameraName = '$camera' Order by date DESC";
			}
			$sqlQuery = "Select * from ".$this->db_table. " WHERE CameraName = '$camera' Order by date DESC";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			return $stmt;
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
	public function excelFile(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$project  = $_POST['Department'];
			$page     = $_POST['page'];
			$row_page = $_POST['row_page'];
			$site     = '';
            if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
				$begin = ($page*$row_page)-$row_page;
				// echo "Begin =====".$begin;
				$sqlQuery = "Select * from ".$this->db_table;
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$totalItems[]=$stmt;
				
				if($project == "Admin"){
					$site = $_POST['site'];
					$massege = "please enter site name !";
					if($site == 'PICKLING' or $site == 'ECL' or $site == '6Hi' or $site == 'RGM' or $site == 'TM' or $site == 'DAF' or $site == 'SB Area' or $site == 'CPL'){
						$massege = "Successfully Data fetch !";
						$success = 1;
						$sqlQuery = "Select * from ".$this->db_table."  where Department = '$site'  ORDER BY time Desc LIMIT {$begin},{$row_page}";
						$stmt = $this->conn->prepare($sqlQuery);
						$stmt->execute();
						$totalPages = ceil(count($totalItems) / $row_page);
						// return json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $stmt,"totalPages"=>$totalPages,"currentpage"=>$page) ));
						return $stmt;
					}else{
						header('Content-Type:Application/json');
						echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					}

				}else{
					$site = $_POST['site'];
					$massege = "Successfully Data fetch !";
					$success = 1;
					$sqlQuery = "Select * from ".$this->db_table." where Department = '$site'  ORDER BY time Desc LIMIT {$begin},{$row_page}";
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
	public function historyFilter(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$project = $_POST['Department'];
		    $search = $_POST['ID'];
			$page= $_POST['page'];
			$row_page = $_POST['row_page'];
			$site = '';
		    $totalPages = 0;
            if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
				$begin = ($page*$row_page)-$row_page;
				$sqlQuery = "Select * from ".$this->db_table;
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
				$totalItems[]=$stmt;
				$site = $_POST['site'];
				if($project == "Admin"){
					$massege = "Please Enter File ID !";
					if($search == ''){
						$massege = "Successfully Data fetch !";
						$success = 1;
						$sqlQuery = "Select * from ".$this->db_table."  where 1  ORDER BY time Desc LIMIT {$begin},{$row_page}";
						$stmt = $this->conn->prepare($sqlQuery);
						$stmt->execute();
						$totalPages = ceil(count($totalItems) / $row_page);
						return $stmt;
					}elseif($search != ''){
					    $massege = "Successfully Data fetch !";
						$success = 1;
						$sqlQuery = "Select * from ".$this->db_table."  where ID = '$search'  ORDER BY time Desc LIMIT {$begin},{$row_page}";
						$stmt = $this->conn->prepare($sqlQuery);
						$stmt->execute();
						$totalPages = ceil(count($totalItems) / $row_page);
						return $stmt;
					}
					else{
					    header('Content-Type:Application/json');
					    echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					}
				}elseif($site == 'TND' or $site == 'Utility' or $site == 'RMHS' or $site == 'Sinter Plant' or $site == 'RMBB' or $site == 'Coke Plant' or $site == 'BPP' or $site == 'SMS' or $site == 'Blast Furnace' or $site == 'LCP' or $site == 'HSM' or $site == 'CRM' or $site == 'Pellet Plant'){
				    $massege = "Please Enter File ID !";
                    if($search != ''){
					    $massege = "Successfully Data fetch !";
						$success = 1;
						$sqlQuery = "Select * from ".$this->db_table."  where ID = '$search'  ORDER BY time Desc LIMIT {$begin},{$row_page}";
						$stmt = $this->conn->prepare($sqlQuery);
						$stmt->execute();
						$totalPages = ceil(count($totalItems) / $row_page);
						return $stmt;
					}
					else{
					    header('Content-Type:Application/json');
					    echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));
					}
				}else{
				    $massege = "please enter site name !";
				    header('Content-Type:Application/json');
					echo json_encode(array( "success" => $success,"message" => $massege ,"result" =>array("data" => $data,"totalPages"=>$totalPages,"currentpage"=>$page) ));
				    }
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
			
		}
	}
	public function abc(){
	   if($_SERVER["REQUEST_METHOD"]=="POST"){

	       
	        $username = $_POST['username'];
			$password = $_POST['password'];
    	    $project = $_POST['Department'];

            $cam = $_POST['CameraName'];
    		$start = $_POST['starttime'];
    		$end = $_POST['endtime'];
    	    $page= $_POST['page'];
    		$row_page = $_POST['row_page'];
            $begin = ($page*$row_page)-$row_page;
    		$sqlQuery = "Select * from ".$this->db_table;
    		$stmt = $this->conn->prepare($sqlQuery);
    		$stmt->execute();
    		$totalItems[]=$stmt;
    		
            if(($username == "TaTaTinPlate") && ($password == "TaTaTinPlate@24052022" )){
               
                $conditions = array();
                if($project == 'Admin'){
                    if(! empty($cam)) {
                      $conditions[] = "CameraName='$cam'";
                      $sqlQuery = "Select * from ".$this->db_table. " WHERE ".implode(' and ', $conditions)." and date BETWEEN '$start' and '$end' ORDER BY time Desc LIMIT {$begin},{$row_page}";
                      $totalPages = ceil(count($totalItems) / $row_page);
                    
                      $stmt = $this->conn->prepare($sqlQuery);
        			  $stmt->execute();
                      return $stmt;
                }else{
                    echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
                	}
                }else{
                    $conditions[] = "CameraName='$cam'";
                    $sqlQuery = "Select * from ".$this->db_table. " WHERE ".implode(' and ', $conditions)." and date BETWEEN '$start' and '$end' ORDER BY time Desc LIMIT {$begin},{$row_page}";
                    $stmt = $this->conn->prepare($sqlQuery);
    				$stmt->execute();
                    return $stmt;
                    
                }
                
    	    }else{
        		echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
        	}   
        }
    }
 }
?>