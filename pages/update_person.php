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
	$firstName = $_POST["first_name"];
	$lastName = $_POST["last_name"];
	$phoneNumber = $_POST["phone_number"];
	$email = $_POST["email"];
	
    $updateSql = "UPDATE contact_person SET first_name = :first_name, last_name = :last_name, phone_number = :phone_number, email = :email;";
    $params = [
        ":person_id" => $person_id,
        ":first_name" => $firstName,
        ":last_name" => $lastName,
        ":phone_number" => $phoneNumber,
        ":email" => $email,
    ];
    
    $updateSql .= " WHERE person_id = :person_id";
    
    $UpdateStatement = $Pdo->prepare($updateSql);
    $UpdateStatement->execute($params);
    
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
	
	<div class="update-container">
		<a href="list_customers.php" class="btn-back">&larr; Tilbake</a>
		<h1>Oppdater profil</h1>
		
		<?php if (isset($error)): ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>
		
		<form action="update_person.php" method="post">
			<div class="form-row">
				<div class="form-group">
					<label for="first_name">Fornavn</label>
					<input type="text" id="first_name" name="first_name" value="<?php echo $user_person['first_name']; ?>">
				</div>
				
				<div class="form-group">
					<label for="last_name">Etternavn</label>
					<input type="text" id="last_name" name="last_name" value="<?php echo $user_person['last_name']; ?>">
				</div>
			</div>
			
			<div class="form-row">
				<div class="form-group" style="flex: 0 0 200px;">
					<label for="phone_number">Telefonnummer</label>
					<input type="text" id="phone_number" name="phone_number" value="<?php echo $user_person['phone_number']; ?>">
				</div>
				
				<div class="form-group">
					<label for="email">E-post</label>
					<input type="email" id="email" name="email" value="<?php echo $user_person['email']; ?>">
				</div>
			</div>
			
			<button type="submit" name="update" class="btn-save">Lagre Endringer</button>
		</form>
	</div>
</body>
</html>
