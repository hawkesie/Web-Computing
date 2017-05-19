<?php
	// Connect to the database
	function dbConnect() {
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=brisbane_parks', 'root', 'password123');
		} catch (PDOException $error) {
			echo $error->getMessage()."<br>";
			die();
		}

		return $pdo
	}

	// Close connections to the database
	function dbClose($query, $pdo) {
		$query = null;
		$pdo = null;
	}

?>