<?php

//This file connects to the corresponding database.
//Parameters for connection:

$Host = "localhost";
$Username = "root";
$Password = "";
$Database = "SarahShelter";

//Set connection with try and catch.
try {
    $Pdo = new PDO("mysql:host=$Host;dbname=$Database",$Username, $Password);
    $Pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}

catch (PDOException $Error) {
    die("Connection to $Database unsuccessful. <br>" . $Error->getMessage() . "<br>");
}