<html>
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .header {
            background-image: url('backend/admin/assets/images/bg-pattern.jpg');
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .header h1 {
            font-size: 48px;
            margin: 0;
        }
        .header p {
            font-size: 18px;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: -50px auto 0;
            background: white;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .form-group input {
    width: 100%;
    padding: 10px;
    border: 4px solid #ced4da;
    border-radius: 7px;
    font-size: 20px;
}
        .form-group input::placeholder {
            color: #ced4da;
        }
        .form-group input:focus {
            border-color: #80bdff;
            outline: none;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #8bc34a;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }
        .btn:hover {
            background-color: #7cb342;
        }
        .login-link {
            margin-top: 20px;
            text-align: center;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
  </style>
</head>
<body>
  <div class="header">
    <div>
      <h1>Sign Up</h1>
      <p>Home — Sign Up</p>
    </div>
  </div>
  <div class="container">
    <h2>Sign Up to your account</h2>
    <form method="post" action="register_process.php"> 
      <div class="form-group">
        <div>
          <label for="full-name">Full Name*</label>
          <input type="text" id="full-name" name="user_fullname" placeholder="Full Name" required> 
        </div>
        <div>
          <label for="email">Your Email*</label>
          <input type="email" id="email" name="user_email" placeholder="Your Email" required> 
        </div>
      </div>
      <div class="form-group">
        <div>
          <label for="mobile-number">Mobile Number*</label>
          <input type="text" id="mobile-number" name="user_mobile" placeholder="Mobile Number" required> 
        </div>
        <div>
          <label for="password">Password*</label>
          <input type="password" id="password" name="user_pwd" placeholder="Password" required> 
        </div>
      </div>
      <div class="form-group">
        <div style="width: 100%;">
          <label for="repeat-password">Repeat Password*</label>
          <input type="password" id="repeat-password" name="repeat_user_pwd" placeholder="Repeat Password" style="width: 100%;" required> 
        </div>
      </div>
      <div class="form-group">
        <button type="submit" name="user_register" class="btn">SIGNUP</button> 
      </div>
    </form>
    <div class="login-link">
      <p>Already have an account? <a href="user_login.php">Login Now!</a></p> 
    </div>
  </div>
</body>
</html>