<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 20:54:55
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-06 21:29:06
 */


/**
 * GitHub OAuth Callback Handler
 * This page handles the redirect back from GitHub after the user authorizes.
 */

session_start();

include "../database/connect.php";

// --- CONFIGURATION ---
$github_client_id     = "Ov23li286sxnmaZBNKV8";
$github_client_secret = "fff7771b3948a4d391f561c90c78c1f138f2b130";
$redirect_uri        = "http://localhost/Repos/CRM_GR2/pages/github_callback.php";

// 1. Verify state to prevent CSRF attacks
if (!isset($_GET["state"]) || $_GET["state"] !== $_SESSION["github_oauth_state"]) {
	die("Invalid state. Possible CSRF attack.");
}
unset($_SESSION["github_oauth_state"]);

// 2. Exchange the code for an access token
$code = $_GET["code"] ?? "";

$token_response = file_get_contents("https://github.com/login/oauth/access_token?" . http_build_query([
	"client_id"     => $github_client_id,
	"client_secret" => $github_client_secret,
	"code"          => $code,
	"redirect_uri"  => $redirect_uri,
]), false, stream_context_create([
	"http" => [
		"method" => "POST",
		"header" => "Accept: application/json",
	]
]));

$token_data   = json_decode($token_response, true);
$access_token = $token_data["access_token"] ?? null;

if (!$access_token) {
	die("Failed to get access token from GitHub. Response: " . $token_response);
}

// 3. Fetch the user's GitHub profile
$user_json = file_get_contents("https://api.github.com/user", false, stream_context_create([
	"http" => [
		"header" => implode("\r\n", [
			"Authorization: Bearer $access_token",
			"User-Agent: CRM_GR2",
			"Accept: application/json",
		])
	]
]));

$github_user = json_decode($user_json, true);
$github_login = $github_user["login"] ?? null; // GitHub username

if (!$github_login) {
	die("Failed to fetch GitHub user info. Response: " . $user_json);
}

// Debug: show what GitHub username we're looking for
// Remove this after testing
// die("Looking for GitHub user: " . $github_login);

// 4. Look up account by github_username
$Sql  = "SELECT * FROM accounts WHERE github_username = :github_username";
$Stmt = $Pdo->prepare($Sql);
$Stmt->bindParam(":github_username", $github_login);
$Stmt->execute();
$user = $Stmt->fetch(PDO::FETCH_ASSOC);

// 5. If no account is linked to this GitHub user, reject
if (!$user) {
	die("Access denied: your GitHub account ($github_login) is not linked to any account. Please add your GitHub username to your account in the database.");
}

// 6. Log the user in via session
$_SESSION["username"] = $user["username"];
$_SESSION["logged_in"] = true;

header("Location: list_customers.php");
exit;
