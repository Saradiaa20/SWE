<?php include 'db.php'; 
$query = $_GET['query'];
$sql = "SELECT * FROM meals WHERE name LIKE '%$query%' OR diet_type LIKE '%$query%' OR ingredients LIKE '%$query%' OR description LIKE '%$query%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="styles.css">
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
    margin-top: 50%;
}

footer p {
    margin: 0;
}

.mySwiper {
    display: flex;
    flex-direction: row;
    margin-top: 20px;
}
.cards {
    display: flex;
    flex-direction: row;
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
        <?php if (isset($_SESSION['name'])=="admin"): ?>
            <a href="admin.php">Home</a>
        <?php else: ?>
            <a href="Home.php">Home</a>
        <?php endif; ?>
        <a href="profile1.php">Profile</a>
        <?php if (isset($_SESSION['name'])): ?>
            <a href="fav.php">Favorits</a>
            <a href="logout.php">Logout</a>
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
    <h1>Search Results for "<?php echo $query; ?>"</h1>
    <div class="cards">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='meal-card'>
            <img src='img/" . $row['image'] . "' alt='Meal Image' class='meal-image'>
                    <h3>{$row['name']}</h3>
                    <p>{$row['description']}</p>
                    <a href='meal.php?meal_ID={$row['meal_ID']}'>View Recipe</a>
                  </div>";
        }
    } else {
        echo "<p>No meals found.</p>";
    }
    ?>
    </div>
    <footer>
        <p>&copy; 2025 Meal Planner. All rights reserved.</p>
    </footer>
</body>
</html>