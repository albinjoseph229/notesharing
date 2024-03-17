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
	<?php
	include('header.php');
	?>

	<!-- ================ start banner Area ================= -->
	<section class="banner-area">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-12 banner-right">
					<h1 class="text-white">
						Note Details
					</h1>
					<p class="mx-auto text-white  mt-20 mb-40">

					</p>
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
							<h4 class="mt-20 mb-20"><?php echo $note['subject']; ?></h4>
							<p class="excert"><?php echo $note_content; ?></p>
							<!-- Provide download link for the file -->
							<?php if (!empty($note['file_path'])) : ?>
								<p>File Name: <?php echo basename($note['file_path']); ?></p>
								<a href="download.php?file=<?php echo urlencode($note['file_path']); ?>" download>Download File</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- End post-content Area -->

	<!-- ================ start footer Area ================= -->
	<footer class="footer-area section-gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>Top Products</h4>
					<ul>
						<li><a href="#">Managed Website</a></li>
						<li><a href="#">Manage Reputation</a></li>
						<li><a href="#">Power Tools</a></li>
						<li><a href="#">Marketing Service</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>Quick Links</h4>
					<ul>
						<li><a href="#">Jobs</a></li>
						<li><a href="#">Brand Assets</a></li>
						<li><a href="#">Investor Relations</a></li>
						<li><a href="#">Terms of Service</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>Features</h4>
					<ul>
						<li><a href="#">Jobs</a></li>
						<li><a href="#">Brand Assets</a></li>
						<li><a href="#">Investor Relations</a></li>
						<li><a href="#">Terms of Service</a></li>
					</ul>
				</div>
				<div class="col-lg-2 col-md-6 single-footer-widget">
					<h4>Resources</h4>
					<ul>
						<li><a href="#">Guides</a></li>
						<li><a href="#">Research</a></li>
						<li><a href="#">Experts</a></li>
						<li><a href="#">Agencies</a></li>
					</ul>
				</div>
				<div class="col-lg-4 col-md-6 single-footer-widget">
					<h4>Newsletter</h4>
					<p>You can trust us. we only send promo offers,</p>
					<div class="form-wrap" id="mc_embed_signup">
						<form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="form-inline">
							<input class="form-control" name="EMAIL" placeholder="Your Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '" required="" type="email">
							<button class="click-btn btn btn-default text-uppercase">subscribe</button>
							<div style="position: absolute; left: -5000px;">
								<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
							</div>

							<div class="info"></div>
						</form>
					</div>
				</div>
			</div>
			<div class="footer-bottom row align-items-center">
				<p class="footer-text m-0 col-lg-8 col-md-12">
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Copyright &copy;<script>
						document.write(new Date().getFullYear());
					</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				</p>
				<div class="col-lg-4 col-md-12 footer-social">
					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="#"><i class="fa fa-dribbble"></i></a>
					<a href="#"><i class="fa fa-behance"></i></a>
				</div>
			</div>
		</div>
	</footer>
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
