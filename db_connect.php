<?php
// LOCAL (XAMPP) settings
$host = "localhost";
$user = "root";
$pass = "";
$db   = "class_scheduling";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

// True if the room is already booked on that day at an overlapping time.
function hasConflict($conn, $room, $day, $start, $end, $excludeId = 0) {
    $sql = "SELECT COUNT(*) FROM schedules
            WHERE room = ? AND day = ? AND start_time < ? AND end_time > ? AND id <> ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $room, $day, $end, $start, $excludeId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}