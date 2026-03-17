<?php

/**
 * @Author: William Berge Groensberg
 * @Date:   2026-03-03
 */
require "auth_check.php";

include "../database/connect.php";

$customer_id = $_GET["customer"] ?? null;

if ($customer_id) {
    $Sql = "SELECT customer_id, name FROM customer WHERE customer_id = :id";
    $Statement = $Pdo->prepare($Sql);
    $Statement->execute([":id" => $customer_id]);
    $CurrentCustomer = $Statement->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_person"])) {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];

    $Sql = "INSERT INTO contact_person (first_name, last_name, phone_number, email) VALUES (:first_name, :last_name, :phone_number, :email)";
    $Statement = $Pdo->prepare($Sql);
    $Statement->execute([
        ":first_name" => $first_name,
        ":last_name" => $last_name,
        ":phone_number" => $phone_number,
        ":email" => $email
    ]);

    $person_id = $Pdo->lastInsertId();

    if ($customer_id) {
        $Sql = "INSERT INTO customer_has_user (customer_id, person_id) VALUES (:customer_id, :person_id)";
        $Statement = $Pdo->prepare($Sql);
        $Statement->execute([":customer_id" => $customer_id, ":person_id" => $person_id]);
    }

    $redirect = "list_people.php";
    if ($customer_id) {
        $redirect .= "?customer=" . $customer_id;
    }
    header("Location: " . $redirect);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_person"])) {
    $person_id = $_POST["id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];

    $Sql = "UPDATE contact_person SET first_name = :first_name, last_name = :last_name, phone_number = :phone_number, email = :email WHERE person_id = :id";
    $Statement = $Pdo->prepare($Sql);
    $Statement->execute([
        ":first_name" => $first_name,
        ":last_name" => $last_name,
        ":phone_number" => $phone_number,
        ":email" => $email,
        ":id" => $person_id
    ]);

    $redirect = "list_people.php";
    if ($customer_id) {
        $redirect .= "?customer=" . $customer_id;
    }
    header("Location: " . $redirect);
    exit;
}

$column = $_GET["column"] ?? "person_id";

$sort_type = "ASC";
if (isset($_GET['sort'])) {
    $sort_type = $_GET['sort'] == "DESC" ? "DESC" : "ASC";
} elseif (isset($_SESSION["sort_type"])) {
    $sort_type = $_SESSION["sort_type"];
}
$_SESSION["sort_type"] = $sort_type;

if ($customer_id) {
    $Sql = "SELECT cp.* FROM contact_person cp 
            INNER JOIN customer_has_user chu ON cp.person_id = chu.person_id 
            WHERE chu.customer_id = :customer_id 
            ORDER BY $column $sort_type";
    $Stmt = $Pdo->prepare($Sql);
    $Stmt->execute([":customer_id" => $customer_id]);
} else {
    $Sql = "SELECT * FROM contact_person ORDER BY $column $sort_type";
    $Stmt = $Pdo->prepare($Sql);
    $Stmt->execute();
}

$people = $Stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <?php include 'pieces/head.php' ?>
    <title>crm g2</title>
</head>
<body>
    <?php include 'pieces/nav.php' ?>
    
    <div style="margin: 15px;">
        <div class="table-header">
            <?php if ($customer_id && $CurrentCustomer): ?>
                <h1><?php echo htmlspecialchars($CurrentCustomer['name']); ?> - Contact Persons</h1>
            <?php else: ?>
                <h1>All Contact Persons</h1>
            <?php endif; ?>
            <div class="table-actions">
                <?php if ($customer_id && $CurrentCustomer): ?>
                    <a href="list_customers.php" class="btn-back">&larr; Back</a>
                <?php endif; ?>
                <button class="btn-add" onclick="document.getElementById('addModal').classList.add('show')">+ Add Person</button>
            </div>
        </div>

        <div class="customers-table-container">
            <table class="customers-table">
                <thead>
                    <tr>
                        <th><a href="?<?php echo $customer_id ? 'customer='.$customer_id.'&' : ''; ?>column=first_name&sort=<?php echo $sort_type == 'ASC' ? 'DESC' : 'ASC'; ?>" style="color: white; text-decoration: none;">Fornavn <?php echo $column == 'first_name' ? ($sort_type == 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                        <th><a href="?<?php echo $customer_id ? 'customer='.$customer_id.'&' : ''; ?>column=last_name&sort=<?php echo $sort_type == 'ASC' ? 'DESC' : 'ASC'; ?>" style="color: white; text-decoration: none;">Etternavn <?php echo $column == 'last_name' ? ($sort_type == 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                        <th>Telefonnummer</th>
                        <th>E-mail</th>
                        <th>Handlinger</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($people as $person): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($person['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($person['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($person['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($person['email']); ?></td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-action btn-edit" onclick="openUpdateModal(<?php echo $person['person_id']; ?>, '<?php echo htmlspecialchars($person['first_name']); ?>', '<?php echo htmlspecialchars($person['last_name']); ?>', '<?php echo htmlspecialchars($person['phone_number']); ?>', '<?php echo htmlspecialchars($person['email']); ?>')">Rediger</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="addModal" class="modal" onclick="if(event.target === this) this.classList.remove('show')">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('addModal').classList.remove('show')">&times;</span>
            <h2>Add Person</h2>
            <form method="POST">
                <input type="hidden" name="add_person" value="1">
                <div class="form-group">
                    <input type="text" id="first_name" name="first_name" placeholder=" " required>
                    <label for="first_name" class="floating">First Name</label>
                </div>
                <div class="form-group">
                    <input type="text" id="last_name" name="last_name" placeholder=" " required>
                    <label for="last_name" class="floating">Last Name</label>
                </div>
                <div class="form-group">
                    <input type="text" id="phone_number" name="phone_number" placeholder=" " required>
                    <label for="phone_number" class="floating">Phone Number</label>
                </div>
                <div class="form-group">
                    <input type="text" id="email" name="email" placeholder=" " required>
                    <label for="email" class="floating">Email</label>
                </div>
                <button type="submit" class="btn-submit">Add Person</button>
            </form>
        </div>
    </div>

    <div id="updateModal" class="modal" onclick="if(event.target === this) this.classList.remove('show')">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('updateModal').classList.remove('show')">&times;</span>
            <h2>Update Person</h2>
            <form method="POST">
                <input type="hidden" name="update_person" value="1">
                <input type="hidden" id="update_id" name="id">
                <div class="form-group">
                    <input type="text" id="update_first_name" name="first_name" placeholder=" " required>
                    <label for="update_first_name" class="floating">First Name</label>
                </div>
                <div class="form-group">
                    <input type="text" id="update_last_name" name="last_name" placeholder=" " required>
                    <label for="update_last_name" class="floating">Last Name</label>
                </div>
                <div class="form-group">
                    <input type="text" id="update_phone_number" name="phone_number" placeholder=" " required>
                    <label for="update_phone_number" class="floating">Phone Number</label>
                </div>
                <div class="form-group">
                    <input type="text" id="update_email" name="email" placeholder=" " required>
                    <label for="update_email" class="floating">Email</label>
                </div>
                <button type="submit" class="btn-submit">Update Person</button>
                <button type="button" id="updateDeleteBtn" class="btn-delete" onclick="if(confirm('Are you sure you want to delete this person?')) { window.location.href='delete_person.php?id=' + document.getElementById('update_id').value; }" style="display: none;">Delete</button>
            </form>
        </div>
    </div>

    <script>
        var customerId = <?php echo $customer_id ? $customer_id : 'null'; ?>;
        
        function openUpdateModal(id, first_name, last_name, phone_number, email) {
            document.getElementById('update_id').value = id;
            document.getElementById('update_first_name').value = first_name;
            document.getElementById('update_last_name').value = last_name;
            document.getElementById('update_phone_number').value = phone_number;
            document.getElementById('update_email').value = email;
            document.getElementById('updateDeleteBtn').style.display = 'inline-block';
            document.getElementById('updateModal').classList.add('show');
        }
        
        function getDeleteUrl(id) {
            if (customerId) {
                return 'delete_person.php?id=' + id + '&customer=' + customerId;
            }
            return 'delete_person.php?id=' + id;
        }
        
        document.getElementById('updateDeleteBtn').onclick = function() {
            var id = document.getElementById('update_id').value;
            if (confirm('Are you sure you want to delete this person?')) {
                window.location.href = getDeleteUrl(id);
            }
        };
    </script>
</body>
</html>
