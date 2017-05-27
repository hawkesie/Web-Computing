<?php

if(isset($_POST['submit'])){
	if (isset($_POST['rating'])){
		//Set and secure variables recieved from user
		$textbox=htmlspecialchars($_POST['textbox']);
		$rating = $_POST['rating'];
		date_default_timezone_set('Australia/Melbourne');
		//Force date to be readable by SQL
		$date=date('Y-m-d');
		$pdo=dbConnect();
		//Insert user review into the database
		$SQL = "INSERT INTO reviews(parkID,userID,review,rating,reviewDate)VALUES(:parkID,:userID,:review,:rating,:reviewDate);";
				    
				    //Prepare statement to prevent from any potential SQL injection attacks
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

		//Find the average rating and round it using parkID from reviews and comparing it to ID in parks
		$SQL = "SELECT AvgRating, ROUND(AVG(rating)) AS CalculatedAverage FROM parks ";
		$SQL.= "INNER JOIN reviews ON reviews.parkID = parks.id ";
		$SQL.= "WHERE id = :parkID;";

		//Prepare statement to prevent from any potential SQL injection attacks
		$stmt = $pdo->prepare($SQL);
		$stmt->execute(array(
			":parkID"=>$_SESSION['itemID']));

		//If a result was found, we use that as the calculated average
		if($stmt->rowCount() > 0){
       		foreach($stmt as $row){
	        	$newAverage=$row['CalculatedAverage'];
	        }
	    } else {
	    	//No result was found, new average rating MUST be the rating the user gave
	    	$newAverage = $rating;
	    }

	    //Update the AvgRating with the new calculated average after the new review
	    $SQL = "UPDATE parks ";
	    $SQL.= "SET AvgRating = :newAverage ";
	    $SQL.= "WHERE id = :parkID";

		//Prepare statement to prevent from any potential SQL injection attacks
	    $stmt = $pdo->prepare($SQL);
	    $stmt->execute(array(
	    	":newAverage"=>$newAverage,
	    	":parkID"=>$_SESSION['itemID']));

	    //Close the connection to the database
		dbClose($pdo, $stmt);

		} 
		else {
			//The user didn't select a rating, nothing is submitted or done
			echo 'Please select a rating';
		}
}


?>