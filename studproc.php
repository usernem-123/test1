<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Connect to the database
    $db = new mysqli("localhost", "root", "", "event web");

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Check if student ID exists in the database
    $stmt = $db->prepare("SELECT Id_num FROM students WHERE Id_num = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['student_id'] = $student_id; // ✅ Set the session
        header("Location: student_dashboard.php"); // redirect to student page
        exit();
    } else {
        // Invalid student ID
        header("Location: index.php?error=1");
        exit();
    }

    $stmt->close();
    $db->close();
} else {
    header("Location: index.php");
    exit();
}
