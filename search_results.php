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
    <?php
    include('header.php');
    ?>
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
                           
                            
                            // Add follow button
                            echo "<form method='get' action='user_profile.php'>";
                            echo "<input type='hidden' name='user_id' value='{$row['user_id']}'>";
                            echo "<button type='submit'class='btn btn-info'>  Visit Profile</button>";
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

    <?php
    include("footer.php");
    ?>
</body>

</html>