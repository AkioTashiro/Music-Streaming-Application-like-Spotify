<?php 
	class Account{

		private $con;  //lec3
		private $errorArray;

		public function __construct($con){  //this is constructor that can be called very 1st!!
			$this->con = $con;   //lec3
			$this->errorArray = array();
		}
		//public will be called manually named register which can access private

		public function login($un, $pw){

			$pw = md5($pw);

			$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

			if(mysqli_num_rows($query) == 1){
				return true;
			}
			else{
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}



		public function register($un, $fn, $ln, $em, $em2, $pw, $pw2){ 
//from register-handler.php file #5
			$this->validateUsername($un);  //add this-> to use the func in the class
			$this->validateFirstName($fn);  //once the register func is called, all 5 gonna run of course
			$this->validateLastName($ln);
			$this->validateEmail($em, $em2);
			$this->validatePasswords($pw, $pw2);


			if(empty($this->errorArray) == true){  //check if the errorArray is empty
				//insert into database	if no error
				//echo "true!!!!!!!!!";
				return $this->insertUserDetails($un, $fn, $ln, $em, $pw);   //change true to insertUserDetails()
			}
			else{
				//echo "false";
				return false;
			}
		}
//connect in register.php file
		public function getError($error){
			if(!in_array($error, $this->errorArray)){ //if $error does NOT(!) exist in errorArray
				$error = ""; //if it doesn't find it, error is set to empty string""
				//echo "no error";
			}
			else
			{
				//echo "there is errors";
			}
			return "<span class='errorMessage'>$error</span>";
		}

//database lec3
		private function insertUserDetails($un, $fn, $ln, $em, $pw){
			$encryptedPw = md5($pw);  //md5 is one of encryption methods 
			$profilePic = "assets/images/profile-pics/head_emerald.png";  //to access to the picture from your file
			$date = date("Y-m-d");

			$result = mysqli_query($this->con, "INSERT INTO users VALUES (NULL, '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");  //these parameters match up with databases
			echo "Error: " . mysqli_error($con);

			return $result;  //if $result is not true above, it returns faulse
		}


//from register-handler.php file #4
		private function validateUsername($un){  //private can be called only inside the class
			//echo "username fucntion called";
			if(strlen($un) > 25 || strlen($un) < 5) {//strlen cound the # of charactars ex cat = 3
				//array_push($this->errorArray, "Your username must be between 5 and 25 characters");  original way. better way below
				array_push($this->errorArray, Constants::$usernameCharacters);  //:: for static, -> for class
				return; //return to stop bc we don't wanna execute any further from this error.
			}
			//Check if the username already exist
			$checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
			if(mysqli_num_rows($checkUsernameQuery) != 0){  //if the username is not = 0, push the error message to errorArray
				array_push($this->errorArray, Constants::$usernameTaken);
				return;
			}


		}
		private function validateFirstName($fn){
			//echo "firstname fucntion called";
			if(strlen($fn) > 25 || strlen($fn) < 2) {
				array_push($this->errorArray, Constants::$fisrtNameCharacters);
				return;
			}
		}
		private function validateLastName($ln){
			//echo "lastname fucntion called";
			if(strlen($ln) > 25 || strlen($ln) < 2) {
				array_push($this->errorArray, Constants::$lastNameCharacters);
				return;
			}
		}
		private function validateEmail($em, $em2){
			//echo "email fucntion called";
			if($em != $em2){
				array_push($this->errorArray, Constants::$emailsDoNoMatch);
				return;
			}
			if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
			//FILTER_VALIDATE_EMAIL knows what correct email format is. if filter_var sees $em is not ture(!)
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}
			//check if the email already exists
			$checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
			if(mysqli_num_rows($checkEmailQuery) != 0){
				array_push($this->errorArray, Constants::$emailTaken);
				return;
			}


		}
		private function validatePasswords($pw, $pw2){
			//echo "password fucntion called";
			if($pw != $pw2){
				array_push($this->errorArray, Constants::$passwordsDoNoMatch);
				return;
			}
			if(preg_match('/[^A-Za-z0-9]/', $pw)){//if inside of parameter match, do this. ^ means not. we don't wanna accept besides in []
				array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
				return;
			}
			if(strlen($pw) > 30 || strlen($pw) < 5){
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
				//we don't need to check pw2 becasue we check pw != pw2 at first of this function
			}
		}
	} 
 ?>


































