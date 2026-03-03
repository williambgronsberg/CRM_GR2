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
        <title>Update pet info</title>
    </head>
    <body>
        <?php include '../Assets/Nav.php'?>
        <header>
            <h1>Update a pet's info</h1>
        </header>
        <main>        
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <br><br><label for="PetId">Pet ID</label>
                <br><input readonly name="PetId" id="PetId" type="text" value="<?php echo htmlspecialchars($Car["PetId"])?>" required>
                <br><br><label for="Animal">Animal</label>
                <br><input name="Animal" id="Animal" type="text" value="<?php echo htmlspecialchars($Car["Animal"])?>" placeholder="Write Animal here..." required>
                <br><br><label for="Race">Race</label>
                <br><input name="Race" id="Race" type="text" value="<?php echo htmlspecialchars($Car["Race"])?>" placeholder="Write type here..." required>
                <br><br><label for="Name">Name</label>
                <br><input name="Name" id="Name" type="text" value="<?php echo htmlspecialchars($Car["Name"])?>" placeholder="Write Name here..." required>
                <br><br><label for="Owner">Owner</label>
                <br><input name="Owner" id="Owner" type="text" value="<?php echo htmlspecialchars($Car["Owner"])?>" placeholder="Write år here..." required>
                <br><br><label for="Colours">Colours</label>
                <br><input name="Colours" id="Colours" type="text" value="<?php echo htmlspecialchars($Car["Colours"])?>" placeholder="Write år here..." required>
                <br><br><input type="submit" name="ChangePet" id="ChangePet" value="Save and exit">
            </form>
        </main>
    </body>
</html>

<?php

if (isset($_POST["ChangePet"]) && $_SERVER["REQUEST_METHOD"] == "POST") { 
    include '../Assets/Connect.php';

    $New_PetId = $_POST["PetId"];
    $New_Animal = $_POST["Animal"];
    $New_Race = $_POST["Race"];
    $New_Name = $_POST["Name"];
    $New_Owner = $_POST["Owner"];
    $New_Colours = $_POST["Colours"];

    $Sql = "UPDATE Pets SET Animal = :Animal, Race = :Race, Name = :Name, Owner = :Owner, Colours = :Colours 
                WHERE PetId = :PetId";
    $Stmt = $Pdo->prepare($Sql);
    $Stmt->bindParam(":PetId", $New_PetId);
    $Stmt->bindParam(":Animal", $New_Animal);
    $Stmt->bindParam(":Race", $New_Race);
    $Stmt->bindParam(":Name", $New_Name);
    $Stmt->bindParam(":Owner", $New_Owner);
    $Stmt->bindParam(":Colours", $New_Colours);
    $Stmt->execute();

    header("Location: ListAll.php");
}

else {
    $Stmt = 0;
}