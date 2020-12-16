$(document).ready(function(){

	$("#hideLogin").click(function(){  //$("#hideLogin") jquery object. hideLogin is from register.php. 
										//when ("#hideLogin") is clicked, below gonna happen
		$("#loginForm").hide();      //'#' means id. '.' means class.   hiding the element
		$("#registerForm").show();	// showing the element.
	});

	$("#hideRegister").click(function(){  //from register.php
		$("#loginForm").show();
		$("#registerForm").hide();
	});
});