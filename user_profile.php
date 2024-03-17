<?php
// Include database connection
require_once 'db_connection.php';

// Start session
session_start();

// Initialize follow_button variable
$follow_button = '';

// Check if user_id is provided in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Query the database to retrieve user information
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);

    // Check if user exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Check if the current user is logged in
        if (isset($_SESSION['user_id'])) {
            $current_user_id = $_SESSION['user_id'];

            // Check if the current user is not the same as the profile user
            if ($current_user_id != $user_id) {
                // Check if the current user is already following the profile user
                $follow_query = "SELECT * FROM follows WHERE follower_id = $current_user_id AND followed_user_id = $user_id";
                $follow_result = mysqli_query($conn, $follow_query);

                // If not following, show the follow button
                if (mysqli_num_rows($follow_result) == 0) {
                    $follow_button = "<form method='post' action='follow.php'>";
                    $follow_button .= "<input type='hidden' name='followed_user_id' value='$user_id'>";
                    $follow_button .= "<button type='submit' name='follow' class='btn btn-success'>Follow</button>";
                    $follow_button .= "</form>";
                } else {
                    // Already following, show unfollow option
                    $follow_button = "<form method='post' action='unfollow.php'>";
                    $follow_button .= "<input type='hidden' name='followed_user_id' value='$user_id'>";
                    $follow_button .= "<button type='submit' name='unfollow' class='btn btn-danger'>Unfollow</button>";
                    $follow_button .= "</form>";
                }
            }
        }
    } else {
        // User not found
        $_SESSION['error_message'] = "User not found.";
        header("Location: search_users.php");
        exit();
    }
} else {
    // Redirect to search page if user_id is not provided
    $_SESSION['error_message'] = "User ID is missing.";
    header("Location: search_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="author" content="colorlib" />
    <!-- Meta Description -->
    <meta name="description" content="" />
    <!-- Meta Keyword -->
    <meta name="keywords" content="" />
    <!-- meta character set -->
    <meta charset="UTF-8" />
    <!-- Site Title -->
    <title>Single Blog</title>

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:900|Roboto:400,400i,500,700" rel="stylesheet" />
    <!--
      CSS
      =============================================
    -->
    <link rel="stylesheet" href="css/linearicons.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/owl.carousel.css" />
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/hexagons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>

<body>
    <?php include('header.php'); ?>

    <?php
    // Check for error message and display it
    if (isset($_SESSION['error_message'])) {
        echo "<div class='error-message'>{$_SESSION['error_message']}</div>";
        unset($_SESSION['error_message']); // Remove the error message from session after displaying
    }

    // Check for success message and display it
    if (isset($_SESSION['success_message'])) {
        echo "<div class='success-message'>{$_SESSION['success_message']}</div>";
        unset($_SESSION['success_message']); // Remove the success message from session after displaying
    }
    ?>

    <!-- ================ start banner Area ================= -->
    <section class="banner-area">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 banner-right">
                    <h1 class="text-white">
                        User profile
                    </h1>
                    <p class="mx-auto text-white  mt-20 mb-40">

                    </p>
                    <div class="link-nav">
                        <span class="box">
                            <a href="dashboard.php">Home </a>
                            <i class="lnr lnr-arrow-right"></i>
                            <a href="manage_notes.php">Serch</a>
                            <i class="lnr lnr-arrow-right"></i>
                            <a href='#'>User profile</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <h1>User Profile</h1>
            <br>
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Joined Date:</strong> <?php echo $user['created_at']; ?></p>
            <!-- Add more user details here as needed -->

            <!-- Display follow button -->
            <?php echo $follow_button; ?>
        </div>
    </section>
    <!-- Popular Course Section -->
    <section class="popular-course-area section-gap">
        <div class="container-fluid">
            <div class="row justify-content-center section-title">
                <div class="col-lg-12">
                    <h2>Uploaded Notes</h2>
                    <p>Notes uploaded by the user</p>
                </div>
            </div>
            <div class="owl-carousel popuar-course-carusel">
                <?php
                // Query the database to retrieve notes uploaded by the user
                $notes_query = "SELECT * FROM notes WHERE user_id = $user_id";
                $notes_result = mysqli_query($conn, $notes_query);

                // Check if user has uploaded notes
                if (mysqli_num_rows($notes_result) > 0) {
                    while ($note = mysqli_fetch_assoc($notes_result)) {
                        echo "<div class='single-popular-course'>";
                        echo "<div class='details'>";
                        echo "<div class='d-flex justify-content-between mb-20'>";
                        // Modify this line to add anchor tag with href to note-details.php
                        echo "<h4 class='name'><a href='note-details.php?note_id=" . $note['note_id'] . "'>" . $note['subject'] . "</a></h4>";
                        echo "</div>";
                        echo "<p>" . $note['title'] . "</p>";
                        echo "</div>";
                        echo "<div class='thumb'>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No notes uploaded by this user.</p>";
                }
                ?>
            </div>
        </div>
    </section>


    <!-- ================ End banner Area ================= -->

    <?php
    include("footer.php");
    ?>
</body>

</html>