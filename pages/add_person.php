<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '/pieces/head.php'?>
    <title>crm_g2</title>
</head>
<body>
    <?php include '/pieces/nav.php' ?>    
    <header>
        <h1>Registrer kontaktperson</h1>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="user_id">Bruker ID</label>
            <input name="user_id" id="user_id" type="text" disabled>

            <label for="first_name">Fornavn</label>
            <input name="first_name" id="first_name" type="text" placehpøder="Skriv fornavnet ditt her..." required>

            <label for="last_name">Etternavn</label>
            <input name="last_name" id="last_name" type="text" placehpøder="Skriv etternavnet ditt her..." required>

            <label for="phone_number">Telefon nummer</label>
            <input name="phone_number" id="phone_number" type="text" placehpøder="Skriv nummeret ditt her..." required>

            <label for="email">Email</label>
            <input name="email" id="email" type="text" placehpøder="Skriv emailen din her..." required>


        </form>


    </main>

</body>
</html>