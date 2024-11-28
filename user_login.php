<html>
<head>
    <title>HMS Login</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('backend/admin/assets/images/bg-pattern.jpg') no-repeat center center fixed;
            background-size: cover;
            filter: grayscale(100%);
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }
        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .login-container p {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }
        .login-container input[type="email"], .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container button {
            background-color: #00bfa5;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .login-container button:hover {
            background-color: #009688;
        }
        .login-container a {
            display: block;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-decoration: none;
        }
        .footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
  <div class="login-container">
    <h1>HMS</h1>
    <p>Enter your email address and password to access User panel.</p> 
    <form action="login_process.php" method="post"> 
      <input type="email" id="email" name="user_email" placeholder="Enter your email" required /> 
      <input type="password" name="password" placeholder="Enter your password" required />
      <button type="submit">Log In</button>
    </form>
    <a href="#">Forgot your password?</a>
  </div>
  <div class="footer">
    2020 - 2024 © Hospital Management System.
  </div>
</body>
</html>