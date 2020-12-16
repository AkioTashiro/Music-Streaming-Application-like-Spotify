<!--Class for the album-->
<?php 
	class Album{

		private $con;  //lec3
		private $id;
		private $title;
		private $artistId;
		private $genre;
		private $artworkPath;


		public function __construct($con, $id){  //this is constructor that can be called very 1st!!
			$this->con = $con;   //lec3
			$this->id = $id;

			$query = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
			$album = mysqli_fetch_array($query);

			$this->title = $album['title'];
			$this->artistId = $album['artist'];
			$this->genre = $album['genre'];
			$this->artworkPath = $album['artworkPath'];

		}

		public function getTitle(){
			/* put this into the public function to make it efficient
			$query = mysqli_query($this->con, "SELECT title FROM albums WHERE id='$this->id'");
			$album = mysqli_fetch_array($query);
			*/
			return $this->title;
		}

		public function getArtist(){
			return new Artist($this->con, $this->artistId);  //because we have Artist class that access to artist column in the sql
		}

		public function getGenre(){
			return $this->genre;
		}

		public function getArtworkPath(){
			return $this->artworkPath;
		}

		public function getNumberOfSongs(){  //to get the number of songs in the album user chose.
			$query = mysqli_query($this->con, "SELECT id FROM Songs WHERE album='$this->id'");
			return mysqli_num_rows($query);
		}

		public function getSongIds(){
			$query = mysqli_query($this->con, "SELECT id FROM Songs WHERE album='$this->id' ORDER BY albumOrder ASC");
			$array = array();
			
			while($row = mysqli_fetch_array($query)){
				array_push($array, $row['id']);
			}
			return $array;
		}
	} 
 ?>


































