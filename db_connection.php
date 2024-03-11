<?php
// Database configuration
$host = "localhost"; // Change this to your database host
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "note_sharing_system"; // Change this to your database name

// Attempt to connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8 (optional, depending on your database configuration)
$conn->set_charset("utf8");

// Alternatively, you can use PDO for database connection:
/*
try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
*/

?>
