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

$allowed_columns = ["customer_id", "name", "address", "phone_number", "kunde_siden"];
$column = $_GET["column"] ?? "customer_id";
if (!in_array($column, $allowed_columns)) {
    $column = "customer_id";
}

$sort_type = "ASC";
if (isset($_GET['sort'])) {
    $sort_type = $_GET['sort'] == "DESC" ? "DESC" : "ASC";
} elseif (isset($_SESSION["sort_type"])) {
    $sort_type = $_SESSION["sort_type"];
}
$_SESSION["sort_type"] = $sort_type;

$Sql = "SELECT * FROM customer ORDER BY $column $sort_type";
$Stmt = $Pdo->prepare($Sql);
$Stmt->execute();

$customers = $Stmt->fetchAll(PDO::FETCH_ASSOC);
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
			<button class="btn-add" onclick="document.getElementById('addModal').classList.add('show')">+ Ny Bedrift</button>
		</div>

		<div class="customers-table-container" style="margin-top: 15px; clear: both;">
			<table class="customers-table">
				<thead>
					<tr>
						<th><a href="?column=name&sort=<?php echo $sort_type == 'ASC' ? 'DESC' : 'ASC'; ?>" style="color: white; text-decoration: none;">Navn (<?php if ($column == 'name') {if ($sort_type == 'ASC') {$sort_icon = '↑';} elseif ($sort_type == 'DESC') {$sort_icon = '↓';}} else {$sort_icon = '↑↓';} echo $sort_icon ?>)</a></th>
						<th>Telefonnummer</th>
						<th><a href="?column=kunde_siden&sort=<?php echo $sort_type == 'ASC' ? 'DESC' : 'ASC'; ?>" style="color: white; text-decoration: none;">Kunde siden (<?php if ($column == 'kunde_siden') {if ($sort_type == 'ASC') {$sort_icon = '↑';} elseif ($sort_type == 'DESC') {$sort_icon = '↓';}} else {$sort_icon = '↑↓';} echo $sort_icon ?>)</a></th>
						<th>Addresse</th>
						<th>Handlinger</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($customers as $customer): ?>
						<tr>
							<td><?php echo htmlspecialchars($customer['name']); ?></td>
							<td><?php echo htmlspecialchars($customer['address']); ?></td>
							<td><?php echo htmlspecialchars($customer['phone_number']); ?></td>
							<td><?php echo htmlspecialchars($customer['kunde_siden']); ?></td>
							<td>
								<div class="action-btns">
									<a href="list_customers.php?customer=<?php echo $customer['customer_id']; ?>" class="btn-action btn-edit">Se mer</a>
									<button class="btn-action btn-edit" onclick="openUpdateModal(<?php echo $customer['customer_id']; ?>, '<?php echo htmlspecialchars($customer['name']); ?>', '<?php echo htmlspecialchars($customer['address']); ?>', '<?php echo htmlspecialchars($customer['phone_number']); ?>')">Rediger</button>

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