<?php
// Get the data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Extract event name and QR code data
$event_name = $data['e_name'];
$student_qr = $data['student_qr']; // Assuming this contains the student's ID_num

// Connect to the database
$db = mysqli_connect("localhost", "root", "", "event web");

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// First, check if the student exists in the `students` table
$query_student = "SELECT * FROM students WHERE Id_num = '$student_qr'";
$student_result = mysqli_query($db, $query_student);

if (mysqli_num_rows($student_result) > 0) {
    // Student exists, now update the attendance in the `event` table
    $query_update_attendance = "
        UPDATE event 
        SET e_attend = e_attend + 1 
        WHERE e_name = '$event_name'
    ";

    if (mysqli_query($db, $query_update_attendance)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($db)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Student not found']);
}

mysqli_close($db);
?>
