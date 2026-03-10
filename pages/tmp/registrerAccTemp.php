<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 13:08:24
 */

include '../../database/connect.php';

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
		$error = "Passwords do not match.";
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
			$error = "Username already exists or error occurred.";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../../pages/pieces/head.php'; ?>
	<title>Register</title>
<body class="center-content">
	<div class="register-container">
		<h1>Register</h1>
		
		<?php if ($error): ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>
		
		<form action="registrerAccTemp.php" method="post">
			<div class="form-group">
				<input type="text" id="username" name="username" placeholder=" " required>
				<label for="username" class="floating">Username</label>
			</div>
			
			<div class="form-group">
				<input type="text" id="first_name" name="first_name" placeholder=" ">
				<label for="first_name" class="floating">First Name</label>
			</div>
			
			<div class="form-group">
				<input type="text" id="last_name" name="last_name" placeholder=" ">
				<label for="last_name" class="floating">Last Name</label>
			</div>
			
			<div class="form-group">
				<input type="text" id="phone_number" name="phone_number" placeholder=" ">
				<label for="phone_number" class="floating">Phone Number</label>
			</div>
			
			<div class="form-group">
				<input type="email" id="email" name="email" placeholder=" ">
				<label for="email" class="floating">Email</label>
			</div>
			
			<div class="form-group">
				<input type="text" id="github_username" name="github_username" placeholder=" ">
				<label for="github_username" class="floating">GitHub Username</label>
			</div>
			
			<div class="form-group">
				<input type="password" id="password" name="password" placeholder=" " required>
				<label for="password" class="floating">Password</label>
			</div>
			
			<div class="form-group">
				<input type="password" id="confirm_password" name="confirm_password" placeholder=" " required>
				<label for="confirm_password" class="floating">Confirm Password</label>
			</div>
			
			<button type="submit" class="btn-register">Register</button>
		</form>
	</div>
</body>
</html>
