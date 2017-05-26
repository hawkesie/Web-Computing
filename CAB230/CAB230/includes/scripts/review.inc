<?php

if(isset($_POST['submit'])){
	if (isset($_POST['rating'])){
		$textbox=$_POST['textbox'];
		$rating = $_POST['rating'];
		date_default_timezone_set('Australia/Melbourne');
		$date=date('Y-m-d');
		$pdo=dbConnect();
		$SQL = "INSERT INTO reviews(parkID,userID,review,rating,reviewDate)VALUES(:parkID,:userID,:review,:rating,:reviewDate);";
				    
				    $stmt = $pdo->prepare($SQL);
				    $stmt->execute(array(
				    	":parkID"=>$_SESSION['itemID'],
				    	":userID"=>$_SESSION['id'],
				    	":review"=>$textbox,
				    	":rating"=>$rating,
				    	":reviewDate"=>$date)			    	
				    	);
		dbClose($pdo, $stmt);

		$pdo = dbConnect();

		$SQL = "SELECT AvgRating, ROUND(AVG(rating)) AS CalculatedAverage FROM parks ";
		$SQL.= "INNER JOIN reviews ON reviews.parkID = parks.id ";
		$SQL.= "WHERE id = :parkID;";

		$stmt = $pdo->prepare($SQL);
		$stmt->execute(array(
			":parkID"=>$_SESSION['itemID']));

		if($stmt->rowCount() > 0){
       		foreach($stmt as $row){
	        	$newAverage=$row['CalculatedAverage'];
	        }
	    } else {
	    	$newAverage = $rating;
	    }

	    $SQL = "UPDATE parks ";
	    $SQL.= "SET AvgRating = :newAverage ";
	    $SQL.= "WHERE id = :parkID";

	    $stmt = $pdo->prepare($SQL);
	    $stmt->execute(array(
	    	":newAverage"=>$newAverage,
	    	":parkID"=>$_SESSION['itemID']));

		dbClose($pdo, $stmt);

		} else {
		echo 'Please select a rating';
		}
}


?>