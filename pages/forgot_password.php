<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-19
 */
session_start();
include "../database/connect.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = trim($_POST["email"]);

	$Sql = "SELECT * FROM accounts WHERE email = :email";
	$Statement = $Pdo->prepare($Sql);
	$Statement->execute([":email" => $email]);
	$User = $Statement->fetch(PDO::FETCH_ASSOC);

	// Always show success to avoid email enumeration
	$success = "Hvis e-posten du skrev finnes i vårt system, så har en mail med en lenke for å endre passord blitt sendt til den.";

	if ($User) {
		$token = bin2hex(random_bytes(32));
		$expires = date("Y-m-d H:i:s", strtotime("+10 minutes"));

		// Delete any existing token for this user
		$Pdo->prepare("DELETE FROM password_reset_tokens WHERE username = :username")
			->execute([":username" => $User["username"]]);

		// Store new token
		$Pdo->prepare("INSERT INTO password_reset_tokens (token, username, expires_at) VALUES (:token, :username, :expires)")
			->execute([":token" => $token, ":username" => $User["username"], ":expires" => $expires]);

		$resetLink = "http://localhost/Repos/CRM_GR2/pages/reset_password.php?token=" . $token;

		// Send email via Gmail SMTP using PHP mail with SMTP settings
		$to      = $email;
		$subject = "Tilbakestill passord - Frisk AS";
		$message = "Hei " . $User["first_name"] . ",\r\n\r\n"
			. "Tilbakestill passordet ditt med lenken nedenfor.\r\n"
			. "Lenken er gyldig i 10 minutter.\r\n\r\n"
			. $resetLink . "\r\n\r\n"
			. "Hvis du ikke ba om dette, kan du ignorere denne e-posten.\r\n\r\n"
			. "- Frisk AS";

		sendResetEmail($to, $subject, $message);
	}
}

function sendResetEmail($to, $subject, $message)
{
	require "../vendor/autoload.php";

	$mail = new PHPMailer\PHPMailer\PHPMailer(true);
	try {
		$mail->isSMTP();
		$mail->Host       = "smtp.gmail.com";
		$mail->SMTPAuth   = true;
		// Credentials are loaded from environment variables to avoid committing secrets to source control.
		// Set MAIL_USERNAME and MAIL_PASSWORD in your environment (or in your process manager / CI secret store).
		$mail->Username   = getenv('MAIL_USERNAME') ?: '';
		$mail->Password   = getenv('MAIL_PASSWORD') ?: '';
		$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
		$mail->Port       = 587;

		// From address is also configurable via environment variables. Fallback to a no-reply address.
		$fromAddress = getenv('MAIL_FROM_ADDRESS') ?: 'no-reply@frisk.example';
		$fromName = getenv('MAIL_FROM_NAME') ?: 'Frisk AS';

		$mail->setFrom($fromAddress, $fromName);
		$mail->addAddress($to);
		$mail->Subject = $subject;
		$mail->Body    = $message;

		$mail->send();
	} catch (Exception $e) {
		error_log("Mail error: " . $mail->ErrorInfo);
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Glemt passord</title>
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

		.form input[type="email"] {
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
		<p class="title">Glemt passord</p>

		<?php if ($success): ?>
			<p class="success"><?php echo $success; ?></p>
		<?php endif; ?>
		<?php if ($error): ?>
			<p class="error"><?php echo $error; ?></p>
		<?php endif; ?>

		<form action="forgot_password.php" method="POST" style="width:100%; display:flex; flex-direction:column; gap:15px;">
			<input type="email" name="email" placeholder="E-postadresse" required>
			<button type="submit" class="btn-submit" style="width:100%;">Send tilbakestillingslenke</button>
		</form>

		<a href="login.php" class="back-link">&larr; Tilbake til innlogging</a>
	</div>
</body>

</html>
