<?php  
include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])){
	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];

//playlist order(when you add the song)
	$orderIdQuery = mysqli_query($con, "SELECT IFNULL(MAX(playlistOrder) + 1, 1) as playlistOrder FROM playlistSongs WHERE playlistId='$playlistId'");
	//MAX(...)is to put new song into last of the list
	$row = mysqli_fetch_array($orderIdQuery);
	$order = $row['playlistOrder'];

	$query = mysqli_query($con, "INSERT INTO playlistSongs VALUES(NULL, '$songId', '$playlistId', '$order')");

}
else{
	echo "PlaylistId or songId was not passed into addToPlaylist.php";
}


?>