<?php
include"config/DBconfig.inc";
$textbox=$_POST['textbox'];
$rating = $_POST['rating'];
$submit = $_POST['submit'];

if(isset($_POST['submit'])){
	$pdo=dbConnect();

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