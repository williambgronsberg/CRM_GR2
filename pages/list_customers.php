<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-03 09:18:02
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-10 10:51:17
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_customer"])) {
	$customer_id = $_POST["id"];
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

	<div style="margin: 15px;">
		<div class="table-header">
			<div></div>
			<button class="btn-add" onclick="document.getElementById('addModal').classList.add('show')">+ Add Customer</button>
		</div>

		<div class="customers-table-container" style="margin-top: 15px; clear: both;">
			<table class="customers-table">
				<thead>
					<tr>
						<th>Navn</th>
						<th>Addresse</th>
						<th>Telefonnummer</th>
						<th>Kunde siden</th>
						<th>Handlinger</th>
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
									<a href="list_people.php?customer=<?php echo $Customer['customer_id']; ?>" class="btn-action btn-edit">Se mer</a>
									<button class="btn-action btn-edit" onclick="openUpdateModal(<?php echo $Customer['customer_id']; ?>, '<?php echo htmlspecialchars($Customer['name']); ?>', '<?php echo htmlspecialchars($Customer['address']); ?>', '<?php echo htmlspecialchars($Customer['phone_number']); ?>')">Rediger</button>

								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<?php include "add_customer.php"; ?>

    <?php include "update_customer.php"; ?>

	<script>
		function openUpdateModal(id, name, address, phone_number) {
			document.getElementById('update_id').value = id;
			document.getElementById('update_name').value = name;
			document.getElementById('update_address').value = address;
			document.getElementById('update_phone_number').value = phone_number;
			document.getElementById('updateDeleteBtn').style.display = 'inline-block';
			document.getElementById('updateModal').classList.add('show');
		}
	</script>
	
</body>

</html>