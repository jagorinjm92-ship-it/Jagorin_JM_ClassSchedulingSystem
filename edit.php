<?php  
// Starts PHP code.  
  
require "db_connect.php";  
// Connects to the database.  
  
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);  
// Gets the schedule ID from the URL or form and converts it to an integer.  
  
  
  
$error = "";  
// Creates an empty variable for error messages.  
  
// Gets the schedule information from the database.  
$stmt = $conn->prepare("SELECT * FROM schedules WHERE id = ?");  
  
// Assigns the schedule ID to the SQL query.  
$stmt->bind_param("i", $id);  
  
// Executes the SQL query.  
$stmt->execute();  
  
// Gets the schedule information and stores it in $row.  
$row = $stmt->get_result()->fetch_assoc();  
  
// Closes the SQL statement.  
$stmt->close();  
  
// Checks if the schedule does not exist.  
if (!$row) {  
    header("Location: schedules.php?msg=notfound");  
    // Redirects to the schedules page with a not-found message.  
  
    exit;  
    // Stops the PHP script.  
}  
  
// Checks if the form was submitted.  
if ($_SERVER["REQUEST_METHOD"] === "POST") {  
  
    // Gets the updated information from the form.  
    foreach (["subject_code","subject_name","instructor","section","room","day","start_time","end_time"] as $k) {  
  
        $row[$k] = trim($_POST[$k] ?? "");  
        // Stores the new values and removes extra spaces.  
    }  
  
    // Checks if the updated schedule information is valid.  
    $error = validateSchedule($row, $days);  
  
    // Continues if there are no validation errors.  
    if ($error === "") {  
  
        $error = findConflict($conn, $row, $id);  
        // Checks if the updated schedule conflicts with another schedule.  
    }  
  
    // Continues if there are no schedule conflicts.  
    if ($error === "") {  
  
        // Prepares an SQL query to update the schedule.  
        $stmt = $conn->prepare("UPDATE schedules SET subject_code=?, subject_name=?, instructor=?,  
            section=?, room=?, day=?, start_time=?, end_time=? WHERE id=?");  
  
        // Assigns the new values to the SQL query.  
        $stmt->bind_param("ssssssssi", $row['subject_code'], $row['subject_name'], $row['instructor'],  
            $row['section'], $row['room'], $row['day'], $row['start_time'], $row['end_time'], $id);  
  
        // Executes the update query.  
        if ($stmt->execute()) {  
  
            $stmt->close();  
            // Closes the SQL statement.  
  
            header("Location: schedules.php?msg=updated");  
            // Redirects to the schedules page with an updated message.  
  
            exit;  
            // Stops the PHP script.  
        }  
  
        $error = "Error updating record: " . $conn->error;  
        // Displays an error if updating the schedule fails.  
  
        $stmt->close();  
        // Closes the SQL statement.  
    }  
}  
  
// Sets the page title.  
$pageTitle = "Edit Schedule";  
  
// Highlights the Schedules menu.  
$active = "schedules";  
  
// Includes the website header.  
require "Includes/header.php";  
?>  <div class="card shadow-sm border-0">  
    <!-- Creates a card with a shadow and no border. -->  <div class="card-body">  
    <!-- Creates the content area inside the card. -->  

    <h4 class="mb-3">Edit Schedule</h4>  
    <!-- Displays the Edit Schedule heading. -->  

    <?php if ($error): ?>  
        <!-- Checks if there is an error message. -->  

        <div class="alert alert-danger">  
            <?= htmlspecialchars($error) ?>  
        </div>  
        <!-- Displays the error message in a red box. -->  

    <?php endif; ?>  
    <!-- Ends the error condition. -->  

    <form method="post">  
        <!-- Creates a form that submits data using POST. -->  

        <input type="hidden" name="id" value="<?= $id ?>">  
        <!-- Stores the schedule ID without displaying it. -->  

        <?php require "Includes/form_fields.php"; ?>  
        <!-- Includes the form fields containing the schedule information. -->  

        <div class="mt-4">  
            <!-- Adds space above the buttons. -->  

            <button class="btn btn-warning">Update Schedule</button>  
            <!-- Creates a button to save the updated information. -->  

            <a href="schedules.php" class="btn btn-secondary">Cancel</a>  
            <!-- Creates a Cancel button that returns to the schedules page. -->  

        </div>  
        <!-- Ends the button container. -->  

    </form>  
    <!-- Ends the form. -->  

</div>  
<!-- Ends the card body. -->

</div>  
<!-- Ends the card. -->  <?php require "Includes/footer.php"; ?>  <!-- Includes the website footer. -->  
