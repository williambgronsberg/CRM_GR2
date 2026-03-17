<?php
require "auth_check.php";
include "../database/connect.php";

$customer_id = $_GET["id"] ?? null;

if ($customer_id) {
    $Sql = "DELETE FROM customer WHERE customer_id = :id";
    $Statement = $Pdo->prepare($Sql);
    $Statement->execute([":id" => $customer_id]);
}

header("Location: list_customers.php");
exit;
?>
