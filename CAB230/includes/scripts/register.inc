<?php
	include "includes/functions.inc";
  	include "config/DBconfig.inc";
	
	$GLOBALS['checkEmail']='';
	$GLOBALS['checkEmailEntered']='';
	$GLOBALS['checkUsername']='';
	$GLOBALS['checkName']='';
	$GLOBALS['checkUsernameEntered']='';
	$GLOBALS['checkBirthDate']='';
	$GLOBALS['checkPostcode']='';
	$GLOBALS['checkPassword']='';
	$GLOBALS['checkConfirmPassword']='';
	$GLOBALS['checkGender']='';
	$GLOBALS['checkPasswordMatch'] = '';

	if (isset($_POST['name'])) {
		//Process the form

		$unique_email = true;
		$correct_form = true;
		$available_entry = true;

		if(!empty($_POST['name'])) {
			$name = $_POST["name"];
		} else {
			$correct_form = false;
    		$GLOBALS['checkName']="<span style='color:red;'>Please enter your name!</span>";
		}

		if(!empty($_POST['email'])) {
			$email = $_POST["email"];
		} else {
			$correct_form = false;
    		$GLOBALS['checkEmailEntered']="<span style='color:red;'>Please enter your email!</span>";
		}

		if(!empty($_POST['username'])) {
			$username = $_POST["username"];
		} else {
			$correct_form = false;
    		$GLOBALS['checkUsernameEntered']="<span style='color:red;'>Please enter a username!</span>";
		}

	    if((!empty($_POST['year'])) && (!empty($_POST['month'])) && (!empty($_POST['day']))) {
		    $birthdate = ($_POST['year']) . '-' . ($_POST['month']) . '-' . ($_POST['day']);
		} else {
			$correct_form = false;
    		$GLOBALS['checkBirthDate']="<span style='color:red;'>Please select your birthdate!</span>";
		}

		if(!empty($_POST['postcode'])) {
			$postcode = $_POST["postcode"];
		} else {
			$correct_form = false;
    		$GLOBALS['checkPostcode']="<span style='color:red;'>Please enter your postcode!</span>";
		}

		if(!empty($_POST['password'])) {
			$password = $_POST["password"];
		} else {
			$correct_form = false;
    		$GLOBALS['checkPassword']="<span style='color:red;'>Please enter a password!</span>";
		}

		if(!empty($_POST['confirmPassword'])) {
			$confirmPassword = $_POST["confirmPassword"];
		} else {
			$correct_form = false;
    		$GLOBALS['checkConfirmPassword']="<span style='color:red;'>Please confirm your password!</span>";
		}

	    if(!empty($_POST['gender'])) {
	        $gender = $_POST['gender'];
	    } else {
	    	$correct_form = false;
    		$GLOBALS['checkGender']="<span style='color:red;'>Please select your gender!</span>";
	    }

	    if ($correct_form) {
		    //Confirm email entered is unique
	    	$pdo =	dbConnect();
	    	
	    	$sql =	"SELECT email FROM users ";
	    	$sql .=	"WHERE email = :email";
		   	$stmt = $pdo->prepare($sql);
	    	$stmt->bindValue(":email", $email);
	    	$stmt->execute();

	    	if ($stmt->rowCount() > 0) {
	    		$available_entry = false;
	    		$GLOBALS['checkEmail']="<span style='color:red;'>Email already exists!</span>";
	    	}

	    	$sql =	"SELECT username FROM users ";
	    	$sql .=	"WHERE username = :username";
		   	$stmt = $pdo->prepare($sql);
	    	$stmt->bindValue(":username", $username);
	    	$stmt->execute();

	    	if ($stmt->rowCount() > 0) {
	    		$available_entry = false;
	    		$GLOBALS['checkUsername']="<span style='color:red;'>Username already exists!</span>";
	    	}

	    	// Hash the password
		    if ($password != $confirmPassword) {
		    	$correct_form = false;
		    	$GLOBALS['checkPasswordMatch']="<span style='color:red;'>Passwords do not match!</span>";
		    } else {
		    	$hashedPassword = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
		    }

	    	// If the form has been filled out correctly without any duplicate unique fields, process the form
	    	if ($available_entry == true && $correct_form == true) {
		    	$q = "INSERT INTO users(name,email,username,birthdate,gender,postcode,password)VALUES(:name,:email,:username,:birthdate,:gender,:postcode,:password);";
			    	
			    $query = $pdo->prepare($q);
			    $query->execute(array(
			    	":name"=>$name,
			   		":email"=>$email,
			   		":username"=>$username,
			   		":birthdate"=>$birthdate,
			   		":gender"=>$gender,
			   		":postcode"=>$postcode,
			   		":password"=>$hashedPassword)
			    	);
			}
		}
	}
?>