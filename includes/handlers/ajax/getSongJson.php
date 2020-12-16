<?php 
include("../../config.php");  //same shit with the linux 2steps up to access config.php

if(isset($_POST['songId'])){
	$songId = $_POST['songId'];

	$query = mysqli_query($con, "SELECT * FROM Songs WHERE id='$songId'");
	$resultArray = mysqli_fetch_array($query);
	echo json_encode($resultArray);
 }

?>