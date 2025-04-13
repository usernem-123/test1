<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "event web");

function calculateAge($birthdate) {
    $dob = new DateTime($birthdate);
    $now = new DateTime();
    $age = $now->diff($dob);
    return $age->y;
}

$query = "SELECT * FROM students";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Events</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="StudentCourse.css" />
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
      <a class="nav-link" href="Dashboard.php">
        <i class="bi bi-clipboard2-check-fill"></i> Dashboard
      </a>
    </li>
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
      <h1 style="color:White;">Computer Science</h1>
    </center>

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 style="color:White;">List Of Students</h1>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add Student</button>
    </div>

    <table class="table table-bordered table-striped" style="color:White;">
      <thead>
        <tr>
          <th>ID Number</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Batch Year</th>
          <th>Contact Number</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($user = mysqli_fetch_assoc($result)) {
          $full_name = $user['f_name'] . ' ' . $user['m_name'] . ' ' . $user['l_name'];
          $year = $user['batchyear'];
        ?>
        <tr style="background-color:White;">
          <td><?php echo  $user['Id_num']; ?></td>
          <td><?php echo htmlspecialchars($full_name); ?></td>
          <td><?php echo htmlspecialchars($user['email']); ?></td>
          <td><?php echo $year; ?></td>
          <td><?php echo htmlspecialchars($user['contact']); ?></td>
          <td>
          <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $user['Id_num']; ?>">
            <i class="bi bi-pencil-fill"></i> Edit
          </button>

          <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#qrModal-<?php echo $user['Id_num']; ?>">
            <i class="bi bi-qr-code"></i> QR
          </button>

          <a href="users.php?delete_id=<?php echo $user['Id_num']; ?>" class="btn btn-danger btn-sm">
            <i class="bi bi-trash-fill"></i> Delete
          </a>
          </td>
        </tr>

<!-- Edit Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="users.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">ID Number</label>
              <input type="text" class="form-control" name="Id_num" id="Id_num" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">First Name</label>
              <input type="text" class="form-control" name="f_name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Middle Initial</label>
              <input type="text" class="form-control" name="m_name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Last Name</label>
              <input type="text" class="form-control" name="l_name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Birthday</label>
              <input type="date" class="form-control" name="b_day" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Contact</label>
              <input type="text" class="form-control" name="contact" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Batch Year</label>
              <select class="form-control" name="batchyear" required>
                <?php
                  // Fetch the ENUM values for batchyear directly from the database
                  $enum_query = "SHOW COLUMNS FROM students LIKE 'batchyear'";
                  $enum_result = mysqli_query($db, $enum_query);
                  $enum_row = mysqli_fetch_assoc($enum_result);
                  preg_match('/^enum\((.*)\)$/', $enum_row['Type'], $matches);
                  $enum_values = explode(',', $matches[1]);

                  // Create dropdown options
                  foreach ($enum_values as $value) {
                    $value = trim($value, "'");
                    echo "<option value='$value'>$value</option>";
                  }
                ?>
              </select>
            </div>
            <div class="col-md-12 mb-3 text-center">
              <label class="form-label">Student QR Code</label>
              <div>
                <img id="qrImage" src="" alt="QR Code" class="img-fluid mt-2 rounded shadow" style="display: none;">
              </div>
              <p class="text-muted mt-1" style="font-size: 0.9rem;">QR is generated automatically from the ID Number.</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="add_user" class="btn btn-primary">Add Student</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- QR Modal -->
<div class="modal fade" id="qrModal-<?php echo $user['Id_num']; ?>" tabindex="-1" aria-labelledby="qrModalLabel-<?php echo $user['Id_num']; ?>" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qrModalLabel-<?php echo $user['Id_num']; ?>">QR Code</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-2 fw-bold"><?php echo $user['f_name'] . ' ' . $user['l_name']; ?></p>
        
        <!-- QR Code Image -->
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode('ID: ' . $user['Id_num']); ?>" alt="QR Code" class="img-fluid rounded shadow">
        
        <p class="mt-2 text-muted"><small>ID: <?php echo $user['Id_num']; ?></small></p>
      </div>
    </div>
  </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="users.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">ID Number</label>
            <input type="text" class="form-control" name="Id_num" id="Id_num" required>
          </div>
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="f_name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Middle Initial</label>
            <input type="text" class="form-control" name="m_name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="l_name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Birthday</label>
            <input type="date" class="form-control" name="b_day" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" class="form-control" name="contact" required>
          </div>
          <div class="mb-3">
  <label class="form-label">Batch Year</label>
  <select class="form-control" name="batchyear" required>
    <?php
      // Fetch the ENUM values for batchyear directly from the database
      $enum_query = "SHOW COLUMNS FROM students LIKE 'batchyear'";
      $enum_result = mysqli_query($db, $enum_query);
      $enum_row = mysqli_fetch_assoc($enum_result);
      preg_match('/^enum\((.*)\)$/', $enum_row['Type'], $matches);
      $enum_values = explode(',', $matches[1]);

      // Create dropdown options
      foreach ($enum_values as $value) {
        $value = trim($value, "'");
        echo "<option value='$value'>$value</option>";
      }
    ?>
  </select>
</div>
          <div class="mb-3 text-center">
            <label class="form-label">Student QR Code</label>
            <div>
              <img id="qrImage" src="" alt="QR Code" class="img-fluid mt-2 rounded shadow" style="display: none;">
            </div>
            <p class="text-muted mt-1" style="font-size: 0.9rem;">QR is generated automatically from the ID Number.</p>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="add_user" class="btn btn-primary">Add Student</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php } ?>
      </tbody>
    </table>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const usernameInput = document.getElementById("Id_num");
    const qrImage = document.getElementById("qrImage");

    function generateQR() {
      const username = usernameInput.value.trim();
      if (username !== "") {
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=${encodeURIComponent(username)}`;
        qrImage.src = qrUrl;
        qrImage.style.display = "block";
      } else {
        qrImage.style.display = "none";
      }
    }

    usernameInput.addEventListener("input", generateQR);

    const addUserModal = document.getElementById("addUserModal");
    addUserModal.addEventListener("shown.bs.modal", function () {
      generateQR();
      usernameInput.focus();
    });
  });
</script>

<script src="StudentCourse.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
