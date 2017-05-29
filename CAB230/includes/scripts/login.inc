<?php
  include "includes/functions.inc";
  //globals for error checking
  $GLOBALS['badUsernamePassword']='';
  $GLOBALS['loggedIn']='';

  //If the user clicks login button
  if (isset($_POST['login'])) {
    //Process the form

    //XSS attack prevention
    $username = htmlspecialchars($_POST["loginUsername"]);
    $submittedPassword = htmlspecialchars($_POST["loginPassword"]);

    //Set bools to test for conditions
    $userExists = true;
    $matchedPasswords = false;

    $pdo =  dbConnect();
    
    //SQL statement to find user details
    $sql =  "SELECT * FROM users ";
    $sql .= "WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":username", $username);
    $stmt->execute();

    // Checking to see if the username exists
    if ($stmt->rowCount() > 0) {
      $userDetails = $stmt->fetch();
      // Result will be true if passwords match, false otherwise
      $result = password_verify($submittedPassword, $userDetails[7]);
    } 
    else {
      $userExists = false;
    }

    //If login details given matches data in database
    if ($userExists == true && $result == true) {
      
      $GLOBALS['loggedIn']='';
      //Begin the session with user details
      $_SESSION['id'] = $userDetails[0];
      $_SESSION['name'] = $userDetails[1];
      $_SESSION['email'] = $userDetails[2];
      $_SESSION['username'] = $userDetails[3];
      $GLOBALS['loggedIn']=$_SESSION['name'];

      //Refresh the page the user was on prior to logging in 
      echo "<meta name='refresh' http-equiv=\"Refresh\">";
    } else {
        //Return an error message to the user if login failed
        $GLOBALS['badUsernamePassword']="<span style='color:red;'>That username and password combination does not exist!<br></span>";
    }

    //Close the connection
    dbClose($stmt, $pdo);
  }