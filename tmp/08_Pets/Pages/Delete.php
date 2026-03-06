<?php
if (isset($_GET["PetId"]) && $_SERVER["REQUEST_METHOD"] == "GET") { 
    include '../Assets/Connect.php';

    $PetId = $_GET["PetId"];

    $Sql = "SELECT * FROM Pets WHERE PetId = :PetId";
    $Stmt = $Pdo->prepare($Sql);
    $Stmt->bindParam(":PetId", $_GET["PetId"]);
    $Stmt->execute();

    $Car = $Stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include '../Assets/Head.php'?>
        <title>Delete a pet from SarahShelter</title>
    </head>
    <body>
        <?php include '../Assets/Nav.php'?>
        <header>
            <h1>Delete a pet from SarahShelter</h1>
        </header>
        <main>        
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <br><br><label for="PetId">Pet ID</label>
                <br><input readonly name="PetId" id="PetId" type="text" value="<?php echo htmlspecialchars($Car["PetId"])?>" required>
                <br><br><label for="Animal">Animal</label>
                <br><input readonly name="Animal" id="Animal" type="text" value="<?php echo htmlspecialchars($Car["Animal"])?>" placeholder="Write Animal here..." required>
                <br><br><label for="Race">Race</label>
                <br><input readonly name="Race" id="Race" type="text" value="<?php echo htmlspecialchars($Car["Race"])?>" placeholder="Write type here..." required>
                <br><br><label for="Name">Name</label>
                <br><input readonly name="Name" id="Name" type="text" value="<?php echo htmlspecialchars($Car["Name"])?>" placeholder="Write Name here..." required>
                <br><br><label for="Owner">Owner</label>
                <br><input readonly name="Owner" id="Owner" type="text" value="<?php echo htmlspecialchars($Car["Owner"])?>" placeholder="Write år here..." required>
                <br><br><label for="Colours">Colours</label>
                <br><input readonly name="Colours" id="Colours" type="text" value="<?php echo htmlspecialchars($Car["Colours"])?>" placeholder="Write år here..." required>

                <br><br><label for="Delete">Are you sure you want to delete this pet?</label>
                <br><br><input type="submit" name="DeletePet" id="Delete" value="Delete and exit">
            </form>
        </main>
    </body>
</html>

<?php

if (isset($_POST["DeletePet"]) && $_SERVER["REQUEST_METHOD"] == "POST") { 
    include '../Assets/Connect.php';

    $PetId = $_POST["PetId"];

    $Sql = "DELETE FROM Pets WHERE PetId = :PetId";
    $Stmt = $Pdo->prepare($Sql);
    $Stmt->bindParam(":PetId", $PetId);
    $Stmt->execute();

    header("Location: ListAll.php");
}

else {
    $Stmt = 0;
}