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

// Check if note ID is provided
if (!isset($_GET['note_id'])) {
    header("Location: manage_notes.php"); // Redirect to manage notes page if note ID is not provided
    exit();
}

// Get the note ID and user ID from the URL
if (isset($_GET['note_id']) && isset($_GET['user_id'])) {
    $note_id = $_GET['note_id'];
    $user_id = $_GET['user_id'];
} else {
    // If either note_id or user_id is not provided in the URL, redirect to manage_notes.php
    header("Location: manage_notes.php");
    exit();
}

// Query database to fetch note details
$query = "SELECT * FROM notes WHERE user_id = $user_id AND note_id = $note_id";

$result = mysqli_query($conn, $query);

// Check if the query was successful and note exists
if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: manage_notes.php"); // Redirect to manage notes page if note does not exist
    exit();
}

// Fetch note details
$note = mysqli_fetch_assoc($result);

// Fetch note content
$note_content = $note['content'];

// Query database to fetch user details
$user_query = "SELECT * FROM users WHERE user_id = $user_id";
$user_result = mysqli_query($conn, $user_query);

// Check if the query was successful and user exists
if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user = mysqli_fetch_assoc($user_result);
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
    <title>Note Details</title>

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:900|Roboto:400,400i,500,700" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" href="css/linearicons.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/owl.carousel.css" />
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/hexagons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css" />
    <link rel="stylesheet" href="css/main.css" />
    <!-- Add your CSS links here -->
    <style>
        .single-post {
            margin-bottom: 30px;
            background: #fff;
            padding: 30px;
            border-radius: 4px;
            overflow: hidden;
        }

        .single-post .user-details {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
        }

        .single-post .user-details p {
            margin-bottom: 0;
        }

        .single-post h3 {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .single-post h4 {
            margin-bottom: 20px;
        }

        .single-post p.excert {
            margin-bottom: 20px;
            font-size: 16px;
            line-height: 28px;
        }

        /* Adjustments for smaller screens */
        @media (max-width: 768px) {
            .single-post {
                padding: 20px;
            }

            .single-post .user-details {
                padding: 10px;
            }

            .single-post h3 {
                font-size: 24px;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .single-post h4 {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .single-post p.excert {
                font-size: 14px;
                line-height: 24px;
            }
        }
    </style>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <!-- ================ start banner Area ================= -->
    <section class="banner-area">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 banner-right">
                    <h1 class="text-white">Note Details</h1>
                    <p class="mx-auto text-white  mt-20 mb-40"></p>
                    <div class="link-nav">
                        <span class="box">
                            <a href="dashboard.php">Home </a>
                            <i class="lnr lnr-arrow-right"></i>
                            <a href="manage_notes.php">Manage Notes</a>
                            <i class="lnr lnr-arrow-right"></i>
                            <a href='#'>Note Details</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End banner Area ================= -->

    <section class="post-content-area single-post-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-11 posts-list"> <!-- Increased the width from col-lg-8 to col-lg-9 -->
                    <div class="single-post row">
                        <!-- Meta Details -->
                        <div class="col-lg-3 col-md-3 meta-details">
                            <div class="user-details row">
                                <p class="user-name col-lg-12 col-md-12 col-6"><a href="#"><?php echo isset($user['username']) ? $user['username'] : ''; ?></a> <span class="lnr lnr-user"></span></p>
                                <p class="date col-lg-12 col-md-12 col-6"><a href="#"><?php echo $note['created_at']; ?></a> <span class="lnr lnr-calendar-full"></span></p>
                            </div>
                        </div>
                        <!-- Post Content -->
                        <div class="col-lg-9 col-md-9">
                            <h3 class="mt-20 mb-20"><?php echo $note['title']; ?></h3>
                            <h6 class="mt-20 mb-20"><?php echo $note['subject']; ?></h6>
                            <p class="excert"><?php echo $note_content; ?></p>
                            <hr>
                            <!-- Provide download link for the file -->
                            <?php if (!empty($note['file_path'])) : ?>
                                <h6>File Name: <?php echo basename($note['file_path']); ?></h6>
                                <br>
                                <button class="btn btn-outline-success" onclick="window.location.href='download.php?file=<?php echo urlencode($note['file_path']); ?>'">Download File</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End post-content Area -->

    <!-- ================ start footer Area ================= -->
    <?php include('footer.php') ?>
    <!-- ================ End footer Area ================= -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/parallax.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/hexagons.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>