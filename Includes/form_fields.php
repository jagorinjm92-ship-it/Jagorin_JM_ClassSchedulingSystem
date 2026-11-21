<div class="row g-3">
    <!-- Creates a row with spacing between fields. -->

    <div class="col-md-4">
        <!-- Creates a column for the Subject Code. -->

        <label class="form-label">Subject Code</label>
        <!-- Displays the Subject Code label. -->

        <input type="text" name="subject_code" class="form-control" required maxlength="20"
               value="<?= htmlspecialchars($row['subject_code']) ?>">
        <!-- Input field that displays the existing subject code. -->
    </div>

    <div class="col-md-8">
        <label class="form-label">Subject Name</label>
        <!-- Displays the Subject Name label. -->

        <input type="text" name="subject_name" class="form-control" required maxlength="100"
               value="<?= htmlspecialchars($row['subject_name']) ?>">
        <!-- Input field that displays the existing subject name. -->
    </div>

    <div class="col-md-6">
        <label class="form-label">Instructor</label>
        <!-- Displays the Instructor label. -->

        <input type="text" name="instructor" class="form-control" required maxlength="100"
               value="<?= htmlspecialchars($row['instructor']) ?>">
        <!-- Input field that displays the instructor's name. -->
    </div>

    <div class="col-md-3">
        <label class="form-label">Section</label>
        <!-- Displays the Section label. -->

        <input type="text" name="section" class="form-control" required maxlength="30"
               value="<?= htmlspecialchars($row['section']) ?>">
        <!-- Input field that displays the existing section. -->
    </div>

    <div class="col-md-3">
        <label class="form-label">Room</label>
        <!-- Displays the Room label. -->

        <input type="text" name="room" class="form-control" required maxlength="30"
               value="<?= htmlspecialchars($row['room']) ?>">
        <!-- Input field that displays the existing room. -->
    </div>

    <div class="col-md-4">
        <label class="form-label">Day</label>
        <!-- Displays the Day label. -->

        <select name="day" class="form-select" required>
            <!-- Creates a dropdown for selecting a day. -->

            <option value="">Select day</option>
            <!-- Default dropdown option. -->

            <?php foreach ($days as $d): ?>
                <!-- Gets each day from the days list. -->

                <option value="<?= $d ?>" <?= $row['day'] === $d ? 'selected' : '' ?>>
                    <?= $d ?>
                </option>
                <!-- Displays the day and selects the saved day. -->

            <?php endforeach; ?>
            <!-- Ends the loop. -->

        </select>
        <!-- Ends the dropdown. -->
    </div>

    <div class="col-md-4">
        <label class="form-label">Start Time</label>
        <!-- Displays the Start Time label. -->

        <input type="time" name="start_time" class="form-control" required
               value="<?= htmlspecialchars(substr($row['start_time'], 0, 5)) ?>">
        <!-- Input field that displays the existing start time. -->
    </div>

    <div class="col-md-4">
        <label class="form-label">End Time</label>
        <!-- Displays the End Time label. -->

        <input type="time" name="end_time" class="form-control" required
               value="<?= htmlspecialchars(substr($row['end_time'], 0, 5)) ?>">
        <!-- Input field that displays the existing end time. -->
    </div>

</div>
<!-- Closes the row. -->
