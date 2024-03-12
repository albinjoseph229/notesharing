<?php
require_once 'db_connection.php';

// Initialize follow_button variable
$follow_button = '';

// Check if user_id is provided in the URL
if(isset($_GET['user_id'])){
    $user_id = $_GET['user_id'];
    
    // Query the database to retrieve user information
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    
    // Check if user exists
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        
        // Check if the current user is logged in
        if(isset($_SESSION['user_id'])){
            $current_user_id = $_SESSION['user_id'];
            
            // Check if the current user is not the same as the profile user
            if($current_user_id != $user_id){
                // Check if the current user is already following the profile user
                $follow_query = "SELECT * FROM follows WHERE follower_id = $current_user_id AND followed_user_id = $user_id";
                $follow_result = mysqli_query($conn, $follow_query);
                
                // If not following, show the follow button
                if(mysqli_num_rows($follow_result) == 0){
                    $follow_button = "<form method='post' action='follow.php'>";
                    $follow_button .= "<input type='hidden' name='followed_user_id' value='$user_id'>";
                    $follow_button .= "<button type='submit' name='follow'>Follow</button>";
                    $follow_button .= "</form>";
                } else {
                    // Already following, show a message
                    $follow_button = "<p>You are already following this user.</p>";
                }
            }
        }
    } else {
        // User not found
        echo "User not found.";
    }
} else {
    // Redirect to search page if user_id is not provided
    header("Location: search_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <!-- Add more user details here as needed -->
        
        <!-- Display follow button -->
        <?php echo $follow_button; ?>
        
        <h2>Uploaded Notes</h2>
        <?php
        // Query the database to retrieve notes uploaded by the user
        $notes_query = "SELECT * FROM notes WHERE user_id = $user_id";
        $notes_result = mysqli_query($conn, $notes_query);
        
        // Check if user has uploaded notes
        if(mysqli_num_rows($notes_result) > 0){
            while($note = mysqli_fetch_assoc($notes_result)){
                echo "<div class='note'>";
                echo "<h3>Title: " . $note['title'] . "</h3>";
                echo "<p>Content: " . $note['content'] . "</p>";
                
                // Check if file is uploaded
                if(!empty($note['file_path'])){
                    // Display file with download link
                    $file_path = $note['file_path'];
                    $file_name = basename($file_path);
                    echo "<p>File: <a href='$file_path' download='$file_name'>$file_name</a></p>";
                }
                
                echo "</div>";
            }
        } else {
            echo "<p>No notes uploaded by this user.</p>";
        }
        ?>
    </div>
</body>
</html>
