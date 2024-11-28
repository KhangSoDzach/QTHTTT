<?php
session_start();
include('backend/doc/assets/inc/config.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// Lấy thông tin người dùng
$user_id = $_SESSION['user_id'];

// Xử lý đăng ký lịch hẹn khám bệnh
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_appointment'])) {
    $doctor_id = $_POST["doctor_id"];
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];

    // Thêm lịch hẹn vào database
    $stmt = $mysqli->prepare("INSERT INTO his_appointments (patient_id, doctor_id, appointment_date, appointment_time) 
            VALUES (?, ?, ?, ?)");
    $stmt->bind_param('iiss', $user_id, $doctor_id, $appointment_date, $appointment_time);

    if ($stmt->execute()) {
        $success = "Đặt lịch hẹn thành công.";
    } else {
        $err = "Lỗi: " . $stmt->error;
    }
}

// Hiển thị lịch sử khám sức khỏe
$sql = "SELECT * FROM his_appointments WHERE patient_id = $user_id";
$result = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="utf-8" />
    <title>Hospital Management Information System - HMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <div id="wrapper">

        <?php include('backend/doc/assets/inc/nav.php');?>
        <?php include('backend/doc/assets/inc/sidebar.php');?>
        <div class="content-page">
            <div class="content">

                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                        <li class="breadcrumb-item active">Add Patient</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Add Patient Details</h4>
                            </div>
                        </div>
                    </div>     
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="header-title"></h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form method="post">
                                                <div class="form-group row">
                                                    <label class="col-md-2 col-form-label" for="simpleinput">Select Doctor</label>
                                                    <div class="col-md-10">
                                                        <select name="doctor_id" id="doctor_id" class="form-control" required="required">
                                                            <option value="">Select Doctor</option>
                                                            <?php
                                                            // Lấy danh sách bác sĩ từ database
                                                            $sql_doctors = "SELECT * FROM his_docs"; 
                                                            $result_doctors = $mysqli->query($sql_doctors);

                                                            if ($result_doctors->num_rows > 0) {
                                                                while($row = $result_doctors->fetch_assoc()) {
                                                                    echo "<option value='" . $row["doc_id"] . "'>" . $row["doc_fname"] . " " . $row["doc_lname"] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-2 col-form-label" for="example-email">Appointment Date</label>
                                                    <div class="col-md-10">
                                                        <input type="date" id="appointment_date" name="appointment_date" class="form-control" placeholder="Enter Appointment Date" required="required">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-2 col-form-label" for="example-placeholder">Appointment Time</label>
                                                    <div class="col-md-10">
                                                        <input type="time" id="appointment_time" name="appointment_time" class="form-control" placeholder="Enter Appointment Time" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group text-right mb-0">
                                                    <button class="btn btn-primary waves-effect waves-light mr-1" type="submit" name="book_appointment">
                                                        Submit
                                                    </button>
                                                    <button type="reset" class="btn btn-secondary waves-effect waves-light">
                                                        Cancel
                                                    </button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Ngày khám</th>
                                                    <th>Thời gian</th>
                                                    <th>Bác sĩ</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        // Lấy tên bác sĩ
                                                        $doc_id = $row['doctor_id']; 
                                                        $sql_doc = "SELECT doc_fname, doc_lname FROM his_docs WHERE doc_id = $doc_id";
                                                        $result_doc = $mysqli->query($sql_doc);
                                                        $row_doc = $result_doc->fetch_assoc();
                                                        echo "<tr>";
                                                        echo "<td>" . $row["appointment_date"] . "</td>";
                                                        echo "<td>" . $row["appointment_time"] . "</td>";
                                                        echo "<td>" . $row_doc['doc_fname'] . " " . $row_doc['doc_lname'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='3'>Không có lịch sử khám bệnh.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    </div> </div> <?php include('backend/doc/assets/inc/footer.php');?>
            </div>

        </div>
    <div class="rightbar-overlay"></div>

    <script src="assets/js/vendor.min.js"></script>

    <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css" />
    <link href="assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

    <script src="assets/js/app.min.js"></script>
    
</body>

</html>