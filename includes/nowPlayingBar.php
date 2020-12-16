<!--nowPlayingBarContainer-->

<?php //using playing bar to actually play songs 
$songQuery = mysqli_query($con, "SELECT id FROM Songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while($row = mysqli_fetch_array($songQuery)){
	array_push($resultArray, $row['id']);
}

//how to put and use php in Java, we use jason
$jsonArray = json_encode($resultArray);  //passing the php array(any valiable) to jason function so the $jasonArray has the playlist now 
?>

<script> //using playing bar to actually play songs pt2

//java script accessing php to play music
$(document).ready(function(){  //will wait until all documents are completely ready to star running.
	var newPlaylist = <?php echo $jsonArray; ?> ;
	//console.log(currentPlaylist);  //the reason why "Array" didn't show up on inspect
	audioElement = new Audio();
	setTrack(newPlaylist[0], newPlaylist, false);//it's false bc we don't want it play everytime open the application
	updateVolumeProgressBar(audioElement.audio);
 
//to not make it highlighted when mouse moves while clicking over the progress bar
	$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
		e.preventDefault();
	});

//in progress bar, make mouse to move play time bar
	$(".playbackBar .progressBar").mousedown(function(){
		mouseDown = true;
	});

	$(".playbackBar .progressBar").mousemove(function(e){  //set time of song, depending on position of mouse
		if(mouseDown == true){
			timeFromOffset(e, this);  //this = $(.playbackBar .ProgressBar), e = click
		}
	});

	$(".playbackBar .progressBar").mouseup(function(e){
		timeFromOffset(e, this);
	});


//in progress bar, make mouse to move volume bar
	$(".volumeBar .progressBar").mousedown(function(){
		mouseDown = true;
	});

	$(".volumeBar .progressBar").mousemove(function(e){  //set time of song, depending on position of mouse
		if(mouseDown == true){
			var percentage = e.offsetX / $(this).width();

			if(percentage >= 0 && percentage <=1){
				audioElement.audio.volume = percentage;
			}
		}
	});

	$(".volumeBar .progressBar").mouseup(function(e){
		var percentage = e.offsetX / $(this).width();

		if(percentage >= 0 && percentage <=1){
			audioElement.audio.volume = percentage;
		}
	});



	$(document).mouseup(function(){
		mouseDown = false;
	});


});

//.cont in progress bar, make mouse to move play time bar
function timeFromOffset(mouse, progressBar){
	var percentage = mouse.offsetX / $(progressBar).width() * 100;
	var seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds);
}


//play back button setting
function prevSong(){
	if(audioElement.audio.currentTime >= 3 || currentIndex == 0){
		audioElement.setTime(0);
	}
	else{
		currentIndex = currentIndex - 1;
		setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
	}
}

function nextSong(){

//About the repeat button
	if(repeat == true){
		audioElement.setTime(0);
		playSong();
		return;
	}

//About the skip button
	if(currentIndex == currentPlaylist.length - 1){
		currentIndex = 0;
	}
	else{
		currentIndex++;
	}

	var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
	setTrack(trackToPlay, currentPlaylist, true);
}

//Repeat button
function setRepeat(){
	repeat = !repeat;  //short way to do if(repeat == ture){repeat = false}else...
	var imageName = repeat ? "repeat-active.png" : "repeat.png"; //short var of if again. 
	$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);

}

//Mute Button
function setMute(){
	audioElement.audio.muted = !audioElement.audio.muted;
	var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png"; //short var of if again. 
	$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);

}

//Shuffle Button
function setShuffle(){
	shuffle = !shuffle;
	var imageName = shuffle ? "shuffle-active.png" : "shuffle.png"; //short var of if again. 
	$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

	if(shuffle == true){
		//randomize
		shuffleArray(shufflePlaylist);
		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
	}
	else{
		//shuggle has been deactivated
		//go back to regular playlist
		currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
	}
}

function shuffleArray(a){

//shuffle algorithm copied from google
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

function setTrack(trackId, newPlaylist, play) {

//Shuffle playlist
	if(newPlaylist != currentPlaylist){
		currentPlaylist = newPlaylist;
		shufflePlaylist = currentPlaylist.slice();
		shuffleArray(shufflePlaylist);
	}

	if(shuffle == true){
		currentIndex = shufflePlaylist.indexOf(trackId);
	}
	else{
		currentIndex = currentPlaylist.indexOf(trackId);  //related to the skip button
	}
	pauseSong();

//Ajax that can access to database in the javascript
	$.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
		

		var track = JSON.parse(data); //put the data from getSongJson file that access to database & pass to track
		$(".trackName span").text(track.title);  //jquery object to access the database // this shows the title in the play bar
//Ajax to get artist name
		$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data){
			var artist = JSON.parse(data);
			$(".trackInfo .artistName span").text(artist.name); 

			//when you click the artist name, it goes artist page
			$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
		});
//Ajax to get Album Image
		$.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data){
			var album = JSON.parse(data);
			$(".content .albumLink img").attr("src", album.artworkPath);  //attr = atribute

			//when you click the artist name, it goes artist page
			$(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
			$(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
		});
		
		audioElement.setTrack(track);
		if(play == true) {
		playSong();
		}
	});

}

function playSong(){

//To count the play
	if(audioElement.audio.currentTime == 0){
		$.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
	}
	
	$(".controlButton.play").hide();   //jquery inside("")is from html buttons in playbar below
	$(".controlButton.pause").show();
	audioElement.play();
}
function pauseSong(){
	$(".controlButton.play").show();   //jquery 
	$(".controlButton.pause").hide();
	audioElement.pause();
}


</script>


<div id="nowPlayingBarContainer">
	<div id="nowPlayingBar">
		<div id="nowPlayingLeft">  <!--leftside of the play bar-->
			<div class="content">
				<span class="albumLink">
					<img role="link" tabindex="0" src="" class="albumArtwork">
				</span>

				<div class="trackInfo">
					<span class="trackName">
						<span role="link" tabindex="0"></span>
					</span>

					<span class="artistName">
						<span role="link" tabindex="0"></span>
					</span>						
				</div>

			</div>
		</div>
		
		<div id="nowPlayingCenter">  <!--Center of the play bar-->
			
			<div class="content playerControls"> <!--2 classes, content and playercontrols-->
				<!--All 5 buttons in the center bar-->
				<div class="buttons">
					<button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>
				
					<button class="controlButton previous" title="Previous button" onclick="prevSong()">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>
				
					<button class="controlButton play" title="Play button" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>
				
					<button class="controlButton next" title="Next button" onclick="nextSong()">
						<img src="assets/images/icons/next.png" alt="Next">
					</button>
				
					<button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
						<img src="assets/images/icons/repeat.png" alt="Repeat">
					</button>
				</div>
<!--Song's Time Bar! it moves! -->
				<div class="playbackBar"> 
					<span class="progressTime current">0.00</span>
					<div class="progressBar">  <!--inside of the progress bar setting-->
						<div class="progressBarBg">  <!--base of the bar-->
							<div class="progress"></div>  <!--bar's color that increase-->
						</div>
					</div>
					<span class="progressTime remaining">0.00</span>
					
				</div>


			</div>
		</div>
<!--the Volume BUtton-->
		<div id="nowPlayingRight">  <!--Rightside of the play bar-->
			<div class="volumeBar">
				
				<button class="controlButton volume" title="Volume button" onclick="setMute()">
					<img src="assets/images/icons/volume.png" alt="Volume">  <!--alt means that in case the image broke, user still can see it's volume button-->
				</button>

				<!--same with the progressBar above-->
				<div class="progressBar">  <!--inside of the progress bar setting-->
					<div class="progressBarBg">  <!--base of the bar-->
						<div class="progress"></div>  <!--bar's color that increase-->
					</div>
				</div>

			</div>
		</div>
	</div>
</div>




