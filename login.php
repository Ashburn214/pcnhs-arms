<!DOCTYPE html>
<html lang="en">
    <?php
        date_default_timezone_set('Asia/Manila');
        session_start();
        include_once 'resources/classes/Popover.php';

        if(!isset($_SESSION['logged_in']) && !isset($_SESSION['account_type'])){
          //header('Location: login.php');
        }else {
          $account_type = $_SESSION['account_type'];
          header("Location: $account_type/index.php");
        }
        
        

      ?>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PCNHS ARMS Login</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- <link rel="stylesheet" href="resources/assets/css/custom.min.css" rel="stylesheet"> -->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="images/pines.png">
        <style type="text/css">
             .transparent{
              background: rgba(0,0,0,0.5);

            }
            img {
                width: 120px;
            }
        </style>
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content transparent">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">

                            <h1><strong>PCNHS ARMS</strong> Login</h1>
                            <div class="description">
                                <p>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 col-sm-offset-3 form-box">
                            <!-- Generate Error Message -->
                            <?php
                            if(isset($_SESSION['error_pop'])) {
                                $error_message = $_SESSION['error_pop'];
                                echo $error_message;
                                session_unset();
                                session_destroy();
                            }
                                if(isset($_SESSION['timeout_message'])) {
                                $timeout_message = $_SESSION['timeout_message'];
                                $popover = new Popover();
                                $popover->set_popover("danger", $timeout_message);
                                echo $popover->get_popover();
                                session_unset();
                                session_destroy();
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
                                        <input type="text" name="username" placeholder="Username..." class="form-username form-control" id="form-username">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password">
                                    </div>
                                    <button type="submit" class="btn">Sign in</button>
                                </form>
                                <br>
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
        
        <script type="text/javascript">
            jQuery(document).ready(function() {
    
                /*
                    Fullscreen background
                */
                $.backstretch([
                                "assets/images/backgrounds/bg.png"
                             ], {duration: 3000, fade: 750});
                
                /*
                    Form validation
                */
                $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
                    $(this).removeClass('input-error');
                });
                
                $('.login-form').on('submit', function(e) {
                    
                    $(this).find('input[type="text"], input[type="password"], textarea').each(function(){
                        if( $(this).val() == "" ) {
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