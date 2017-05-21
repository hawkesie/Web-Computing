<?php
	// Function for global variable to echo if email already taken in UserRegistrationPage.php
	function checkEmail(){
		echo $GLOBALS['checkEmail'];
	}

	// Function for global variable to echo if username already taken in UserRegistrationPage.php
	function checkUsername(){
		echo $GLOBALS['checkUsername'];
	}

	// Function for global variable to echo if the username and password combination doesn't exist
	function checkUsernamePasswordCombination(){
		echo $GLOBALS['badUsernamePassword'];
	}
?>