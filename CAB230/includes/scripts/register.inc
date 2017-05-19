<?php
	include"config/DBconfig.inc";

	if (isset($_POST['submit'])) {
		//Process the form

		$unique_email = true;
		$correct_password = true;

		$name = test_input($_POST["name"]);
		$email = test_input($_POST["email"]);
		$username = test_input($_POST["email"]);
		$gender = test_input($_POST["gender"]);
		$dobDay = test_input($_POST["day"]);
		$dobMonth = test_input($_POST["month"]);
		$dobYear = test_input($_POST["year"]);
	    $postcode = test_input($_POST["postcode"]);
	    $password = test_input($_POST["password"]);
	    $confirmPassword = test_input($_POST["confirmPassword"]);
		
	    //Confirm password entered correctly twice
	    if ($password != $confirmPassword)
	    	$correct_password = false;

	    //Confirm email entered is unique
    	$pdo =	dbConnet();
    	
    	$sql =	"SELECT email FROM users";
    	$sql .=	"WHERE email = :email";

    	$stmt = $pdo->prepare($sql);
    	$stmt->bindValue(":email", $email);
    	$stmt->execute();

    	if ($stmt->rowCount() > 0)
    		die("That email is already in use.");
    	else
    		die("asdf");

    	dbClose($pdo, $stmt);
	}