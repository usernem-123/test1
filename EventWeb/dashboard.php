<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "event web"); // Change database to 'event web'

// Query to get the total number of students from the 'students' table
$query_students = "SELECT COUNT(*) AS total_students FROM students";
$result_students = mysqli_query($db, $query_students);
$row_students = mysqli_fetch_assoc($result_students);
$total_students = $row_students['total_students'];

// Query to get the total number of events from the 'event' table
$query_events = "SELECT COUNT(*) AS total_events FROM event";
$result_events = mysqli_query($db, $query_events);
$row_events = mysqli_fetch_assoc($result_events);
$total_events = $row_events['total_events'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <center>
  <title>Dashboard</title>
</center>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="dashboard.css">
  
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
  <center>
    <h1 style="color:White;">Dashboard</h1>
  </center>
  <div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Total College Students
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Number of Students</h5>
                <p class="card-text" style="font-size: 36px;"><?php echo $total_students; ?></p> <!-- Total students -->
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Total Events
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Number of Events</h5>
                <p class="card-text" style="font-size: 36px;"><?php echo $total_events; ?></p> <!-- Total events -->
            </div>
        </div>
    </div>
</div>
</div>
        
      </div>

    </div>
  </div>

  <script src="StudentCourse.js"></script>

</body>

</html>
