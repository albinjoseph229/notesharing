<!-- ================ Start Header Area ================= -->
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
                <form class="d-flex justify-content-between" action="search_results.php" method="GET">
                    <input type="text" class="form-control" id="search-input" name="search" placeholder="Search Here" />
                    <button type="submit" class="btn">Search</button>
                    <span class="lnr lnr-cross" id="close-search" title="Close Search" style="margin-right: -5px;"></span>
                </form>
            </div>
        </div>

    </header>
    <!-- ================ End Header Area ================= -->
    