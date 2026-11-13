<?php
require "db_connect.php";

$msg = "notfound";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM schedules WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $msg = "deleted";
    }
    $stmt->close();
}
header("Location: schedules.php?msg=" . $msg);
exit;
