<!--Class for the artist-->
<?php 
	class Artist{

		private $con;  //lec3
		private $id;

		public function __construct($con, $id){  //this is constructor that can be called very 1st!!
			$this->con = $con;   //lec3
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		public function getName(){
			$artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id='$this->id'");
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['name'];
		}

		public function getSongIds(){
			$query = mysqli_query($this->con, "SELECT id FROM Songs WHERE artist='$this->id' ORDER BY plays DESC");
			$array = array();
			
			while($row = mysqli_fetch_array($query)){
				array_push($array, $row['id']);
			}
			return $array;
		}

	} 
 ?>


































