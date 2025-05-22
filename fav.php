<?php
include_once "db.php";
session_start();

// Check login
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get favorite meals for the logged-in user
$sql = "SELECT meals.* 
        FROM meals 
        JOIN favorites ON meals.meal_ID = favorites.meal_id 
        WHERE favorites.user_id = '$user_id'";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Favorites</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .favorites-container {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .meal-card {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 15px;
        }

        .meal-card img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
        }

        .meal-card h3 {
            margin: 0;
            color: #1A535C;
        }

        .meal-card p {
            margin: 5px 0;
            color: #555;
        }
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
.search-container {
    margin-left: auto;
    display: flex;
    align-items: center;
}

#search-form input {
    width: 130px;
    padding: 5px;
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
}/* Footer */
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
      
    </style>
    </style>
</head>
<body>

<nav>
    <a href="Home.php">Home</a>
    <a href="profile1.php">Profile</a>
    <a href="fav.php">Favorites</a>
    <a href="logout.php" style="color: red;">Logout</a>
</nav>

<div class="favorites-container">
    <h2 style="color:#FF6F61; text-align:center;">My Favorite Meals</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($meal = $result->fetch_assoc()): ?>
            <div class="meal-card">
                <img src="img/<?php echo htmlspecialchars($meal['image']); ?>" alt="Meal">
                <div>
                    <h3><?php echo htmlspecialchars($meal['name']); ?></h3>
                    <p><?php echo htmlspecialchars($meal['description']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">You haven’t added any meals to favorites yet.</p>
    <?php endif; ?>
</div>

 <!--footer part-->
    <footer>
        <p>&copy; 2025 Meal Planner. All rights reserved.</p>
    </footer>

</body>
</html>
