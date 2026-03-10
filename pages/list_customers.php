<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-03 09:18:02
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-09 11:20:16
 */
require "auth_check.php";

include "../database/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_customer"])) {
	$name = $_POST["name"];
	$address = $_POST["address"];
	$phone_number = $_POST["phone_number"];
	$kunde_siden = date("d-m-Y");

	$Sql = "INSERT INTO customer (name, address, phone_number, kunde_siden) VALUES (:name, :address, :phone_number, :kunde_siden)";
	$Statement = $Pdo->prepare($Sql);
	$Statement->execute([
		":name" => $name,
		":address" => $address,
		":phone_number" => $phone_number,
		":kunde_siden" => $kunde_siden
	]);

	header("Location: list_customers.php");
	exit;
}

$Sql = "SELECT * FROM customer";
$Statement = $Pdo->query($Sql);
$Customers = $Statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include "pieces/head.php"; ?>
</head>

<body>
	<?php include "pieces/nav.php"; ?>
	
	<div style="width: 1000px; margin: 40px auto;">
		<div style="text-align: right;">
			<button class="btn-add" onclick="document.getElementById('addModal').classList.add('show')">+ Add Customer</button>
		</div>
		
		<div class="customers-table-container" style="margin-top: 15px; clear: both;">
			<table class="customers-table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Address</th>
						<th>Phone Number</th>
						<th>Customer Since</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($Customers as $Customer): ?>
						<tr>
							<td><?php echo htmlspecialchars($Customer['name']); ?></td>
							<td><?php echo htmlspecialchars($Customer['address']); ?></td>
							<td><?php echo htmlspecialchars($Customer['phone_number']); ?></td>
							<td><?php echo htmlspecialchars($Customer['kunde_siden']); ?></td>
							<td>
								<div class="action-btns">
									<a href="view_customer.php?id=<?php echo $Customer['customer_id']; ?>" class="btn-action btn-edit">Se mer</a>
									<a href="update_customer.php?id=<?php echo $Customer['customer_id']; ?>" class="btn-action btn-edit">Rediger</a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div id="addModal" class="modal" onclick="if(event.target === this) this.classList.remove('show')">
		<div class="modal-content">
			<span class="close" onclick="document.getElementById('addModal').classList.remove('show')">&times;</span>
			<h2>Add Customer</h2>
			<form method="POST">
				<input type="hidden" name="add_customer" value="1">
				<div class="form-group">
					<input type="text" id="name" name="name" placeholder=" " required>
					<label for="name" class="floating">Name</label>
				</div>
				<div class="form-group">
					<input type="text" id="address" name="address" placeholder=" " required>
					<label for="address" class="floating">Address</label>
				</div>
				<div class="form-group">
					<input type="text" id="phone_number" name="phone_number" placeholder=" " required>
					<label for="phone_number" class="floating">Phone Number</label>
				</div>
				<button type="submit" class="btn-submit">Add Customer</button>
			</form>
		</div>
	</div>
</body>

</html>