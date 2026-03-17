<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06
 */
include '../database/connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$confirmPassword = $_POST["confirm_password"];
	$firstName = $_POST["first_name"];
	$lastName = $_POST["last_name"];
	$phoneNumber = $_POST["phone_number"];
	$email = $_POST["email"];
	$githubUsername = $_POST["github_username"];
	
	if ($password != $confirmPassword) {
		$error = "Passord samsvarer ikke.";
	} else {
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		
		$Sql = "INSERT INTO accounts (username, password, first_name, last_name, phone_number, email, github_username) 
				VALUES (:username, :password, :first_name, :last_name, :phone_number, :email, :github_username)";
		
		try {
			$Statement = $Pdo->prepare($Sql);
			$Statement->execute([
				":username" => $username,
				":password" => $hashedPassword,
				":first_name" => $firstName,
				":last_name" => $lastName,
				":phone_number" => $phoneNumber,
				":email" => $email,
				":github_username" => $githubUsername
			]);
			
			header("Location: login.php");
			exit;
		} catch (PDOException $e) {
			$error = "Brukernavn finnes allerede, eller så oppstod det et problem.";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registrer</title>
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
			padding: 40px;
		}
		.register-container {
			max-width: 500px;
			width: 100%;
			background: rgb(var(--green));
			padding: 40px;
			border-radius: 20px;
			border: 4px solid #323232;
			box-shadow: 8px 8px #323232;
		}
		.register-container h1 {
			color: white;
			font-size: 32px;
			margin-bottom: 30px;
			text-align: center;
		}
		.form-group {
			margin-bottom: 20px;
		}
		.form-group label {
			display: block;
			color: white;
			font-size: 18px;
			margin-bottom: 8px;
		}
		.form-group input {
			width: 100%;
			padding: 15px;
			font-size: 16px;
			border-radius: 10px;
			border: 3px solid #323232;
			background: white;
		}
		.btn-register {
			width: 100%;
			padding: 15px;
			font-size: 18px;
			font-weight: 700;
			background: rgb(var(--pink));
			color: white;
			border: 3px solid #323232;
			border-radius: 10px;
			cursor: pointer;
			margin-top: 20px;
		}
		.btn-register:hover {
			opacity: 0.8;
		}
		.error {
			color: white;
			background: rgba(255,0,0,0.3);
			padding: 10px;
			border-radius: 8px;
			margin-bottom: 20px;
		}
		.login-link {
			display: block;
			text-align: center;
			color: white;
			margin-top: 20px;
			text-decoration: none;
		}
	</style>
</head>
<body>
	<div class="register-container">
		<h1>Registrer</h1>
		
		<?php if ($error): ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>
		
		<form action="register.php" method="post">
			<div class="form-group">
				<label for="username">Brukernavn</label>
				<input type="text" id="username" name="username" required>
			</div>
			
			<div class="form-group">
				<label for="first_name">Fornavn</label>
				<input type="text" id="first_name" name="first_name">
			</div>
			
			<div class="form-group">
				<label for="last_name">Etternavn</label>
				<input type="text" id="last_name" name="last_name">
			</div>
			
			<div class="form-group">
				<label for="phone_number">Telefonnummer</label>
				<input type="text" id="phone_number" name="phone_number">
			</div>
			
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" id="email" name="email">
			</div>
			
			<div class="form-group">
				<label for="github_username">GitHub Brukernavn</label>
				<input type="text" id="github_username" name="github_username">
			</div>
			
			<div class="form-group">
				<label for="password">Passord</label>
				<input type="password" id="password" name="password" required>
			</div>
			
			<div class="form-group">
				<label for="confirm_password">Bekreft Passord</label>
				<input type="password" id="confirm_password" name="confirm_password" required>
			</div>
			
			<button type="submit" class="btn-register">Registrer</button>
		</form>
		
		<a href="login.php" class="login-link">Har du allerede bruker? Logg inn</a>
	</div>
</body>
</html>
