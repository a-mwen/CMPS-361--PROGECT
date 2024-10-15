<?php
// Start Session
session_start();

// Database Configuration
$host = 'localhost';
$db = 'project-WAD';
$user = 'postgres';
$pass = '317!!Musha4lyf';
$port = '5437';

// Create connection to Postgres
$conn = pg_connect("host=$host dbname=$db user=$user password=$pass port=$port");

// Check Connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Get User Account Information
$username = $_POST['username'];
$password = $_POST['password'];

// Fetch user data from the database
$sql = "SELECT * FROM users WHERE username=$1";
$result = pg_query_params($conn, $sql, array($username));

// Check if the user exists
if (pg_num_rows($result) > 0) {
    $user = pg_fetch_assoc($result);
    
    // Verify the password
    if (hash_equals($user['password'], crypt($password, $user['password']))) {
        // Authentication successful
        $_SESSION['username'] = $username;
        header("Location: welcome.php");
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "Invalid username.";
}

pg_close($conn);
?>
