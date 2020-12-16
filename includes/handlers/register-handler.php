<?php  

//2 "Sanitization" - function for when register button was pressed
function sanitizeFormPassword($inputText){  //green coloer = function name, Orange = parameter with variable
	$inputText = strip_tags($inputText);	
	return $inputText;
}

function sanitizeFormUsername($inputText){
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);	
	return $inputText;
}

function sanitizeFormString($inputText){   //string type
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText));	
	return $inputText;
}

/* Move to Account.php file
//4 fucntion to validate the input
function validateUsername($un){

}
function validateFirstName($fn){
	
}
function validateLastName($ln){
	
}
function validateEmail($em, $em2){
	
}
function validatePasswords($pw, $pw2){
	
}
*/

//1 when the Register button was pressed
if(isset($_POST['registerButton'])){
//3	
	// call the functions #2
	$username = sanitizeFormUsername($_POST['username']);   //sanitize the datas and then call the function
	$firstname = sanitizeFormString($_POST['firstname']);
	$lastname = sanitizeFormString($_POST['lastname']);
	$email = sanitizeFormString($_POST['email']);
	$email2 = sanitizeFormString($_POST['email2']);
	$password = sanitizeFormPassword($_POST['password']);
	$password2 = sanitizeFormPassword($_POST['password2']);
//from register.php
	$wasSuccessful = $account->register($username, $firstname, $lastname, $email, $email2, $password, $password2);  
	//added $wasSuccessful varuable after if(empty)function in Account.php
	if($wasSuccessful == true){
		//echo "register is true";
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}
	

//Move to register.php as a header
//6	$account = new Account(); 


/* Move to Account.php file
//5 call the function #4
	validateUsername($username);
	validateFirstName($firstname);
	validateLastName($lastname);
	validateEmail($email, $email2);
	validatePasswords($password, $password2);
*/

/* Basic way. go to #2 for the better way
//1*
	$username = $_POST['username'];  //$ means variable same as var username, string username etc
	$username = strip_tags($username); //strip only allows text but no special charactars
	$username = str_replace(" ", "", $username); //if user put space" ", it'll change to no space "" 

	$firstname = $_POST['firstname'];
	$firstname = strip_tags($firstname);
	$firstname = str_replace(" ", "", $firstname);
	$firstname = ucfirst(strtolower($firstname)); //uppercase at first letter, the rest all will be lower

*/	

}


?>