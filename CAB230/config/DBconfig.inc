<?php
	// Connect to the database
	session_start();
	function dbConnect() {
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=n7521022', 'n7521022', 'password');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $error) {
			echo $error->getMessage()."<br>";
			die();
		}

		return $pdo;
	}

	// Close connections to the database
	function dbClose($query, $pdo) {
		$query = null;
		$pdo = null;
	}

?>