<?php
require "db_connect.php";

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$error = "";

$stmt = $conn->prepare("SELECT * FROM schedules WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
if (!$row) { header("Location: schedules.php"); exit; }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach (["subject_code","subject_name","instructor","section","room","day","start_time","end_time"] as $k) {
        $row[$k] = trim($_POST[$k] ?? "");
    }

    if ($row['end_time'] <= $row['start_time']) {
        $error = "End time must be later than start time.";
    } elseif (hasConflict($conn, $row['room'], $row['day'], $row['start_time'], $row['end_time'], $id)) {
        $error = "Room conflict: that room is already booked at the selected day and time.";
    } else {
        $stmt = $conn->prepare("UPDATE schedules SET subject_code=?, subject_name=?, instructor=?,
            section=?, room=?, day=?, start_time=?, end_time=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $row['subject_code'], $row['subject_name'], $row['instructor'],
            $row['section'], $row['room'], $row['day'], $row['start_time'], $row['end_time'], $id);
        if ($stmt->execute()) {
            header("Location: schedules.php?msg=updated");
            exit;
        }
        $error = "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Schedule | Class Scheduling System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.html">Class Scheduling System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="schedules.php">Schedules</a></li>
                <li class="nav-item"><a class="nav-link" href="add.php">Add Schedule</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="mb-3">Edit Schedule</h4>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Subject Code</label>
                    <input type="text" name="subject_code" class="form-control" required maxlength="20"
                           value="<?= htmlspecialchars($row['subject_code']) ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Subject Name</label>
                    <input type="text" name="subject_name" class="form-control" required maxlength="100"
                           value="<?= htmlspecialchars($row['subject_name']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Instructor</label>
                    <input type="text" name="instructor" class="form-control" required maxlength="100"
                           value="<?= htmlspecialchars($row['instructor']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Section</label>
                    <input type="text" name="section" class="form-control" required maxlength="30"
                           value="<?= htmlspecialchars($row['section']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Room</label>
                    <input type="text" name="room" class="form-control" required maxlength="30"
                           value="<?= htmlspecialchars($row['room']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Day</label>
                    <select name="day" class="form-select" required>
                        <option value="">Select day</option>
                        <?php foreach ($days as $d): ?>
                            <option value="<?= $d ?>" <?= $row['day'] === $d ? 'selected' : '' ?>><?= $d ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="start_time" class="form-control" required
                           value="<?= htmlspecialchars(substr($row['start_time'], 0, 5)) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">End Time</label>
                    <input type="time" name="end_time" class="form-control" required
                           value="<?= htmlspecialchars(substr($row['end_time'], 0, 5)) ?>">
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-warning">Update Schedule</button>
                <a href="schedules.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>