<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Planner</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <a href="Home.php">Home</a>
        <a href="search.php">Search Meals</a>
        <a href="meal_plan.php">Meal Plan Generator</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <form action="search_results.php" method="GET">
        <input type="text" name="query" placeholder="Search by name, diet, or ingredients..." required>
        <button type="submit">Search</button>
    </form>
    </nav>
    <h1>Welcome to Your Meal Planner!</h1>
    <section class="recommendations">
        <h2>Today's Recommendations</h2>
        <?php
        $sql = "SELECT * FROM meals LIMIT 5";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='meal-card'>
                        <h3>{$row['name']}</h3>
                        <p>{$row['description']}</p>
                        <a href='meal.php?ID={$row['meal_ID']}'>View Recipe</a>
                      </div>";
            }
        } else {
            echo "<p>No meals found.</p>";
        }
        ?>
    </section>
    <footer>
        <p>&copy; 2025 Meal Planner. All rights reserved.</p>
    </footer>
</body>
</html>