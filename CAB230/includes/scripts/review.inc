<?php

if(isset($_POST['submit'])){
	if (isset($_POST['rating'])){
	$textbox=$_POST['textbox'];
	$rating = $_POST['rating'];
	date_default_timezone_set('Australia/Melbourne');
	$date=date('Y-m-d');
	$pdo=dbConnect();
	$q = "INSERT INTO reviews(parkID,userID,review,rating,reviewDate)VALUES(:parkID,:userID,:review,:rating,:reviewDate);";
			    
			    $stmt = $pdo->prepare($q);
			    $stmt->execute(array(
			    	":parkID"=>$_SESSION['itemID'],
			    	":userID"=>$_SESSION['id'],
			    	":review"=>$textbox,
			    	":rating"=>$rating,
			    	":reviewDate"=>$date)			    	
			    	);
	}
	else{
	echo 'Please select a rating';

	}

}


?>