<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '/pieces/head.php'?>
    <title>crm_g2</title>
</head>
<body>
    <?php include '/pieces/nav.php'?>    
    <header>
        <h1>Registrer kontaktperson</h1>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

            <label for="first_name">Fornavn</label>
            <input name="first_name" id="first_name" type="text" placeholder="Skriv fornavnet ditt her..." required> <br> <br>

            <label for="last_name">Etternavn</label>
            <input name="last_name" id="last_name" type="text" placeholder="Skriv etternavnet ditt her..." required> <br> <br>

            <label for="phone_number">Telefon nummer</label>
            <input name="phone_number" id="phone_number" type="text" placeholder="Skriv nummeret ditt her..." required> <br> <br>

            <label for="email">Email</label>
            <input name="email" id="email" type="text" placeholder="Skriv emailen din her..." required> <br> <br>

            <input type="submit" name="new_person" id="new_person" value="Registrer">


        </form>


    </main>

</body>
</html>

<?php

if (isset($_POST["new_person"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    include '/pieces/connect.php';

    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $Sql = "INSERT INTO accounts (user_id, first_name, last_name, phone_number, email) VALUES(:user_id, :first_name, :last_name, :phone_number, :email);";
    $Stmt = $Pdo->prepare($Sql);

    $Stmt->bindParam(":user_id", $user_id);
    $Stmt->bindParam(":first_name", $first_name);
    $Stmt->bindParam(":last_name", $last_name);
    $Stmt->bindParam(":phone_number", $phone_number);
    $Stmt->bindParam(":email", $email);

    $Stmt->execute();

    header("Location: list_people.php");

}

else {
    $Stmt= 0;
}


?>