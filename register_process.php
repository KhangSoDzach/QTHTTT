<?php
session_start();
include('backend/admin/assets/inc/config.php'); 

if(isset($_POST['user_register'])) {
    $user_email = $_POST['user_email'];
    $user_pwd = md5($_POST['user_pwd']); // Sử dụng MD5, nhưng khuyến khích bcrypt
    $user_rank = 'standard'; 

    // Kiểm tra xem email đã tồn tại chưa
    $stmt = $mysqli->prepare("SELECT user_id FROM users WHERE user_email=? "); 
    $stmt->bind_param('s', $user_email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        $err = "Email đã tồn tại.";
        header("location:user_register.php?error=" . urlencode($err)); 
        exit(); // Dừng script sau khi chuyển hướng
    } else {
        // Thêm người dùng mới
        $stmt = $mysqli->prepare("INSERT INTO users (user_email, user_pwd, user_rank) VALUES (?, ?, ?)"); 
        $stmt->bind_param('sss', $user_email, $user_pwd, $user_rank);

        if ($stmt->execute()) {
            $success = "Đăng ký thành công.";
            header("location:user_login.php?success=" . urlencode($success)); 
            exit(); // Dừng script sau khi chuyển hướng
        } else {
            $err = "Lỗi khi đăng ký: " . $stmt->error; // Hiển thị lỗi SQL cụ thể
            header("location:user_register.php?error=" . urlencode($err)); 
            exit(); // Dừng script sau khi chuyển hướng
        }
    }

    $stmt->close(); // Giải phóng prepared statement
}
?>