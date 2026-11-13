<?php
require "db_connect.php";

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$error = "";

$stmt = $conn->prepare("SELECT * FROM schedules WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$row) { header("Location: schedules.php?msg=notfound"); exit; }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach (["subject_code","subject_name","instructor","section","room","day","start_time","end_time"] as $k) {
        $row[$k] = trim($_POST[$k] ?? "");
    }

    $error = validateSchedule($row, $days);
    if ($error === "") {
        $error = findConflict($conn, $row, $id);
    }
    if ($error === "") {
        $stmt = $conn->prepare("UPDATE schedules SET subject_code=?, subject_name=?, instructor=?,
            section=?, room=?, day=?, start_time=?, end_time=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $row['subject_code'], $row['subject_name'], $row['instructor'],
            $row['section'], $row['room'], $row['day'], $row['start_time'], $row['end_time'], $id);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: schedules.php?msg=updated");
            exit;
        }
        $error = "Error updating record: " . $conn->error;
        $stmt->close();
    }
}

$pageTitle = "Edit Schedule";
$active = "schedules";
require "Includes/header.php";
?>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="mb-3">Edit Schedule</h4>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <?php require "Includes/form_fields.php"; ?>
            <div class="mt-4">
                <button class="btn btn-warning">Update Schedule</button>
                <a href="schedules.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php require "Includes/footer.php"; ?>
