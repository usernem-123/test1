<?php
// Ensure that the 'e_name' parameter is passed in the URL
if (isset($_GET['e_name'])) {
    $event_name = $_GET['e_name'];
} else {
    die("Error: Event name not provided.");
}

$db = mysqli_connect("localhost", "root", "", "event web");

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM event WHERE e_name = '$event_name'";
$result = mysqli_query($db, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

$event = mysqli_fetch_assoc($result);

if (!$event) {
    die("Event not found.");
}

$student_query = "SELECT s.f_name, s.Id_num FROM students s, event e 
                  WHERE e.e_name = '$event_name'";
$student_result = mysqli_query($db, $student_query);

if (!$student_result) {
    die("Query failed: " . mysqli_error($db));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Attendance Checker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    .sidebar {
      height: 100vh;
      width: 250px;
      background-color: #f8f9fa;
      position: fixed;
      left: 0;
      top: 0;
      padding-top: 20px;
      box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar a {
      display: block;
      padding: 10px;
      text-decoration: none;
      color: #000;
      margin: 10px 0;
    }

    .sidebar a:hover {
      background-color: #007bff;
      color: white;
    }

    .container {
      display: flex;
      justify-content: flex-start;
      padding-left: 250px;
      margin-top: 20px;
    }

    .scanner-container {
      width: 50%;
      margin-right: 20px;
    }

    .table-container {
      width: 45%;
    }

    body {
      background-color: #f4f7fc;
    }

    .navbar-light {
      background-color: #ffffff;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center">Event Management</h4>
    <a href="dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="container">
    <div class="scanner-container">
      <h1>Attendance for <?php echo htmlspecialchars($event['e_name']); ?></h1>
      <p>Current students attended: <span id="attendCount"><?php echo htmlspecialchars($event['e_attend']); ?></span></p>

      <div class="mb-3">
        <button id="startScan" class="btn btn-primary me-2">Start Scanning</button>
        <button id="stopScan" class="btn btn-danger" style="display:none;">Stop Scanning</button>
      </div>

      <video id="preview" style="width:100%; height:400px; display:none;"></video>

      <!-- ✅ Add scanned list display -->
      <h5 class="mt-3">Scanned QR Codes:</h5>
      <ul id="scan-list" class="list-group"></ul>
    </div>

    <div class="table-container">
      <h3 class="mt-4">Students Attended:</h3>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Student ID</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($student_result)) { ?>
            <tr>
              <td><?php echo htmlspecialchars($row['f_name']); ?></td>
              <td><?php echo htmlspecialchars($row['Id_num']); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

  <script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    let isScanning = false;

    scanner.addListener('scan', function (content) {
      console.log('Scanned content: ' + content);

      const listItem = document.createElement("li");
      listItem.className = "list-group-item";
      listItem.textContent = content;
      document.getElementById("scan-list").appendChild(listItem); // ✅ Now the element exists

      const isStudentQR = /^\d{5,}$/.test(content);

      if (isStudentQR) {
        fetch('update_attendance.php', {
          method: 'POST',
          body: JSON.stringify({
            e_name: "<?php echo $event_name; ?>",
            student_qr: content
          }),
          headers: {
            'Content-Type': 'application/json',
          },
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert("Attendance recorded!");

            const countSpan = document.getElementById("attendCount");
            let currentCount = parseInt(countSpan.textContent);
            countSpan.textContent = currentCount + 1;

            // new Audio('success.mp3').play(); // optional
          } else {
            alert("Error updating attendance: " + (data.error || ""));
          }
        });
      }
    });

    document.getElementById("startScan").addEventListener("click", function () {
      if (isScanning) return;

      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
          isScanning = true;
          document.getElementById("preview").style.display = "block";
          document.getElementById("stopScan").style.display = "inline-block";
          document.getElementById("startScan").style.display = "none";
        } else {
          alert('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
        alert('Camera error: ' + e);
      });
    });

    document.getElementById("stopScan").addEventListener("click", function () {
      if (isScanning) {
        scanner.stop();
        isScanning = false;
        document.getElementById("preview").style.display = "none";
        document.getElementById("stopScan").style.display = "none";
        document.getElementById("startScan").style.display = "inline-block";
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
