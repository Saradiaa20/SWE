<?php include 'db.php';
session_start(); 
// // Ensure the user is logged in
// if (!isset($_SESSION["id"])) {
//     header("Location: login.php"); // Redirect to login if not logged in
//     exit();
// }

// // Get the user ID from the session
// $id = $_SESSION["id"];

// Query to get the logged-in user's details
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// $sql = "SELECT * FROM users WHERE id = '$id'";

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    $welcomeMessage = "Welcome, " . htmlspecialchars($_SESSION['name']) . "!";
} else {
    $welcomeMessage = "Welcome, Guest!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Planner</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>/* General Styles */
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
    justify-content: space-between;
    align-items: center;
    text-align: center;
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

#search-btn {
    background-color: #FF6F61; /* Turquoise */
    color: #1A535C; /* White */
    padding: 1px;
    border-radius: 5px;
    width: 10px;
}

#search-form {
    position: absolute;
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
    width: 150px; /* Adjust width as needed */
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

.meal-card {
    background-color: #FFFFFF; /* White */
    width: 300px;
    height: 350px;
    padding: 20px 0 0 0;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 0 0 0 50px;
    text-align: center;
}

.meal-image {
    align-items: center;
    width: 150px; /* Adjust as needed */
    height: 150px; /* Adjust as needed */
    border-radius: 10px; /* Optional */
    object-fit: cover; /* Ensure the image covers the area */
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

.mySwiper {
    display: flex;
    flex-direction: row;
    margin-top: 20px;
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
    .meal-image {
        width: 50%;
        height: 20px;
    }
}</style>
</head>
<body>
    <nav>
        <a href="Home.php">Home</a>
        <a href="profile1.php">Profile</a>
        <!-- <a href="fav.php">Favorits</a> -->
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
    <h1><?php echo $welcomeMessage; ?></h1>
    <br><br>
    <section class="recommendations">
        <h2>Today's Recommendations</h2>
        <div class="swiper mySwiper">
        <div class="swiper-wrapper">
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30"
        centered-slides="true" autoplay-delay="2500" autoplay-disable-on-interaction="false">
        <?php
        $sql = "SELECT * FROM meals LIMIT 4";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='meal-card'>
                <img src='img/" . $row['image'] . "' alt='Meal Image' class='meal-image'>
                        <h3>{$row['name']}</h3>
                        <p>{$row['description']}</p>
                        <a href='meal.php?ID={$row['meal_ID']}'>View Recipe</a>
                      </div>";
            }
        } else {
            echo "<p>No meals found.</p>";
        }
        ?>
        </swiper-container>
        </div>
        
        <div class="swiper-pagination"></div>
            <!-- Add Navigation Buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <br><br><br><br>
    <section class="recommendations">
        <h2>Pasta Dishes</h2>
        <div class="swiper mySwiper">
        <div class="swiper-wrapper">
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" space-between="30"
        centered-slides="true" autoplay-delay="2500" autoplay-disable-on-interaction="false">
        <?php
        $sql = "SELECT * FROM meals WHERE description LIKE '%pasta%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='meal-card'>
                <img src='img/" . $row['image'] . "' alt='Meal Image' class='meal-image'>
                        <h3>{$row['name']}</h3>
                        <p>{$row['description']}</p>
                        <a href='meal.php?ID={$row['meal_ID']}'>View Recipe</a>
                      </div>";
            }
        } else {
            echo "<p>No meals found.</p>";
        }
        ?>
        </swiper-container>
        </div>
        
        <div class="swiper-pagination"></div>
            <!-- Add Navigation Buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
    <footer>
        <p>&copy; 2025 Meal Planner. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>document.addEventListener('DOMContentLoaded', function () {
    console.log("JavaScript is running!"); // Add this line
    const searchIcon = document.getElementById('search-icon');
    const searchForm = document.getElementById('search-form');

    searchIcon.addEventListener('click', function (event) {
        console.log("Search icon clicked!"); // Add this line
        event.stopPropagation();
        searchForm.classList.toggle('active');
    });

    document.addEventListener('click', function (event) {
        if (!searchForm.contains(event.target)) {
            searchForm.classList.remove('active');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
            // Initialize Swiper
            const swiper = new Swiper('.mySwiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
</script>
</body>
</html>