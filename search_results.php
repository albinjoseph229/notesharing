<?php
require_once 'db_connection.php';

if(isset($_GET['search'])){
    $search = $_GET['search'];
    $query = "SELECT * FROM users WHERE username LIKE '%$search%' OR email LIKE '%$search%'";
    $result = mysqli_query($conn, $query);
    // Display search results
    while($row = mysqli_fetch_assoc($result)){
        echo "<div>";
        echo "<p>{$row['username']}</p>"; // Display username
        // Add a button to visit the user's profile
        echo "<form method='get' action='user_profile.php'>";
        echo "<input type='hidden' name='user_id' value='{$row['user_id']}'>";
        echo "<button type='submit'>Visit Profile</button>";
        echo "</form>";
        // Add follow button
        echo "<form method='post' action='follow.php'>";
        echo "<input type='hidden' name='followed_user_id' value='{$row['user_id']}'>";
        echo "<button type='submit' name='follow'>Follow</button>";
        echo "</form>";
        echo "</div>";
    }
}
?>
