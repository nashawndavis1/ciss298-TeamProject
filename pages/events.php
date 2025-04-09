<?php
session_start();
require_once __DIR__ . '/../db.php';
?>

<div class="container py-4">
  <h2 class="mb-4">Upcoming Events</h2>

  <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>
    <form id="eventForm" class="loadForm mb-5">
      <div class="mb-3">
        <label for="title" class="form-label">Event Title:</label>
        <input type="text" name="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
      </div>
      <div class="mb-3">
        <label for="location" class="form-label">Location:</label>
        <input type="text" name="location" class="form-control" required>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label for="start_date" class="form-label">Start Date:</label>
          <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="col">
          <label for="end_date" class="form-label">End Date (Optional):</label>
          <input type="date" name="end_date" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label for="start_time" class="form-label">Start Time:</label>
          <input type="time" name="start_time" class="form-control" required>
        </div>
        <div class="col">
          <label for="end_time" class="form-label">End Time:</label>
          <input type="time" name="end_time" class="form-control" required>
        </div>
      </div>
      <button type="submit" name="submit" class="btn btn-success">Post Event</button>
    </form>
  <?php endif; ?>

  <?php
  $result = $conn->query("SELECT * FROM events ORDER BY start_date DESC, start_time DESC");
  while ($row = $result->fetch_assoc()):
  ?>
    <div class="border p-3 mb-4">
      <h4><?= htmlspecialchars($row['title']) ?></h4>
      <p class="mb-1"><strong><?= htmlspecialchars($row['location']) ?></strong></p>
      <p class="mb-1"><?= htmlspecialchars($row['description']) ?></p>
      <p class="text-muted small">
        <?= htmlspecialchars($row['start_date']) ?> <?= $row['end_date'] ? " - " . htmlspecialchars($row['end_date']) : '' ?>
        <?= htmlspecialchars($row['start_time']) ?> to <?= htmlspecialchars($row['end_time']) ?>
      </p>
    </div>
  <?php endwhile; ?>
</div>