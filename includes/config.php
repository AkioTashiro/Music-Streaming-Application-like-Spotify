<?php 
	
	ob_start();  //all the data to be sent it to server
	session_start();  //to not let access to index.php page without username and password. 

	$timezone = date_default_timezone_set("America/New_York");

	$con = mysqli_connect("localhost", "root", "", "slotify");   //make connection to the database

	if(mysqli_connect_errno()){   //if it can't connect to the database
		echo "Failed to connect: " . mysqli_connect_errno();
	}

?>