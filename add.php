<?php
require "db_connect.php";

$error = "";
$row = ["subject_code"=>"","subject_name"=>"","instructor"=>"","section"=>"",
        "room"=>"","day"=>"","start_time"=>"","end_time"=>""];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($row as $k => $v) { $row[$k] = trim($_POST[$k] ?? ""); }

    $error = validateSchedule($row, $days);
    if ($error === "") {
        $error = findConflict($conn, $row);
    }
    if ($error === "") {
        $stmt = $conn->prepare("INSERT INTO schedules
            (subject_code, subject_name, instructor, section, room, day, start_time, end_time)
            VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss", $row['subject_code'], $row['subject_name'], $row['instructor'],
            $row['section'], $row['room'], $row['day'], $row['start_time'], $row['end_time']);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: schedules.php?msg=added");
            exit;
        }
        $error = "Error saving record: " . $conn->error;
        $stmt->close();
    }
}

$pageTitle = "Add Schedule";
$active = "add";
require "Includes/header.php";
?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="mb-3">Add Schedule</h4>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <?php require "Includes/form_fields.php"; ?>
            <div class="mt-4">
                <button class="btn btn-primary">Save Schedule</button>
                <a href="schedules.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php require "Includes/footer.php"; ?>
