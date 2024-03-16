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
        .search-form {
            width: 100%;
            max-width: 400px;
            /* Adjust as needed */
            margin: 0 auto;
            /* Center the form horizontally */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
            width: calc(100% - 85px);
            /* Adjust for button width and padding */
            padding: 10px;
            margin-right: 10px;
            /* Add spacing between input and button */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 75px;
            /* Adjust as needed */
            padding: 10px;
            background-color: #28a745;
            /* Bootstrap success color */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #218838;
            /* Darker shade of green */
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
                        Manage Notes
                    </h1>
                    <p class="mx-auto text-white  mt-20 mb-40">
                        Here you can manage your notes.
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

    <!-- search Section -->
    <div class="container">
        <form action="search_results.php" method="GET">
            <label for="search">Search by Username or Email:</label>
            <input type="text" id="search" name="search" class="form-control" required>
            <button type="submit" class="btn btn-success btn-lg">Search</button>
        </form>
    </div>

    <!-- end search Section -->



    <?php
    include("footer.php");
    ?>
</body>

</html>