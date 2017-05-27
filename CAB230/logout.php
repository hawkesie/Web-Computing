<?php
	//Destroys the session and sends user to home page
 	include"config/DBconfig.inc";
  	include "includes/scripts/login.inc";
  	session_destroy();
  	header("Location: index.php");
?>



