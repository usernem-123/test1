<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    die("No student ID found in session. Please log in.");
}

$student_id = $_SESSION['student_id'];

$db = new mysqli("localhost", "root", "", "event web");

if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

$stmt = $db->prepare("SELECT f_name, Id_num FROM students WHERE Id_num = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$stmt->bind_result($f_name, $Id_num);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #83a4d4, #b6fbff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .dashboard-container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 8px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 18px;
        }

        h3 {
            margin-bottom: 12px;
            color: #333;
        }

        img {
            width: 100%;
            max-width: 200px;
            height: auto;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        button {
            background-color: #e74c3c;
            color: white;
            padding: 10px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c0392b;
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 20px;
            }

            h1 {
                font-size: 20px;
            }

            p, h3 {
                font-size: 14px;
            }

            button {
                font-size: 15px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php if ($f_name && $Id_num): ?>
        <h1>Welcome, <?= htmlspecialchars($f_name) ?>!</h1>
        <p>Your ID: <?= htmlspecialchars($Id_num) ?></p>

        <h3>Your QR Code</h3>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode('ID: ' . $Id_num) ?>" alt="Student QR Code">

        <form method="post" action="logout.php">
            <button type="submit">Logout</button>
        </form>
    <?php else: ?>
        <p>Student record not found.</p>
    <?php endif; ?>
</div>

</body>
</html>
