<?php

include_once "db.php";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

h1, h2, h3 {
    color: #FF6F61; /* Coral for headings */
    margin-bottom: 20px;
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
    justify-content: space-between;
    align-items: center;
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

/* Search Container */
div .search-container {
    width: 10px;
    position: relative;
    display: flex;
    align-items: center;
    margin-left: auto; /* Align to the right */
}

#search-icon {
    color: #F7FFF7; /* Light text */
    cursor: pointer;
    font-size: 1.2rem; /* Adjust size as needed */
}

#search-form {
    position: absolute;
    width: 10px;
    top: 100%;
    right: 0;
    background-color: #FFFFFF; /* White */
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 10px;
    z-index: 10;
    display: none; /* Initially hidden */
}

#search-form.active {
    display: block; /* Show when active */
}

#search-form input {
    width: 50px; /* Adjust width as needed */
    padding: 1px; /* Smaller padding */
    border: 1px solid #1A535C; /* Dark teal */
    border-radius: 5px;
    outline: none;
}

.meal-card:hover {
    transform: translateY(-5px);
}

.meal-card h3 {
    margin-top: 0;
    color: #1A535C; /* Dark teal */
}

.meal-card p {
    color: #4ECDC4; /* Turquoise */
}

.meal-card a {
    display: inline-block;
    background-color: #4ECDC4; /* Turquoise */
    color: #FFFFFF; /* White */
    padding: 10px 15px;
    border-radius: 5px;
    margin-top: 10px;
}

.meal-card a:hover {
    background-color: #FF6F61; /* Coral */
}

/* Forms */
form {
    background-color: #FFFFFF; /* White */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px 0;
}

input, select, button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #1A535C; /* Dark teal */
    border-radius: 5px;
    font-family: 'Poppins', sans-serif;
}

button {
    background-color: #4ECDC4; /* Turquoise */
    color: #FFFFFF; /* White */
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    background-color: #FF6F61; /* Coral */
}

/* Search Results */
.search-results {
    margin-top: 20px;
}

/* Meal Details */
.meal-details {
    background-color: #FFFFFF; /* White */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px 0;
}

.meal-details h2 {
    color: #1A535C; /* Dark teal */
}

.meal-details p {
    color: #4ECDC4; /* Turquoise */
}

/* User Account Pages */
.login-form, .register-form {
    max-width: 400px;
    margin: 0 auto;
    text-align: center;
}

.login-form h1, .register-form h1 {
    color: #1A535C; /* Dark teal */
}

.logincontainer {
    width: 50%;
    margin: 0 auto;
    background-color: rgba(245, 245, 220, 0.664);
}

/* Footer */
footer {
    background-color: #1A535C; /* Dark teal */
    color: #F7FFF7; /* Light text */
    text-align: center;
    padding: 20px 0;
    margin-top: 40px;
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

    .meal-card {
        padding: 15px;
    }

    .meal-details {
        padding: 15px;
    }
}
        img {
            justify-content: center;
            width: 100px;
            height: 100px;
            border-radius: 50%;
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
        <a href="fav.php">Favorits</a>
        <?php if (isset($_SESSION['name'])): ?>
            <a href="logout.php">Logout</a> <!-- Add a logout link for logged-in users -->
        <?php else: ?>
            <a href="create.php">Sign Up</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
        <div class="search-container">
            <i class="fas fa-search" id="search-icon"></i>
            <form action="search_results.php" method="GET" id="search-form">
                <input type="text" name="query" placeholder="Search..." required>
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>
    </nav>
        <div class="main-content">
            <h2 class="profileText">Profile Details</h2>
            <div class="profile-picture">

                <?php if (!empty($user['image'])): ?>
                    <img src="img/<?php echo htmlspecialchars($user['image']); ?>"
                    alt="Profile" class="profile-picture">
                <?php else: ?>
                    <img src="img/default-profile.png"
                    alt="Default Profile" class="profile-picture">
                <?php endif; ?>
                
                <label for="profile_image" style="border-bottom: none;">
                <input type="file" id="profile_image" name="profile_image" accept="image/*" form="editProfileForm">
                </label>
            </div>
            <form action="profile-edit.php" method="post" enctype="multipart/form-data" id="editProfileForm" onsubmit="return validateForm()">
                <label for="name">First Name:
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>" required>
                </label>
                <br>
                <label for="email">Email:
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>"required>
                </label>
                <br>
                <label for="password">Password:
                <input type="password" id="password" name="password"  value="<?php echo htmlspecialchars($user["password"]); ?>" required>
                </label>
                <br>
                <label for="diet">Mobile Number:
                <input type="text" id="diet" name="diet" value="<?php echo htmlspecialchars($user["diet"]); ?>" required>
                </label>
                <br><br><br>
                <input type="submit" value="Save Changes">
            </form>
        </div>
    </div>

    <!--footer part-->
    <footer>
        <p>&copy; 2025 Meal Planner. All rights reserved.</p>
    </footer>

    <script>
    function validateForm() {
        // Get form inputs
        const Name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const phone = document.getElementById('diet').value.trim();

        // Check if any field is empty
        if (!Name || !email || !diet) {
            alert('Please fill in all required fields.');
            return false; // Prevent form submission
        }

        // Optionally: you can add more validations like email or phone format

        return true; // Allow form submission
    }
</script>

</body>
</html>