<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event Attendance Tracker</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Arial', sans-serif;
      height: 100vh;
      background: url('mainblogo.png') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      padding-right: 20px;
    }
    .login-container {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      padding: 40px;
      width: 350px;
      text-align: center;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .login-container i {
      font-size: 50px;
      color: #ffffff;
      margin-bottom: 20px;
    }
    .login-container h2 {
      color: #fff;
      margin-bottom: 20px;
    }
    .input-field {
      margin-bottom: 15px;
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      background: rgba(255, 255, 255, 0.3);
      color: #fff;
    }
    .input-field:focus {
      outline: none;
      border-color: #008cba;
      background: rgba(255, 255, 255, 0.5);
    }
    .login-btn {
      background-color: #008cba;
      border: none;
      padding: 10px 20px;
      color: white;
      font-size: 16px;
      border-radius: 5px;
      width: 100%;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .login-btn:hover {
      background-color: #005f7f;
    }
    .role-selector {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
    }
    .role-selector button {
      background-color: transparent;
      border: 1px solid #fff;
      padding: 10px 20px;
      color: white;
      cursor: pointer;
      width: 48%;
    }
    .role-selector button:hover {
      background-color: #008cba;
      border-color: #008cba;
    }
  </style>
</head>
<body>

<div class="login-container">
  <i class="fas fa-user"></i>
  <h2>Login</h2>

  <!-- Role Selector -->
  <div class="role-selector">
    <button id="student-login-btn">Student Login</button>
    <button id="admin-login-btn">Admin Login</button>
  </div>

  <!-- Student Login Form -->
  <form id="student-form" method="POST" action="studproc.php" style="display: none;">
    <input type="hidden" name="role" value="student">
    <input name="student_id" type="text" class="input-field" placeholder="Student ID" required>
    <button type="submit" class="login-btn">Login</button>
  </form>

  <!-- Admin Login Form -->
  <form id="admin-form" method="POST" action="adminproc.php" style="display: none;">
    <input type="hidden" name="role" value="admin">
    <input name="admin_username" type="text" class="input-field" placeholder="Username" required>
    <input name="admin_password" type="password" class="input-field" placeholder="Password" required>
    <button type="submit" class="login-btn">Login</button>
  </form>
</div>

<script>
  // Switching between Student and Admin forms
  document.getElementById('student-login-btn').onclick = function() {
    document.getElementById('student-form').style.display = 'block';
    document.getElementById('admin-form').style.display = 'none';
  };
  
  document.getElementById('admin-login-btn').onclick = function() {
    document.getElementById('admin-form').style.display = 'block';
    document.getElementById('student-form').style.display = 'none';
  };
</script>

</body>
</html>
