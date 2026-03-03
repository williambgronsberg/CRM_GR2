<?php
    session_start();
    include '../Assets/Connect.php';

    if (isset($_GET["Column"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
        $Column = $_GET["Column"];
    }

    else {
        $Column = "PetId";
    }

    if (!(isset($_SESSION["SortType"]))) {
        $_SESSION["SortType"] = "ASC";
    }

    if (isset($_POST["AscSortType"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION["SortType"] = "ASC";
    }
    
    if (isset($_POST["DescSortType"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION["SortType"] = "DESC";
    }

    $SortType = $_SESSION["SortType"];

    $Sql = "SELECT * FROM Pets
    ORDER BY $Column $SortType";
    $Stmt =  $Pdo ->prepare($Sql);
    $Stmt->execute();

    $Sql2 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = 'Pets'";
    $Stmt2 =  $Pdo ->prepare($Sql2);
    $Stmt2->execute();

    $Pets = $Stmt->fetchAll(PDO::FETCH_ASSOC);

    $PetsKeys = $Stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../Assets/Head.php'?> 
    <title>List of all pets</title>
</head>
<body>
    <?php include '../Assets/Nav.php'?>
    <header>
        <h1>Show all pets</h1>
    </header>
    <main>
        <section>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p>Current sort type: <?php $TextSortType = $SortType == "ASC" ? "Ascending" : "Descending"; echo $TextSortType?></p>
                <label for="AscSortType">Ascending:</label>
                <input type="submit" value="ASC" name="AscSortType">
                <label for="DescSortType">Descending:</label>
                <input type="submit" value="DESC" name="DescSortType">
            </form>
            <table>
                <thead>
                        <th><a href="ListAll.php?Column=PetId">Pet ID</th>
                        <th><a href="ListAll.php?Column=Animal">Animal</th>
                        <th><a href="ListAll.php?Column=Race">Race</th>
                        <th><a href="ListAll.php?Column=Name">Name</th>
                        <th><a href="ListAll.php?Column=Owner">Owner</th>
                        <th><a href="ListAll.php?Column=Colours">Colours</th>
                        <th>Update</th>;
                        <th>Delete</th>;
                </thead>
                <tr>
                    <?php 
                    foreach ($Pets as $Pet) {
                        $Counter = 0;
                        foreach ($PetsKeys as $PetKey) {
                            if ($Counter <= count($PetsKeys)/2-1) {
                                echo "<td>".htmlspecialchars($Pet[$PetKey["COLUMN_NAME"]])."</td>";
                                $Counter++;
                            }
                        }
                        ?>
                        <td><a href="Update.php?PetId=<?php echo $Pet['PetId']?>">Edit</a></td>
                        <td><a class="Red0" href="Delete.php?PetId=<?php echo $Pet['PetId']?>">Delete</a></td>
                        <?php
                        echo "</tr><tr>";
                    }
                    ?>
                </tr>
            </table>
        </section>
    </main>
</body>
</html>