<?php
	include"config/DBconfig.inc";

	if (isset($_POST['name'])) {
		//Process the form

		$unique_email = true;
		$correct_password = true;

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
		
	    //Confirm password entered correctly twice
	    if ($password != $confirmPassword)
	    	$correct_password = false;

	    //Confirm email entered is unique
    	$pdo =	dbConnect();
    	
    	$sql =	"SELECT email FROM users";
    	$sql .=	"WHERE email = :email";
    	
    	$q = "INSERT INTO users(name,email,username,birthdate,gender,postcode,password,salt)VALUES(:name,:email,:username,:birthdate,:gender,:postcode,:password,:salt);";
	    	
	    $query = $pdo->prepare($q);
	    $query->execute(array(	    		
	    	":name"=>$name,
	   		":email"=>$email,
	   		":username"=>$username,
	   		":birthdate"=>$birthdate,
	   		":gender"=>$gender,	    		
	   		":postcode"=>$postcode,
	   		":password"=>$password,
	   		":salt"=>'salty')

	    	);
	}