<?php
  include"config/DBconfig.inc";

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
      echo "That Username/Password combination does not exist!<br>";
    }

    if ($userExists == true && $result == true) {
      die("Successfully logged in!");
      /////////////////////////////////////////////////SESSION STUFF GOES IN HERE////////////////////////////////////////////////
    }

    //Close the connection
    dbClose($stmt, $pdo);
  }