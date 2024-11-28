<?php
    session_start();
    include('assets/inc/config.php');
    if(isset($_POST['update_profile']))
    {
        $phar_fname=$_POST['phar_fname'];
        $phar_lname=$_POST['phar_lname'];
        $phar_id=$_SESSION['phar_id'];
        $phar_email=$_POST['phar_email'];
        // $phar_pwd=sha1(md5($_POST['phar_pwd']));
        $phar_dpic=$_FILES["phar_dpic"]["name"];
        move_uploaded_file($_FILES["phar_dpic"]["tmp_name"],"assets/images/users/".$_FILES["phar_dpic"]["name"]);

        //sql to insert captured values
        $query="UPDATE his_pharmacists SET phar_fname=?, phar_lname=?,  phar_email=?, phar_dpic=? WHERE phar_id = ?";
        $stmt = $mysqli->prepare($query);
        $rc=$stmt->bind_param('ssssi', $phar_fname, $phar_lname, $phar_email, $phar_dpic, $phar_id);
        $stmt->execute();

        if($stmt)
        {
            $success = "Profile Updated";
        }
        else {
            $err = "Please Try Again Or Try Later";
        }
    }
    
    if(isset($_POST['update_pwd']))
    {
        $phar_number=$_SESSION['phar_number'];
        $phar_pwd=sha1(md5($_POST['phar_pwd']));//double encrypt 
        
        //sql to insert captured values
        $query="UPDATE his_pharmacists SET phar_pwd =? WHERE phar_number = ?";
        $stmt = $mysqli->prepare($query);
        $rc=$stmt->bind_param('si', $phar_pwd, $phar_number);
        $stmt->execute();
        
        if($stmt)
        {
            $success = "Password Updated";
        }
        else {
            $err = "Please Try Again Or Try Later";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php include('assets/inc/head.php');?>
    <body>
        <div id="wrapper">
            <?php include('assets/inc/navp.php');?>
            <?php include('assets/inc/sidebarp.php');?>

            <?php
                $phar_id=$_SESSION['phar_id'];
                $ret="SELECT * FROM  his_pharmacists where phar_id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('i',$phar_id);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                while($row=$res->fetch_object())
                {
            ?>
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $row->phar_fname;?> <?php echo $row->phar_lname;?>'s Profile</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    <img src="../doc/assets/images/users/<?php echo $row->phar_dpic;?>" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                                    <div class="text-centre mt-3">
                                        <p class="text-muted mb-2 font-13"><strong>Employee Full Name :</strong> <span class="ml-2"><?php echo $row->phar_fname;?> <?php echo $row->phar_lname;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Employee Department :</strong> <span class="ml-2"><?php echo $row->phar_dept;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Employee Number :</strong> <span class="ml-2"><?php echo $row->phar_number;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Employee Email :</strong> <span class="ml-2"><?php echo $row->phar_email;?></span></p>
                                    </div>
                                </div> 
                            </div> 

                            <div class="col-lg-8 col-xl-8">
                                <div class="card-box">
                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                        <li class="nav-item">
                                            <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                                Update Profile
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Change Password
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="aboutme">
                                            <form method="post" enctype="multipart/form-data">
                                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="firstname">First Name</label>
                                                            <input type="text" name="phar_fname"  class="form-control" id="firstname" placeholder="<?php echo $row->phar_fname;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lastname">Last Name</label>
                                                            <input type="text" name="phar_lname" class="form-control" id="lastname" placeholder="<?php echo $row->phar_lname;?>">
                                                        </div>
                                                    </div> 
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="useremail">Email Address</label>
                                                            <input type="email" name="phar_email" class="form-control" id="useremail" placeholder="<?php echo $row->phar_email;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="useremail">Profile Picture</label>
                                                            <input type="file" name="phar_dpic" class="form-control btn btn-success" id="useremail" >
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="text-right">
                                                    <button type="submit" name="update_profile" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                                </div>
                                            </form>
                                        </div> 
                                        <div class="tab-pane" id="settings">
                                            <form method="post">
                                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="firstname">Old Password</label>
                                                            <input type="password" class="form-control" id="firstname" placeholder="Enter Old Password">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lastname">New Password</label>
                                                            <input type="password" class="form-control" name="phar_pwd" id="lastname" placeholder="Enter New Password">
                                                        </div>
                                                    </div> 
                                                </div> 
                                                <div class="form-group">
                                                    <label for="useremail">Confirm Password</label>
                                                    <input type="password" class="form-control" id="useremail" placeholder="Confirm New Password">
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" name="update_pwd" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update Password</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div> 
                                </div> 
                            </div> 
                        </div>
                    </div> 
                </div>
                <?php include("assets/inc/footer.php");?>
            </div>
            <?php }?>
        </div>
        <div class="rightbar-overlay"></div>
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>
    </body>
</html>