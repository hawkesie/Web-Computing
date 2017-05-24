<?php

if(isset($_POST['submit'])){
	$textbox=$_POST['textbox'];
	$rating = $_POST['rating'];

	$pdo=dbCOnnect();
	$q = "INSERT INTO reviews(parkID,userID,review,rating,reviewDate)VALUES(:parkID,:userID,:review,:rating,:reviewDate);";
			    
			    $stmt = $pdo->prepare($q);
			    $stmt->execute(array(
			    	":parkID"=>'5',
			    	":userID"=>$_SESSION['id'],
			    	":review"=>$textbox,
			    	":rating"=>$rating,
			    	":reviewDate"=>'2017-05-23')			    	
			    	);
}


?>