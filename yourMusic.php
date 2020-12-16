<?php 
include("includes/includedFiles.php");
?>

<div class="playlistContainer">
	<div class="gridViewContainers">
		<h2>PLAYLISTS</h2>

		<div class="buttonItems">
			<button class="button green" onclick="createPlaylist()">NEW PLAYLIST</button>
		</div>


<!--Copied fro0m Album.php class same strategy-->
		<?php
			$username = $userLoggedIn->getUsername();

			$playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

			if(mysqli_num_rows($playlistsQuery) == 0) {
				echo "<span class='noResult'>You don't have any playlists yet.</span>";
			}

			while($row = mysqli_fetch_array($playlistsQuery)){  //roop the every single row in the album table 

				$playlist = new Playlist($con, $row);

				//it'll show the list on the screen
				echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'> 
						<div class='playlistImage'>
							<img src='assets/images/icons/playlist.png'>
						</div>

						<div class='gridViewInfo'>"  
								. $playlist->getName() .
						"</div>
					</div>";	
			}
		?>







	</div>

</div>
