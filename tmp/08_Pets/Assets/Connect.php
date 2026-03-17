<?php

//This file connects to the corresponding database.
//Parameters for connection:

$Host = "localhost";
$username = "root";
$password = "";
$Database = "SarahShelter";

//Set connection with try and catch.
try {
    $Pdo = new PDO("mysql:host=$Host;dbname=$Database",$username, $password);
    $Pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}

catch (PDOException $Error) {
    die("Connection to $Database unsuccessful. <br>" . $Error->getMessage() . "<br>");
}