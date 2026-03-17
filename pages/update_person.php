<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06
 */
require "auth_check.php";
include "../database/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$Sql = "SELECT * FROM contact_person WHERE person_id = :person_id";
	$Statement = $Pdo->prepare($Sql);
	$Statement->bindParam(":person_id", $person_id);
	$Statement->execute();
	$user_person = $Statement->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$phone_number = $_POST["phone_number"];
	$email = $_POST["email"];
	
    $update_sql = "UPDATE contact_person SET first_name = :first_name, last_name = :last_name, phone_number = :phone_number, email = :email;";
    $params = [
        ":person_id" => $person_id,
        ":first_name" => $first_name,
        ":last_name" => $last_name,
        ":phone_number" => $phone_number,
        ":email" => $email,
    ];
    
    $update_sql .= " WHERE person_id = :person_id";
    
    $update_statement = $Pdo->prepare($update_sql);
    $update_statement->execute($params);
    
    header("Location: list_customers.php");
    exit;
	
	$Sql = "SELECT * FROM contact_person WHERE person_id = :person_id";
	$Statement = $Pdo->prepare($Sql);
	$Statement->bindParam(":person_id", $person_id);
	$Statement->execute();
	$user_person = $Statement->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "pieces/head.php"; ?>
<body>
	<?php include "pieces/nav.php"; ?>
	
	<div class="update_container">
		<a href="list_customers.php" class="btn_back">&larr; Back</a>
		<h1>Update Profile</h1>
		
		<?php if (isset($error)): ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>
		
		<form action="update_person.php" method="post">
			<div class="form_row">
				<div class="form_group">
					<label for="first_name">First Name</label>
					<input type="text" id="first_name" name="first_name" value="<?php echo $user_person['first_name']; ?>">
				</div>
				
				<div class="form_group">
					<label for="last_name">Last Name</label>
					<input type="text" id="last_name" name="last_name" value="<?php echo $user_person['last_name']; ?>">
				</div>
			</div>
			
			<div class="form_row">
				<div class="form_group" style="flex: 0 0 200px;">
					<label for="phone_number">Phone Number</label>
					<input type="text" id="phone_number" name="phone_number" value="<?php echo $user_person['phone_number']; ?>">
				</div>
				
				<div class="form_group">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" value="<?php echo $user_person['email']; ?>">
				</div>
			</div>
			
			<button type="submit" name="update" class="btn_save">Save Changes</button>
		</form>
	</div>
</body>
</html>
