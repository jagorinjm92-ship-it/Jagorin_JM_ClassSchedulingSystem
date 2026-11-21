
<?php
// Starts PHP code.

require "db_connect.php";
// Connects to the database.

$msg = "notfound";
// Sets the default message if no schedule is deleted.

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Checks if the form was submitted using POST.

    $id = (int)($_POST['id'] ?? 0);
    // Gets the schedule ID from the form and converts it to an integer.

    $stmt = $conn->prepare("DELETE FROM schedules WHERE id = ?");
    // Prepares an SQL query to delete a schedule using its ID.

    $stmt->bind_param("i", $id);
    // Assigns the schedule ID to the SQL query.
    // "i" means the value is an integer.

    $stmt->execute();
    // Executes the delete query.

    if ($stmt->affected_rows > 0) {
        // Checks if a schedule was successfully deleted.

        $msg = "deleted";
        // Changes the message to "deleted".
    }

    $stmt->close();
    // Closes the SQL statement.
}

// Redirects the user to the schedules page with a message.
header("Location: schedules.php?msg=" . $msg);

// Stops the PHP script.
exit;
