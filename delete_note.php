<?php
// Include the database connection file
require_once 'db_connection.php';

// Start session
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if note_id is provided and the request method is POST
if (isset($_POST['note_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize the input to prevent SQL injection
    $note_id = mysqli_real_escape_string($conn, $_POST['note_id']);
    
    // Prepare and execute the DELETE statement
    $query = "DELETE FROM notes WHERE note_id = $note_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // If deletion was successful, redirect back to the profile page
        header("Location: manage_notes.php");
        exit();
    } else {
        // If deletion failed, display an error message
        echo "Error deleting note: " . mysqli_error($conn);
        exit();
    }
} else {
    // If note_id is not provided or request method is not POST, redirect back to the profile page
    header("Location: manage_notes.php");
    exit();
}
?>
