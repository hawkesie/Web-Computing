<?php
	include"config/DBconfig.inc";

	$pdo =	dbConnect();

	if (isset($_POST['name'])) {
		echo'okay';
		//Process the form
		$name = $_POST['name'];
		$email = $_POST['email'];
		$username =$_POST['username'];
		$gender = $_POST['gender'];
		$dobDay = $_POST['day'];
		$dobMonth = $_POST['month'];
		$dobYear = $_POST['year'];
	    $postcode = $_POST['postcode'];
	    $password = $_POST['password'];
	    $confirmPassword = $_POST['confirmPassword'];
	    echo'REEEEEEEEEEEEEEee';
		


	    	$q = "INSERT INTO users(name,email,username,gender,postcode)VALUES(:name,:email,:username,:gender,:postcode,:password);";
	    	echo'thisfar';
	    	$query = $pdo->prepare($q);
	    	$results = $query->execute(array(
	    		":name"=>$name,
	    		":email"=>$email,
	    		":username"=>$username,
	    		":gender"=>$gender,
	    		
	    		":postcode"=>$postcode,
	    		":password"=>$password

	    	));;	
	}
	?>