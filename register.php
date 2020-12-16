<?php 
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php"); 
 
//from Account.php #6
	$account = new Account($con); //Account is the Class name in Account.php
// Move to register-handler.php
	//$account->register();  //need -> to access register function inside of the class

	include("includes/handlers/register-handler.php");  //references to other files. "call"
	include("includes/handlers/login-handler.php");
 	
 	function getInputValue($name){
 		if(isset($_POST[$name])){
 			echo $_POST[$name];
 		}
 	}

 ?>



<!DOCTYPE html>
<html>
<head>
	<title>Welcom to Slotify!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/register.css"><!--how to link the css file-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!--jquery hosted by google to use jquery java-->
	<script src="assets/js/register.js"></script><!--to use the java script file register.js. not "include" on the top this time-->
</head>

<body>
	<?php 

	if(isset($_POST['registerButton'])){  //to show the register form after pressing the button.
		echo '<script>
				$(document).ready(function(){ 
					$("#loginForm").hide();
					$("#registerForm").show();
				});	
			</script>';
	}
	else{
		echo '<script>
				$(document).ready(function(){ 
					$("#loginForm").show();
					$("#registerForm").hide();
				});	
			</script>';

	}

	?>
	
	<script>// script = java script
	/*	$(document).ready(function(){  //to show login or register on the web
				$("#loginForm").show();
				$("#registerForm").hide();
		});	copy to the php above*/
	</script>
	<div id="background">
		<div id="loginContainer">

			<div id="inputContainer">

				<!--Login-->
				<form id="loginForm" action="register.php" method="POST"> <!--how we send the data to another page-->

					<h2>Login to your account</h2>	<!--header and size of it-->
					<p>
						<?php echo $account->getError(Constants::$loginFailed); ?> 
						<label for="loginUsername">Username</label><!--label tag = label-->
						<input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('loginUsername') ?>" required>   
					<!--type = input box in the web, placeholder = e.g. in the box, required = input has to be valid-->
					</p><!--paragraph tag= always appears in the seperate line-->
					<p>
						<label for="loginPassword">Password</label>  <!--loginPassword must be same name as id below-->
						<input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" required> 
					<!--type=password to hide with .--> 
					</p>

					<button type="submit" name="loginButton">LOG IN</button>

					<!--to seperate the login and registerform-->
					<div class="hasAccountText">
						<span id="hideLogin">Don't have an account yet? Signup here.</span>
					</div>

				</form>


				<!--Registration-->
				<form id="registerForm" action="register.php" method="POST"> <!--how we send the data to another page-->
					<!--registration part-->
					<h2>Create your free account</h2>
					
					<!--User Name section-->
					<p>
						<?php echo $account->getError(Constants::$usernameCharacters); ?>  <!--connecting to Accont.php file-->
						<?php echo $account->getError(Constants::$usernameTaken);?>
						<label for="username">Username</label>
						<input id="username" name="username" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('username') ?>" required>   <!--value=?php is to keep showing the input in the input box after submitting -->
					<!--id, name must be different from above-->
					</p>		
					
					<!--First Name section-->
					<p>
						<?php echo $account->getError(Constants::$fisrtNameCharacters); ?>
						<label for="firstname">First name</label>
						<input id="firstname" name="firstname" type="text" placeholder="e.g. bart" value="<?php getInputValue('firstname') ?>" required>   
					</p>
					<!--Last Name section-->
					<p>
						<?php echo $account->getError(Constants::$lastNameCharacters); ?>
						<label for="lastname">Last name</label>
						<input id="lastname" name="lastname" type="text" placeholder="e.g. Simpson" value="<?php getInputValue('lastname') ?>" required>   
					</p>

					<!--Email section-->
					<p>
						<?php echo $account->getError(Constants::$emailsDoNoMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<label for="email">Email</label>	<!--don't forget to change the type. email is a type-->
						<input id="email" name="email" type="email" placeholder="e.g. bart@gmail.com" value="<?php getInputValue('email') ?>" required>   
					</p>
					<!--The Email confirmation-->
					<p>
						<label for="email2">Confirm email</label>
						<input id="email2" name="email2" type="email" placeholder="e.g. bart@gmail.com" value="<?php getInputValue('email2') ?>" required>   
					</p>

					<!--Password section-->
					<p>
						<?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
						<label for="password">Password</label>  <!--loginPassword must be same name as id below-->
						<input id="password" name="password" type="password" placeholder="Your password">  
					</p>
					<!--Password sconfirmation-->
					<p>
						<label for="password2">Confirm password</label>  <!--loginPassword must be same name as id below-->
						<input id="password2" name="password2" type="password" placeholder="Your password" required> 
					<!--type=password to hide with .--> 
					</p>

					<button type="submit" name="registerButton">SIGN UP</button>

					<!--to seperate the login and registerform.-->
					<div class="hasAccountText">   <!--ust class instead of id-->
						<span id="hideRegister">Already have an account? Log in here.</span>
					</div>

				</form>

			</div>

			<div id="loginText">
				<h1>Get great music, right now</h1>
				<h2>Listen to loads of songs for free</h2>
				<ul>
					<li>Discover music you'll fall in love with</li>  <!--li stands for list item(different bullet point)-->
					<li>Create your own playlists</li>
					<li>Follow artists to keep up to date</li>
				</ul>
			</div>


		</div>	
	</div>
</body>

</html>