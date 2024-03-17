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

        // Delete follow record from the database
        $query = "DELETE FROM follows WHERE follower_id = $follower_user_id AND followed_user_id = $followed_user_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Unfollow action successful
            // Set success message
            $_SESSION['success_message'] = "You have unfollowed this user.";
            // Redirect back to the user profile page
            header("Location: user_profile.php?user_id=$followed_user_id");
            exit();
        } else {
            // Error handling if the unfollow action fails
            $_SESSION['error_message'] = "An error occurred while unfollowing the user.";
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
