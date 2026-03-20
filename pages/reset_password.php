<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-20
 */
session_start();
include "../database/connect.php";

$error   = "";
$success = "";
$token   = $_GET["token"] ?? "";

// Validate token
$Sql = "SELECT * FROM password_reset_tokens WHERE token = :token AND expires_at > NOW()";
$Statement = $Pdo->prepare($Sql);
$Statement->execute([":token" => $token]);
$TokenRow = $Statement->fetch(PDO::FETCH_ASSOC);

if (!$TokenRow) {
	$error = "Lenken er ugyldig eller har utløpt.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $TokenRow) {
	$newPassword     = $_POST["new_password"];
	$confirmPassword = $_POST["confirm_password"];

	if (strlen($newPassword) < 8) {
		$error = "Passordet må være minst 8 tegn.";
	} elseif ($newPassword !== $confirmPassword) {
		$error = "Passordene samsvarer ikke.";
	} else {
		$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

		$Pdo->prepare("UPDATE accounts SET password = :password WHERE username = :username")
			->execute([":password" => $hashed, ":username" => $TokenRow["username"]]);

		// Delete token so it can't be reused
		$Pdo->prepare("DELETE FROM password_reset_tokens WHERE token = :token")
			->execute([":token" => $token]);

		$success = "Passordet er oppdatert. Du kan nå logge inn.";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tilbakestill passord</title>
	<link rel="stylesheet" href="https://use.typekit.net/idz1bdq.css">
	<link rel="stylesheet" href="../assets/style.css">
	<style>
		body {
			background: rgb(var(--pink));
			min-height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.form {
			padding: 30px;
			background: rgb(var(--green));
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 20px;
			border-radius: 20px;
			border: 4px solid #323232;
			box-shadow: 8px 8px #323232;
			width: 320px;
		}

		.form p.title {
			color: white;
			font-weight: 700;
			font-size: 24px;
		}

		.form input[type="password"] {
			width: 100%;
			height: 45px;
			border-radius: 8px;
			border: 3px solid #323232;
			background: white;
			box-shadow: 4px 4px #323232;
			font-size: 16px;
			padding: 5px 15px;
			outline: none;
		}

		.success {
			color: white;
			font-size: 14px;
			text-align: center;
		}

		.error {
			color: #ff6b6b;
			font-size: 14px;
			text-align: center;
		}

		.back-link {
			color: white;
			font-size: 13px;
			text-decoration: none;
			opacity: 0.8;
		}

		.back-link:hover {
			opacity: 1;
		}
	</style>
</head>

<body>
	<div class="form">
		<p class="title">Nytt passord</p>

		<?php if ($success): ?>
			<p class="success"><?php echo $success; ?></p>
			<a href="login.php" class="back-link">Gå til innlogging &rarr;</a>
		<?php elseif ($error && !$TokenRow): ?>
			<p class="error"><?php echo $error; ?></p>
			<a href="forgot_password.php" class="back-link">&larr; Prøv igjen</a>
		<?php else: ?>
			<?php if ($error): ?>
				<p class="error"><?php echo $error; ?></p>
			<?php endif; ?>
			<form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="POST" style="width:100%; display:flex; flex-direction:column; gap:15px;">
				<input type="password" name="new_password" placeholder="Nytt passord" required>
				<input type="password" name="confirm_password" placeholder="Bekreft passord" required>
				<button type="submit" class="btn-submit" style="width:100%;">Oppdater passord</button>
			</form>
			<a href="login.php" class="back-link">&larr; Tilbake til innlogging</a>
		<?php endif; ?>
	</div>
</body>

</html>