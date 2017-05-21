<?php
  include"config/DBconfig.inc";

  $GLOBALS['badUsernamePassword']='';

  if (isset($_POST['login'])) {
    //Process the form

    $username = $_POST["username"];
    $submittedPassword = $_POST["password"];
    $userExists = true;
    $matchedPasswords = false;

    $pdo =  dbConnect();
    
    $sql =  "SELECT password FROM users ";
    $sql .= "WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":username", $username);
    $stmt->execute();

    // Checking to see if the username exists
    if ($stmt->rowCount() > 0) {
      $hashedPassword = $stmt->fetch();
      // Result will be true if passwords match, false otherwise
      $result = password_verify($submittedPassword, $hashedPassword[0]);
    } else {
      $userExists = false;
    }

    if ($userExists == true && $result == true) {
      die("Successfully logged in!");
      /////////////////////////////////////////////////SESSION STUFF GOES IN HERE////////////////////////////////////////////////
    } else {
        $GLOBALS['badUsernamePassword']="<span style='color:red;'>That username and password combination does not exist!<br><br></span>";
    }

    //Close the connection
    dbClose($stmt, $pdo);
  }