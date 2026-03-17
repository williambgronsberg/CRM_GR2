<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 12:51:20
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-06 15:55:43
 */


//This file connects to the corresponding database.
//Parameters for connection:

$Host = "localhost";
$username = "root";
$password = "";
$Database = "crm_g2";

//Set connection with try and catch.
try {
	$Pdo = new PDO("mysql:host=$Host;dbname=$Database", $username, $password);
	$Pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
} catch (PDOException $Error) {
	die("Connection to $Database unsuccessful. <br>" . $Error->getMessage() . "<br>");
}
