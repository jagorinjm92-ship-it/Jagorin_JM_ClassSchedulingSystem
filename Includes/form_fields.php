<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Subject Code</label>
        <input type="text" name="subject_code" class="form-control" required maxlength="20"
               value="<?= htmlspecialchars($row['subject_code']) ?>">
    </div>
    <div class="col-md-8">
        <label class="form-label">Subject Name</label>
        <input type="text" name="subject_name" class="form-control" required maxlength="100"
               value="<?= htmlspecialchars($row['subject_name']) ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">Instructor</label>
        <input type="text" name="instructor" class="form-control" required maxlength="100"
               value="<?= htmlspecialchars($row['instructor']) ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">Section</label>
        <input type="text" name="section" class="form-control" required maxlength="30"
               value="<?= htmlspecialchars($row['section']) ?>">
    </div>
    <div class="col-md-3">
        <label class="form-label">Room</label>
        <input type="text" name="room" class="form-control" required maxlength="30"
               value="<?= htmlspecialchars($row['room']) ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">Day</label>
        <select name="day" class="form-select" required>
            <option value="">Select day</option>
            <?php foreach ($days as $d): ?>
                <option value="<?= $d ?>" <?= $row['day'] === $d ? 'selected' : '' ?>><?= $d ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Start Time</label>
        <input type="time" name="start_time" class="form-control" required
               value="<?= htmlspecialchars(substr($row['start_time'], 0, 5)) ?>">
    </div>
    <div class="col-md-4">
        <label class="form-label">End Time</label>
        <input type="time" name="end_time" class="form-control" required
               value="<?= htmlspecialchars(substr($row['end_time'], 0, 5)) ?>">
    </div>
</div>