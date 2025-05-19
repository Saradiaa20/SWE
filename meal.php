<?php include 'db.php'; 
$ID = $_GET['ID'];
$sql = "SELECT * FROM meals WHERE meal_ID = $ID";
$result = $conn->query($sql);
$meal = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $meal['name']; ?></title>
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
        <?php if (isset($_SESSION['username'])): ?>
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
    <h1><?php echo $meal['name']; ?></h1>
    <div class="meal-details">
        <h2>Ingredients</h2>
        <p><?php echo $meal['ingredients']; ?></p>
        <h2>Recipe</h2>
        <p><?php echo $meal['recipe']; ?></p>
        <h2>Nutritional Information</h2>
        <p>Calories: <?php echo $meal['calories']; ?></p>
        <p>Fats: <?php echo $meal['fats']; ?>g</p>
        <p>Protein: <?php echo $meal['protein']; ?>g</p>
        <p>Carbs: <?php echo $meal['carbs']; ?>g</p>
        <h2>Suitable For</h2>
        <p><?php echo $meal['diet_type']; ?></p>
    </div>
    <footer>
        <p>&copy; 2025 Meal Planner. All rights reserved.</p>
    </footer>
</body>
</html>