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
    <title>Eclipse Education</title>

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
    include ('header.php');
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
                        In the history of modern astronomy, there is probably no one
                        greater leap forward than the building and launch of the space
                        telescope known as the Hubble.
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
                            <h4>New Classes</h4>
                            <p>
                                In the history of modern astronomy, there is probably no one
                                greater leap forward.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="feature-item d-flex">
                        <i class="ti-cup"></i>
                        <div class="ml-20">
                            <h4>Top Courses</h4>
                            <p>
                                In the history of modern astronomy, there is probably no one
                                greater leap forward.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="feature-item d-flex border-right-0">
                        <i class="ti-desktop"></i>
                        <div class="ml-20">
                            <h4>Full E-Books</h4>
                            <p>
                                In the history of modern astronomy, there is probably no one
                                greater leap forward.
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

    <!-- ================ Start Video Area ================= -->
    <section class="video-area section-gap-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="section-title text-white">
                        <h2 class="text-white">
                            Watch Our Trainers <br />
                            in Live Action
                        </h2>
                        <p>
                            In the history of modern astronomy, there is probably no one
                            greater leap forward than the building and launch of the space
                            telescope known as the Hubble.
                        </p>
                    </div>
                </div>
                <div class="offset-lg-1 col-md-6 video-left">
                    <div class="owl-carousel video-carousel">
                        <div class="single-video">
                            <div class="video-part">
                                <img class="img-fluid" src="img/video-img.jpg" alt="" />
                                <div class="overlay"></div>
                                <a class="popup-youtube play-btn" href="https://www.youtube.com/watch?v=VufDd-QL1c0">
                                    <img class="play-icon" src="img/play-btn.png" alt="" />
                                </a>
                            </div>
                            <h4 class="text-white mb-20 mt-30">
                                Learn Angular js Course for Legendary Persons
                            </h4>
                            <p class="text-white mb-20">
                                In the history of modern astronomy, there is probably no one
                                greater leap forward than the building and launch of the space
                                telescope known as the Hubble.
                            </p>
                        </div>

                        <div class="single-video">
                            <div class="video-part">
                                <img class="img-fluid" src="img/video-img.jpg" alt="" />
                                <div class="overlay"></div>
                                <a class="popup-youtube play-btn" href="https://www.youtube.com/watch?v=VufDd-QL1c0">
                                    <img class="play-icon" src="img/play-btn.png" alt="" />
                                </a>
                            </div>
                            <h4 class="text-white mb-20 mt-30">
                                Learn Angular js Course for Legendary Persons
                            </h4>
                            <p class="text-white mb-20">
                                In the history of modern astronomy, there is probably no one
                                greater leap forward than the building and launch of the space
                                telescope known as the Hubble.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End Video Area ================= -->

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
                        <p>
                            If you are looking at blank cassettes on the web, you may be
                            very confused at the difference in price. You may see some for
                            as low as $.17 each.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="other-feature-item">
                        <i class="ti-key"></i>
                        <h4>Lifetime Access</h4>
                        <div>
                            <p>
                                Lorem ipsum dolor sit amet consec tetur adipisicing elit, sed
                                do eiusmod tempor incididunt labore. Lorem ipsum dolor sit
                                amet consec tetur adipisicing elit, sed do eiusmod tempor
                                incididunt labore.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--160">
                    <div class="other-feature-item">
                        <i class="ti-files"></i>
                        <h4>Source File Included</h4>
                        <div>
                            <p>
                                Lorem ipsum dolor sit amet consec tetur adipisicing elit, sed
                                do eiusmod tempor incididunt labore. Lorem ipsum dolor sit
                                amet consec tetur adipisicing elit, sed do eiusmod tempor
                                incididunt labore.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--260">
                    <div class="other-feature-item">
                        <i class="ti-medall-alt"></i>
                        <h4>Student Membership</h4>
                        <div>
                            <p>
                                Lorem ipsum dolor sit amet consec tetur adipisicing elit, sed
                                do eiusmod tempor incididunt labore. Lorem ipsum dolor sit
                                amet consec tetur adipisicing elit, sed do eiusmod tempor
                                incididunt labore.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="other-feature-item">
                        <i class="ti-briefcase"></i>
                        <h4>35000+ Courses</h4>
                        <div>
                            <p>
                                Lorem ipsum dolor sit amet consec tetur adipisicing elit, sed
                                do eiusmod tempor incididunt labore. Lorem ipsum dolor sit
                                amet consec tetur adipisicing elit, sed do eiusmod tempor
                                incididunt labore.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--160">
                    <div class="other-feature-item">
                        <i class="ti-crown"></i>
                        <h4>Expert Mentors</h4>
                        <div>
                            <p>
                                Lorem ipsum dolor sit amet consec tetur adipisicing elit, sed
                                do eiusmod tempor incididunt labore. Lorem ipsum dolor sit
                                amet consec tetur adipisicing elit, sed do eiusmod tempor
                                incididunt labore.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--260">
                    <div class="other-feature-item">
                        <i class="ti-headphone-alt"></i>
                        <h4>Live Supports</h4>
                        <div>
                            <p>
                                Lorem ipsum dolor sit amet consec tetur adipisicing elit, sed
                                do eiusmod tempor incididunt labore. Lorem ipsum dolor sit
                                amet consec tetur adipisicing elit, sed do eiusmod tempor
                                incididunt labore.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End Feature Area ================= -->

    <!-- ================ Start Testimonials Area ================= -->
    <section class="testimonials-area section-gap">
        <div class="container">
            <div class="testi-slider owl-carousel" data-slider-id="1">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="item">
                            <div class="testi-item">
                                <img src="img/quote.png" alt="" />
                                <div class="mt-40 text">
                                    <p>
                                        As conscious traveling Paup ers we must always be oncerned
                                        about our dear Mother Earth. If you think about it, you
                                        travel across her face and She is the host to your
                                        journey.
                                    </p>
                                </div>
                                <h4>Fanny Spencer</h4>
                                <p>Chief Executive, Amazon</p>
                            </div>
                        </div>
                    </div>

                    <div class="offset-lg-1 col-lg-6">
                        <img src="img/testimonial/t1.jpg" alt="" />
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="item">
                            <div class="testi-item">
                                <img src="img/quote.png" alt="" />
                                <div class="mt-40 text">
                                    <p>
                                        As conscious traveling Paup ers we must always be oncerned
                                        about our dear Mother Earth. If you think about it, you
                                        travel across her face <br />
                                        and She is the host to your journey.
                                    </p>
                                </div>
                                <h4>Fanny Spencer</h4>
                                <p>Chief Executive, Amazon</p>
                            </div>
                        </div>
                    </div>

                    <div class="offset-lg-1 col-lg-6">
                        <img src="img/testimonial/t1.jpg" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End Testimonials Area ================= -->

    <!-- ================ Start Registration Area ================= -->
    <section class="registration-area">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-5">
                    <div class="section-title text-left text-white">
                        <h2 class="text-white">
                            Watch Our Trainers <br />
                            in Live Action
                        </h2>
                        <p>
                            If you are looking at blank cassettes on the web, you may be
                            very confused at the difference in price. You may see some for
                            as low as $.17 each.
                        </p>
                    </div>
                </div>
                <div class="offset-lg-3 col-lg-4 col-md-6">
                    <div class="course-form-section">
                        <h3 class="text-white">Courses for Free</h3>
                        <p class="text-white">It is high time for learning</p>
                        <form class="course-form-area contact-page-form course-form text-right" id="myForm" action="mail.html" method="post">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'" />
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Phone Number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone Number'" />
                            </div>
                            <div class="form-group col-md-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" />
                            </div>
                            <div class="col-lg-12 text-center">
                                <button class="btn text-uppercase">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End Registration Area ================= -->

    <!-- ================ Start Blog Post Area ================= -->
    <section class="blog-post-area section-gap">
        <div class="container-fluid">
            <div class="feature-inner row">
                <div class="col-lg-12">
                    <div class="section-title text-left">
                        <h2>
                            Features That <br />
                            Can Avail By Everyone
                        </h2>
                        <p>
                            There is a moment in the life of any aspiring astronomer that it
                            is time to buy that first telescope. It’s exciting to think
                            about setting up your own viewing station.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-blog-post">
                        <img src="img/blog-post/b1.jpg" class="img-fluid" alt="" />
                        <div class="overlay"></div>
                        <div class="top-text">
                            <p>29th, oct, 2018</p>
                            <p>121 likes</p>
                            <p>05 comments</p>
                        </div>
                        <div class="text">
                            <h4 class="text-white">Smart Kitchen Setup</h4>
                            <div>
                                <p>
                                    Lorem ipsum dolor sit amet consec tetur adipisicing elit,
                                    sed do.
                                </p>
                            </div>
                            <a href="#" class="primary-btn">
                                View Details
                                <i class="fa fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--160">
                    <div class="single-blog-post">
                        <img src="img/blog-post/b2.jpg" class="img-fluid" alt="" />
                        <div class="overlay"></div>
                        <div class="top-text">
                            <p>29th, oct, 2018</p>
                            <p>121 likes</p>
                            <p>05 comments</p>
                        </div>
                        <div class="text">
                            <h4 class="text-white">Smart Kitchen Setup</h4>
                            <div>
                                <p>
                                    Lorem ipsum dolor sit amet consec tetur adipisicing elit,
                                    sed do.
                                </p>
                            </div>
                            <a href="#" class="primary-btn">
                                View Details
                                <i class="fa fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt--260">
                    <div class="single-blog-post">
                        <img src="img/blog-post/b3.jpg" class="img-fluid" alt="" />
                        <div class="overlay"></div>
                        <div class="top-text">
                            <p>29th, oct, 2018</p>
                            <p>121 likes</p>
                            <p>05 comments</p>
                        </div>
                        <div class="text">
                            <h4 class="text-white">Smart Kitchen Setup</h4>
                            <div>
                                <p>
                                    Lorem ipsum dolor sit amet consec tetur adipisicing elit,
                                    sed do.
                                </p>
                            </div>
                            <a href="#" class="primary-btn">
                                View Details
                                <i class="fa fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End Blog Post Area ================= -->
<?php
include("footer.php");
?>
</body>

</html>