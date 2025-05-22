<?php
include 'db.php';
session_start();
$user_id = $_SESSION["id"];
$meal_id = $_POST['meal_id'];
mysqli_query($conn, "INSERT INTO favorites (user_id, meal_id) VALUES ('$user_id', '$meal_id')");
header("Location: fav.php");
