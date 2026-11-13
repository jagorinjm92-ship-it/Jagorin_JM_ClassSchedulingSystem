<?php
// LOCAL (XAMPP) settings
$host = "sql303.infinityfree.com";
$user = "if0_43361265";
$pass = "shoyo101306";
$db   = "if0_43361265_class_scheduling";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

// Validates (and cleans) a schedule row. Returns an error message, or "" if OK.
function validateSchedule(array &$row, array $days) {
    $limits = [
        "subject_code" => 20, "subject_name" => 100, "instructor" => 100,
        "section" => 30, "room" => 30,
    ];
    foreach ($limits as $field => $max) {
        if ($row[$field] === "") {
            return "All fields are required.";
        }
        if (mb_strlen($row[$field]) > $max) {
            return "$field must not be longer than $max characters.";
        }
    }
    if (!in_array($row["day"], $days, true)) {
        return "Please select a valid day.";
    }
    foreach (["start_time", "end_time"] as $t) {
        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $row[$t])) {
            return "Please enter a valid start and end time.";
        }
        $row[$t] = substr($row[$t], 0, 5); // normalize to HH:MM
    }
    if ($row["end_time"] <= $row["start_time"]) {
        return "End time must be later than start time.";
    }
    return "";
}

// True if $field (room / instructor / section) is already booked on that day at an overlapping time.
function overlapExists($conn, $field, $value, $day, $start, $end, $excludeId = 0) {
    if (!in_array($field, ["room", "instructor", "section"], true)) {
        return false;
    }
    $sql = "SELECT COUNT(*) FROM schedules
            WHERE $field = ? AND day = ? AND start_time < ? AND end_time > ? AND id <> ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $value, $day, $end, $start, $excludeId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

// Returns a conflict message, or "" when there is no conflict.
function findConflict($conn, array $row, $excludeId = 0) {
    $d = $row["day"]; $s = $row["start_time"]; $e = $row["end_time"];
    if (overlapExists($conn, "room", $row["room"], $d, $s, $e, $excludeId)) {
        return "Room conflict: that room is already booked at the selected day and time.";
    }
    if (overlapExists($conn, "instructor", $row["instructor"], $d, $s, $e, $excludeId)) {
        return "Instructor conflict: that instructor already has a class at the selected day and time.";
    }
    if (overlapExists($conn, "section", $row["section"], $d, $s, $e, $excludeId)) {
        return "Section conflict: that section already has a class at the selected day and time.";
    }
    return "";
}
