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

// Query database to fetch user's notes
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM notes WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    // Handle the error accordingly
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
    <title>Contacts</title>


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
        table {
            width: 80%;
            /* Adjust the width of the table here */
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="default-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <img src="img/logo.png" alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="lnr lnr-menu"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li><a href="dashboard.php">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="add_note.php">Add Notes</a></li>
                        <li><a href="manage_notes.php">Manage Notes</a></li>
                        <li><a href="logout.php">Logout</a></li>
                        <!-- Dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                Pages
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="elements.html">Elements</a>
                                <a class="dropdown-item" href="course-details.html">Course Details</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                Blog
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="blog-home.html">Blog Home</a>
                                <a class="dropdown-item" href="blog-single.html">Blog Details</a>
                            </div>
                        </li>
                        <li><a href="contacts.html">Contacts</a></li>

                        <li>
                            <button class="search">
                                <span class="lnr lnr-magnifier" id="search"></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="search-input" id="search-input-box">
            <div class="container">
                <form class="d-flex justify-content-between">
                    <input type="text" class="form-control" id="search-input" placeholder="Search Here" />
                    <button type="submit" class="btn"></button>
                    <span class="lnr lnr-cross" id="close-search" title="Close Search"></span>
                </form>
            </div>
        </div>
    </header <!-- Banner -->
    <section class="banner-area">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 banner-right">
                    <h1 class="text-white">
                    Search Results
                    </h1>
                    <p class="mx-auto text-white  mt-20 mb-40">
                        The Results For Your Search Will Appear Here.
                    </p>
                    <div class="link-nav">
                        <span class="box">
                            <a href="dashboard.php">Home </a>
                            <i class="lnr lnr-arrow-right"></i>
                            <a href="manage_notes.php">Manage Notes</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- search results sectionS-->
    <section class="contact-page-area section-gap">
        <div class="container">

            <!-- Your existing code to display user's notes -->
            <!-- Replace this part with the code below -->

            <h1>Search Results</h1>
            <br>
            <div style="margin: 0 auto;">
                <table style="width: 100%;"> <!-- Set the width of the table to 100% -->
                    <tr>
                        <th>Username</th>
                        <th>Email</th> <!-- New column for email -->
                        <th>Joined Date</th> <!-- New column for joined date -->
                        <th>Action</th>
                    </tr>
                    <?php
                    // Your search query code
                    if (isset($_GET['search'])) {
                        $search = $_GET['search'];
                        $query = "SELECT * FROM users WHERE username LIKE '%$search%' OR email LIKE '%$search%'";
                        $result = mysqli_query($conn, $query);
                        // Display search results
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['username']}</td>"; // Display username
                            echo "<td>{$row['email']}</td>"; // Display email
                            echo "<td>{$row['created_at']}</td>"; // Display joined date
                            // Add a button to visit the user's profile
                            echo "<td>";
                            echo "<form method='post' action='follow.php'>";
                            echo "<input type='hidden' name='followed_user_id' value='{$row['user_id']}'>";
                            echo "<button type='submit' name='follow'>Follow</button>";
                            echo "</form>";

                            // Add follow button
                            echo "<form method='get' action='user_profile.php'>";
                            echo "<input type='hidden' name='user_id' value='{$row['user_id']}'>";
                            echo "<button type='submit'>Visit Profile</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-area section-gap">
        <!-- Footer Content -->
    </footer>

    <!-- Scripts -->
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE"></script>
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