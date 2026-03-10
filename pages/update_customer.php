<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 12:44:55
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-10 10:22:26
 */

require "auth_check.php";
include "../database/connect.php";

$customer_id = $_GET["id"] ?? null;

if (!$customer_id) {
	header("Location: list_customers.php");
	exit;
}

$Sql = "SELECT * FROM customer WHERE customer_id = :id";
$Statement = $Pdo->prepare($Sql);
$Statement->execute([":id" => $customer_id]);
$Customer = $Statement->fetch(PDO::FETCH_ASSOC);

if (!$Customer) {
	header("Location: list_customers.php");
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_customer"])) {
	$name = $_POST["name"];
	$address = $_POST["address"];
	$phone_number = $_POST["phone_number"];

	$Sql = "UPDATE customer SET name = :name, address = :address, phone_number = :phone_number WHERE customer_id = :id";
	$Statement = $Pdo->prepare($Sql);
	$Statement->execute([
		":name" => $name,
		":address" => $address,
		":phone_number" => $phone_number,
		":id" => $customer_id
	]);

	header("Location: list_customers.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include "pieces/head.php"; ?>
</head>

<body>
	<?php include "pieces/nav.php"; ?>

	<div style="width: 500px; margin: 40px auto;">
		<h2>Update Customer</h2>
		<form method="POST">
			<input type="hidden" name="update_customer" value="1">
			<div class="form-group">
				<input type="text" id="name" name="name" value="<?php echo htmlspecialchars($Customer['name']); ?>" required>
				<label for="name" class="floating">Name</label>
			</div>
			<div class="form-group">
				<input type="text" id="address" name="address" value="<?php echo htmlspecialchars($Customer['address']); ?>" required>
				<label for="address" class="floating">Address</label>
			</div>
			<div class="form-group">
				<input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($Customer['phone_number']); ?>" required>
				<label for="phone_number" class="floating">Phone Number</label>
			</div>
			<a href="delete_customer.php?id=<?php echo $Customer['customer_id']; ?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this customer?')">Slett</a>
			<button type="submit" class="btn-submit">Update Customer</button>
			<a href="list_customers.php" class="btn-action" style="display: inline-block; margin-left: 10px;">Cancel</a>
		</form>
	</div>
</body>

</html>