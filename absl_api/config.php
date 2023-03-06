<?php
$host = "localhost";
$user = "root";
$password = "pass";
$db = "tatatinplate";
$con = mysqli_connect($host,$user,$password,$db);
if(	mysqli_connect_errno()){
echo "Failed to connect with Database:".mysqli_connect_errno();

}




?>