<?php 
//To search the songs from the tab

include("includes/includedFiles.php");

if(isset($_GET['term'])){
	$term = urldecode($_GET['term']);
}
else{
	$term = "";
}
?>

<div class="searchContainer">

	<h4>Serch for an artist, album or song</h4>
	<input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing..." onfocus="this.selectionStart = this.selectionEnd = this.value.length;"> <!--to make the cursol stay where user left the typing-->
	
</div>

<script>
	$(".searchInput").focus();

$(function(){
	//var timer; moved to script.js

	$(".searchInput").keyup(function(){
		clearTimeout(timer); //to clear the timer for the 2 sec below when type something

		//it'll show the result after after typing(2sec wait)
		timer = setTimeout(function(){
			var val = $(".searchInput").val();
			openPage("search.php?term=" + val);
		}, 2000);   //2000 mili-second = 2sec
	})
})

</script>

<?php if($term == "") exit(); ?>


<!--Copied from artist.php-->
<div class="tracklistContainer borderButton">
	<h2>SONGS</h2>
	<ul class="tracklist">   <!--ul makes order with a dot • to make it look good-->
		<?php
		//Search bar //matchs with the term(typed by user) //% with $term will include all in database
		$songsQuery = mysqli_query($con, "SELECT id FROM Songs WHERE title LIKE '$term%'");

		if(mysqli_num_rows($songsQuery) == 0) {
			echo "<span class='noResult'>No songs found matching " . $term . "</span>";
		}

		
//While loop to show the Search result up to 15
		$songIdArray = array();

		$i=1;
		while($row = mysqli_fetch_array($songsQuery)){
			
			if($i > 15){
				break;
			}

			array_push($songIdArray, $row['id']);

			$albumSong = new Song($con, $row['id']);
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

<div class="artistsContainer borderButton">

	<h2>ARTISTS</h2>

	<?php  
	$artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE'$term%' LIMIT 10");

	if(mysqli_num_rows($artistsQuery) == 0) {
		echo "<span class='noResult'>No artists found matching " . $term . "</span>";
	}

	while($row = mysqli_fetch_array($artistsQuery)){
		$artistFound = new Artist($con, $row{'id'});

		echo "<div class='searchResultRow'>
				<div class='artistName'>
					<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() ."\")'>
					"
					. $artistFound->getName() .

					"
					</span>
				</div>
			</div>";

	}

	?>
	
</div>

<div class="gridViewContainers">

	<h2>ALBUMS</h2>
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE'$term%' LIMIT 10");

		if(mysqli_num_rows($albumQuery) == 0) {
			echo "<span class='noResult'>No albums found matching " . $term . "</span>";
		}

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















