<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "event web");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add_user'])) {
    $Id_num = mysqli_real_escape_string($db, $_POST['Id_num']);
    $f_name = mysqli_real_escape_string($db, $_POST['f_name']);
    $m_name = mysqli_real_escape_string($db, $_POST['m_name']);
    $l_name = mysqli_real_escape_string($db, $_POST['l_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $b_day = mysqli_real_escape_string($db, $_POST['b_day']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $batchyear = mysqli_real_escape_string($db, $_POST['batchyear']);

    $query = "INSERT INTO students (Id_num, f_name, m_name, l_name, email, bday, contact, batchyear)
              VALUES ('$Id_num', '$f_name', '$m_name', '$l_name', '$email', '$b_day', '$contact', '$batchyear')";

    if (mysqli_query($db, $query)) {
        // Redirect or show success message
        header("Location: StudentCourse.php?success=1");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }
}
?>
