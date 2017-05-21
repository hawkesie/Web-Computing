<?php
	include"includes/functions.inc";
	
	$GLOBALS['checkEmail']='';
	$GLOBALS['checkUsername']='';

	if (isset($_POST['name'])) {
		//Process the form

		$unique_email = true;
		$correct_form = true;

		$name = $_POST["name"];
		$email = $_POST["email"];
		$username = $_POST["username"];
		$gender = $_POST["gender"];
		$dobDay = $_POST["day"];
		$dobMonth = $_POST["month"];
		$dobYear = $_POST["year"];
	    $postcode = $_POST["postcode"];
	    $password = $_POST["password"];
	    $confirmPassword = $_POST["confirmPassword"];
	    $birthdate = $dobYear . '-' . $dobMonth . '-' . $dobDay;

	    //Confirm email entered is unique
    	$pdo =	dbConnect();
    	
    	$sql =	"SELECT email FROM users ";
    	$sql .=	"WHERE email = :email";
	   	$stmt = $pdo->prepare($sql);
    	$stmt->bindValue(":email", $email);
    	$stmt->execute();

    	if ($stmt->rowCount() > 0) {
    		$correct_form = false;
    		$GLOBALS['checkEmail']="<span style='color:red;'>Email already exists!</span>";
    	}

    	$sql =	"SELECT username FROM users ";
    	$sql .=	"WHERE username = :username";
	   	$stmt = $pdo->prepare($sql);
    	$stmt->bindValue(":username", $username);
    	$stmt->execute();

    	if ($stmt->rowCount() > 0) {
    		$correct_form = false;
    		$GLOBALS['checkUsername']="<span style='color:red;'>Username already exists!</span>";
    	}

    	// Hash the password
	    if ($password != $confirmPassword) {
	    	$correct_form = false;
	    	echo "Passwords do not match!<br>";
	    } else {
	    	$hashedPassword = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
	    }

    	// If the form has been filled out correctly without any duplicate unique fields, process the form
    	if ($correct_form == true) {
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
?>