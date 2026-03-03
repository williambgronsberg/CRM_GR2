<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../Assets/Head.php'?>   
    <title>Register a new pet</title>
</head>
<body>
    <?php include '../Assets/Nav.php'?>
    <header>
        <h1>Register a pet</h1>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <br><br><label for="PetId">ID for pet</label>
            <br><input name="PetId" id="PetId" type="number" disabled>

            <br><br><label for="Animal">Type of animal (ex. Cat)</label>
            <br><input name="Animal" id="Animal" type="text" placeholder="Write Animal here..." required>

            <br><br><label for="Race">Race of pet</label>
            <br><input name="Race" id="Race" type="text" placeholder="Write Race here..." required>

            <br><br><label for="Name">Name of pet</label>
            <br><input name="Name" id="Name" type="text" placeholder="Write Name here..." required>

            <br><br><label for="Owner">Owner of pet</label>
            <br><input name="Owner" id="Owner" type="text" placeholder="Write Owner here..." required>

            <br><br><label for="Colours">Colours of pet</label>
            <br><input name="Colours" id="Colours" type="text" placeholder="Write Colours here..." required>

            <br><br><input type="submit" name="NewPet" id="NewPet" value="Register">
        </form>
    </main>
</body>
</html>

<?php

if (isset($_POST["NewPet"]) && $_SERVER["REQUEST_METHOD"] == "POST") { 
    include '../Assets/Connect.php';

    $New_Animal = $_POST["Animal"];
    $New_Race = $_POST["Race"];
    $New_Name = $_POST["Name"];    
    $New_Owner = $_POST["Owner"];    
    $New_Colours = $_POST["Colours"];

    $Sql = "INSERT INTO Pets (Animal, Race, Name, Owner, Colours)
    VALUES (:Animal, :Race, :Name, :Owner, :Colours);";
    $Stmt =  $Pdo->prepare($Sql);

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