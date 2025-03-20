<?php
$servername = "localhost";
$username = "root";
$password = "your-mysql-password";
$dbname = "testdb";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected to database: $dbname";
$conn->close();
?>
