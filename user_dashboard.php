<?php
session_start();
include('backend/doc/assets/inc/config.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin lịch sử khám và danh sách bác sĩ
$sql = "SELECT a.appointment_date, a.appointment_time, a.appointment_status, 
               d.doc_fname, d.doc_lname 
        FROM his_appointments a 
        JOIN his_docs d ON a.doctor_id = d.doc_id 
        WHERE a.patient_id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Lấy danh sách bác sĩ
$sql_doctors = "SELECT * FROM his_docs";
$result_doctors = $mysqli->query($sql_doctors);

// Xử lý đặt lịch hẹn
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_appointment'])) {
    $doctor_id = $_POST["doctor_id"];
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];
    $appointment_note = $_POST["appointment_note"]; // Lấy ghi chú từ form

    $stmt = $mysqli->prepare("INSERT INTO his_appointments (patient_id, doctor_id, appointment_date, appointment_time, appointment_note) 
                              VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('iisss', $user_id, $doctor_id, $appointment_date, $appointment_time, $appointment_note);

    if ($stmt->execute()) {
        $success = "Đặt lịch hẹn thành công.";
        // Chuyển hướng sau khi thêm thành công
        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); // Kết thúc script để ngăn xử lý thêm
    } else {
        $err = "Lỗi: " . $stmt->error;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>User Dashboard - HMS</title>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" /> -->
    <?php include("head.php");?>
</head>

<body>
    <div id="wrapper">
        <?php include('nav.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- Breadcrumb -->
                    <div class="row">
                        <div class="col-12">
                            <h4 class="page-title">Dashboard - User</h4>
                        </div>
                    </div>

                    <!-- Success/Error messages -->
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php } ?>
                    <?php if (isset($err)) { ?>
                        <div class="alert alert-danger"><?php echo $err; ?></div>
                    <?php } ?>

                    <!-- Form đặt lịch -->
                    <div class="card-box">
                        <h4 class="header-title">Đặt Lịch Hẹn</h4>
                        <form method="post">
                            <div class="form-group">
                                <label for="doctor_id">Chọn bác sĩ</label>
                                <select name="doctor_id" class="form-control" required>
                                    <option value="">-- Chọn bác sĩ --</option>
                                    <?php while ($doc = $result_doctors->fetch_assoc()) { ?>
                                        <option value="<?php echo $doc['doc_id']; ?>">
                                            <?php echo $doc['doc_fname'] . " " . $doc['doc_lname']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="appointment_date">Ngày hẹn</label>
                                <input type="date" name="appointment_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="appointment_time">Giờ hẹn</label>
                                <input type="time" name="appointment_time" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="appointment_note">Ghi chú</label>
                                <textarea name="appointment_note" class="form-control" rows="3" placeholder="Nhập ghi chú nếu có..."></textarea>
                            </div>

                            <button type="submit" name="book_appointment" class="btn btn-primary">Đặt lịch</button>
                        </form>
                    </div>

                    <!-- Lịch sử khám -->
                    <div class="card-box">
                        <h4 class="header-title">Lịch Sử Khám</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ngày</th>
                                    <th>Giờ</th>
                                    <th>Bác sĩ</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['appointment_date']; ?></td>
                                        <td><?php echo $row['appointment_time']; ?></td>
                                        <td><?php echo $row['doc_fname'] . " " . $row['doc_lname']; ?></td>
                                        <td><?php echo $row['appointment_status']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <?php include('backend/doc/assets/inc/footer.php'); ?>
        </div>
    </div>

    <script src="assets/js/app.min.js"></script>
</body>
</html>
