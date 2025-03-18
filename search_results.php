<?php include 'db.php'; 
$query = $_GET['query'];
$sql = "SELECT * FROM meals WHERE name LIKE '%$query%' OR diet_type LIKE '%$query%' OR ingredients LIKE '%$query%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Search Results for "<?php echo $query; ?>"</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='meal-card'>
                    <h3>{$row['name']}</h3>
                    <p>{$row['description']}</p>
                    <a href='meal.php?meal_ID={$row['meal_ID']}'>View Recipe</a>
                  </div>";
        }
    } else {
        echo "<p>No meals found.</p>";
    }
    ?>
</body>
</html>