<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-03 09:18:02
 * @Last Modified by:   William Berge Groensberg
 * @Last Modified time: 2026-03-06 16:13:10
 */

include "../database/connect.php";

$Username = $_SESSION["username"] ?? "";
$Sql = "SELECT * FROM accounts WHERE username = :username";
$Statement = $Pdo->prepare($Sql);
$Statement->bindParam(":username", $Username);
$Statement->execute();
$User = $Statement->fetch(PDO::FETCH_ASSOC);

$firstName = $User["first_name"] ?? "";
$lastName = $User["last_name"] ?? "";
$initials = "";

if ($firstName && $lastName) {
	$initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
} elseif ($firstName) {
	$initials = strtoupper(substr($firstName, 0, 2));
} else {
	$initials = strtoupper(substr($Username, 0, 2));
}
?>

<nav>
	<div class="nav-logo"><a class='no_decor' href="list_customers.php">Frisk AS</a></div>
	<div class="nav-links">
		<a href="list_customers.php">Bedrifter</a>
		<a href="about_us.php">Om oss</a>
		<div class="nav-avatar" onclick="toggleProfileModal()">
			<?php echo $initials; ?>
		</div>
	</div>
</nav>

<div id="profileModal" class="modal" onclick="closeProfileModal(event)">
	<div class="modal-content" onclick="event.stopPropagation()">
		<span class="close-btn" onclick="toggleProfileModal()">&times;</span>
		<h2>Profil</h2>
		<?php if ($User): ?>
			<div class="profile-info">
				<p><strong>Brukernavn:</strong> <?php echo htmlspecialchars($User["username"]); ?></p>
				<p><strong>E-post:</strong> <?php echo htmlspecialchars($User["email"] ?? "Not set"); ?></p>
				<p><strong>GitHub:</strong> <?php echo htmlspecialchars($User["github_username"] ?? "Not linked"); ?></p>
			</div>
			<div class="profile-actions">
				<a href="update_account.php" class="btn-edit">Rediger Profil</a>
				<a href="logout.php" class="btn-logout">Logg ut</a>
			</div>
		<?php else: ?>
			<p>Bruker ikke funnet</p>
		<?php endif; ?>
	</div>
</div>

<script>
function toggleProfileModal() {
	const modal = document.getElementById('profileModal');
	modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
}

function closeProfileModal(event) {
	if (event.target.id === 'profileModal') {
		event.target.style.display = 'none';
	}
}
</script>

<style>
.modal {
	display: none;
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.5);
	justify-content: center;
	align-items: center;
	z-index: 1000;
}

.modal-content {
	background: rgb(var(--green));
	padding: 30px;
	border-radius: 20px;
	border: 4px solid #323232;
	box-shadow: 8px 8px #323232;
	min-width: 300px;
	position: relative;
}

.modal-content h2 {
	color: white;
	margin-bottom: 20px;
	font-size: 28px;
}

.close-btn {
	position: absolute;
	top: 10px;
	right: 15px;
	font-size: 30px;
	color: white;
	cursor: pointer;
}

.profile-info p {
	color: white;
	font-size: 16px;
	margin: 10px 0;
}

.profile-actions {
	display: flex;
	gap: 15px;
	margin-top: 25px;
}

.btn-edit, .btn-logout {
	padding: 12px 24px;
	border-radius: 8px;
	border: 3px solid #323232;
	text-decoration: none;
	font-weight: 700;
	cursor: pointer;
	transition: all 0.2s;
}

.btn-edit {
	background: white;
	color: #323232;
}

.btn-edit:hover {
	background: #f0f0f0;
}

.btn-logout {
	background: rgb(var(--pink));
	color: white;
}

.btn-logout:hover {
	opacity: 0.8;
}
</style>
