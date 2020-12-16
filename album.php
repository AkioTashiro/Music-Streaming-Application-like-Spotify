<!--Album contents-->


<?php 
//include("includes/header.php");
include("includes/includedFiles.php");  //remove header.php and add this one instead

if(isset($_GET['id'])){
	//echo $_GET['id'];  to test if it works
	$albumId = $_GET['id'];
}
else{
	//echo "Id not set";  to test if it works
	header("Location: index.php"); //if id isn't set, stay in the index page
}

/*Deleted and create new one below instead
$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumId'");
$album = mysqli_fetch_array($albumQuery);
*/
$album = new Album($con, $albumId);

//echo $album['title']; to test if it works
//$album['artist']; we wanna put this into the sql command but there's single quotes so we can't. so
//$artistId = $album['artist']; and this go into the Artist class so get red of it

/*Moved to Artist.php
$artistQuery = mysqli_query($con, "SELECT * FROM artists WHERE id='$artistId'");
$artist = mysqli_fetch_array($artistQuery);
*/

$artist = $album->getArtist();  //new Artist($con, $album['artist']); taking off this. bc we have this in Album.php
/* 
test 1
echo $artist['name'] . "<br>";
echo $album['title'];
test 2
echo $album->getTitle() . "<br>";
echo $artist->getName();
*/
//$artistId = $artist-getId();

?>

<div class="entityInfo">
	<div class="leftSection">  <!--to show the artwork of the album when user click containers-->
		<img src="<?php echo $album->getArtworkPath(); ?>">  <!--remenber bc I have function of getArt.. in Album.php-->
	</div>

	<div class="rightSection">  <!--to show the title of the album right next to the artwork-->
		<h2><?php echo $album->getTitle(); ?></h2>
		<p>By <?php echo $artist->getName(); ?></p>  <!--if you wanna put only text, <span> is good one to use//changed to <p>-->
		<p><?php echo $album->getNumberOfSongs(); ?> songs</p>
	</div>
</div>


<!--Track list and play buttun icon etc-->
<div class="tracklistContainer">
	<ul class="tracklist">   <!--ul makes order with a dot • to make it look good-->
		<?php 
		
		$songIdArray = $album->getSongIds();

		$i=1;
		foreach($songIdArray as $songId){  //foreach loop pick up each songId everyting run the songIdArray
			
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

<!--For the Option Menue to put songs into the Playlist-->
<nav class="optionsMenu">
	<input type="hidden" class="songId">  <!--prev in the script.js access here(closest ancester)-->
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?> <!--goes Playlist.php file to access sql-->
</nav>








