<?php 
include("../../config.php");  //same shit with the linux 2steps up to access config.php

if(isset($_POST['albumId'])){
	$albumId = $_POST['albumId'];

	$query = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumId'");  // space matters
	$resultArray = mysqli_fetch_array($query);
	echo json_encode($resultArray);
 }

?>