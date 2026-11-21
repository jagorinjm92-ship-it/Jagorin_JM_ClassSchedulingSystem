<?php
// Connect this page to the database and load the functions from db_connect.php
require "db_connect.php";

// Get the search keyword from the URL.
// trim() removes extra spaces.
// If there is no search keyword, use an empty string.
$q = trim($_GET['q'] ?? '');

// Set the order of the schedules.
// FIELD() arranges the days from Monday to Saturday.
// start_time arranges schedules by their starting time.
$order = "ORDER BY FIELD(day,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'), start_time";

// Check if the user entered a search keyword.
if ($q !== '') {

    // Add % before and after the keyword.
    // This allows the search to find matching words even if they are part of a longer text.
    $like = "%" . $q . "%";

    // Prepare an SQL query to search the schedules table.
    // It searches the subject code, subject name, instructor, section, and room.
    // The ? symbols are placeholders for the search keyword.
    $stmt = $conn->prepare("SELECT * FROM schedules
        WHERE subject_code LIKE ? OR subject_name LIKE ? OR instructor LIKE ? OR section LIKE ? OR room LIKE ?
        $order");

    // Put the search keyword into all five placeholders.
    // "sssss" means all five values are strings.
    $stmt->bind_param("sssss", $like, $like, $like, $like, $like);

    // Execute the prepared SQL query.
    $stmt->execute();

    // Get the search results.
    $result = $stmt->get_result();

} else {

    // If the search box is empty, get all schedules from the database.
    // The schedules will still follow the specified day and time order.
    $result = $conn->query("SELECT * FROM schedules $order");
}

// Create an array containing the messages displayed after an action.
$messages = [
    // Display this message when a schedule is successfully added.
    "added"    => ["success", "Schedule added successfully."],

    // Display this message when a schedule is successfully updated.
    "updated"  => ["success", "Schedule updated successfully."],

    // Display this message when a schedule is successfully deleted.
    "deleted"  => ["success", "Schedule deleted successfully."],

    // Display this message when the requested schedule cannot be found.
    "notfound" => ["danger",  "That schedule could not be found."],
];

// Get the message type from the URL.
// If there is no message, use an empty string.
$msg = $_GET['msg'] ?? '';

// Set the page title.
$pageTitle = "Schedules";

// Tell the header that the Schedules menu is currently active.
$active = "schedules";

// Include the website header and navigation bar.
require "Includes/header.php";
?>

<!-- Check if the message exists in the messages array. -->
<?php if (isset($messages[$msg])): ?>

    <!-- Display a Bootstrap alert.
         The alert color depends on the message type:
         success = green, danger = red. -->
    <div class="alert alert-<?= $messages[$msg][0] ?> alert-dismissible fade show">

        <!-- Display the message.
             htmlspecialchars() helps prevent HTML or JavaScript injection. -->
        <?= htmlspecialchars($messages[$msg][1]) ?>

        <!-- Button that allows the user to close the alert. -->
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

<!-- End of the message condition. -->
<?php endif; ?>

<!-- Create a Bootstrap card to contain the schedules table. -->
<div class="card shadow-sm border-0">

    <!-- Card body contains the actual content of the card. -->
    <div class="card-body">

        <!-- Arrange the heading and search form.
             On small screens, they appear vertically.
             On medium screens and larger, they appear horizontally. -->
        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-3">

            <!-- Heading of the schedules page. -->
            <h4 class="mb-0">Class Schedules</h4>

            <!-- Search form.
                 method="get" sends the search keyword through the URL. -->
            <form class="d-flex gap-2" method="get">

                <!-- Search input field.
                     name="q" is the variable used to receive the search keyword.
                     value keeps the previous search keyword visible. -->
                <input type="text" name="q" class="form-control" placeholder="Search..."
                       value="<?= htmlspecialchars($q) ?>">

                <!-- Button that submits the search form. -->
                <button class="btn btn-outline-primary">Search</button>

                <!-- Link that takes the user to add.php to create a new schedule. -->
                <a href="add.php" class="btn btn-primary text-nowrap">+ Add</a>
            </form>
        </div>

        <!-- Make the table responsive.
             This allows horizontal scrolling on smaller screens. -->
        <div class="table-responsive">

            <!-- Create a Bootstrap table.
                 table-striped adds alternating row colors.
                 table-hover highlights rows when the mouse moves over them.
                 align-middle vertically centers the content. -->
            <table class="table table-striped table-hover align-middle">

                <!-- Table heading with a light blue background. -->
                <thead class="table-primary">

                    <!-- Start of the table heading row. -->
                    <tr>

                        <!-- Column names displayed in the table. -->
                        <th>#</th>
                        <th>Code</th>
                        <th>Subject</th>
                        <th>Instructor</th>
                        <th>Section</th>
                        <th>Room</th>
                        <th>Day</th>
                        <th>Time</th>

                        <!-- Center the Actions column heading. -->
                        <th class="text-center">Actions</th>

                    <!-- End of the heading row. -->
                    </tr>
                </thead>

                <!-- Start of the table body. -->
                <tbody>

                <!-- Check if the database query returned at least one schedule.
                     num_rows counts how many records were found.
                     If records exist, set the row number to 1. -->
                <?php if ($result->num_rows > 0): $n = 1; ?>

                    <!-- Fetch each schedule from the database one at a time. -->
                    <?php while ($r = $result->fetch_assoc()): ?>

                    <!-- Create a new table row for each schedule. -->
                    <tr>

                        <!-- Display the row number.
                             $n++ increases the number by 1 after displaying it. -->
                        <td><?= $n++ ?></td>

                        <!-- Display the subject code from the database. -->
                        <td><?= htmlspecialchars($r['subject_code']) ?></td>

                        <!-- Display the subject name from the database. -->
                        <td><?= htmlspecialchars($r['subject_name']) ?></td>

                        <!-- Display the instructor's name. -->
                        <td><?= htmlspecialchars($r['instructor']) ?></td>

                        <!-- Display the section. -->
                        <td><?= htmlspecialchars($r['section']) ?></td>

                        <!-- Display the room. -->
                        <td><?= htmlspecialchars($r['room']) ?></td>

                        <!-- Display the class day. -->
                        <td><?= htmlspecialchars($r['day']) ?></td>

                        <!-- Display the starting and ending time.
                             strtotime() converts the database time into a timestamp.
                             date("g:i A") formats it into a readable 12-hour format.
                             Example: 08:00:00 becomes 8:00 AM. -->
                        <td><?= date("g:i A", strtotime($r['start_time'])) ?> - <?= date("g:i A", strtotime($r['end_time'])) ?></td>

                        <!-- Create the Actions column and center its contents.
                             text-nowrap prevents the buttons from wrapping. -->
                        <td class="text-center text-nowrap">

                            <!-- Edit button.
                                 Sends the schedule ID to edit.php through the URL.
                                 Example: edit.php?id=5 -->
                            <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Edit</a>

                            <!-- Delete form.
                                 Sends the schedule ID to delete.php using POST.
                                 d-inline keeps the form beside the Edit button.
                                 onsubmit asks for confirmation before deleting. -->
                            <form action="delete.php" method="post" class="d-inline"
                                  onsubmit="return confirm('Delete this schedule?');">

                                <!-- Hidden input stores the schedule ID.
                                     The user does not see this field.
                                     It is sent when the form is submitted. -->
                                <input type="hidden" name="id" value="<?= $r['id'] ?>">

                                <!-- Delete button that submits the form. -->
                                <button class="btn btn-sm btn-danger">Delete</button>

                            <!-- End of the delete form. -->
                            </form>

                        <!-- End of the Actions column. -->
                        </td>

                    <!-- End of the schedule row. -->
                    </tr>

                    <!-- Continue fetching schedules until there are no more records. -->
                    <?php endwhile; ?>

                <!-- If no schedules were found, execute this part instead. -->
                <?php else: ?>

                    <!-- Display a message across all 9 columns. -->
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No schedules found.
                        </td>
                    </tr>

                <!-- End of the if-else condition. -->
                <?php endif; ?>

                <!-- End of the table body. -->
                </tbody>

            <!-- End of the table. -->
            </table>

        <!-- End of the responsive table container. -->
        </div>

    <!-- End of the card body. -->
    </div>

<!-- End of the card. -->
</div>

<?php
// Include the website footer.
// This may contain the closing HTML tags and Bootstrap JavaScript.
require "Includes/footer.php";
?>
