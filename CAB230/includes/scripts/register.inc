<?php
	include"config/DBconfig.inc";

	if (isset($_POST['name'])) {
		//Process the form

		$unique_email = true;
		$correct_password = true;

		$name = $_POST["name"];
		$email = $_POST["email"];
		$username = $_POST["email"];
		$gender = $_POST["gender"];
		$dobDay = $_POST["day"];
		$dobMonth = $_POST["month"];
		$dobYear = $_POST["year"];
	    $postcode = $_POST["postcode"];
	    $password = $_POST["password"];
	    $confirmPassword = $_POST["confirmPassword"];
		
	    //Confirm password entered correctly twice
	    if ($password != $confirmPassword)
	    	$correct_password = false;

	    //Confirm email entered is unique
    	$pdo =	dbConnect();
    	
    	$sql =	"SELECT email FROM users";
    	$sql .=	"WHERE email = :email";

    	$stmt = $pdo->prepare($sql);
    	$stmt->bindValue(":email", $email);
    	$stmt->execute();

    	if ($stmt->rowCount() > 0)
    		die("That email is already in use.");
    	else
    		$q = "INSERT INTO users(name,email,username,gender,postcode)VALUES(:name,:email,:username,:gender,:postcode,:password);";
	    	echo'IN ELSE STATEMENT';
	    	$query = $pdo->prepare($q);
	    	$query->execute(array(
	    		":name"=>$name,
	    		":email"=>$email,
	    		":username"=>$username,
	    		":gender"=>$gender,
	    		
	    		":postcode"=>$postcode,
	    		":password"=>$password

	    	));;

    	dbClose($pdo, $stmt);
	}