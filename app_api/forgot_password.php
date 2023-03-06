<?php 
session_start(); 
if($_SERVER['REQUEST_METHOD']=='POST'){
	include_once("config.php");
	$username = $_POST['username'];
	$password  = $_POST['newpassword'];
	$conf_pass = $_POST['confirmpassword'];
	// $conn = mysqli_connect('hostname', 'username', 'password', 'database');
	
	if($password == $conf_pass) {
		// $hash = sodium_crypto_pwhash_str(
			// $password,
			// SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
			// SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
		// ); 
		
        $update = "UPDATE registration SET password = '$password' WHERE username = '$username' ";
		$success = 1;
        $result = mysqli_query($con, $update);
        $massege =  'Your new password has reset successfully, you can now login.';
        echo json_encode(array( "success" => $success,"message" => $massege ));
        // header("Location: index.php");
    }else {
        // $_SESSION['msg'] = 'Password does not match';
        // header("Location: index.php");
        $success = 0;
       
		$massege= 'Password does not match';
		echo json_encode(array( "success" => $success,"message" => $massege ));
    }

}else{
    $success = 0;
	$massege = "Some error!";
	echo json_encode(array( "success" => $success,"message" => $massege ));
}
?>