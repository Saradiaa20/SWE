<?php
include_once 'db.php';
session_start();

// Check if session already has ID
if (!isset($_SESSION["id"])) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}

$id = $_SESSION["id"];

// Connect to DB
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user data
$sql = "SELECT * FROM users WHERE id = '$id'";
$result = $conn->query($sql);

if ($result && $result->num_rows == 1) {
    $user = $result->fetch_assoc(); // now $user is an array

    // You can now safely do this
    $_SESSION["name"] = $user['name']; // store name for greeting
} else {
    echo "User not found.";
    exit();
}

// Greeting message
if (isset($_SESSION['name'])) {
    $welcomeMessage = "Welcome, " . htmlspecialchars($_SESSION['name']) . "!";
} else {
    $welcomeMessage = "Welcome, Guest!";
}

if ($_SESSION['name'] !== 'admin') {
    header("Location: Home.php"); // block non-admin users
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Planner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
/* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #F7FFF7; /* Light background */
    color: #1A535C; /* Dark text */
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

h1{
    text-align: center;
    color: #FF6F61; /* Coral for headings */
    margin-bottom: 20px;
}

h2, h3 {
    text-align: left;
    color: #FF6F61; /* Coral for headings */
    margin: 20px 40px;
}

a {
    color: #4ECDC4; /* Turquoise for links */
    text-decoration: none;
}

a:hover {
    color: #FF6F61; /* Coral on hover */
}

/* Container */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Header */
header {
    background-color: #1A535C; /* Dark teal */
    color: #F7FFF7; /* Light text */
    padding: 20px 0;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 2.5rem;
}

/* Navigation Bar */
nav {
    display: flex;
    justify-content:left;
    align-items: center;
    text-align: left;
    background-color: #1A535C; /* Dark teal */
    padding: 10px 20px;
    position: relative;
}

nav a {
    color: #F7FFF7; /* Light text */
    text-decoration: none;
    margin: 0 15px;
    font-weight: bold;
}

nav a:hover {
    color: #FF6F61; /* Coral on hover */
}

.admin-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 60px;
    gap: 40px;
    flex-wrap: wrap;
}

.admin-btn {
    background-color: #4ECDC4;
    color: white;
    width: 180px;
    height: 180px;
    border-radius: 30px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-weight: bold;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, background-color 0.3s ease;
}

.admin-btn i {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.admin-btn:hover {
    transform: scale(1.1);
    color: #F7FFF7;
    background-color: #FF6F61;
}

.admin-btn:active {
    transform: scale(0.9);
}



/* Footer */
footer {
    background-color: #1A535C; /* Dark teal */
    color: #F7FFF7; /* Light text */
    text-align: center;
    padding: 20px 0;
    margin-top: 40vh;
}

footer p {
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    header h1 {
        font-size: 2rem;
    }

    nav a {
        display: block;
        margin: 10px 0;
    }
}
</style>
</head>
<body>
    <nav>
        <?php if (isset($_SESSION['name'])=="admin"): ?>
            <a href="admin.php">Home</a>
        <?php else: ?>
            <a href="Home.php">Home</a>
        <?php endif; ?>
        <a href="profile1.php">Profile</a>
        <?php if (isset($_SESSION['name'])): ?>
            <a href="logout.php" style="color: red;">Logout</a>
        <?php else: ?>
            <a href="create.php">Sign Up</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
    <h1><?php echo $welcomeMessage; ?></h1>
    <br><br>

    <div class="admin-buttons">
        <a href="admin_users.php" class="admin-btn">
            <i class="fas fa-users"></i>
            <span>Manage Users</span>
        </a>
        <a href="admin_meals.php" class="admin-btn">
            <i class="fas fa-utensils"></i>
            <span>Manage Meals</span>
        </a>
    </div>



    <footer>
        <p>&copy; 2025 Meal Planner. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>document.addEventListener('DOMContentLoaded', function () {
    console.log("JavaScript is running!"); // Add this line
    

    document.addEventListener('click', function (event) {
        if (!searchForm.contains(event.target)) {
            searchForm.classList.remove('active');
        }
    });
});

</script>
</body>
</html>
