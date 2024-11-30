<?php
session_start();
include('assets/inc/config.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['doc_id'])) {
    header("Location: user_login.php");
    exit();
}

// Xử lý xác nhận hoặc hủy cuộc hẹn
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'];

    if (isset($_POST['confirm_appointment'])) {
        // Cập nhật trạng thái cuộc hẹn thành 'Confirmed'
        $stmt = $mysqli->prepare("UPDATE his_appointments SET appointment_status = 'Confirmed' WHERE appointment_id = ?");
        $stmt->bind_param('i', $appointment_id);
        $stmt->execute();
        $success = "Appointment confirmed successfully!";
    } elseif (isset($_POST['cancel_appointment'])) {
        // Xóa cuộc hẹn
        $stmt = $mysqli->prepare("DELETE FROM his_appointments WHERE appointment_id = ?");
        $stmt->bind_param('i', $appointment_id);
        $stmt->execute();
        $success = "Appointment canceled successfully!";
    }

    // Chuyển hướng sau khi xử lý
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


// Lấy danh sách cuộc hẹn
$query = "SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.appointment_status, 
                 a.appointment_note, 
                 u.user_fname, u.user_lname, u.user_mobile 
          FROM his_appointments a
          JOIN users u ON a.patient_id = u.user_id
          ORDER BY a.appointment_date DESC";

$result = $mysqli->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Manage Appointments</title>
    <?php include('assets/inc/head.php');?>
</head>
<body>
    <div id="wrapper">
    <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
    <?php include("assets/inc/sidebar.php");?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="page-title">Manage Appointments</h4>
                        </div>
                    </div>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php } ?>

                    <div class="card-box">
                        <h4 class="header-title">Appointments</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Phone</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Note</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0) { 
                                    $count = 1;
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $row['user_fname'] . " " . $row['user_lname']; ?></td>
                                            <td><?php echo $row['user_mobile']; ?></td>
                                            <td><?php echo $row['appointment_date']; ?></td>
                                            <td><?php echo $row['appointment_time']; ?></td>
                                            <td><?php echo $row['appointment_status']; ?></td>
                                            <td><?php echo $row['appointment_note']; ?></td>
                                            <td>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                                    <button type="submit" name="confirm_appointment" class="btn btn-success btn-sm">Confirm</button>
                                                </form>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                                    <button type="submit" name="cancel_appointment" class="btn btn-danger btn-sm">Cancel</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No Appointments Found</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <?php include('assets/inc/footer.php'); ?>
        </div>
    </div>
    <script src="assets/js/app.min.js"></script>
</body>
</html>
