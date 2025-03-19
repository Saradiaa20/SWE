<?php 
session_start();
include_once "includes/dbh.inc.php"; 

// Ensure the user is logged in
if (!isset($_SESSION["id"])) {
    header("Location: signinup.php"); // Redirect to login if not logged in
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION["id"];

// Query to get the logged-in user's details
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

//$stmt->close();
//$conn->close();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>


        body {
    font-family: Arial, sans-serif;
    background-color: #f1eee7; /* Main screen background color */
    margin: 0;
    padding: 0;
}


/* Container */
.container {
    display: flex;
}

/* Sidebar Styles */
.sidebar {
    width: 230px;
    height: 100%;
    font-size: 20px;
    background-color: #9b784886;
    /*background-color: #231F20; */
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    margin-left: 60px;
    margin-right: 30px;
    margin-top: 100px;
    border-radius: 5px;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar ul li {
    margin: 15px 0 30px;
}

.sidebar ul li a {
    /* color: #9B7848;  */
    /* Light brown color for links */
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

.sidebar ul li a:hover {
    color: #f1eee7; 
}


/* Main Content Styles */
.main-content {
    flex: 1;
    padding: 20px;
    background-color: #ffffff; 
    /* background-color: #f1eee7;  */
    /*box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);*/
    border-radius: 5px;
    margin-left: 20px;
    margin-right: 40px;
    margin-top: 50px;
    margin-bottom: 20px;
}

h2 {
    text-align: center;
    color: #9b7848; 
}

.profileText {
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    text-align: center;
    color: #9b7848;
}

/* Profile Pic */
.profile-picture {
    text-align: center;
    margin-bottom: 20px;
}

.profile-picture img {
    width: 100px;
    height: 100px;
    margin-bottom: 10px;
}

.profile-picture label {
    display: block;
    margin-bottom: 10px;
}

.profile-picture input[type="file"] {
    display: none;
}

.profile-picture label::before {
    content: "Upload Picture";
    display: inline-block;
    background-color:  #9B7848;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.profile-picture label:hover::before {
    background-color: #444;
}


/* Form Styles */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    font-size: large;
    font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    margin: 10px 10px 5px 0;
    align-content: center;
    border-bottom: 1px solid #9b784886;
}

input[type="text"],
input[type="email"],
input[type="password"],
textarea {
    padding: 10px;
    width: 250px;
    font-size: large;
    border: none;
    margin-bottom: 15px;
    margin-left: 100px;
}

input[type="submit"] {
    background-color: #9B7848; 
    color: #ffffff; 
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    width: 250px;
    justify-content: center;
}

input[type="submit"]:hover {
    background-color: #1F4A54; 
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #9B7848; 
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #1F4A54; 
    color: #ffffff; 
}

tr:nth-child(even) {
    background-color: #f1eee7; 
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%; /* Full width sidebar on small screens */
        height: auto;
        position: relative; /* Remove fixed position */
    }

    .main-content {
        margin-left: 0; /* No margin on small screens */
    }
}

::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #f1eee7;
}

::-webkit-scrollbar-thumb {
    background: #9B7848;
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: #1F4A54;
}

/* Nav bar style */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #9b7848;
    padding: 15px;
    position: sticky;
    top: 0;
    z-index: 1000;
    height: 60px;
}

.navbar .logo {
            display: flex; 
            align-items: center; 
        }

        .navbar .logo img {
            width: auto;  
            height: 70px;  
            margin-right: 20px; 
        }
.navbar nav ul {
    list-style: none;
    display: flex;
}

.navbar nav ul li {
    margin: 0 10px;
}

.navbar nav ul li a {
    color: #fff;
    text-decoration: none;
    text-transform: uppercase;
    padding: 10px 15px;
    transition: background-color 0.3s ease;
}

.navbar nav ul li a:hover {
    color: black;
    border-radius: 5px;
}

.user-icon {
    width: 25px; 
    height: 25px; 
    border-radius: 50%; 
    display: flex;
    justify-content: center; 
    align-items: center; 
    transition: background-color 0.3s ease, color 0.3s ease; 
    margin-left: 10px; 
}
.user-icon:hover {
  background-color: lightgray;
}
.user-icon img {
    width: 100%; /* Make the image fit the circle */
    height: 100%; 
    object-fit: cover; /* Ensure the image covers the entire circle */
}

footer{
            background: linear-gradient(to right, #9b7848, #c5b394);
            border-top-left-radius: 100px;
            padding-bottom: 50px; 
            margin-top: 200px;
        }

        footer *{
            color: white;
        }

        .f_container{
            display: flex;
            justify-content: space-between;
            padding: 50px 7%;
        }

        .footer-col{
            width: 25%;
        }

        .footer-col h2{
            font-optical-sizing: 1.7em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        p.email{
            margin: 12px 0px;
        }

        p.phone{
            font-size: 15px;
            font-weight: 400;
        }

        .footer-col .text-office{
            margin-bottom: 20px;
        }
        .underline{
            width: 70px;
            height: 3px;
            position: relative;
            background-color: white;
            border-radius: 3px;
            overflow: hidden;
        }

        .underline span{
            width: 7px;
            height: 100%;
            position: absolute;
            left: 10px;
            background-color: rgb(63,63,63);
            border-radius: 3px;
            animation: moving 1.5s linear infinite;
        }

        @keyframes moving {
            0%{
                left: -20px;
 }
            100%{
                left: 100%;
            }
        }

        .footer-col ul{
            list-style-type: none;
            padding-top: 10px;
        }

        .footer-col ul li{
            margin: 10px;
        }

        .footer-col form{
            margin-top: 20px;
            border-bottom: 1px solid white;
            padding-bottom: 10px;
            display: flex;
        }

        .footer-col form input{
            width: 70%;
            background: transparent;
            border: none;
            outline: none;
            padding-left: 10px;
        }

        .footer-col form i{
            font-size: 15px;
        }

        .footer-col .social-icons{
            margin-top: 20px;
        }

        .footer-col .social-icons i{
            padding: 10px;
            background-color: white;
            color: #00093c;
            border-radius: 50%;
            margin: 5px;
        }

        .footer-para{
            max-width: 225px;
        }
        .name{
            margin:-3px;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="navbar">
        <div class="logo">
        <img src="pics/Screenshot_2024-10-28_000155-removebg-preview.png" alt="logo">
        </div>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="rooms.php">Rooms</a></li>
                <li><a href="#footer">Contact us</a></li>
                <li><a href="aboutUs.php">About</a></li>
            </ul>
        </nav>
        <div class="user-icon">
        <img src="pics/profileHome-removebg-preview.png" alt="A person icon">
    </div>
    </div>
    <div class="container">
        <div class="sidebar">
            <h2>USER</h2>
            <ul>
                <li><a href="profile3.php">Profile Details</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="payment.php">Payment Methods</a></li>
                <li><a href="booking-history.php">Booking History</a></li>
                <li><a href="feedback2.php">Feedback</a></li>
                <li><a href="logout.php" style="color: brown;">Log Out</a></li>
                <li><a href="delete.php" style="color: red;">Delete Account</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h2 class="profileText">Profile Details</h2>
            <div class="profile-picture">

                <?php if (!empty($user['profile_image'])): ?>
                    <img src="pics/<?php echo htmlspecialchars($user['profile_image']); ?>" 
                    alt="Profile Picture" class="profile-picture">
                <?php else: ?>
                    <img src="pics/default-profile.jpg" 
                    alt="Default Profile Picture" class="profile-picture">
                <?php endif; ?>

                <!-- <img src="pics/WIN_20240811_01_31_40_Pro.jpg" alt="Profile Picture" class="profile-picture"> -->
                
                <label for="profile_image" style="border-bottom: none;">
                <input type="file" id="profile_image" name="profile_image" accept="image/*" form="editProfileForm">
                </label>
            </div>
            <form action="profile-edit.php" method="post" enctype="multipart/form-data" id="editProfileForm" onsubmit="return validateForm()">
                <label for="name">First Name:
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user["first_name"]); ?>" required>
                </label>
                <br>
                <label for="last_name">Last Name:
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user["last_name"]); ?>" required>
                </label>
                <br>
                <label for="email">Email:
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>"required>
                </label>
                <br>
                <label for="password">Password:
                <input type="password" id="password" name="password"  value="<?php echo htmlspecialchars($user["password"]); ?>" required>
                </label>
                <br>
                <label for="phone">Mobile Number:
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user["phone"]); ?>" required>
                </label>
                <br><br><br>
                <input type="submit" value="Save Changes">
            </form>
        </div>
    </div>

    <!--footer part-->
    <footer id="footer">
        <div class="f_container">
            <div class="footer-col">
                <h2 class="name">The Royal Palm</h2>
                <p class="footer-para">Welcome to our luxury hotel, where comfort meets elegance. Enjoy your stay with top-notch facilities and personalized service.</p>
            </div>
            <div class="footer-col">
                <h3 class="text-office">
                    Contact Us
                    <div class="underline"><span></span></div>
                </h3>
                <p class="email">reservations@theroyalpalm.com</p>
                <p class="phone">+20 101 234 5678</p>
            </div>
            <div class="footer-col">
                <h3>
                    Quick Links
                    <div class="underline"><span></span></div>
                </h3>
                <ul>
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="#">Rooms & Suites</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>
                    Newsletter
                    <div class="underline"><span></span></div>
                </h3>
                <form action="">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" placeholder="Enter Your Email">
                    <a href=""><i class="fa-solid fa-arrow-right"></i></a>
                </form>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
    function validateForm() {
        // Get form inputs
        const firstName = document.getElementById('first_name').value.trim();
        const lastName = document.getElementById('last_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const phone = document.getElementById('phone').value.trim();

        // Check if any field is empty
        if (!firstName || !lastName || !email || !phone) {
            alert('Please fill in all required fields.');
            return false; // Prevent form submission
        }

        // Optionally: you can add more validations like email or phone format

        return true; // Allow form submission
    }
</script>

<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>