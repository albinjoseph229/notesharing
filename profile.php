<?php
// Start session
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once 'db_connection.php';

// Fetch user's information
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users WHERE user_id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Check if the profile being viewed belongs to the logged-in user
$is_own_profile = ($user_id == $_SESSION['user_id']);

// If not own profile, get the user_id from the URL
if (!$is_own_profile && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    // Fetch user's information
    $user_query = "SELECT * FROM users WHERE user_id = $user_id";
    $user_result = mysqli_query($conn, $user_query);
    $user = mysqli_fetch_assoc($user_result);
}

// Fetch the number of notes uploaded by the user
$uploaded_notes_query = "SELECT COUNT(*) AS total_notes FROM notes WHERE user_id = $user_id";
$uploaded_notes_result = mysqli_query($conn, $uploaded_notes_query);
$uploaded_notes_data = mysqli_fetch_assoc($uploaded_notes_result);
$total_notes_uploaded = $uploaded_notes_data['total_notes'];

// Function to format the join date
function formatDate($date)
{
    return date('F j, Y', strtotime($date));
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-info">
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Joined:</strong> <?php echo formatDate($user['created_at']); ?></p>
            <p><strong>Total Notes Uploaded:</strong> <?php echo $total_notes_uploaded; ?></p>
            <?php if ($is_own_profile) : ?>
                <a href="manage_notes.php">Manage Notes</a>
            <?php else : ?>
                <a href="uploaded_notes.php?user_id=<?php echo $user_id; ?>">Uploaded Notes</a>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
