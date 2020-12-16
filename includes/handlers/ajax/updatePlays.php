 <?php 
include("../../config.php");  //same shit with the linux 2steps up to access config.php

if(isset($_POST['songId'])){
	$songId = $_POST['songId'];

	$query = mysqli_query($con, "UPDATE Songs SET plays = plays + 1 WHERE id='$songId'");  // space matters
	
 }

?>