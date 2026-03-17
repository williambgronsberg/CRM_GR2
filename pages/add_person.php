<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <?php include 'pieces/head.php'?>
    <title>crm_g2</title>
</head>
<body>
    <?php include 'pieces/nav.php'?>    
    <header>
        <h1>Registrer kontaktperson</h1>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

            <label for="first_name">Fornavn</label>
            <input name="first_name" id="first_name" type="text" placeholder="Skriv fornavnet ditt her..." required> <br> <br>

            <label for="last_name">Etternavn</label>
            <input name="last_name" id="last_name" type="text" placeholder="Skriv etternavnet ditt her..." required> <br> <br>

            <label for="phone_number">Telefonnummer</label>
            <input name="phone_number" id="phone_number" type="text" placeholder="Skriv nummeret ditt her..." required> <br> <br>

            <label for="email">E-post</label>
            <input name="email" id="email" type="text" placeholder="Skriv emailen din her..." required> <br> <br>

            <input type="submit" name="new_person" id="new_person" value="Registrer">


        </form>


    </main>

</body>
</html>

<?php

if (isset($_POST["new_person"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    include '../database/connect.php';

    $person_id = $_POST['person_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $Sql = "INSERT INTO accounts (person_id, first_name, last_name, phone_number, email) VALUES(:person_id, :first_name, :last_name, :phone_number, :email);";
	try {
			$Statement = $Pdo->prepare($Sql);
			$Statement->execute([
				":person_id" => $person_id,
				":first_name" => $firstName,
				":last_name" => $lastName,
				":phone_number" => $phoneNumber,
				":email" => $email
		]);
			
			header("Location: list_people.php");
			exit;
	} catch (PDOException $e) {
			$error = "ID finnes allerede, eller så oppstod det et problem.";
	}

    $Stmt->execute();

    header("Location: list_people.php");

}

else {
    $Stmt= 0;
}


?>