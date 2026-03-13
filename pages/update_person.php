<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06
 */
require "auth_check.php";
include "../database/connect.php";

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$Sql = "SELECT * FROM contact_person WHERE user_id = :user_id";
	$Statement = $Pdo->prepare($Sql);
	$Statement->bindParam(":user_id", $user_id);
	$Statement->execute();
	$User = $Statement->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$firstName = $_POST["first_name"];
	$lastName = $_POST["last_name"];
	$phoneNumber = $_POST["phone_number"];
	$email = $_POST["email"];
	
    $updateSql = "UPDATE contact_person SET first_name = :first_name, last_name = :last_name, phone_number = :phone_number, email = :email;
    $params = [
        ":user_id" => $user_id
        ":first_name" => $firstName,
        ":last_name" => $lastName,
        ":phone_number" => $phoneNumber,
        ":email" => $email,
    ];
    
    $updateSql .= " WHERE user_id = :user_id";
    
    $UpdateStatement = $Pdo->prepare($updateSql);
    $UpdateStatement->execute($params);
    
    header("Location: list_customers.php");
    exit;
	
	$Sql = "SELECT * FROM contact_person WHERE user_id = :user_id";
	$Statement = $Pdo->prepare($Sql);
	$Statement->bindParam(":user_id", $user_id);
	$Statement->execute();
	$User = $Statement->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Update person</title>
	<link rel="stylesheet" href="https://use.typekit.net/idz1bdq.css">
	<link rel="stylesheet" href="../assets/style.css">
	<?php include "pieces/head.php"; ?>
	
</head>
<body>
	<?php include "pieces/nav.php"; ?>
	
	<div class="update-container">
		<a href="list_customers.php" class="btn-back">&larr; Back</a>
		<h1>Update Profile</h1>
		
		<?php if (isset($error)): ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>
		
		<form action="update_person.php" method="post">
			<div class="form-row">
				<div class="form-group">
					<label for="first_name">First Name</label>
					<input type="text" id="first_name" name="first_name" value="<?php echo $User['first_name']; ?>">
				</div>
				
				<div class="form-group">
					<label for="last_name">Last Name</label>
					<input type="text" id="last_name" name="last_name" value="<?php echo $User['last_name']; ?>">
				</div>
			</div>
			
			<div class="form-row">
				<div class="form-group" style="flex: 0 0 200px;">
					<label for="phone_number">Phone Number</label>
					<input type="text" id="phone_number" name="phone_number" value="<?php echo $User['phone_number']; ?>">
				</div>
				
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" value="<?php echo $User['email']; ?>">
				</div>
			</div>
			
			<div class="form-group">
				<label for="github_user_id">GitHub user_id</label>
				<input type="text" id="github_user_id" name="github_user_id" value="<?php echo $User['github_user_id']; ?>">
			</div>
			
			<div class="form-row">
				<div class="form-group">
					<label for="new_password">New Password (leave blank to keep current)</label>
					<input type="password" id="new_password" name="new_password">
				</div>
				
				<div class="form-group">
					<label for="confirm_password">Confirm New Password</label>
					<input type="password" id="confirm_password" name="confirm_password">
				</div>
			</div>
			
			<button type="submit" name="update" class="btn-save">Save Changes</button>
		</form>
	</div>
</body>
</html>
