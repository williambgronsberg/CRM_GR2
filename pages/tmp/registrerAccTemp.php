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
<?php include '../../pages/pieces/head.php'; ?>
	<title>Register</title>
<body class="center-content">
	<div class="register_container">
		<h1>Register</h1>
		
		<?php if ($error): ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>
		
		<form action="registrerAccTemp.php" method="post">
			<div class="form_group">
				<input type="text" id="username" name="username" placeholder=" " required>
				<label for="username" class="floating">username</label>
			</div>
			
			<div class="form_group">
				<input type="text" id="first_name" name="first_name" placeholder=" ">
				<label for="first_name" class="floating">First Name</label>
			</div>
			
			<div class="form_group">
				<input type="text" id="last_name" name="last_name" placeholder=" ">
				<label for="last_name" class="floating">Last Name</label>
			</div>
			
			<div class="form_group">
				<input type="text" id="phone_number" name="phone_number" placeholder=" ">
				<label for="phone_number" class="floating">Phone Number</label>
			</div>
			
			<div class="form_group">
				<input type="email" id="email" name="email" placeholder=" ">
				<label for="email" class="floating">Email</label>
			</div>
			
			<div class="form_group">
				<input type="text" id="github_username" name="github_username" placeholder=" ">
				<label for="github_username" class="floating">GitHub username</label>
			</div>
			
			<div class="form_group">
				<input type="password" id="password" name="password" placeholder=" " required>
				<label for="password" class="floating">Password</label>
			</div>
			
			<div class="form_group">
				<input type="password" id="confirm_password" name="confirm_password" placeholder=" " required>
				<label for="confirm_password" class="floating">Confirm Password</label>
			</div>
			
			<button type="submit" class="btn_register">Register</button>
		</form>
	</div>
</body>
</html>
