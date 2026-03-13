<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06
 */
require "auth_check.php";
include "../database/connect.php";

if (isset($_GET["id"])) {
    $person_id = $_GET["id"];
    $customer_id = $_GET["customer"] ?? null;

    $Sql = "DELETE FROM customer_has_user WHERE person_id = :id";
    $Statement = $Pdo->prepare($Sql);
    $Statement->execute([":id" => $person_id]);

    $Sql = "DELETE FROM contact_person WHERE person_id = :id";
    $Statement = $Pdo->prepare($Sql);
    $Statement->execute([":id" => $person_id]);
}

$redirect = "list_people.php";
if (isset($_GET["customer"])) {
    $redirect .= "?customer=" . $_GET["customer"];
}
header("Location: " . $redirect);
exit;
