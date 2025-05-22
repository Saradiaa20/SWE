<?php
session_start();
session_unset();      // Remove all session variables
session_destroy();    // Destroy the session
header("Location: Home.php"); // Redirect to login page (or Home.php)
exit();
