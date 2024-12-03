<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['update_profile'])) {
    $user_fname = $_POST['user_fname'];
    $user_lname = $_POST['user_lname'];
    $user_email = $_POST['user_email'];
    $user_rank = $_POST['user_rank'];  // New field for rank
    $user_mobile = $_POST['user_mobile'];  // New field for phone number
    $user_id = $_SESSION['user_id'];
    $user_dpic = $_FILES["user_dpic"]["name"];

    // Upload avatar if provided
    if ($user_dpic != '') {
        move_uploaded_file($_FILES["user_dpic"]["tmp_name"], "assets/images/users/" . $user_dpic);
    } else {
        $user_dpic = 'default.jpg'; // Default image if no new image is provided
    }

    // Update user profile information including rank and phone
    $query = "UPDATE users SET user_fname = ?, user_lname = ?, user_email = ?, user_rank = ?, user_mobile = ?, user_dpic = ? WHERE user_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssssi', $user_fname, $user_lname, $user_email, $user_rank, $user_mobile, $user_dpic, $user_id);
    $stmt->execute();

    if ($stmt) {
        $success = "Profile Updated Successfully!";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

// Update password
if (isset($_POST['update_pwd'])) {
    $user_pwd = sha1(md5($_POST['user_pwd'])); // Encrypt password

    $query = "UPDATE users SET user_pwd = ? WHERE user_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('si', $user_pwd, $_SESSION['user_id']);
    $stmt->execute();

    if ($stmt) {
        $success = "Password Updated Successfully!";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
    <div id="wrapper">
        <?php include('nav.php'); ?>

        <?php
        $user_id = $_SESSION['user_id'];
        $ret = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_object()) {
        ?>
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title"><?php echo $row->user_fname; ?> <?php echo $row->user_lname; ?>'s Profile</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Display user info -->
                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    <img src="assets/images/users/<?php echo $row->user_dpic; ?>" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                    <div class="text-center mt-3">
                                        <p class="text-muted mb-2 font-13"><strong>Full Name:</strong> <span class="ml-2"><?php echo $row->user_fname . ' ' . $row->user_lname; ?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Email:</strong> <span class="ml-2"><?php echo $row->user_email; ?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Rank:</strong> <span class="ml-2"><?php echo $row->user_rank; ?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Phone:</strong> <span class="ml-2"><?php echo $row->user_mobile; ?></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8 col-xl-8">
                                <div class="card-box">
                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                        <li class="nav-item">
                                            <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">Update Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">Change Password</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="aboutme">
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input type="text" name="user_fname" class="form-control" value="<?php echo $row->user_fname; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input type="text" name="user_lname" class="form-control" value="<?php echo $row->user_lname; ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" name="user_email" class="form-control" value="<?php echo $row->user_email; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Rank</label>
                                                            <input type="text" name="user_rank" class="form-control" value="<?php echo $row->user_rank; ?>"> <!-- Rank -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Phone Number</label>
                                                            <input type="text" name="user_mobile" class="form-control" value="<?php echo $row->user_mobile; ?>"> <!-- Phone -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Profile Picture</label>
                                                            <input type="file" name="user_dpic" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-right">
                                                    <button type="submit" name="update_profile" class="btn btn-success">Save</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane" id="settings">
                                            <form method="post">
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input type="password" name="user_pwd" class="form-control" placeholder="Enter New Password">
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" name="update_pwd" class="btn btn-success">Update Password</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
