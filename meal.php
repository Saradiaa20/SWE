<?php include 'db.php'; 
$ID = $_GET['ID'];
$sql = "SELECT * FROM meals WHERE ID = $ID";
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
</head>
<body>
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
</body>
</html>