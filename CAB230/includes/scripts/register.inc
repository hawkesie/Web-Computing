<?php
	
	//Set globals for backend error checking. Provided the Javascript doesn't fail, these should never be required but are there just in case.
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

		//Set bools for error checks
		$unique_email = true;
		$correct_form = true;
		$available_entry = true;

		//setting values while ensuring XSS are prevented. Will only be used if Javascript fails
		if(!empty(htmlspecialchars($_POST['name']))) {
			$name = htmlspecialchars($_POST["name"]);
		} else {
			$correct_form = false;
			//Sets error message where global is positioned
    		$GLOBALS['checkName']="<span style='color:red;'>Back end validation failed. Please enter your name!</span>";
		}

		//setting values while ensuring XSS are prevented. Will only be used if Javascript fails
		if(!empty(htmlspecialchars($_POST['email']))) {
			$email = htmlspecialchars($_POST["email"]);
		} else {
			$correct_form = false;
			//Sets error message where global is positioned
    		$GLOBALS['checkEmailEntered']="<span style='color:red;'>Back end validation failed. Please enter your email!</span>";
		}

		//setting values while ensuring XSS are prevented. Will only be used if Javascript fails
		if(!empty(htmlspecialchars($_POST['username']))) {
			$username = htmlspecialchars($_POST["username"]);
		} else {
			$correct_form = false;
			//Sets error message where global is positioned
    		$GLOBALS['checkUsernameEntered']="<span style='color:red;'>Back end validation failed. Please enter a username!</span>";
		}

		//setting values while ensuring XSS are prevented. Will only be used if Javascript fails
	    if((!empty(htmlspecialchars($_POST['year']))) && (!empty(htmlspecialchars($_POST['month']))) && (!empty(htmlspecialchars($_POST['day'])))) {
		    $birthdate = (htmlspecialchars($_POST['year'])) . '-' . (htmlspecialchars($_POST['month'])) . '-' . (htmlspecialchars($_POST['day']));
		} else {
			$correct_form = false;
			//Sets error message where global is positioned
    		$GLOBALS['checkBirthDate']="<span style='color:red;'>Back end validation failed. Please select your birthdate!</span>";
		}

		//setting values while ensuring XSS are prevented. Will only be used if Javascript fails
		if(!empty(htmlspecialchars($_POST['postcode']))) {
			$postcode = htmlspecialchars($_POST["postcode"]);
		} else {
			$correct_form = false;
			//Sets error message where global is positioned
    		$GLOBALS['checkPostcode']="<span style='color:red;'>Back end validation failed. Please enter your postcode!</span>";
		}

		//setting values while ensuring XSS are prevented. Will only be used if Javascript fails
		if(!empty(htmlspecialchars($_POST['password']))) {
			$password = htmlspecialchars($_POST["password"]);
		} else {
			$correct_form = false;
			//Sets error message where global is positioned
    		$GLOBALS['checkPassword']="<span style='color:red;'>Back end validation failed. Please enter a password!</span>";
		}

		//setting values while ensuring XSS are prevented. Will only be used if Javascript fails
		if(!empty(htmlspecialchars($_POST['confirmPassword']))) {
			$confirmPassword = htmlspecialchars($_POST["confirmPassword"]);
		} else {
			$correct_form = false;
			//Sets error message where global is positioned
    		$GLOBALS['checkConfirmPassword']="<span style='color:red;'>Back end validation failed. Please confirm your password!</span>";
		}

		//setting values while ensuring XSS are prevented. Will only be used if Javascript fails
	    if(!empty(htmlspecialchars($_POST['gender']))) {
	        $gender = htmlspecialchars($_POST['gender']);
	    } else {
	    	$correct_form = false;
			//Sets error message where global is positioned
    		$GLOBALS['checkGender']="<span style='color:red;'>Back end validation failed. Please select your gender!</span>";
	    }

	    if ($correct_form) {
		    //Confirm email entered is unique
	    	$pdo =	dbConnect();
	    	
	    	//SQL statement to check if the email already exists within the database
	    	$sql =	"SELECT email FROM users ";
	    	$sql .=	"WHERE email = :email";
		   	$stmt = $pdo->prepare($sql);
	    	$stmt->bindValue(":email", $email);
	    	$stmt->execute();

	    	//If result is returned, email already exists
	    	if ($stmt->rowCount() > 0) {
	    		$available_entry = false;
				//Sets error message where global is positioned
	    		$GLOBALS['checkEmail']="<span style='color:red;'>Email already exists!</span>";
	    	}

	    	//SQL statement to check if the username already exists within the database
	    	$sql =	"SELECT username FROM users ";
	    	$sql .=	"WHERE username = :username";
		   	$stmt = $pdo->prepare($sql);
	    	$stmt->bindValue(":username", $username);
	    	$stmt->execute();

	    	//If result is returned, username already exists
	    	if ($stmt->rowCount() > 0) {
	    		$available_entry = false;
				//Sets error message where global is positioned
	    		$GLOBALS['checkUsername']="<span style='color:red;'>Username already exists!</span>";
	    	}

	    	// Hash the password after checking that passwords match. Error check will only run if Javascript fails
		    if ($password != $confirmPassword) {
		    	$correct_form = false;
				//Sets error message where global is positioned
		    	$GLOBALS['checkPasswordMatch']="<span style='color:red;'>Back end validation failed. Passwords do not match!</span>";
		    } else {
		    	//Hash the password
		    	$hashedPassword = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
		    }

	    	// If the form has been filled out correctly without any duplicate unique fields, process the form
	    	if ($available_entry == true && $correct_form == true) {
		    	$q = "INSERT INTO users(name,email,username,birthdate,gender,postcode,password)VALUES(:name,:email,:username,:birthdate,:gender,:postcode,:password);";
			    
			    //prepare the statement to prevent any SQL injection attacks
			    $stmt = $pdo->prepare($q);
			    $stmt->execute(array(
			    	":name"=>$name,
			   		":email"=>$email,
			   		":username"=>$username,
			   		":birthdate"=>$birthdate,
			   		":gender"=>$gender,
			   		":postcode"=>$postcode,
			   		":password"=>$hashedPassword)
			    	);
			}
			//Close the connection to the database
			dbClose($pdo, $stmt);
		}
	}
?>