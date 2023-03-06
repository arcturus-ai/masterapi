<?php
 class Analytics{
    private $conn;
	private $db_table = "cameras";
    public  $SparePartID;
    public  $OrderID;
    public  $Price;
    public  $Quantity;
	public  $Department = 'hello';
	public  $Name;
	public  $Area;
	public  $NvrName;
	public  $CameraName;
	public  $IPAddress;
	public  $PanelNo1;
	public  $PanelNo2;
	public  $PanelNo3;
	public  $PanelNo4;
	public  $PanelNo5;
	public  $user;
	public  $pass;
	public  $vest;
	public	$helmet;
	public	$boot;
	public	$glove;
	public	$goggle;
	public	$RackIn;
	public	$RackOut;
	public	$lockStatus;
	public	$TagStatus;
	public	$Koolcoat;
	public	$Barricading;
	public	$MagneticFlesher;
	public	$Distance;
	public	$Counter;
	public	$Hydroulic;
	public	$M_electrical;
	public	$M_ppe;
	public	$General;
	public	$Electrical;
	public	$Mechanical;
	public  $stmt = null;

	public function __construct($db){
		
		$this->conn = $db;
		
	}
	
	function ppe($arr) {
        $ppe = array();
        $cameras = [];
        $data = json_decode($arr);
        // $Graph1 = array_key_exists('Graph1',$data);
        // $Graph2 = array_key_exists('Graph2',$data);
        $Graph2 = array_key_exists('Graph2',(array)$data);
        if($Graph2){
           	foreach($data as $item){
           	    $data__ = array();
    			foreach($item as $itm){
    				$depar = str_replace('&', 'N', $itm->Department); 
    			    if($itm->CameraName!=''){
    			       $query =  "SELECT SUM($itm->helmet) as 'helmet',
                		SUM($itm->vest) as 'vest' ,
                		SUM($itm->glove) as 'glove',
                		SUM($itm->goggle) as 'goggle',
                		SUM($itm->boot) as 'boot',
                		SUM($itm->handguard) as 'handguard' ,
                		SUM($itm->hazardous) as 'hazardous' ,
                		SUM($itm->legguard) as 'legguard',Department from ai_safety where CameraName = '$itm->CameraName' and date BETWEEN '$itm->starttime' and '$itm->endtime'";
                    // print_r("if".$query);    
                    $stmt = $this->conn->prepare($query);

    			    }elseif($depar!=''){
        			    $query =  "SELECT SUM($itm->helmet) as 'helmet',
                    		SUM($itm->vest) as 'vest' ,
                    		SUM($itm->glove) as 'glove',
                    		SUM($itm->goggle) as 'goggle',
                    		SUM($itm->boot) as 'boot',
                    		SUM($itm->handguard) as 'handguard' ,
                		    SUM($itm->legguard) as 'legguard',
                		    SUM($itm->hazardous) as 'hazardous' ,
                            Department from ai_safety where  Department = '$depar' and date BETWEEN '$itm->starttime' and '$itm->endtime'";
                        // print_r("elseif".$query);
                        $stmt = $this->conn->prepare($query);     
    			    }else{
        			    $query =  "SELECT SUM($itm->helmet) as 'helmet',
                    		SUM($itm->vest) as 'vest' ,
                    		SUM($itm->glove) as 'glove',
                    		SUM($itm->goggle) as 'goggle',
                    		SUM($itm->boot) as 'boot',
                    		SUM($itm->handguard) as 'handguard' ,
                		    SUM($itm->legguard) as 'legguard',
                		    SUM($itm->hazardous) as 'hazardous' ,
                    		Department from ai_safety where date BETWEEN '$itm->starttime' and '$itm->endtime'";
                    	// print_r("else".$query);
                        $stmt = $this->conn->prepare($query);
    			    }
    				if ($stmt->execute()){
    				    array_push($data__,$stmt);
    				}else{
    				    $arr = $stmt->errorInfo();
    				    array_push($data__,$arr);
    				}
    			}
    		}
		 return $data__;  
	    }

	    else{
	        
	        echo json_encode(array( "success" => 0,"message" => "Please Defined Graph Mode !") );
	    }
	}
	
	function processCount($arr){
	    $data = json_decode($arr);
	    // $Graph3 = array_key_exists('Graph3',$data);
	    $Graph3 = array_key_exists('Graph3',(array)$data);
	    if($Graph3){
		    foreach($data as $item){
       	    $data__ = array();
    			foreach($item as $itm){
    			    if($itm->Cameraname!=''){
    			       $query =  "SELECT sum(Case when $itm->ppe = 1 THEN 1 else 0 end) as ppe, 
                	   sum(Case when $itm->Rackin = 1 THEN 1 else 0 end) as RackIn,
                	   sum(Case when $itm->Rackout = 1 THEN 1 else 0 end) as RackOut, 
                	   sum(Case when $itm->lockStatus = 1 THEN 1 else 0 end) as LockStatus, 
                	   sum(Case when $itm->UnLock = 0 THEN 0 else 1 end) as UnLoclStatus, 
                	   sum(Case when $itm->Tag = 1 THEN 1 else 0 end) as Tag, 
                	   sum(Case when $itm->UnTag = 0 THEN 0 else 1 end) as UnTag, 
                	   sum(Case when $itm->barricading = 1 THEN 1 else 0 end) as Barricading, 
                	   sum(Case when $itm->magneticFlesher = 1 THEN 1 else 0 end) as MagneticFlesher, 
                	   sum(Case when $itm->PersonCount = 1 THEN 1 else 0 end) as PersonCount,
    	               Department from joblist where  Department = $itm->Department and CameraName = '$itm->Cameraname' and date BETWEEN '$itm->starttime' and '$itm->endtime'";
                    $stmt = $this->conn->prepare($query); 
    			    }elseif($itm->Department!=''){
    			        
        			 $query =  "SELECT sum(Case when $itm->ppe = 1 THEN 1 else 0 end) as ppe, 
                	   sum(Case when $itm->Rackin = 1 THEN 1 else 0 end) as RackIn,
                	   sum(Case when $itm->Rackout = 1 THEN 1 else 0 end) as RackOut, 
                	   sum(Case when $itm->Lock = 1 THEN 1 else 0 end) as LockStatus, 
                	   sum(Case when $itm->UnLock = 0 THEN 0 else 1 end) as UnLockStatus, 
                	   sum(Case when $itm->Tag = 1 THEN 1 else 0 end) as Tag, 
                	   sum(Case when $itm->UnTag = 0 THEN 0 else 1 end) as UnTag, 
                	   sum(Case when $itm->barricading = 1 THEN 1 else 0 end) as Barricading, 
                	   sum(Case when $itm->magneticFlesher = 1 THEN 1 else 0 end) as MagneticFlesher, 
                	   sum(Case when $itm->PersonCount = 1 THEN 1 else 0 end) as PersonCount
                		 ,Department from joblist where  Department = '$itm->Department' and time BETWEEN '$itm->starttime' and '$itm->endtime'";
                        $stmt = $this->conn->prepare($query);
    			        
    			    }else{
    			     
        			 $query =  "SELECT sum(Case when $itm->ppe = 1 THEN 1 else 0 end) as ppe, 
                	   sum(Case when $itm->Rackin = 1 THEN 1 else 0 end) as RackIn,
                	   sum(Case when $itm->Rackout = 1 THEN 1 else 0 end) as RackOut, 
                	   sum(Case when $itm->Lock = 1 THEN 1 else 0 end) as LockStatus, 
                	   sum(Case when $itm->UnLock = 0 THEN 0 else 1 end) as UnLockStatus, 
                	   sum(Case when $itm->Tag = 1 THEN 1 else 0 end) as Tag, 
                	   sum(Case when $itm->UnTag = 0 THEN 0 else 1 end) as UnTag, 
                	   sum(Case when $itm->barricading = 1 THEN 1 else 0 end) as Barricading, 
                	   sum(Case when $itm->magneticFlesher = 1 THEN 1 else 0 end) as MagneticFlesher, 
                	   sum(Case when $itm->PersonCount = 1 THEN 1 else 0 end) as PersonCount from joblist ";
                        $stmt = $this->conn->prepare($query);
    			    }
    				if ($stmt->execute()){
    				    array_push($data__,$stmt);
    				}else{
    				    $arr = $stmt->errorInfo();
    				    array_push($data__,$arr);
    				}
    			}
		    }
		    return $data__;
	    }else{
	        $data__ = array();
	         $query =  "SELECT sum(Case when ppe = 1 THEN 1 else 0 end) as ppe, 
	         sum(Case when Rackin = 1 THEN 1 else 0 end) as RackIn, 
	         sum(Case when Rackout = 1 THEN 1 else 0 end) as RackOut, 
	         sum(Case when lockStatus = 1 THEN 1 else 0 end) as LockStatus, 
	         sum(Case when lockStatus = 0 THEN 0 else 1 end) as UnLockStatus, 
	         sum(Case when TagStatus = 1 THEN 1 else 0 end) as Tag, 
	         sum(Case when TagStatus = 0 THEN 0 else 1 end) as UnTag, 
	         sum(Case when barricading = 1 THEN 1 else 0 end) as Barricading, 
	         sum(Case when magneticFlesher = 1 THEN 1 else 0 end) as MagneticFlesher, 
	         sum(Case when PersonCount = 1 THEN 1 else 0 end) as PersonCount from joblist";
            // print_r($query);
            $stmt = $this->conn->prepare($query); 
		   
			if ($stmt->execute()){
			    array_push($data__,$stmt);
			}else{
			    $arr = $stmt->errorInfo();
			    array_push($data__,$arr);
			}
		    return $data__;
	    }
	}
	function upLoadedFile(){
	    if($_SERVER["REQUEST_METHOD"]=="POST"){
	        $username = $_POST['username'];
			$password = $_POST['password'];
			if(($username == "TaTaStEEl") && ($password == "TaTaStEEl@24052022" )){
			    $sqlQuery = "Select Count(Distinct Name) as 'TotalFile' from joblist ";
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
	    }
	    return $stmt;
	}
	
	function executedJob(){
	    if($_SERVER["REQUEST_METHOD"]=="POST"){
	        $username = $_POST['username'];
			$password = $_POST['password'];
			if(($username == "TaTaStEEl") && ($password == "TaTaStEEl@24052022" )){
			    $sqlQuery = "Select Count(Name) as 'job' from joblist ";
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
	    }
	    return $stmt;
	}
	function camActivate(){
	    if($_SERVER["REQUEST_METHOD"]=="POST"){
	        $username = $_POST['username'];
			$password = $_POST['password'];
			if(($username == "TaTaStEEl") && ($password == "TaTaStEEl@24052022" )){
			    $sqlQuery = "Select Count(Name) as 'job' from joblist ";
				$stmt = $this->conn->prepare($sqlQuery);
				$stmt->execute();
			}else{
				echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
			}
	    }
	    return $stmt;
	}
	function camera($arr){
	    $data = json_decode($arr);
	    // $Graph1 = array_key_exists('Graph1',$data);
	    $Graph1 = array_key_exists('Graph1',(array)$data);
	    $conditions = array();
	    if($Graph1){
	        foreach($data as $item){
    			foreach($item as $itm){
    				$CameraName = str_replace(' ', '_', $itm->CameraName);
    				// print_r($CameraName);
                    $conditions[] = "'$CameraName'";
                    // $sql = $query;
                    if (count($conditions) > 0) {
                        if(($itm->starttime!='') and ($itm->endtime!= '') and $CameraName!='' ){
                            $sql = "SELECT DISTINCT(CameraName),Activity FROM CameraActivity WHERE  CameraName IN (" .implode( ',',$conditions).") and time BETWEEN '$itm->starttime' and '$itm->endtime' ORDER BY Activity DESC";
                        }else{
                            $sql = "SELECT DISTINCT(CameraName),Activity FROM CameraActivity WHERE  time BETWEEN '$itm->starttime' and '$itm->endtime'  ORDER BY Activity DESC";
                            
                        }
                    
                            
                    }
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute();
    			}
    			return $stmt;
	        }
	       // return $stmt;
	    }else{
	        foreach($data as $item){
    			foreach($item as $itm){
                    $sql = "SELECT CameraName,Activity,Department FROM CameraActivity WHERE time BETWEEN ORDER BY Activity DESC";
                            
                }
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
    		}
    	return $stmt;
	   }
	}
	
    function operation($arr) {
        $ppe = array();
        $cameras = [];
        $data = json_decode($arr);
        $Graph2 = array_key_exists('Graph2',(array)$data);
        if($Graph2){
           	foreach($data as $item){
           	    $data__ = array();
    			foreach($item as $itm){
    				$depar = str_replace('&', 'N', $itm->Department);
    			    if($itm->Cameraname!=''){
    			       $query =  "SELECT
                		SUM($itm->Handling) as 'Handling' ,
                		SUM($itm->HandSignal) as 'HandSignal',
                		SUM($itm->Cranelatch) as 'Cranelatch',
                		SUM($itm->Crane) as 'Crane',Department from ai_safety where  Department = '$depar' and CameraName = '$itm->Cameraname' and date BETWEEN '$itm->starttime' and '$itm->endtime'";
                        
                    $stmt = $this->conn->prepare($query); 
    			    }elseif($itm->Department!=''){
        			    $query =  "SELECT 
                    		SUM($itm->Handling) as 'Handling', 
                    		SUM($itm->HandSignal) as 'HandSignal',
                    		SUM($itm->Cranelatch) as 'Cranelatch',
                    		SUM($itm->Crane) as 'Crane' ,Department from ai_safety where  Department = '$depar' and date BETWEEN '$itm->starttime' and '$itm->endtime'";
                        $stmt = $this->conn->prepare($query);     
    			    }else{
        			    $query =  "SELECT 
                    		SUM($itm->Handling) as 'Handling' ,
                    		SUM($itm->HandSignal) as 'HandSignal',
                    		SUM($itm->Cranelatch) as 'Cranelatch',
                    		SUM($itm->Crane) as 'Crane' ,Department from ai_safety where date BETWEEN '$itm->starttime' and '$itm->endtime'";

                        $stmt = $this->conn->prepare($query);
    			    }
    			    // print_r($query);
    				if ($stmt->execute()){
    				    array_push($data__,$stmt);
    				}else{
    				    $arr = $stmt->errorInfo();
    				    array_push($data__,$arr);
    				}
    			}
    		}
		 return $data__;  
	    }

	    else{
	        
	        echo json_encode(array( "success" => 0,"message" => "Please Defined Graph Mode !") );
	    }
	}
	}

?>