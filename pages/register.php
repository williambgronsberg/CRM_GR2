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
	$confirm_password = $_POST["confirm_password"];
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$phone_number = $_POST["phone_number"];
	$email = $_POST["email"];
	$github_username = $_POST["github_username"];
	
	if ($password != $confirm_password) {
		$error = "Passwords do not match.";
	} else {
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
		$Sql = "INSERT INTO accounts (username, password, first_name, last_name, phone_number, email, github_username) 
				VALUES (:username, :password, :first_name, :last_name, :phone_number, :email, :github_username)";
		
		try {
			$Statement = $Pdo->prepare($Sql);
			$Statement->execute([
				":username" => $username,
				":password" => $hashed_password,
				":first_name" => $first_name,
				":last_name" => $last_name,
				":phone_number" => $phone_number,
				":email" => $email,
				":github_username" => $github_username
			]);
			
			header("Location: login.php");
			exit;
		} catch (PDOException $e) {
			$error = "Username already exists or error occurred.";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
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
		.register_container {
			max-width: 500px;
			width: 100%;
			background: rgb(var(--green));
			padding: 40px;
			border-radius: 20px;
			border: 4px solid #323232;
			box-shadow: 8px 8px #323232;
		}
		.register_container h1 {
			color: white;
			font-size: 32px;
			margin-bottom: 30px;
			text-align: center;
		}
		.form_group {
			margin-bottom: 20px;
		}
		.form_group label {
			display: block;
			color: white;
			font-size: 18px;
			margin-bottom: 8px;
		}
		.form_group input {
			width: 100%;
			padding: 15px;
			font-size: 16px;
			border-radius: 10px;
			border: 3px solid #323232;
			background: white;
		}
		.btn_register {
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
		.btn_register:hover {
			opacity: 0.8;
		}
		.error {
			color: white;
			background: rgba(255,0,0,0.3);
			padding: 10px;
			border-radius: 8px;
			margin-bottom: 20px;
		}
		.login_link {
			display: block;
			text-align: center;
			color: white;
			margin-top: 20px;
			text-decoration: none;
		}
	</style>
</head>
<body>
	<div class="register_container">
		<h1>Register</h1>
		
		<?php if ($error): ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>
		
		<form action="register.php" method="post">
			<div class="form_group">
				<label for="username">Username</label>
				<input type="text" id="username" name="username" required>
			</div>
			
			<div class="form_group">
				<label for="first_name">First Name</label>
				<input type="text" id="first_name" name="first_name">
			</div>
			
			<div class="form_group">
				<label for="last_name">Last Name</label>
				<input type="text" id="last_name" name="last_name">
			</div>
			
			<div class="form_group">
				<label for="phone_number">Phone Number</label>
				<input type="text" id="phone_number" name="phone_number">
			</div>
			
			<div class="form_group">
				<label for="email">Email</label>
				<input type="email" id="email" name="email">
			</div>
			
			<div class="form_group">
				<label for="github_username">GitHub Username</label>
				<input type="text" id="github_username" name="github_username">
			</div>
			
			<div class="form_group">
				<label for="password">Password</label>
				<input type="password" id="password" name="password" required>
			</div>
			
			<div class="form_group">
				<label for="confirm_password">Confirm Password</label>
				<input type="password" id="confirm_password" name="confirm_password" required>
			</div>
			
			<button type="submit" class="btn_register">Register</button>
		</form>
		
		<a href="login.php" class="login_link">Already have an account? Login</a>
	</div>
</body>
</html>
