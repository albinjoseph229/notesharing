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

// Fetch user's uploaded notes
$query = "SELECT * FROM notes WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Fetch the list of people you are following
$following_query = "SELECT * FROM follows WHERE follower_id = $user_id";
$following_result = mysqli_query($conn, $following_query);

// Logout functionality
if (isset($_POST['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to the login page after logout
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/fav.png" />
    <!-- Author Meta -->
    <meta name="author" content="colorlib" />
    <!-- Meta Description -->
    <meta name="description" content="" />
    <!-- Meta Keyword -->
    <meta name="keywords" content="" />
    <!-- meta character set -->
    <meta charset="UTF-8" />
    <!-- Site Title -->
    <title>Dashboard</title>

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
    <link rel="stylesheet" href="css/nice-select.css" />
    <link rel="stylesheet" href="css/hexagons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>

<body>
    <?php
    include('header.php');
    ?>
    <!-- ================ start banner Area ================= -->
    <section class="home-banner-area">
        <div class="container">
            <div class="row justify-content-center fullscreen align-items-center">
                <div class="col-lg-5 col-md-8 home-banner-left">
                    <h1 class="text-white">
                        Welcome, <?php echo isset($user['username']) ? $user['username'] : ''; ?>
                    </h1>
                    <p class="mx-auto text-white mt-20 mb-40">
                    This website offers a user-friendly note-taking experience with authentication and customizable dashboards. Easily manage, view, and edit notes on any device for enhanced productivity
                    </p>
                </div>
                <div class="offset-lg-2 col-lg-5 col-md-12 home-banner-right">
                    <img class="img-fluid" src="img/header-img.png" alt="" />
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End banner Area ================= -->

    <!-- ================ Start Feature Area ================= -->
    <section class="feature-area">
        <div class="container-fluid">
            <div class="feature-inner row">
                <div class="col-lg-2 col-md-6">
                    <div class="feature-item d-flex">
                        <i class="ti-book"></i>
                        <div class="ml-20">
                            <h4>Add Notes</h4>
                            <p>
                                feature allows users to create new notes, providing a platform for organized content creation and management.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="feature-item d-flex">
                        <i class="ti-cup"></i>
                        <div class="ml-20">
                            <h4>User Interactions</h4>
                            <p>
                                Enables users to share their notes with others, fostering teamwork and knowledge exchange.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="feature-item d-flex border-right-0">
                        <i class="ti-desktop"></i>
                        <div class="ml-20">
                            <h4>Note Management</h4>
                            <p>
                                Effortlessly manage notes, including viewing, editing, and deleting, for efficient organization.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End Feature Area ================= -->

    <!-- ================ Start Popular Course Area ================= -->
    <section class="popular-course-area section-gap">
        <div class="container-fluid">
            <div class="row justify-content-center section-title">
                <div class="col-lg-12">
                    <h2>
                        Your Notes
                    </h2>
                    <p>
                        Here are the notes you have uploaded:
                    </p>
                </div>
            </div>
            <div class="owl-carousel popuar-course-carusel">
                <?php
                // Loop through your notes and display them
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <div class="single-popular-course">
                        <div class="thumb">
                            <!-- Dummy image as cover image -->
                            <img class="f-img img-fluid mx-auto" src="img/dummy-image.jpg" alt="" />
                        </div>
                        <div class="details">
                            <div class="d-flex justify-content-between mb-20">
                                <!-- Display subject -->
                                <p class="name"><?php echo $row['subject']; ?></p>
                            </div>
                            <!-- Make the note title a link to the manage notes page -->
                            <a href="manage_notes.php?note_id=<?php echo $row['note_id']; ?>">
                                <!-- Display title of the note -->
                                <h4><?php echo $row['title']; ?></h4>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>


    <!-- ================ End Popular Course Area ================= -->


    <!-- ================ Start Feature Area ================= -->
    <section class="other-feature-area">
        <div class="container">
            <div class="feature-inner row">
                <div class="col-lg-12">
                    <div class="section-title text-left">
                        <h2>
                            Features That <br />
                            Can Avail By Everyone
                        </h2>
                        <p>Our website offers a user-friendly note-taking experience with authentication and customizable dashboards. Easily manage, view, and edit notes on any device for enhanced productivity</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="other-feature-item">
                        <i class="ti-key"></i>
                        <h4>User Authentication</h4>
                        <div>
                            <p>
                                Users can log in to access the features of the website. If not logged in, they are redirected to the login page.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--160">
                    <div class="other-feature-item">
                        <i class="ti-files"></i>
                        <h4>Dashboard</h4>
                        <div>
                            <p>
                                Users have a dashboard page where they can access various functionalities.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--260">
                    <div class="other-feature-item">
                        <i class="ti-medall-alt"></i>
                        <h4>Manage Notes</h4>
                        <div>
                            <p>
                                Users can manage their notes, including viewing, editing, and deleting them.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="other-feature-item">
                        <i class="ti-briefcase"></i>
                        <h4>View Note Details</h4>
                        <div>
                            <p>
                                Users can view detailed information about a specific note, including its title, subject, content, and file attachments.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--160">
                    <div class="other-feature-item">
                        <i class="ti-crown"></i>
                        <h4>Navigation Links:</h4>
                        <div>
                            <p>
                                The website includes navigation links to facilitate easy movement between different pages, such as the home page, manage notes page, and note details page.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--260">
                    <div class="other-feature-item">
                        <i class="ti-headphone-alt"></i>
                        <h4>Responsive Design</h4>
                        <div>
                            <p>
                                The website is designed to be responsive, ensuring that it displays properly and is usable across various devices and screen sizes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    include("footer.php");
    ?>
</body>

</html>