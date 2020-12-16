<?php

if(isset($_POST['loginButton'])){
	
	$username = $_POST['loginUsername'];
	$password = $_POST['loginPassword'];
	

	$result = $account->login($username, $password);

	if($result == true){
		$_SESSION['userLoggedIn'] = $username;  //for the session(security for the index.php page)
		header("Location: index.php");
	}
}

?>