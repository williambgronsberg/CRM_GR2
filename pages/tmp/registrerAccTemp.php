<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-06 13:08:24
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-06 15:37:18
 *
 * 
 */


include('../../database/connect.php');






?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width='device-width', initial-scale=1.0">
	<title>Document</title>
</head>

<body>

	<!-- make registrer form -->
	<form action="registrer_acc_temp_confirm.php" method="post">
		<label for="username">Username:</label>
		<input type="text" id="username" name="username"><br><br>
		<label for="first_name">fornavn</label>
		<input type="text" id="first_name" name="first_name"><br><br>
		<label for="last_name">etternavn</label>
		<input type="text" id="last_name" name="last_name"><br><br>
		<label for="phone_number">telefon nummer</label>
		<input type="number" id="phone_number" name="phone_number"><br><br>
		<label for="email">email</label>
		<input type="email" id="email" name="email"><br><br>

		<label for="password">Password:</label>
		<input type="password" id="password" name="password"><br><br>
		<input type="submit" value="Register">


</body>

</html>