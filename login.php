<!DOCTYPE html>
<html lang="en">
<?php
    require_once "resources/config.php";
    date_default_timezone_set('Asia/Manila');
    session_start();
    include_once 'resources/classes/Popover.php';
    if (!isset($_SESSION['logged_in']) && !isset($_SESSION['account_type'])) {
    } else {
        $account_type = $_SESSION['account_type'];
        header("Location: $account_type/index.php");
    }

    $curr_month = date('F');

    $query = "SELECT * from backups where month = '$curr_month';";
    $result1 = DB::query($query);

    if (count($result1) > 0) {
        foreach ($result1 as $row) {
            if (($curr_month === "June" && $row['status'] == 0) || ($curr_month === "September" && $row['status'] == 0) ||
                ($curr_month === "December" && $row['status'] == 0) || ($curr_month === "March" && $row['status'] == 0)) {

                $alert_type = "success";
                $message = "Gentle Reminder: The system is scheduled for quarterly database backup,
                            login time may take longer than usual.";
                $popover = new Popover();
                $popover->set_popover($alert_type, $message);
                $_SESSION['backup_notif'] = $popover->get_popover();
            }
        }
    }


?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/form-elements.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="resources/libraries/nprogress/nprogress.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="resources/assets/css/custom.min.css" rel="stylesheet"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="assets/images/ico/fav.png">
</head>

<body>

<!-- Top content -->
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
           <!--  <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">

                    <h1><img src="assets/images/pcnhslogo.png" style='height: 80px; width: 80px;'/> <strong>PCNHS
                            ARMS</strong></h1>
                    <div class="description">
                        <p>
                        </p>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-sm-5 col-sm-offset-3 form-box">
                    <!-- Generate Error Message -->
                    <?php
                    if (isset($_SESSION['error_pop'])) {
                        $error_message = $_SESSION['error_pop'];
                        echo $error_message;
                        session_unset();
                        session_destroy();
                    }
                    if (isset($_SESSION['timeout_message'])) {
                        $timeout_message = $_SESSION['timeout_message'];
                        $popover = new Popover();
                        $popover->set_popover("danger", $timeout_message);
                        echo $popover->get_popover();
                        session_unset();
                        session_destroy();
                    }
                    if (isset($_SESSION['backup_notif'])) {
                        echo $_SESSION['backup_notif'];
                        unset($_SESSION['backup_notif']);
                    }
                    ?>
                    <!-- Generate Error Message -->
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Pines City National Highschool</h3>
                            <p>Academic Records Management System</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="resources/verify.php" method="post" class="login-form">
                            <div class="form-group">
                                <label class="sr-only" for="form-username">Username</label>
                                <input type="text" name="username" placeholder="Username..."
                                       class="form-username form-control" id="form-username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="password" placeholder="Password..."
                                       class="form-password form-control" id="form-password">
                            </div>
                            <button type="submit" class="btn">Sign in</button>

                        </form>
                        <br>
                        <center>
                            <a href="#" data-toggle="tooltip" data-placement="top"
                               title="Login as System Administrator to add an account.">
                                Create an Account</a>
                                |
                            <a href="#" data-toggle="tooltip" data-placement="top"
                               title="Contact System Administrator to reset password.">
                                Reset Password</a>
                                |
                            <a href="help.php">Help Page</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Javascript -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<!-- jQuery -->

<!-- Bootstrap -->
<script src="resources/libraries/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="resources/libraries/fastclick/lib/fastclick.js"></script>
<!-- input mask -->
<script src="resources/libraries/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<script src="resources/libraries/parsleyjs/dist/parsley.min.js"></script>
<!-- NProgress -->
<script src="resources/libraries/nprogress/nprogress.js"></script>
<!-- Custom Theme Scripts -->
<script src="assets/js/custom.min.js"></script>
<script type="text/javascript">
    $(function () {

        /*
         Fullscreen background
         */
        $.backstretch([
            "assets/images/backgrounds/bg.png"
        ], {fade: 750});

        /*
         Form validation
         */
        $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function () {
            $(this).removeClass('input-error');
        });

        $('.login-form').on('submit', function (e) {

            $(this).find('input[type="text"], input[type="password"], textarea').each(function () {
                if ($(this).val() == "") {
                    e.preventDefault();
                    $(this).addClass('input-error');
                }
                else {
                    $(this).removeClass('input-error');
                }
            });

        });


    });
</script>
<!--[if lt IE 10]>
<script src="assets/js/placeholder.js"></script>
<![endif]-->

</body>

</html>
