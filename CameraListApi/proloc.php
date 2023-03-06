<?php
$con = mysqli_connect("localhost","root","root","l&mhi");
$sql = "SELECT * from cameras";
$result = mysqli_query($con,$sql);
$data = array();
while($row = mysqli_fetch_assoc($result)){
	
	$data[] =$row;
	
}
header('Content-Type:Application/json');
echo json_encode(array( "status" => "true","message" => "Data fetch Success!" , "data" => $data) );


?>