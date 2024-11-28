<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $phar_id = $_SESSION['phar_id'];
  $phar_number = $_SESSION['phar_number'];
?>
<!DOCTYPE html>
<html lang="en">
    
    <?php include("assets/inc/head.php");?>

    <body>

        <div id="wrapper">

            <?php include('assets/inc/navp.php');?>
            <?php include('assets/inc/sidebarp.php');?>
            <div class="content-page">
                <div class="content">

                    <div class="container-fluid">
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Hospital Management Information System Dashboard</h4>
                                </div>
                            </div>
                        </div>     
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                                <i class="mdi mdi-pill font-22 avatar-title text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    /* 
                                                    * code for summing up number of pharmaceuticals,
                                                    */ 
                                                    $result ="SELECT count(*) FROM his_pharmaceuticals ";
                                                    $stmt = $mysqli->prepare($result);
                                                    $stmt->execute();
                                                    $stmt->bind_result($phar);
                                                    $stmt->fetch();
                                                    $stmt->close();
                                                ?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $phar;?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Pharmaceuticals</p>
                                            </div>
                                        </div>
                                    </div> </div> </div> <div class="col-md-6 col-xl-6">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                                                <i class="mdi mdi-flask font-22 avatar-title text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    /* 
                                                    * code for summing up number of assets,
                                                    */ 
                                                    $result ="SELECT count(*) FROM his_equipments ";
                                                    $stmt = $mysqli->prepare($result);
                                                    $stmt->execute();
                                                    $stmt->bind_result($assets);
                                                    $stmt->fetch();
                                                    $stmt->close();
                                                ?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $assets;?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Corporation Assets</p>
                                            </div>
                                        </div>
                                    </div> </div> </div> </div>
                        
                        </div> </div> <?php include('assets/inc/footer.php');?>
                </div>

            </div>
        <div class="right-bar">
            </div>
        <div class="rightbar-overlay"></div>

        <script src="assets/js/vendor.min.js"></script>

        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.time.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.selection.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.crosshair.js"></script>

        <script src="assets/js/pages/dashboard-1.init.js"></script>

        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>