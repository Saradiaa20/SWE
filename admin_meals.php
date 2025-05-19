<?php
include_once 'db.php';
session_start();

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Block non-admins
if ($_SESSION['name'] !== 'admin') {
    header("Location: Home.php");
    exit();
}

// Get all meals
$meals = mysqli_query($conn, "SELECT * FROM meals");

// Optional: handle add/edit/delete here
// Handle Add Meal
if (isset($_POST['add_meal'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $recipe = $_POST['recipe'];
    $serving = $_POST['serving'];
    $calories = $_POST['calories'];
    $fats = $_POST['fats'];
    $protein = $_POST['protein'];
    $carbs = $_POST['carbs'];
    $diet = $_POST['diet_type'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "uploads/$image");

    $sql = "INSERT INTO meals (name, description, ingredients, recipe, serving, calories, fats, protein, carbs, diet_type, image)
            VALUES ('$name', '$desc', '$ingredients', '$recipe', '$serving', '$calories', '$fats', '$protein', '$carbs', '$diet', '$image')";
    mysqli_query($conn, $sql);
    header("Location: admin_meals.php");
    exit();
}

// Handle Edit Meal
if (isset($_POST['edit_meal'])) {
    $id = $_POST['meal_id'];
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $recipe = $_POST['recipe'];
    $serving = $_POST['serving'];
    $calories = $_POST['calories'];
    $fats = $_POST['fats'];
    $protein = $_POST['protein'];
    $carbs = $_POST['carbs'];
    $diet = $_POST['diet_type'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "uploads/$image");
        $img_sql = ", image='$image'";
    } else {
        $img_sql = "";
    }

    $sql = "UPDATE meals SET
        name='$name', description='$desc', ingredients='$ingredients', recipe='$recipe',
        serving='$serving', calories='$calories', fats='$fats', protein='$protein',
        carbs='$carbs', diet_type='$diet' $img_sql WHERE meal_ID=$id";
    mysqli_query($conn, $sql);
    header("Location: admin_meals.php");
    exit();
}

// Handle Delete Meal
if (isset($_POST['delete_meal'])) {
    $id = $_POST['meal_id'];
    mysqli_query($conn, "DELETE FROM meals WHERE meal_ID=$id");
    header("Location: admin_meals.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #F7FFF7;
        }

        .container {
            background-color: white;
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        h1 {
            text-align: center;
            color: #1A535C;
            margin-bottom: 20px;
        }

        .container {
    max-width: 1100px;
    margin: 50px auto;
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    position: relative;
}

.add-meal-btn {
    position: absolute;
    right: 30px;
    top: 30px;
    background-color: #4ECDC4;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
}

.meal-card {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 15px;
}

.meal-thumb {
    width: 120px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    margin-right: 20px;
}

.meal-info h2 {
    margin: 0;
    font-size: 1.2rem;
    color: #1A535C;
}

.meal-info p {
    margin: 5px 0;
    color: #555;
}

.meal-info button {
    margin-top: 10px;
    margin-right: 10px;
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    color: white;
    cursor: pointer;
}

.meal-info button:first-of-type {
    background-color: #4ECDC4;
}

.meal-info button:last-of-type {
    background-color: #FF6F61;
}


        .action-btn {
            margin: 0 5px;
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: white;
        }

        .edit-btn {
            background-color: #4ECDC4;
        }

        .delete-btn {
            background-color: #FF6F61;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            max-width: 90%;
        }

        .modal-content h2 {
            margin-top: 0;
            color: #1A535C;
        }

        .modal-content label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        .modal-content input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal-content button {
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #4ECDC4;
            border: none;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #FF6F61;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Meals</h1>
    <button class="add-meal-btn" onclick="openModal('addMealModal')"><i class="fas fa-plus"></i> Add Meal</button>

    <?php while ($meal = mysqli_fetch_assoc($meals)): ?>
    <div class="meal-card">
        <img src="img/<?= $meal['image'] ?>" class="meal-thumb" alt="Meal image">
        <div class="meal-info">
            <h2><?= $meal['name'] ?></h2>
            <p><?= $meal['description'] ?></p>
            <button onclick="openEditMeal(<?= $meal['meal_ID'] ?>)">Edit</button>
            <button onclick="openDeleteMeal(<?= $meal['meal_ID'] ?>)">Delete</button>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<!-- Edit Meal Modal -->
<div class="modal" id="editMealModal">
  <div class="modal-content">
    <h2>Edit Meal</h2>
    <form method="POST" action="admin_meals.php" enctype="multipart/form-data">
      <input type="hidden" name="edit_meal" value="1">
      <input type="hidden" name="meal_id" id="edit_meal_id">
      <label>Name</label><input name="name" id="edit_name" required>
      <label>Description</label><input name="description" id="edit_description" required>
      <label>Ingredients</label><input name="ingredients" id="edit_ingredients" required>
      <label>Recipe</label><input name="recipe" id="edit_recipe" required>
      <label>Serving</label><input name="serving" id="edit_serving" required>
      <label>Calories</label><input name="calories" id="edit_calories" required>
      <label>Fats</label><input name="fats" id="edit_fats" required>
      <label>Protein</label><input name="protein" id="edit_protein" required>
      <label>Carbs</label><input name="carbs" id="edit_carbs" required>
      <label>Diet Type</label><input name="diet_type" id="edit_diet" required>
      <label>Image</label><input type="file" name="image" accept="image/*">
      <button type="submit">Save Changes</button>
    </form>
  </div>
</div>


<!-- Delete Meal Modal -->
<div class="modal" id="deleteMealModal">
  <div class="modal-content">
    <h2>Confirm Delete</h2>
    <form method="POST" action="admin_meals.php">
      <input type="hidden" name="delete_meal" value="1">
      <input type="hidden" name="meal_id" id="delete_meal_id">
      <p>Are you sure you want to delete this meal?</p>
      <button type="submit">Yes, Delete</button>
    </form>
  </div>
</div>


<!-- Add Meal Modal -->
<div class="modal" id="addMealModal">
  <div class="modal-content">
    <h2>Add New Meal</h2>
    <form method="POST" action="admin_meals.php" enctype="multipart/form-data">
      <input type="hidden" name="add_meal" value="1">
      <label>Name</label><input name="name" required>
      <label>Description</label><input name="description" required>
      <label>Ingredients</label><input name="ingredients" required>
      <label>Recipe</label><input name="recipe" required>
      <label>Serving</label><input name="serving" required>
      <label>Calories</label><input name="calories" required>
      <label>Fats</label><input name="fats" required>
      <label>Protein</label><input name="protein" required>
      <label>Carbs</label><input name="carbs" required>
      <label>Diet Type</label><input name="diet_type" required>
      <label>Image</label><input type="file" name="image" accept="image/*" required>
      <button type="submit">Create Meal</button>
    </form>
  </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script>
function openEditMeal(id, name, description, ingredients, recipe, serving, calories, fats, protein, carbs, diet) {
    document.getElementById('edit_meal_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_ingredients').value = ingredients;
    document.getElementById('edit_recipe').value = recipe;
    document.getElementById('edit_serving').value = serving;
    document.getElementById('edit_calories').value = calories;
    document.getElementById('edit_fats').value = fats;
    document.getElementById('edit_protein').value = protein;
    document.getElementById('edit_carbs').value = carbs;
    document.getElementById('edit_diet').value = diet;
    document.getElementById('editMealModal').style.display = 'flex';
}

function openDeleteMeal(id) {
    document.getElementById('delete_meal_id').value = id;
    document.getElementById('deleteMealModal').style.display = 'flex';
}

function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}

function closeModals() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.style.display = 'none';
    });
}

window.addEventListener('click', function(e) {
    document.querySelectorAll('.modal').forEach(modal => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>


</body>
</html>


