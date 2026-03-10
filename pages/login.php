<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 12:44:55
 */
session_start();
include "../database/connect.php";

if (isset($_SESSION["username"])) {
	header("Location: list_customers.php");
	exit;
}

$GithubClientId = "Ov23li286sxnmaZBNKV8";
$RedirectUri    = "http://localhost/CRM_GR2/pages/github_callback.php";

// GitHub OAuth redirect
if (isset($_GET["github"])) {
	$State = bin2hex(random_bytes(16));
	$_SESSION["github_oauth_state"] = $State;
	header("Location: https://github.com/login/oauth/authorize?" . http_build_query([
		"client_id"    => $GithubClientId,
		"redirect_uri" => $RedirectUri,
		"scope"        => "read:user user:email",
		"state"        => $State,
	]));
	exit;
}

// Normal login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$Username  = $_POST["username"];
	$Password  = $_POST["password"];

	$Sql = "SELECT * FROM accounts WHERE username = :username";
	$Statement = $Pdo->prepare($Sql);
	$Statement->bindParam(":username", $Username);
	$Statement->execute();
	$User = $Statement->fetch(PDO::FETCH_ASSOC);

	if ($User && password_verify($Password, $User["password"])) {
		$_SESSION["username"] = $User["username"];
		header("Location: list_customers.php");
		exit;
	} else {
		$error = "Invalid username or password.";
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="https://use.typekit.net/idz1bdq.css">
	<link rel="stylesheet" href="../assets/style.css">
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			background: rgb(var(--pink));
			min-height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.form {
			--bg-color: #fff;
			--main-color: #323232;
			--font-color: #323232;
			--font-color-sub: #666;
			padding: 30px;
			background: rgb(var(--green));
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			gap: 20px;
			border-radius: 20px;
			border: 4px solid var(--main-color);
			box-shadow: 8px 8px var(--main-color);
		}

		.form>p {
			color: white;
			font-weight: 700;
			font-size: 28px;
			margin-bottom: 10px;
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		.form>p>span {
			color: rgba(255, 255, 255, 0.8);
			font-weight: 500;
			font-size: 16px;
		}

		.separator {
			width: 100%;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 10px;
		}

		.separator>div {
			width: 80px;
			height: 3px;
			background-color: rgba(255, 255, 255, 0.5);
		}

		.separator>span {
			color: white;
			font-weight: 600;
		}

		.oauthButton {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 8px;
			padding: 12px 20px;
			width: 250px;
			height: 45px;
			border-radius: 8px;
			border: 3px solid var(--main-color);
			background-color: var(--bg-color);
			box-shadow: 4px 4px var(--main-color);
			font-size: 14px;
			font-weight: 700;
			color: var(--font-color);
			cursor: pointer;
			transition: all 250ms;
			position: relative;
			overflow: hidden;
			z-index: 1;
			text-decoration: none;
		}

		.oauthButton::before {
			content: "";
			position: absolute;
			top: 0;
			left: 0;
			height: 100%;
			width: 0;
			background-color: #212121;
			z-index: -1;
			transition: all 250ms;
		}

		.oauthButton:hover {
			color: #e8e8e8;
		}

		.oauthButton:hover::before {
			width: 100%;
		}

		.form>input[type="text"],
		.form>input[type="password"] {
			width: 250px;
			height: 45px;
			border-radius: 8px;
			border: 3px solid var(--main-color);
			background-color: var(--bg-color);
			box-shadow: 4px 4px var(--main-color);
			font-size: 16px;
			font-weight: 600;
			color: var(--font-color);
			padding: 5px 15px;
			outline: none;
		}

		.form>input::placeholder {
			color: var(--font-color-sub);
		}

		.icon {
			width: 1.2rem;
			height: 1.2rem;
		}

		.error {
			color: #ff6b6b;
			font-weight: 600;
			background: rgba(0, 0, 0, 0.2);
			padding: 8px 16px;
			border-radius: 5px;
		}
	</style>
</head>

<body>
	<form action="login.php" method="post" class="form">
		<p>
			Welcome
			<span>sign in to continue</span>
		</p>


		<!-- GitHub OAuth -->
		<a href="login.php?github=1" class="oauthButton">
			<svg class="icon" viewBox="0 0 24 24">
				<path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" />
			</svg>
			Github
		</a>

		<div class="separator">
			<div></div>
			<span>OR</span>
			<div></div>
		</div>

		<?php if (isset($error)): ?>
			<p class="error"><?php echo htmlspecialchars($error); ?></p>
		<?php endif; ?>

		<input type="text" placeholder="Username" name="username">
		<input type="password" placeholder="Password" name="password">

		<button type="submit" class="oauthButton">
			Login
			<svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<path d="m6 17 5-5-5-5" />
				<path d="m13 17 5-5-5-5" />
			</svg>
		</button>
	</form>
</body>

</html>