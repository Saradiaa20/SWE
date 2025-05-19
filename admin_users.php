<?php
include 'db.php';
session_start();

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


// Optional: block access if not admin
if ($_SESSION['name'] !== 'admin') {
    header("Location: Home.php");
    exit();
}

// Get all users
$users = mysqli_query($conn, "SELECT * FROM users");
if (!$users) {
    die("Query failed: " . mysqli_error($conn));
}

// Handle Add User
if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $diet = $_POST['diet'];
    $sql = "INSERT INTO users (name, email, password, role, diet_type) VALUES ('$name', '$email', '$password', '$role', '$diet)";
    mysqli_query($conn, $sql);
    header("Location: admin_users.php");
    exit();
}

// Handle Edit User
if (isset($_POST['edit_user'])) {
    $id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $diet = $_POST['diet'];
    $sql = "UPDATE users SET name='$name', email='$email', role='$role', diet='$diet' WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: admin_users.php");
    exit();
}

// Handle Delete User
if (isset($_POST['delete_user'])) {
    $id = $_POST['user_id'];
    $sql = "DELETE FROM users WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: admin_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #F7FFF7;
        }

        .container {
            background-color: white;
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        h1 {
            text-align: center;
            color: #1A535C;
            margin-bottom: 20px;
        }

        .add-user-btn {
            position: absolute;
            top: 30px;
            right: 30px;
            background-color: #4ECDC4;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
        }

        .add-user-btn:hover {
            background-color: #FF6F61;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #1A535C;
            color: white;
        }

        .action-btn {
            margin: 0 5px;
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: white;
        }

        .edit-btn {
            background-color: #4ECDC4;
        }

        .delete-btn {
            background-color: #FF6F61;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            max-width: 90%;
        }

        .modal-content h2 {
            margin-top: 0;
            color: #1A535C;
        }

        .modal-content label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        .modal-content input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal-content button {
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #4ECDC4;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #FF6F61;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Users</h1>
    <button class="add-user-btn" onclick="openModal('addUserModal')"><i class="fas fa-user-plus"></i> Add User</button>

    <table>
        <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Diet Type</th><th>Actions</th>
        </tr>
        </thead>
        <tbody>
            <?php while ($user = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td><?= $user['diet'] ?></td>
                    <td>
                        <button class="action-btn edit-btn" onclick="openEditModal(<?= $user['id'] ?>, '<?= $user['name'] ?>', '<?= $user['email'] ?>', '<?= $user['role'] ?>', '<?= $user['diet'] ?>')">Edit</button>
                        <button class="action-btn delete-btn" onclick="openDeleteModal(<?= $user['id'] ?>)">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>
</div>

<!-- Edit User Modal -->
<div class="modal" id="editUserModal">
    <div class="modal-content">
        <span onclick="closeModals()" style="cursor:pointer; float:right; font-weight:bold; font-size:18px;">&times;</span>
        <h2>Edit User</h2>
        <form method="POST" action="admin_users.php">
            <input type="hidden" name="edit_user" value="1">
            <input type="hidden" name="user_id" id="edit_user_id">
            <label>Name</label><input type="text" name="name" id="edit_name" required>
            <label>Email</label><input type="email" name="email" id="edit_email" required>
            <label>Role</label><input type="text" name="role" id="edit_role" required>
            <label>Diet Type</label><input type="text" name="diet" id="edit_diet" required>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteConfirmModal">
    <div class="modal-content">
        <span onclick="closeModals()" style="cursor:pointer; float:right; font-weight:bold; font-size:18px;">&times;</span>
        <h2>Confirm Delete</h2>
        <form method="POST" action="admin_users.php">
            <input type="hidden" name="delete_user" value="1">
            <input type="hidden" name="user_id" id="delete_user_id">
            <p>Are you sure you want to delete this user?</p>
            <button type="submit">Yes, Delete</button>
        </form>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal" id="addUserModal">
    <div class="modal-content">
        <span onclick="closeModals()" style="cursor:pointer; float:right; font-weight:bold; font-size:18px;">&times;</span>
        <h2>Add New User</h2>
        <form method="POST" action="admin_users.php">
            <input type="hidden" name="add_user" value="1">
            <label>Name</label><input type="text" name="name" placeholder="Enter name" required>
            <label>Email</label><input type="email" name="email" placeholder="Enter email" required>
            <label>Password</label><input type="password" name="password" placeholder="Enter password" required>
            <label>Role</label><input type="text" name="role" placeholder="Enter role" required>
            <label>Diet Type</label><input type="text" name="diet" placeholder="Enter diet type" required>
            <button type="submit">Create User</button>
        </form>
    </div>
</div>


<script>
function openEditModal(id, name, email, role, diet) {
    document.getElementById('edit_user_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;
    document.getElementById('edit_diet').value = diet;
    document.getElementById('editUserModal').style.display = 'flex';
}

function openDeleteModal(id) {
    document.getElementById('delete_user_id').value = id;
    document.getElementById('deleteConfirmModal').style.display = 'flex';
}

function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}

function closeModals() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.style.display = 'none';
    });
}

window.addEventListener('click', function(e) {
    document.querySelectorAll('.modal').forEach(modal => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>


</body>
</html>

