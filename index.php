
<!DOCTYPE html>
<!-- Declares that this is an HTML5 document. -->

<html lang="en">
<!-- Starts the HTML page and sets the language to English. -->

<head>
<!-- Contains the webpage information and settings. -->

<meta charset="UTF-8">
<!-- Sets the character format. -->

<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Makes the website fit different screen sizes. -->

<title>Class Scheduling System</title>
<!-- Sets the title displayed in the browser tab. -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Connects Bootstrap to style the website. -->

<link rel="stylesheet" href="style.css">
<!-- Connects the custom CSS file. -->

</head>
<!-- Ends the head section. -->

<body class="bg-light">
<!-- Starts the webpage with a light background. -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
<!-- Creates a blue navigation bar. -->

<div class="container">
<!-- Creates a centered container for the navigation content. -->

<a class="navbar-brand fw-bold" href="index.php">Class Scheduling System</a>
<!-- Displays the website name and links to the homepage. -->

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
<!-- Creates a menu button for smaller screens. -->

<span class="navbar-toggler-icon"></span>
<!-- Displays the menu icon. -->

</button>
<!-- Ends the menu button. -->

<div class="collapse navbar-collapse" id="nav">
<!-- Makes the navigation menu expandable and collapsible. -->

<ul class="navbar-nav ms-auto">
<!-- Creates the navigation list and aligns it to the right. -->

<li class="nav-item">
<!-- Creates a navigation item. -->

<a class="nav-link" href="index.php">Home</a>
<!-- Creates a link to the homepage. -->

</li>
<!-- Ends the Home navigation item. -->

<li class="nav-item">
<a class="nav-link" href="#features">Features</a>
<!-- Creates a link that moves to the Features section. -->
</li>

<li class="nav-item">
<a class="nav-link" href="#about">About</a>
<!-- Creates a link that moves to the About section. -->
</li>

<li class="nav-item">
<a class="nav-link" href="schedules.php">Schedules</a>
<!-- Creates a link to the schedules page. -->
</li>

<li class="nav-item">
<a class="nav-link" href="add.php">Add Schedule</a>
<!-- Creates a link to the Add Schedule page. -->
</li>

</ul>
<!-- Ends the navigation list. -->

</div>
<!-- Ends the navigation menu. -->

</div>
<!-- Ends the navigation container. -->

</nav>
<!-- Ends the navigation bar. -->

<header class="hero text-center">
<!-- Creates the main welcome section with centered text. -->

<div class="container">
<!-- Centers the content inside the header. -->

<h1 class="display-5 fw-bold">Class Scheduling System</h1>
<!-- Displays the main heading of the website. -->

<p class="lead mb-4">Create, view, update and manage class schedules in one place.</p>
<!-- Displays a short description of the system. -->

<a href="schedules.php" class="btn btn-light btn-lg me-2">Open System</a>
<!-- Creates a button that opens the schedules page. -->

<a href="add.php" class="btn btn-outline-light btn-lg">Add Schedule</a>
<!-- Creates a button that opens the Add Schedule page. -->

</div>
<!-- Ends the header container. -->

</header>
<!-- Ends the welcome section. -->

<section id="features" class="container py-5">
<!-- Creates the Features section with top and bottom spacing. -->

<h2 class="text-center mb-4">Features</h2>
<!-- Displays the Features heading in the center. -->

<div class="row g-4">
<!-- Creates a row with spacing between the feature cards. -->

<div class="col-md-3">
<!-- Creates a column that takes 3 out of 12 columns. -->

<div class="card h-100 text-center p-3">
<!-- Creates a card with centered text and padding. -->

<h5>Add</h5>
<!-- Displays the Add feature title. -->

<p class="text-muted">Create a new class schedule.</p>
<!-- Describes the Add feature. -->

<a href="add.php" class="btn btn-sm btn-primary mt-auto">Add Schedule</a>
<!-- Creates a button to add a new schedule. -->

</div>
<!-- Ends the Add card. -->

</div>
<!-- Ends the Add column. -->

<div class="col-md-3">
<!-- Creates another feature column. -->

<div class="card h-100 text-center p-3">
<!-- Creates the View feature card. -->

<h5>View</h5>
<!-- Displays the View feature title. -->

<p class="text-muted">See and search all schedules.</p>
<!-- Describes the View feature. -->

<a href="schedules.php" class="btn btn-sm btn-primary mt-auto">View Schedules</a>
<!-- Creates a button to view schedules. -->

</div>
<!-- Ends the View card. -->

</div>
<!-- Ends the View column. -->

<div class="col-md-3">
<!-- Creates another feature column. -->

<div class="card h-100 text-center p-3">
<!-- Creates the Edit feature card. -->

<h5>Edit</h5>
<!-- Displays the Edit feature title. -->

<p class="text-muted">Update a schedule when something changes.</p>
<!-- Describes the Edit feature. -->

<a href="schedules.php" class="btn btn-sm btn-primary mt-auto">Edit a Schedule</a>
<!-- Creates a button to open the schedules page for editing. -->

</div>
<!-- Ends the Edit card. -->

</div>
<!-- Ends the Edit column. -->

<div class="col-md-3">
<!-- Creates the last feature column. -->

<div class="card h-100 text-center p-3">
<!-- Creates the Delete feature card. -->

<h5>Delete</h5>
<!-- Displays the Delete feature title. -->

<p class="text-muted">Remove schedules you no longer need.</p>
<!-- Describes the Delete feature. -->

<a href="schedules.php" class="btn btn-sm btn-primary mt-auto">Manage Schedules</a>
<!-- Creates a button to manage and delete schedules. -->

</div>
<!-- Ends the Delete card. -->

</div>
<!-- Ends the Delete column. -->

</div>
<!-- Ends the row containing all four feature cards. -->

</section>
<!-- Ends the Features section. -->

<section id="about" class="bg-white py-5">
<!-- Creates the About section with a white background and spacing. -->

<div class="container text-center">
<!-- Centers the content inside the About section. -->

<h2 class="mb-3">About</h2>
<!-- Displays the About heading. -->

<p class="text-muted mb-1">Final project for Web Systems Technologies.</p>
<!-- Displays the project description. -->

<p class="text-muted mb-0">Built with PHP, MySQL, HTML, CSS and Bootstrap 5.</p>
<!-- Displays the programming languages and tools used. -->

</div>
<!-- Ends the About container. -->

</section>
<!-- Ends the About section. -->

<footer class="text-center text-muted py-4 small">
<!-- Creates the footer with centered, small, gray text. -->

Class Scheduling System &copy; <?= date("Y") ?> | JM Jagorin
<!-- Displays the copyright symbol, current year, and developer name. -->

</footer>
<!-- Ends the footer. -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Loads Bootstrap JavaScript for interactive features like the mobile menu. -->

</body>
<!-- Ends the webpage body. -->

</html>
<!-- Ends the HTML document. -->
