<?php
    // Lấy ID và email của user từ session
    $user_id = $_SESSION['user_id'];
    $user_email = $_SESSION['user_email'];

    // Truy vấn để lấy thông tin user
    $ret = "SELECT * FROM users WHERE user_id = ? AND user_email = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('is', $user_id, $user_email);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_object()) {
?>
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">

            <!-- Thanh tìm kiếm -->
            <li class="d-none d-sm-block">
                <form class="app-search">
                    <div class="app-search-box">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <button class="btn" type="submit">
                                    <i class="fe-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </li>

            <!-- Thông tin người dùng và các nút -->
            <li class="notification-list">
                <div class="nav-link nav-user mr-0 waves-effect waves-light d-flex align-items-center">
                    <img src="assets/images/users/default-user.png" alt="dpic" class="rounded-circle" style="height: 40px;"> <!-- Ảnh mặc định -->
                    <span class="pro-user-name ml-2">
                        <?php echo $row->user_id; ?> - <?php echo $row->user_email; ?>
                    </span>
                    <!-- Update Account -->
                    <a href="update_user_account.php" class="btn btn-sm btn-outline-primary ml-3">
                        <i class="fas fa-user-tag"></i> Update Account
                    </a>
                    <!-- Logout -->
                    <a href="logout.php" class="btn btn-sm btn-outline-danger ml-2">
                        <i class="fe-log-out"></i> Logout
                    </a>
                </div>
            </li>
        </ul>

        <!-- Logo -->
        <div class="logo-box">
            <a href="user_dashboard.php" class="logo text-center">
                <span class="logo-lg">
                    <img src="assets/images/logo-light.png" alt="" height="18">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm-white.png" alt="" height="24">
                </span>
            </a>
        </div>

        <!-- Menu trái -->
        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li class="dropdown d-none d-lg-block">
                <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    Create New
                    <i class="mdi mdi-chevron-down"></i>
                </a>
                <div class="dropdown-menu">
                    <!-- Tạo mới bệnh nhân -->
                    <a href="register_patient.php" class="dropdown-item">
                        <i class="fe-activity mr-1"></i>
                        <span>Patient</span>
                    </a>

                    <!-- Tạo mới báo cáo phòng thí nghiệm -->
                    <a href="lab_report.php" class="dropdown-item">
                        <i class="fe-hard-drive mr-1"></i>
                        <span>Laboratory Report</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
<?php } ?>
