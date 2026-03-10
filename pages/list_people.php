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

$people = $Stmt->fetchAll(PDO::FETCH_ASSOC);

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
            <p>Sorterings type: <?php $text_sort_type = $sort_type == "ASC" ? "Stigende" : "Synkende";
            echo $text_sort_type ?></p>
            <label for="asc_sort_type">Stigende:</label>
            <input type="submit" value="Stigende" name="asc_sort_type">

            <label for="desc_sort_type">Synkende:</label>
            <input type="submit" value="Synkende" name="desc_sort_type">
        </form>

        <table>
            <thead>
                <th>Fornavn</th>
                <th>Etternavn</th>
                <th>Telefonnummer</th>
                <th>E-mail</th>
                <th>Handlinger</th>
            </thead>
            <tr>
                <?php foreach ($people as $person): ?>
                    {
                        <tr>
                            <td><?php echo htmlspecialchars($person['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($person['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($person['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($person['email']); ?></td>
                        </tr>
                    }
                <?php endforeach; ?>    
                

            </tr>
        </table>

    </section>
</main>   



</body>
</html>