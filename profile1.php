<?php 
session_start();
include_once "includes/dbh.inc.php"; 

// Ensure the user is logged in
if (!isset($_SESSION["id"])) {
    header("Location: signinup.php"); // Redirect to login if not logged in
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION["id"];

// Query to get the logged-in user's details
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

//$stmt->close();
//$conn->close();
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
</head>
<body>
<nav>
        <a href="Home.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="fav.php">Favorits</a>
        <?php if (isset($_SESSION['username'])): ?>
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

                <?php if (!empty($user['profile_image'])): ?>
                    <img src="img/<?php echo htmlspecialchars($user['profile_image']); ?>" 
                    alt="Profile Picture" class="profile-picture">
                <?php else: ?>
                    <img src="img/default-profile.jpg" 
                    alt="Default Profile Picture" class="profile-picture">
                <?php endif; ?>

                <!-- <img src="pics/WIN_20240811_01_31_40_Pro.jpg" alt="Profile Picture" class="profile-picture"> -->
                
                <label for="profile_image" style="border-bottom: none;">
                <input type="file" id="profile_image" name="profile_image" accept="image/*" form="editProfileForm">
                </label>
            </div>
            <form action="profile-edit.php" method="post" enctype="multipart/form-data" id="editProfileForm" onsubmit="return validateForm()">
                <label for="name">First Name:
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user["first_name"]); ?>" required>
                </label>
                <br>
                <label for="last_name">Last Name:
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user["last_name"]); ?>" required>
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
                <label for="phone">Mobile Number:
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user["phone"]); ?>" required>
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