<?php
	// Function for global variable to echo if email already taken in UserRegistrationPage.php
	function checkEmail(){
		echo $GLOBALS['checkEmail'];
	}

	function checkEmailEntered(){
		echo $GLOBALS['checkEmailEntered'];
	}

	// Function for global variable to echo if username already taken in UserRegistrationPage.php
	function checkUsername(){
		echo $GLOBALS['checkUsername'];
	}

	function checkName(){
		echo $GLOBALS['checkName'];
	}

	function checkUsernameEntered(){
		echo $GLOBALS['checkUsernameEntered'];
	}

	function checkBirthDate(){
		echo $GLOBALS['checkBirthDate'];
	}

	function checkPostcode(){
		echo $GLOBALS['checkPostcode'];
	}

	function checkPassword(){
		echo $GLOBALS['checkPassword'];
	}

	function checkConfirmPassword(){
		echo $GLOBALS['checkConfirmPassword'];
	}

	function checkGender(){
		echo $GLOBALS['checkGender'];
	}

	function checkPasswordMatch(){
		echo $GLOBALS['checkPasswordMatch'];
	}

	// Function for global variable to echo if the username and password combination doesn't exist
	function checkUsernamePasswordCombination(){
		echo $GLOBALS['badUsernamePassword'];
	}
?>