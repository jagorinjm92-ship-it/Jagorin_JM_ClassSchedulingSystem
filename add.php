
<?php
// Starts PHP code.

require "db_connect.php";
// Connects to the database.

$error = "";
// Creates an empty variable for error messages.

$row = ["subject_code"=>"","subject_name"=>"","instructor"=>"","section"=>"",
        "room"=>"","day"=>"","start_time"=>"","end_time"=>""];
// Creates an array containing empty values for all schedule fields.

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Checks if the form was submitted.

    foreach ($row as $k => $v) {
        // Loops through all the schedule fields.

        $row[$k] = trim($_POST[$k] ?? "");
        // Gets the submitted value and removes extra spaces.
    }

    $error = validateSchedule($row, $days);
    // Checks if the schedule information is valid.

    if ($error === "") {
        // Continues if there are no validation errors.

        $error = findConflict($conn, $row);
        // Checks if the schedule conflicts with another schedule.
    }

    if ($error === "") {
        // Continues if there are still no errors.

        $stmt = $conn->prepare("INSERT INTO schedules
            (subject_code, subject_name, instructor, section, room, day, start_time, end_time)
            VALUES (?,?,?,?,?,?,?,?)");
        // Prepares an SQL query to insert the schedule into the database.

        $stmt->bind_param("ssssssss", $row['subject_code'], $row['subject_name'], $row['instructor'],
            $row['section'], $row['room'], $row['day'], $row['start_time'], $row['end_time']);
        // Connects the schedule values to the SQL query.
        // The letter "s" means each value is a string.

        if ($stmt->execute()) {
            // Executes the query to save the schedule.

            $stmt->close();
            // Closes the prepared statement.

            header("Location: schedules.php?msg=added");
            // Redirects the user to the schedules page.

            exit;
            // Stops the current PHP script.
        }

        $error = "Error saving record: " . $conn->error;
        // Displays an error if saving the schedule fails.

        $stmt->close();
        // Closes the prepared statement.
    }
}

// Sets the page title.
$pageTitle = "Add Schedule";

// Sets the Add Schedule menu as active.
$active = "add";

require "Includes/header.php";
// Includes the website header and navigation bar.
?>

<div class="card shadow-sm border-0">
    <!-- Creates a card with a shadow and no border. -->

    <div class="card-body">
        <!-- Creates the content area inside the card. -->

        <h4 class="mb-3">Add Schedule</h4>
        <!-- Displays the Add Schedule heading. -->

        <?php if ($error): ?>
            <!-- Checks if there is an error message. -->

            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
            <!-- Displays the error message in a red alert box. -->

        <?php endif; ?>
        <!-- Ends the error condition. -->

        <form method="post">
            <!-- Creates a form that sends data using POST. -->

            <?php require "Includes/form_fields.php"; ?>
            <!-- Includes the form fields for entering schedule information. -->

            <div class="mt-4">
                <!-- Adds space above the buttons. -->

                <button class="btn btn-primary">Save Schedule</button>
                <!-- Creates a button to submit and save the schedule. -->

                <a href="schedules.php" class="btn btn-secondary">Cancel</a>
                <!-- Creates a Cancel button that returns to the schedules page. -->

            </div>
            <!-- Ends the button container. -->

        </form>
        <!-- Ends the form. -->

    </div>
    <!-- Ends the card body. -->

</div>
<!-- Ends the card. -->

<?php require "Includes/footer.php"; ?>
<!-- Includes the website footer. -->
