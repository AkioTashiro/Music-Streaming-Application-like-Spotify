<!--Copied from album.php bc it's super similer-->

<?php 
include("includes/includedFiles.php");

if(isset($_GET['id'])){
	$playlistId = $_GET['id'];
}
else{
	header("Location: index.php"); 
}
$playlist = new Playlist($con, $playlistId);
$owner = new User($con, $playlist->getOwner());

?>

<div class="entityInfo">
	<div class="leftSection">
		<div class="playlistImage">
			<img src="assets/images/icons/playlist.png">
		</div> 
	</div>

	<div class="rightSection">  <!--to show the title of the album right next to the artwork-->
		<h2><?php echo $playlist->getName(); ?></h2>
		<p>By <?php echo  $playlist->getOwner(); ?></p>  <!--if you wanna put only text, <span> is good one to use//changed to <p>-->
		<p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
		<button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>
	</div>
</div>

<!--Track list and play buttun icon etc-->
<div class="tracklistContainer">
	<ul class="tracklist">   <!--ul makes order with a dot • to make it look good-->
		<?php 
		
		$songIdArray = $playlist->getSongIds();

		$i = 1;
		foreach($songIdArray as $songId){  //foreach loop pick up each songId everyting run the songIdArray
			
			$playlistSong = new Song($con, $songId);
			$songArtist = $playlistSong->getArtist();

//All the design of tracks of the album under the image of the album
			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $playlistSong->getId() . "\" , tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" . $playlistSong->getTitle() . "</span>
						<span class='artistName'>" . $songArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
						<img class='optionButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $playlistSong->getDuration() . "</span>
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

<nav class="optionsMenu">
	<input type="hidden" class="songId">  <!--prev in the script.js access here(closest ancester)-->
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?> <!--goes Playlist.php file to access sql-->
	<div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from Playlist</div>
</nav>









