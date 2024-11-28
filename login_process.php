<?php
session_start();
include('backend/admin/assets/inc/config.php'); // Thay đổi đường dẫn nếu cần

if(isset($_POST['user_email']) && isset($_POST['password'])) { // Thay đổi user_number thành user_email
    $user_email = $_POST['user_email'];
    $password = md5($_POST['password']); // Sử dụng MD5 

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE user_email=? AND user_pwd=? ");  // Thay đổi bảng his_docs thành users và doc_number thành user_email, doc_pwd thành user_pwd
    $stmt->bind_param('ss', $user_email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id']; // Thay đổi doc_id thành user_id
        // ... Lưu thêm thông tin vào session nếu cần ...
        header("location:user_dashboard.php"); // Thay đổi đường dẫn đến user dashboard
    } else {
        $err = "Access Denied Please Check Your Credentials";
        header("location:user_login.php?error=" . urlencode($err));  // Thay đổi đường dẫn đến user login
    }
}
?>