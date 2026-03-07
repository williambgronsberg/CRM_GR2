<?php

session_start();

function requireLogin() {
	if (!isset($_SESSION["username"])) {
		header("Location: ../index.php");
		exit;
	}
}

function isLoggedIn() {
	return isset($_SESSION["username"]);
}

function getUsername() {
	return $_SESSION["username"] ?? null;
}

function logout() {
	session_destroy();
	header("Location: ../index.php");
	exit;
}
