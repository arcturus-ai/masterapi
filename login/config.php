<?php
$host = "localhost";
$user = "arcturu_root";
$password = "ravi@8448214581";
$db = "arcturu_scaff";
$con = mysqli_connect($host,$user,$password,$db);
if(	mysqli_connect_errno()){
echo "Failed to connect with Database:".mysqli_connect_errno();

}




?>