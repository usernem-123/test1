<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "event web");

// Check if connection was successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to get the total number of students from the 'students' table for each department
$query_students = "SELECT department, COUNT(*) AS total_students FROM students GROUP BY department"; 

$result = mysqli_query($db, $query_students);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

// Create an associative array to hold student counts for each department
$department_counts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $department_counts[$row['department']] = $row['total_students'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Courses</title>
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
    </ul>
    <ul class="nav flex-column px-3">
      <li class="nav-item">
        <a class="nav-link active" href="StudentCourse.php">
          <i class="bi bi-person-lines-fill"></i> Student Courses
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Event.php">
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
        <h1 style="color:White;">List Of Courses</h1>
      </div>

      <div class="row"> <!-- Start of row for cards -->
        <?php
        // Define the departments you want to display
        $departments = [
            'Computer Science', 
            'Electrical Technology', 
            'Social Work', 
            'Industrial Technology', 
            'Criminology', 
            'Hospitality and Restaurant Management', 
            'HESS'
        ];

        // Loop through each department and display the count
        foreach ($departments as $department) {
            // Get the student count for this department
            $total_students = isset($department_counts[$department]) ? $department_counts[$department] : 0;
            ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <a href="SC_comscie.php" class="text-decoration-none text-light"> 
                            Department of <?php echo $department; ?>
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Total Number of Students</h5>
                        <p class="card-text" style="font-size: 36px;"><?php echo $total_students; ?></p> <!-- Display the student count dynamically -->
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
      </div> <!-- End of row -->
    </div>
</div>

<script src="StudentCourse.js"></script>

</body>

</html>
