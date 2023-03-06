<?php
  class Ploygone{
	private $conn;
	private $db_table = "paint_cordinate";
    public $SparePartID;
    public $OrderID;
    public $Price;
    public $Quantity;
	public $Department;
	public $Name;
	public $Area;
	public $NvrName;
	public $CameraName;
	public $IPAddress;
	public $PanelNo1;
	public $PanelNo2;
	public $PanelNo3;
	public $PanelNo4;
	public $PanelNo5;
	public $user;
	public $pass;
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
	public function __construct($db){
		$this->conn = $db;
	}
	
	
	public function getData(){
	    if($_SERVER["REQUEST_METHOD"]=="POST"){
	        $username = $_POST['username'];
					$password = $_POST['password'];
          if(($username == "TaTaStEEl") && ($password == "TaTaStEEl@24052022" )){
	                
	    			$sqlQuery = "Select * from ".$this->db_table."";
	    			$stmt = $this->conn->prepare($sqlQuery);
	    			$stmt->execute();
	    			print_r($stmt);
    		
	    		}else{
	    			echo json_encode(array( "success" => 0,"message" => "opps parameter missing !") );
	    		}
	    }
	}
	
	
	// CREATE
	public function polygone(){
		if($_SERVER['REQUEST_METHOD']=='POST'){ 
			
			$camname = $_POST['CameraName'];
			$pn1 = $_POST['cordinate'];
			$sqlQuery = "Select Location from ".$this->db_table."";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$camArr = array();
			// $camArr["body"] = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				array_push($camArr, $Location);
			}
			if (in_array($camname, $camArr))
			{
				// print_r("update");
		    $sqlQuery = "Update paint_cordinate set line1 = '$pn1' where Location = '$camname'";
				$stmt = $this->conn->prepare($sqlQuery);
				if($stmt->execute()){
				   return true;
			  }
			}
		  else{
				// print_r("insert");
				// $pass = $_POST['pass'];
				$sqlQuery = "INSERT INTO paint_cordinate(Location,line1) 
				VALUES ('$camname','$pn1')";
				$stmt = $this->conn->prepare($sqlQuery);
				if($stmt->execute()){
			   return true;
		  }
			// print_r($stmt);
			
			}
			return false;
		}else{
			echo json_encode(array("success" => 0,"message" => "Error occured, please try again!") );
		}
	}
	
	
  }
?>