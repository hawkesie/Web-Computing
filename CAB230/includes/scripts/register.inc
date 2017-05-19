<?php
	require_once("../../config/DBconfig.inc");

	if (isset($_POST['submit'])) {
		//Process the form

	$name = test_input($_POST["name"]);
	$email = test_input($_POST["email"]);
	$username = test_input($_POST["email"]);
	$gender = test_input($_POST["gender"]);
	$dobDay = test_input($_POST["day"]);
	$dobMonth = test_input($_POST["month"]);
	$dobYear = test_input($_POST["year"]);
    $postcode = test_input($_POST["postcode"]);
    $password = test_input($_POST["password"]);
    $confirmPassword = test_input($_POST["confirmPassword"]);
	}