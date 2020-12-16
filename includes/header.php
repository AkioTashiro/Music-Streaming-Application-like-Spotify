<?php
include("includes/config.php");
include("includes/classes/User.php");  //User.php has to be here bc other files need to use it
include("includes/classes/Artist.php");
include("includes/classes/Album.php");   //make sure it's after Artist.php
include("includes/classes/Song.php");
include("includes/classes/Playlist.php");
//session_destroy(); LOGOUT

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
	$username = $userLoggedIn->getUsername();
	echo "<script>userLoggedIn = '$username';</script>";

}
else {
	header("Location: register.php");  //header("Location: register.php");   //if nothing is set, user goes back to register page

}

?>

<html>
<head>
	<title>Welcome to Slotify!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">  <!--to connect with style.css file-->
<!--Lecture 10-->
	<!--Jquery Library-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
	<!--java script using jquery library above-->
	<script src="assets/js/script.js"></script>
</head>

<body>
	<script>
	var audioElemet = new Audio();
	audioElemet.setTrack("assets/music/bensound-acousticbreeze.mp3");
	audioElemet.audio.play(); 
	</script>

<!--Main: 1.Navigation part left 2.Main container part right 3.progress Bar part Bottom-->
<!--take the all lecture5 inside of the mainContainer below-->
	<div id="mainContainer">

<!--Navigation and Main on the top part-->
		<div id="topContainer">
	<!--Navigation part on the top left side-->
			<!--Moved to navBarContainer.php file so we have call the file now-->
			<?php include("includes/navBarContainer.php"); ?>  <!--calling the file-->
	<!--Main view part on the top right side-->
			<div id="mainViewContainer">
				<div id="mainContent">















