<?php
$env = parse_ini_file(__DIR__ . "/.env");
$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$dbname = $env['DB_NAME'];

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a test table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS test_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Insert a test row
$randomData = "TestData_" . rand(1000, 9999);
$sql = "INSERT INTO test_table (data) VALUES ('$randomData')";
if ($conn->query($sql) === FALSE) {
    die("Error inserting data: " . $conn->error);
}

// Fetch all data from the table
$result = $conn->query("SELECT * FROM test_table");

if ($result->num_rows > 0) {
    echo "<h2>Stored Data:</h2><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>ID: " . $row["id"] . " - Data: " . $row["data"] . " - Created At: " . $row["created_at"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No data found.";
}
$conn->close();
?>
