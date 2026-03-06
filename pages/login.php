<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 12:44:55
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-06 13:44:29
 */
include "../database/connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get the username and password from the form
	$Username = $_POST["username"];
	$Password = $_POST["password"];
	
	// Prepare and execute the SQL statement to fetch the user
	$Sql = "SELECT * FROM accounts WHERE username = :username";
	$Statement = $Pdo->prepare($Sql);
	$Statement->bindParam(":username", $Username);
	$Statement->execute();
	$User = $Statement->fetch(PDO::FETCH_ASSOC);

	// Verify the password
	if ($User && password_verify($Password, $User["password"])) {
		echo "Login successful.";
	} else {
		echo "Invalid username or password.";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>login</title>
</head>
<body>
	<form action="login.php" method="post">
		<label for="username">Username:</label>
		<input type="text" id="username" name="username"><br><br>
	
		<label for="password">Password:</label>
		<input type="password" id="password" name="password"><br><br>
		<input type="submit" value="Login">
	
</body>
</html>