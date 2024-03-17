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

// Initialize variables
$title = $content = $subject = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Validate and sanitize form inputs
	$title = htmlspecialchars($_POST['title']);
	$content = htmlspecialchars($_POST['content']);
	$subject = htmlspecialchars($_POST['subject']);

	// File upload logic
	$targetDir = "uploads/";
	$targetFile = $targetDir . basename($_FILES["file"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

	// Absolute path to the uploads directory
	$targetDir = $_SERVER['DOCUMENT_ROOT'] . "/notesharing/uploads/";

	// Ensure that the directory exists
	if (!file_exists($targetDir)) {
		mkdir($targetDir, 0777, true); // Create the directory recursively
	}

	// Destination file path
	$targetFile = $targetDir . basename($_FILES["file"]["name"]);

	// Check file size
	if ($_FILES["file"]["size"] > 50000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}

	

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
			echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";

			// Insert data into the database
			$sql = "INSERT INTO notes (user_id, title, subject, content, file_path) 
					VALUES (?, ?, ?, ?, ?)";

			// Prepare the SQL statement
			$stmt = $conn->prepare($sql);

			// Bind parameters and execute the statement
			$stmt->bind_param("issss", $_SESSION['user_id'], $title, $subject, $content, $targetFile);
			if ($stmt->execute()) {
				echo "New record inserted successfully.";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}

			// Close statement
			$stmt->close();
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
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
						Add Note
					</h1>
					<p class="mx-auto text-white  mt-20 mb-40">
						Add a new note to the system
					</p>
					<div class="link-nav">
						<span class="box">
							<a href="dashboard.php">Home </a>
							<i class="lnr lnr-arrow-right"></i>
							<a href="add_note.php">Add Notes</a>
						</span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- ================ End banner Area ================= -->

	<!-- ================ Start add notes-page Area  ================= -->
	<section class="contact-page-area section-gap">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="section-title">
						<h1>Add New Note</h1>
					</div>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
						<div class="form-group">
							<label for="subject">Subject:</label>
							<input type="text" class="form-control" id="subject" name="subject" value="<?php echo $subject; ?>">
						</div>
						<div class="form-group">
							<label for="title">Title:</label>
							<input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
						</div>
						<div class="form-group">
							<label for="content">Content:</label>
							<textarea class="form-control" id="content" name="content"><?php echo $content; ?></textarea>
						</div>
						<div class="form-group">
							<label for="file">Upload File:</label>
							<input type="file" class="form-control-file" id="file" name="file">
						</div>
						<button type="submit" class="btn btn-primary">Add Note</button>
					</form>
				</div>
			</div>
		</div>
	</section>

	<!-- ================ End add notes-page Area ================= -->

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