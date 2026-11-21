
<?php
// Starts PHP code.

// Database connection settings.
$host = "sql303.infinityfree.com";
// Stores the database server address.

$user = "if0_43361265";
// Stores the database username.

$pass = "YOUR_DATABASE_PASSWORD";
// Stores the database password.

$db = "if0_43361265_class_scheduling";
// Stores the database name.

// Connects to the MySQL database.
$conn = new mysqli($host, $user, $pass, $db);

// Checks if the database connection has an error.
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
    // Stops the program and displays the error.
}

// Sets the character format for the database.
$conn->set_charset("utf8mb4");

// Stores the available class days.
$days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

// Checks if the schedule information is valid.
function validateSchedule(array &$row, array $days) {

    // Sets the maximum characters for each field.
    $limits = [
        "subject_code" => 20, "subject_name" => 100, "instructor" => 100,
        "section" => 30, "room" => 30,
    ];

    // Checks each field in the list.
    foreach ($limits as $field => $max) {

        // Checks if the field is empty.
        if ($row[$field] === "") {
            return "All fields are required.";
            // Displays an error if a field is empty.
        }

        // Checks if the field exceeds the character limit.
        if (mb_strlen($row[$field]) > $max) {
            return "$field must not be longer than $max characters.";
            // Displays an error if the text is too long.
        }
    }

    // Checks if the selected day is valid.
    if (!in_array($row["day"], $days, true)) {
        return "Please select a valid day.";
        // Displays an error if the day is invalid.
    }

    // Checks the start time and end time.
    foreach (["start_time", "end_time"] as $t) {

        // Checks if the time format is correct.
        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $row[$t])) {
            return "Please enter a valid start and end time.";
            // Displays an error if the time is invalid.
        }

        // Keeps only the hours and minutes.
        $row[$t] = substr($row[$t], 0, 5);
    }

    // Checks if the end time is later than the start time.
    if ($row["end_time"] <= $row["start_time"]) {
        return "End time must be later than start time.";
        // Displays an error if the end time is incorrect.
    }

    // Returns empty if all information is valid.
    return "";
}

// Checks if the room, instructor, or section is already booked.
function overlapExists($conn, $field, $value, $day, $start, $end, $excludeId = 0) {

    // Allows only room, instructor, and section to be checked.
    if (!in_array($field, ["room", "instructor", "section"], true)) {
        return false;
        // Returns false if the field is not allowed.
    }

    // Creates an SQL query to check overlapping schedules.
    $sql = "SELECT COUNT(*) FROM schedules
            WHERE $field = ? AND day = ? AND start_time < ? AND end_time > ? AND id <> ?";

    // Prepares the SQL query.
    $stmt = $conn->prepare($sql);

    // Assigns values to the SQL query.
    $stmt->bind_param("ssssi", $value, $day, $end, $start, $excludeId);

    // Runs the SQL query.
    $stmt->execute();

    // Stores the result in the count variable.
    $stmt->bind_result($count);

    // Gets the result from the database.
    $stmt->fetch();

    // Closes the SQL statement.
    $stmt->close();

    // Returns true if a schedule conflict exists.
    return $count > 0;
}

// Finds conflicts in the selected schedule.
function findConflict($conn, array $row, $excludeId = 0) {

    // Gets the selected day and class times.
    $d = $row["day"];
    $s = $row["start_time"];
    $e = $row["end_time"];

    // Checks if the selected room is already occupied.
    if (overlapExists($conn, "room", $row["room"], $d, $s, $e, $excludeId)) {
        return "Room conflict: that room is already booked at the selected day and time.";
        // Returns an error if the room is already booked.
    }

    // Checks if the instructor already has another class.
    if (overlapExists($conn, "instructor", $row["instructor"], $d, $s, $e, $excludeId)) {
        return "Instructor conflict: that instructor already has a class at the selected day and time.";
        // Returns an error if the instructor is unavailable.
    }

    // Checks if the section already has another class.
    if (overlapExists($conn, "section", $row["section"], $d, $s, $e, $excludeId)) {
        return "Section conflict: that section already has a class at the selected day and time.";
        // Returns an error if the section already has a class.
    }

    // Returns empty if there are no schedule conflicts.
    return "";
}
