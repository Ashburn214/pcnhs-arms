<?php require_once "../../resources/config.php"; ?>
<!DOCTYPE html>
<?php
    session_start();
    // Session Timeout
    $time = time();
    $session_timeout = 1800; //seconds
    
    if(isset($_SESSION['last_activity']) && ($time - $_SESSION['last_activity']) > $session_timeout) {
      session_unset();
      session_destroy();
      session_start();
    }

    $_SESSION['last_activity'] = $time;
    if(!isset($_SESSION['logged_in']) && !isset($_SESSION['account_type'])){
      header('Location: ../../login.php');
    }
    
  ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="../../resources/libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../resources/libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../resources/libraries/nprogress/nprogress.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../../css/custom.min.css" rel="stylesheet">
    <link href="../../css/tstheme/style.css" rel="stylesheet">

</head> 
<body class="nav-md">
<!-- Sidebar -->
<?php include "../../resources/templates/admin/sidebar.php"; ?>
<!-- Top Navigation -->
<?php include "../../resources/templates/admin/top-nav.php"; ?>
<!-- Content Here -->
<!-- page content -->
<div class="right_col" role="main">
    <div class="row top_tiles">

    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-user"> </i> View Personnel Account</h2>
                    <div class="clearfix"></div>
                    <br>

                    <div class="x_content">
                        <form class="form-horizontal form-label-left" action="phpupdate/personnel_update_info.php" method="POST" novalidate>
                            <?php require_once "../../resources/config.php";

                            $per_id = $_GET['per_id'];
                            $uname;
                            $password;
                            $last_name;
                            $first_name;
                            $mname;
                            $position;
                            $access_type;
                            $accnt_status;

                            $statement = "SELECT * FROM pcnhsdb.personnel WHERE personnel.per_id = '$per_id'";
                            $result = $conn->query($statement);
                            if($result->num_rows>0) {
                                while($row=$result->fetch_assoc()){

                                    $uname = $row['uname'];
                                    $password = $row['password'];
                                    $last_name = $row['last_name'];
                                    $first_name = $row['first_name'];
                                    $mname = $row['mname'];
                                    $position = $row['position'];
                                    $access_type = $row['access_type'];
                                    $accnt_status = $row['accnt_status'];
                                }
                            }
                            $conn->close();
                            ?>

                            <div class="item form-group"><br>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Personnel ID</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="per_id" class="form-control col-md-7 col-xs-12" required="required" type="text" name="per_id" readonly value=<?php echo "'$per_id'"; ?>>
                                    <?php $_SESSION['per_id']=$per_id?>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">User Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="uname" class="form-control col-md-7 col-xs-12" required="required" type="text" name="uname" readonly value=<?php echo "'$uname'"; ?>>
                                    <?php
                                            if(isset($_SESSION['error_msg_personnel_edit'])) {
                                                $error_msg_personnel_edit = $_SESSION['error_msg_personnel_edit'];
                                                echo "<p style='color: red'>$error_msg_personnel_edit</p>";
                                                unset($_SESSION['error_msg_personnel_edit']);
                                         } 
                                     ?>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password" class="form-control col-md-7 col-xs-12" required="required" type="password" name="password" readonly value=<?php echo "'$password'"; ?>>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="last_name" class="form-control col-md-7 col-xs-12" required="required" type="text" name="last_name" readonly value=<?php echo "'$last_name'"; ?>>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">First Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="first_name" class="form-control col-md-7 col-xs-12" required="required" type="text" name="first_name" readonly value=<?php echo "'$first_name'"; ?>>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Middle Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="mname" class="form-control col-md-7 col-xs-12" required="required" type="text" name="mname" readonly value=<?php echo "'$mname'"; ?>>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Position</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="position" class="form-control col-md-7 col-xs-12" required="required" type="text" name="position" readonly value=<?php echo "'$position'"; ?>>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Access Type</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="access_type" class="form-control col-md-7 col-xs-12" required="required" type="text" name="access_type" readonly value=<?php echo "'$access_type'"; ?>>
                                </div>

                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Account Status</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="accnt_status" class="form-control col-md-7 col-xs-12" required="required" type="text" name="accnt_status" readonly value=<?php echo "'$accnt_status'"; ?>>
                                </div>

                            </div>

                            <div class="form-group">
                                <br>
                                <div class="col-md-5 col-md-offset-3 pull-left">
                                    <a href = <?php echo "personnel_edit.php?per_id=$per_id" ?> button type="submit" class="btn btn-primary " >Edit Profile</a>
                                    <a href = "" button type="submit" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm" >Remove</a> &nbsp&nbsp&nbsp&nbsp
                                    <a href = "personnels.php" button type="submit" class="btn btn-primary " >View Personnels</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- /page content -->
    <!-- Content Here -->
<!-- Small modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Remove Personnel Account :<br>
                    <b><?php echo "$uname";?></b>
                </h4>
            </div>
            <div class="modal-body">
                    <!-- start form for validation -->
                    <form id="change-pw" action="phpdelete/delete.php" method="DELETE" data-parsley-validate>
                        <label for="cpw">Enter Personnel Account Password :</label>
                        <input type="password" id="vpw" class="form-control" name="vpw" required 
                            data-parsley-minlength="4"
                            data-parsley-minlength-message="Password should be greater than 4 characters"
                            data-parsley-maxlength="50"
                            data-parsley-maxlength-message="Error"
                            data-parsley-equalto="#password"
                            data-parsley-equalto-message="Incorrect Personnel Account Password">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" >Remove</button>
                        </div>

                    </form>
                </div>
        </div>
    </div>
</div>
<!-- /modals -->
    <!-- Footer -->
    <?php include "../../resources/templates/admin/footer.php"; ?>
    <!-- Scripts -->
    <!-- jQuery -->
    <script src="../../resources/libraries/jquery/dist/jquery.min.js" ></script>
    <!-- Bootstrap -->
    <script src="../../resources/libraries/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src= "../../resources/libraries/fastclick/lib/fastclick.js"></script>
    <!-- input mask -->
    <script src= "../../resources/libraries/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src= "../../resources/libraries/parsleyjs/dist/parsley.min.js"></script>
    <!-- NProgress -->
    <script src="../../resources/libraries/nprogress/nprogress.js"></script>
    <!-- Custom Theme Scripts -->
    <script src= "../../js/custom.min.js"></script>
    <!-- Scripts -->
    <!-- Parsley -->
</body>
</html>