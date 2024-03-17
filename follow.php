<?php
// Include database connection
require_once 'db_connection.php';

// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the followed user ID is provided
    if (isset($_POST['followed_user_id'])) {
        $followed_user_id = $_POST['followed_user_id'];
        
        // Retrieve current user ID from session or wherever it's stored
        // For demonstration purpose, I assume it's stored in $_SESSION['user_id']
        $follower_user_id = $_SESSION['user_id']; // Adjust this according to your application

        // Check if the current user is already following the profile user
        $check_query = "SELECT * FROM follows WHERE follower_id = $follower_user_id AND followed_user_id = $followed_user_id";
        $check_result = mysqli_query($conn, $check_query);

        // If the user is already being followed, display an error message
        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['error_message'] = "You are already following this user.";
            header("Location: user_profile.php?user_id=$followed_user_id");
            exit();
        }

        // Insert follow record into the database
        $query = "INSERT INTO follows (follower_id, followed_user_id) VALUES ($follower_user_id, $followed_user_id)";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Follow action successful
            // Set success message
            $_SESSION['success_message'] = "You are now following this user.";
            // Redirect back to the user profile page
            header("Location: user_profile.php?user_id=$followed_user_id");
            exit();
        } else {
            // Error handling if the follow action fails
            $_SESSION['error_message'] = "An error occurred while following the user.";
            header("Location: user_profile.php?user_id=$followed_user_id");
            exit();
        }
    } else {
        // Handle error if followed_user_id is not provided
        $_SESSION['error_message'] = "Followed user ID is missing.";
        header("Location: user_profile.php");
        exit();
    }
} else {
    // Handle error if the form is not submitted
    $_SESSION['error_message'] = "Form submission error.";
    header("Location: user_profile.php");
    exit();
}
?>
