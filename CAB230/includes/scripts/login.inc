<?php
  //include"config/DBconfig.inc";

  $GLOBALS['badUsernamePassword']='';
  $GLOBALS['loggedIn']='';

  if (isset($_POST['login'])) {
    //Process the form

<<<<<<< HEAD
    $username = $_POST["loginUsername"];
    $submittedPassword = $_POST["loginPassword"];
=======
    $username = $_POST["username"];
    $submittedPassword = $_POST["logpassword"];
>>>>>>> 86b9f29d6178a4fd526d6089e30690bb359db497
    $userExists = true;
    $matchedPasswords = false;

    $pdo =  dbConnect();
    
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
    } else {
      $userExists = false;
    }

    if ($userExists == true && $result == true) {
      session_start();
      $GLOBALS['loggedIn']='';
      $_SESSION['id'] = $userDetails[0];
      $_SESSION['name'] = $userDetails[1];
      $_SESSION['email'] = $userDetails[2];
      $_SESSION['username'] = $userDetails[3];
      $GLOBALS['loggedIn']=$_SESSION['name'];
<<<<<<< HEAD
      #echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
=======
      echo "<meta http-equiv=\"refresh\">";
>>>>>>> 86b9f29d6178a4fd526d6089e30690bb359db497
    } else {
        $GLOBALS['badUsernamePassword']="<span style='color:red;'>That username and password combination does not exist!<br></span>";
    }

    //Close the connection
    dbClose($stmt, $pdo);
  }