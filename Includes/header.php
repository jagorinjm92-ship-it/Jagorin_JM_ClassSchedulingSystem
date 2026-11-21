
<?php
// Starts PHP code.

// Sets the page title and active menu before including this file.
$pageTitle = $pageTitle ?? "Class Scheduling System";
// Uses the given page title or the default title.

$active = $active ?? "";
// Sets the active menu or leaves it empty.
?>

<!DOCTYPE html>
<!-- Declares that this is an HTML5 document. -->

<html lang="en">
<!-- Starts the HTML page and sets the language to English. -->

<head>
<!-- Contains the webpage information and settings. -->

    <meta charset="UTF-8">
    <!-- Sets the character format. -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Makes the website responsive on mobile devices. -->

    <title><?= htmlspecialchars($pageTitle) ?> | Class Scheduling System</title>
    <!-- Sets the browser tab title using PHP. -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Connects Bootstrap to style the website. -->

    <link rel="stylesheet" href="style.css">
    <!-- Connects the custom CSS file. -->

</head>
<!-- Ends the head section. -->

<body class="bg-light">
<!-- Starts the webpage body with a light background. -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
<!-- Creates a blue navigation bar. -->

    <div class="container">
    <!-- Creates a centered container for the navigation bar. -->

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

                    <a class="nav-link <?= $active === 'home' ? 'active' : '' ?>" href="index.php">Home</a>
                    <!-- Creates the Home link and highlights it if active. -->

                </li>
                <!-- Ends the Home navigation item. -->

                <li class="nav-item">
                <!-- Creates another navigation item. -->

                    <a class="nav-link <?= $active === 'schedules' ? 'active' : '' ?>" href="schedules.php">Schedules</a>
                    <!-- Creates the Schedules link and highlights it if active. -->

                </li>
                <!-- Ends the Schedules navigation item. -->

                <li class="nav-item">
                <!-- Creates another navigation item. -->

                    <a class="nav-link <?= $active === 'add' ? 'active' : '' ?>" href="add.php">Add Schedule</a>
                    <!-- Creates the Add Schedule link and highlights it if active. -->

                </li>
                <!-- Ends the Add Schedule navigation item. -->

            </ul>
            <!-- Ends the navigation list. -->

        </div>
        <!-- Ends the expandable navigation menu. -->

    </div>
    <!-- Ends the navigation container. -->

</nav>
<!-- Ends the navigation bar. -->

<div class="container">
<!-- Creates a container for the main webpage content. -->
