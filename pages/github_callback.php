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

require "auth/auth.php";

include "../database/connect.php";

// --- CONFIGURATION ---
$GithubClientId     = "Ov23li286sxnmaZBNKV8";
$GithubClientSecret = "fff7771b3948a4d391f561c90c78c1f138f2b130";
$RedirectUri        = "http://localhost:8080/CRM_GR2/pages/github_callback.php";

// 1. Verify state to prevent CSRF attacks
if (!isset($_GET["state"]) || $_GET["state"] !== $_SESSION["github_oauth_state"]) {
	die("Invalid state. Possible CSRF attack.");
}
unset($_SESSION["github_oauth_state"]);

// 2. Exchange the code for an access token
$Code = $_GET["code"] ?? "";

$TokenResponse = file_get_contents("https://github.com/login/oauth/access_token?" . http_build_query([
	"client_id"     => $GithubClientId,
	"client_secret" => $GithubClientSecret,
	"code"          => $Code,
	"redirect_uri"  => $RedirectUri,
]), false, stream_context_create([
	"http" => [
		"method" => "POST",
		"header" => "Accept: application/json",
	]
]));

$TokenData   = json_decode($TokenResponse, true);
$AccessToken = $TokenData["access_token"] ?? null;

if (!$AccessToken) {
	die("Failed to get access token from GitHub. Response: " . $TokenResponse);
}

// 3. Fetch the user's GitHub profile
$UserJson = file_get_contents("https://api.github.com/user", false, stream_context_create([
	"http" => [
		"header" => implode("\r\n", [
			"Authorization: Bearer $AccessToken",
			"User-Agent: CRM_GR2",
			"Accept: application/json",
		])
	]
]));

$GithubUser = json_decode($UserJson, true);
$GithubLogin = $GithubUser["login"] ?? null; // GitHub username

if (!$GithubLogin) {
	die("Failed to fetch GitHub user info. Response: " . $UserJson);
}

// Debug: show what GitHub username we're looking for
// Remove this after testing
// die("Looking for GitHub user: " . $GithubLogin);

// 4. Look up account by github_username
$Sql  = "SELECT * FROM accounts WHERE github_username = :github_username";
$Stmt = $Pdo->prepare($Sql);
$Stmt->bindParam(":github_username", $GithubLogin);
$Stmt->execute();
$User = $Stmt->fetch(PDO::FETCH_ASSOC);

// 5. If no account is linked to this GitHub user, reject
if (!$User) {
	die("Access denied: your GitHub account ($GithubLogin) is not linked to any account. Please add your GitHub username to your account in the database.");
}

// 6. Log the user in via session
$_SESSION["username"] = $User["username"];
$_SESSION["logged_in"] = true;

header("Location: list_customers.php");
exit;
