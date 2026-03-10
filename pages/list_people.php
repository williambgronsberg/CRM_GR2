<?php
session_start();
include '../database/connect.php';

if (isset($_GET['column']) && $_SERVER["REQUEST_METHOD"] == "GET")
    {
    $column = $_GET["column"];
    }

else 
    {
    $column = "user_id";
    }

if (!(isset($_SESSION["sort_type"])))
    {
    $_SESSION["sort_type"] = "ASC";
    }

if (isset($_POST["asc_sort_type"]) && $_SERVER["REQUEST_METHOD"] == "POST")
    {
    $_SESSION["sort_type"] = "ASC";
    }

if (isset($_POST["desc_sort_type"]) && $_SERVER["REQUEST_METHOD"] == "POST")
    {
    $_SESSION["sort_type"] = "DESC";
    }

$sort_type = $_SESSION["sort_type"];

$Sql = "SELECT * FROM contact_person ORDER BY $column $sort_type";
$Stmt = $Pdo -> prepare($Sql);
$Stmt -> execute();

$person = $Stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <?php include 'pieces/head.php' ?>
    <title>crm g2</title>
</head>
<body>
    <?php include 'pieces/nav.php' ?>
<header>Vis alle personer</header>
<main>
    <section>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>Sorterings type: <?php $text_sort_type = $sort_type?></p>


        </form>
    </section>
</main>   



</body>
</html>