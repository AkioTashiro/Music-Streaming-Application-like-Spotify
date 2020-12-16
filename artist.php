<?php 
//To make the artist page

include("includes/includedFiles.php");

if(isset($_GET['id'])){
	//echo $_GET['id'];  to test if it works
	$artistId = $_GET['id'];
}
else{
	//echo "Id not set";  to test if it works
	header("Location: index.php"); //if id isn't set, stay in the index page
}

$artist = new Artist($con, $artistId);

?>

<div class="entityInfo borderButton">  <!--we already created the html style in album.php-->
	
	<div class="centerSection">
		
		<div class="artistInfo">

			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>

			<div class="headerButtons">
				<button class="button green" onclick="playFirstSong()">PLAY</button>
				
			</div>
			
		</div>
	</div>

</div>

<!--copied from album.php-->
<div class="tracklistContainer borderButton">
	<h2>SONGS</h2>
	<ul class="tracklist">   <!--ul makes order with a dot • to make it look good-->
		<?php 
		
		$songIdArray = $artist->getSongIds();

		$i=1;
		foreach($songIdArray as $songId){  //foreach loop pick up each songId everyting run the songIdArray
			
			if($i > 5){
				break;
			}

			$albumSong = new Song($con, $songId);
			$albumArtist = $albumSong->getArtist();

//All the design of tracks of the album under the image of the album
			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\" , tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $albumArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
						<img class='optionButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>


				</li>";
			$i = $i + 1;
		}

		?>

<!--To play the correct playlist(organized)-->
		<script>
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>

	</ul>
</div>


<!--copied from browse.php-->
<div class="gridViewContainers">

	<h2>ALBUMS</h2>
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

		while($row = mysqli_fetch_array($albumQuery)){  //roop the every single row in the album table 

			//to get the image of the containers
			//seperate strings exist by . . that joints them together
			//!! a little confusing part with all " ' .
			echo "<div class='gridViewItem'>
					<span role='linik' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'> 

						<div class='gridViewInfo'>"
							. $row['title'] .
							"</div>
					</span>
				</div>";
			//echo $row['title'] . "<br>";  // . "<br>" to seperate the lines //this works but use alt way above

		}
	?>
	
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">  <!--prev in the script.js access here(closest ancester)-->
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?> <!--goes Playlist.php file to access sql-->
</nav>



