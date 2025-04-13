<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "event web");

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Insert event if form is submitted
if (isset($_POST['add_event'])) {
    // Get the data from the form
    $event_name = mysqli_real_escape_string($db, $_POST['e_name']);
    $event_date = mysqli_real_escape_string($db, $_POST['e_date']);
    $event_time = mysqli_real_escape_string($db, $_POST['e_time']);
    $event_attend = mysqli_real_escape_string($db, $_POST['e_attend']); // Default to 0 or another value as needed

    // Prepare the SQL query to insert the event
    $query = "INSERT INTO event (e_name, e_date, e_time, e_attend) VALUES ('$event_name', '$event_date', '$event_time', '$event_attend')";
    
    // Execute the query
    if (mysqli_query($db, $query)) {
        // Redirect to the same page to avoid resubmission (optional)
        header("Location: Event.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($db);
    }
}

$query = "SELECT * FROM event";
$result = mysqli_query($db, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="StudentCourse.css">
</head>

<body>
  <div class="sidebar" id="sidebar">
    <div class="text-center p-3">
      <img src="logo1.png" alt="Admin Image" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
      <h5 class="fw-bold mt-2">Administrator</h5>
    </div>
    <span class="hamburger" id="toggleSidebar">
      <i class="bi bi-x-lg"></i>
    </span>

    <ul class="nav flex-column px-3">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
          <i class="bi bi-clipboard2-check-fill"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="StudentCourse.php">
          <i class="bi bi-person-lines-fill"></i> Student Courses
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="Event.php">
          <i class="bi bi-calendar-check-fill"></i> Events
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="bi bi-box-arrow-right"></i> Log Out
        </a>
      </li>
    </ul>
  </div>

  <div class="content" id="content">
    <nav class="navbar navbar-light bg-light">
      <button class="btn btn-light" id="toggleSidebarMobile">
        <i class="bi bi-list"></i>
      </button>
    </nav>

    <div class="container mt-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="color:white;">List Of Events</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">Add Event</button>
      </div>

      <table class="table table-bordered table-striped" style="color:white;">
        <thead>
          <tr>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Event Time</th>
            <th>Total Students Attended</th>
            <th>Attendance</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td style="color: white;"><?php echo htmlspecialchars($row['e_name']); ?></td>
              <td style="color: white;"><?php echo htmlspecialchars($row['e_date']); ?></td>
              <td style="color: white;"><?php echo htmlspecialchars($row['e_time']); ?></td>
              <td style="color: white;"><?php echo htmlspecialchars($row['e_attend']); ?></td>
              <td style="color: white;">
                <a href="attendancechecker.php?e_name=<?php echo urlencode($row['e_name']); ?>" class="btn btn-success">Check Attendance</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Add Event Modal -->
  <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="Event.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="event_name" class="form-label">Event Name</label>
              <input type="text" class="form-control" id="event_name" name="e_name" required>
            </div>
            <div class="mb-3">
              <label for="event_date" class="form-label">Event Date</label>
              <input type="date" class="form-control" id="event_date" name="e_date" required>
            </div>
            <div class="mb-3">
              <label for="event_time" class="form-label">Event Time</label>
              <input type="time" class="form-control" id="event_time" name="e_time" required>
            </div>
            <input type="hidden" name="e_attend" value="0">
            <input type="hidden" name="add_event" value="1">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Event</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="StudentCourse.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
