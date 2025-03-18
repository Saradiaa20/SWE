<?php 
session_start();
include "db.php"; 

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        // Handle sign-up logic
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Securely hash password
        $diet = $_POST["diet"];

        // Prepare and execute the SQL INSERT statement
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, diet) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $password, $diet);

        if ($stmt->execute()) {
            echo "Registration successful! You can now sign in.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['signin'])) {
        // Handle sign-in logic
        $email = $_POST["email"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row["password"])) {
                $_SESSION["id"] = $row["id"];
                $_SESSION["name"] = $row["name"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["diet"] = $row["diet"];
                if($_SESSION["id"] == 1){
                  header("Location: AdminPage.php?login=success");
                }
                else if($_SESSION["id"] >= 2){
                  header("Location: Home.php?login=success");
                }
                
                exit;
            } else {
                echo "Invalid Password.";
            }
        } else {
            echo "Invalid Email.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="sign-in-form" method="post">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" required placeholder="Email" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" required placeholder="Password" />
            </div>
            <input type="submit" name="signin" value="Login" class="btn solid" />
          </form>

          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="sign-up-form" method="post">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="name" required placeholder="Name" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" required placeholder="Email" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" required placeholder="Password" />
            </div>
            <div class="input-field">
              <i class="fas fa-phone"></i>
              <input type="text" name="diet" required placeholder="Diet Type">
            </div>
            <input type="submit" name="signup" value="Sign up" class="btn" />
          </form>

        </div>
      </div>
      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p></p>
            
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
           </div> 
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p></p>
            
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
        </div>
      </div>
    </div>
    <script src="app.js"></script>
  </body>
</html>