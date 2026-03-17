<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06
 */
require "auth_check.php";
include "../database/connect.php";

$username = $_SESSION["username"];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$Sql = "SELECT * FROM accounts WHERE username = :username";
	$Statement = $Pdo->prepare($Sql);
	$Statement->bindParam(":username", $username);
	$Statement->execute();
	$user = $Statement->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$phone_number = $_POST["phone_number"];
	$email = $_POST["email"];
	$github_username = $_POST["github_username"];
	$new_assword = $_POST["new_password"];
	$confirm_password = $_POST["confirm_password"];
	
	if (!empty($new_assword) && $new_assword != $confirm_password) {
		$error = "Passwords do not match.";
	} else {
		$update_sql = "UPDATE accounts SET first_name = :first_name, last_name = :last_name, phone_number = :phone_number, email = :email, github_username = :github_username";
		$params = [
			":first_name" => $first_name,
			":last_name" => $last_name,
			":phone_number" => $phone_number,
			":email" => $email,
			":github_username" => $github_username,
			":username" => $username
		];
		
		if (!empty($new_assword)) {
			$hashed_password = password_hash($new_assword, PASSWORD_DEFAULT);
			$update_sql .= ", password = :password";
			$params[":password"] = $hashed_password;
		}
		
		$update_sql .= " WHERE username = :username";
		
		$update_statement = $Pdo->prepare($update_sql);
		$update_statement->execute($params);
		
		header("Location: list_customers.php");
		exit;
	}
	
	$Sql = "SELECT * FROM accounts WHERE username = :username";
	$Statement = $Pdo->prepare($Sql);
	$Statement->bindParam(":username", $username);
	$Statement->execute();
	$user = $Statement->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update Account</title>
	<?php include "pieces/head.php"; ?>
</head>
<body>
	<?php include "pieces/nav.php"; ?>
	
	<div class="update_container">
		<a href="list_customers.php" class="btn_back">&larr; Back</a>
		<h1>Update Profile</h1>
		
		<?php if (isset($error)): ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>
		
		<form action="update_account.php" method="post">
			<div class="form_row">
				<div class="form_group">
					<label for="first_name">First Name</label>
					<input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>">
				</div>
				
				<div class="form_group">
					<label for="last_name">Last Name</label>
					<input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>">
				</div>
			</div>
			
			<div class="form_row">
				<div class="form_group" style="flex: 0 0 200px;">
					<label for="phone_number">Phone Number</label>
					<input type="text" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>">
				</div>
				
				<div class="form_group">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">
				</div>
			</div>
			
			<div class="form_group">
				<label for="github_username">GitHub Username</label>
				<input type="text" id="github_username" name="github_username" value="<?php echo $user['github_username']; ?>">
			</div>
			
			<div class="form_row">
				<div class="form_group">
					<label for="new_password">New Password (leave blank to keep current)</label>
					<input type="password" id="new_password" name="new_password">
				</div>
				
				<div class="form_group">
					<label for="confirm_password">Confirm New Password</label>
					<input type="password" id="confirm_password" name="confirm_password">
				</div>
			</div>
			
			<button type="submit" name="update" class="btn_save">Save Changes</button>
		</form>
	</div>
</body>
</html>
