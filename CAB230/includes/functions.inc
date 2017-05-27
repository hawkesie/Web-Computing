<?php
	// Function for global variable to echo if email already taken in UserRegistrationPage.php
	function checkEmail(){
		echo $GLOBALS['checkEmail'];
	}

	// Function for global variable to echo if email is entered correctly in UserRegistrationPage.php
	function checkEmailEntered(){
		echo $GLOBALS['checkEmailEntered'];
	}

	// Function for global variable to echo if username already taken in UserRegistrationPage.php
	function checkUsername(){
		echo $GLOBALS['checkUsername'];
	}

	// Function for global variable to echo if name is entered correctly in UserRegistrationPage.php
	function checkName(){
		echo $GLOBALS['checkName'];
	}

	// Function for global variable to echo if username is entered correctly in UserRegistrationPage.php
	function checkUsernameEntered(){
		echo $GLOBALS['checkUsernameEntered'];
	}

	// Function for global variable to echo if birthdate is entered correctly in UserRegistrationPage.php
	function checkBirthDate(){
		echo $GLOBALS['checkBirthDate'];
	}

	// Function for global variable to echo if postcode is entered correctly in UserRegistrationPage.php
	function checkPostcode(){
		echo $GLOBALS['checkPostcode'];
	}

	// Function for global variable to echo if password is entered correctly in UserRegistrationPage.php
	function checkPassword(){
		echo $GLOBALS['checkPassword'];
	}

	// Function for global variable to echo if confirmPassword is entered correctly in UserRegistrationPage.php
	function checkConfirmPassword(){
		echo $GLOBALS['checkConfirmPassword'];
	}

	// Function for global variable to echo if gender is entered correctly in UserRegistrationPage.php
	function checkGender(){
		echo $GLOBALS['checkGender'];
	}

	// Function for global variable to check that be passwords given match in UserRegistrationPage.php
	function checkPasswordMatch(){
		echo $GLOBALS['checkPasswordMatch'];
	}

	// Function for global variable to echo if the username and password combination doesn't exist
	function checkUsernamePasswordCombination(){
		echo $GLOBALS['badUsernamePassword'];
	}
?>