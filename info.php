<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
    /* Basic Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Arial', sans-serif;
        height: 100vh;
        background: url('binfo.png') no-repeat center center fixed;
        background-size: cover;
        display: flex;
        justify-content: flex-start; /* Align items to the left */
        align-items: center;
        padding-left: 20px; /* Add some padding to the left */
    }

    .login-container {
        background: rgba(255, 255, 255, 0.1); 
        border-radius: 10px;
        padding: 40px;
        width: 300px;
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

    .login-btn:active {
        background-color: #004a60;
    }

    .social-btns {
        margin-top: 20px;
    }

    .social-btns a {
        margin: 0 10px;
        color: white;
        transition: color 0.3s ease;
    }

    .social-btns a:hover {
        color: #008cba;
    }

    .social-btns a i {
        font-size: 30px; 
    }
</style>
</head>
<body>

<div class="login-container">
    <i class="fas fa-user"></i>
    <h2>Administrator</h2>
    <form action="dashboard.php" method="POST">
        <input name="email" type="text" class="input-field" placeholder="Email" required>
        <input name="password" type="password" class="input-field" placeholder="Password" required>
        <button type="submit" class="login-btn">Login</button>
    </form>
    <div class="social-btns">
        <a href="https://www.facebook.com/login/" class="facebook"><i class="fab fa-facebook"></i></a>
        <a href="https://x.com/i/flow/login" class="twitter"><i class="fab fa-twitter"></i></a>
        <a href="https://accounts.google.com/v3/signin/identifier" class="google"><i class="fab fa-google"></i></a>
    </div>
</div>

</body>
</html>