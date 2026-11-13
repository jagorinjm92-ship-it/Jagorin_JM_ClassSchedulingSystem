<?php
// Set $pageTitle and $active ("home" | "schedules" | "add") before including this file.
$pageTitle = $pageTitle ?? "Class Scheduling System";
$active    = $active ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?> | Class Scheduling System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Class Scheduling System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link <?= $active === 'home' ? 'active' : '' ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $active === 'schedules' ? 'active' : '' ?>" href="schedules.php">Schedules</a></li>
                <li class="nav-item"><a class="nav-link <?= $active === 'add' ? 'active' : '' ?>" href="add.php">Add Schedule</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
