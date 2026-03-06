<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 13:11:50
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-06 13:42:14
 */



include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$Username = $_POST["username"];
	$Password = $_POST["password"];
	$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
	// echo $hashedPassword;
	// Insert into database
	$Sql = "INSERT INTO accounts (username, first_name, last_name, phone_number, email, password) VALUES (:username, :first_name, :last_name, :phone_number, :email, :password)";
	$Statement = $Pdo->prepare($Sql);
	$Statement->bindParam(":username", $Username);
	$Statement->bindParam(":first_name", $_POST["first_name"]);
	$Statement->bindParam(":last_name", $_POST["last_name"]);
	$Statement->bindParam(":phone_number", $_POST["phone_number"]);
	$Statement->bindParam(":email", $_POST["email"]);
	$Statement->bindParam(":password", $hashedPassword);
	$Statement->execute();

	echo "Account created successfully.";
}
