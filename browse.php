<!--Moved to header.php-->
<?php 
//include("includes/header.php");
include("includes/includedFiles.php");  //to make it work as AJAX (about URL)
?>
	
<!--Inside the main view-->	
<h1 class="pageHeadingBig">You Might Also Like</h1>
<!--Containers(Actual musics from the database)-->
<div class="gridViewContainers">
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

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