<?php
$host = "localhost";
$user = "arcturu_tata";
$password = "ravi@8448214581";
$db = "arcturu_tatasteel";
$con = mysqli_connect($host,$user,$password,$db);
if(	mysqli_connect_errno()){
echo "Failed to connect with Database:".mysqli_connect_errno();

}




?>