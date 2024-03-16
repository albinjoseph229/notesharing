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
    <?php
    include ('header.php');
    ?>
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

    <!-- Manage Notes Section -->
    <section class="contact-page-area section-gap">
        <div class="container">
            <h1>Your Notes</h1>

            <div style="margin: 0 auto;">
                <table style="width: 100%;"> <!-- Set the width of the table to 100% -->
                    <tr>
                        <th style="width: 15%;">Subject</th>
                        <th style="width: 15%;">Title</th>
                        <th style="width: 40%;">Note Details</th> <!-- Increased width for the content column -->
                        <th style="width: 10%;">Added Date</th>
                        <th style="width: 10%;">Download</th>
                        <th style="width: 5%;">Action</th> <!-- Adjusted width for better alignment -->
                    </tr>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['subject'] . "</td>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td><a href='note-details.php?note_id=" . $row['note_id'] . "'>View Details</a></td>"; // Redirect to note-details.php page
                            echo "<td>" . $row['created_at'] . "</td>";
                            echo "<td>";
                            // Add download link
                            echo "<a href='download.php?file=" . urlencode(basename($row['file_path'])) . "'>Download Note</a>";
                            echo "</td>";
                            echo "<td>";
                            // Add delete button with form
                            echo "<form action='delete_note.php' method='POST'>";
                            echo "<input type='hidden' name='note_id' value='" . $row['note_id'] . "' />";
                            echo "<button type='submit' class='btn btn-danger' name='delete'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>You have not uploaded any notes yet.</td></tr>";
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