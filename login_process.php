<?php
session_start();
include('backend/admin/assets/inc/config.php');

if (isset($_POST['user_email']) && isset($_POST['password'])) {
    $user_email = trim($_POST['user_email']);
    $password = md5($_POST['password']); // Nếu sử dụng MD5, sửa lại nếu dùng password_hash

    if (empty($user_email) || empty($password)) {
        $err = "Email and password are required.";
        header("location:user_login.php?error=" . urlencode($err));
        exit;
    }

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE user_email = ? AND user_pwd = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param('ss', $user_email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_email'] = $row['user_email'];
        header("location:user_dashboard.php");
        exit;
    } else {
        $err = "Invalid email or password.";
        header("location:user_login.php?error=" . urlencode($err));
        exit;
    }
} else {
    $err = "Please fill out the login form.";
    header("location:user_login.php?error=" . urlencode($err));
    exit;
}
?>
