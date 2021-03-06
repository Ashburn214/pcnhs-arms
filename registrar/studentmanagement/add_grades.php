<!DOCTYPE html>
<?php require_once "../../resources/config.php"; ?>
<?php include('include_files/session_check.php'); ?>
<?php
  ob_start();
?>
<?php
    $stud_id = "";
    if(isset($_GET['stud_id']) && isset($_GET['yr_level'])) {
        $stud_id = htmlspecialchars($_GET['stud_id'], ENT_QUOTES);
        $yr_level = htmlspecialchars($_GET['yr_level']);
    }else {
        header("location: student_list.php");
    }

    $first_name;
    $last_name;
    $curriculum;
    $statement = "SELECT * FROM pcnhsdb.students left join curriculum on students.curr_id = curriculum.curr_id where students.stud_id = '$stud_id' limit 1";
    $result = DB::query($statement);
    if (!$result) {
    //echo "<p>Record Not Found. <a href='../../index.php'>Back to Home</a></p>";
    header("location: student_list.php");
    die();
    }
    foreach ($result as $row) {
      $curriculum = $row['curr_name'];
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
    }
?>
    <?php
    $stud_id = $_GET['stud_id'];
    $stryr = "";
    if($_GET['yr_level'] > 1) {
    $pschool_year = "";
    $yr_level_1 = intval($_GET['yr_level'])-1;
    $statement = "SELECT distinct(schl_name) as 'schl_name', studentsubjects.yr_level, studentsubjects.schl_year FROM pcnhsdb.studentsubjects left join subjects on studentsubjects.subj_id = subjects.subj_id left join pcnhsdb.grades on studentsubjects.stud_id = grades.stud_id where studentsubjects.yr_level = '$yr_level_1' and studentsubjects.stud_id = '$stud_id';";
    $result = DB::query($statement);
    if(count($result) > 0) {
    foreach ($result as $row) {
    $pschool_year = $row['schl_year'];
    }
    $explode_pschool_year = explode("-", $pschool_year);
    $yr1 = intval($explode_pschool_year[0]);
    $yr2 = intval($explode_pschool_year[1]);
    $yr1plus1 = $yr1+1;
    $yr2plus1 = $yr2+1;
    $stryr = $yr1plus1.' - '.$yr2plus1;
    }
    }else {
    $pschool_year = "";
    $statement = "SELECT * FROM pcnhsdb.students NATURAL JOIN primaryschool where stud_id = '$stud_id';";
    $result = DB::query($statement);
    if(count($result) > 0) {
    foreach ($result as $row) {
    $pschool_year = $row['pschool_year'];
    }
    $explode_pschool_year = explode("-", $pschool_year);
    $yr1 = intval($explode_pschool_year[0]);
    $yr2 = intval($explode_pschool_year[1]);
    $yr1plus1 = $yr1+1;
    $yr2plus1 = $yr2+1;
    $stryr = $yr1plus1.' - '.$yr2plus1;
    }

    }
    ?>
    <?php
    $stud_id = $_GET['stud_id'];
    $statement = "SELECT * from students where stud_id = '$stud_id'";
    $second_school_name = "";
    $result = DB::query($statement);
    if(count($result) > 0) {
       foreach ($result as $row) {
        $second_school_name = $row['second_school_name'];
        } 
    }
    ?>
<html>
    <head>
        <title>Add Student Grades</title>
        <link rel="shortcut icon" href="../../assets/images/ico/fav.png" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- NProgress -->
        <link href="../../resources/libraries/nprogress/nprogress.css" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="../../resources/libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="../../resources/libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- Datatables -->
        <link href="../../resources/libraries/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="../../assets/css/custom.min.css" rel="stylesheet">
        <link href="../../assets/css/easy-autocomplete-topnav.css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="../js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="nav-md">
        <!-- Sidebar -->
        <?php include "../../resources/templates/registrar/sidebar.php"; ?>
        <!-- Top Navigation -->
        <?php include "../../resources/templates/registrar/top-nav.php"; ?>
        <div class="right_col" role="main">
            <div class="clearfix"></div>
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Grades</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <!-- First -->
                    <?php 
                        $full_name= "$last_name".', '."$first_name";
                    ?>
                    <form id="val-gr" class="form-horizontal form-label-left" action=<?php  echo "grades_form.php"; ?> method="GET" novalidate>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Student Name</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">

                                    <?php

                                    echo <<<SP
                                        <input id="name" class="form-control col-md-7 col-xs-12" type="text" name="stud_name" readonly value='$full_name'>
SP;
                                    ?>

                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Student ID</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">

                                    <?php

                                    echo <<<SP
                                        <input id="name" class="form-control col-md-7 col-xs-12" type="text" name="stud_id" readonly value='$stud_id'>
SP;
                                    ?>

                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Year Level</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                    <?php

                                    echo <<<SP
                                        <input id="name" class="form-control col-md-7 col-xs-12" type="text" name="yr_level" readonly value='$yr_level'>
SP;
                                    ?>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Student Program</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="prog_id">
                                    <?php
                                    $stud_id = $_GET['stud_id'];
                                    $statement = "SELECT prog_id, prog_name FROM pcnhsdb.students left join programs using (prog_id) where stud_id = '$stud_id'";
                                    $result = DB::query($statement);
                                    foreach ($result as $row) {
                                      $prog_name = $row['prog_name'];
                                      $prog_id = $row['prog_id'];
                                      echo <<<SP
                                          <option value='$prog_id'>$prog_name</option>
SP;
                                    }
                                    ?>
                                </select>
                                <p style="color: red">Default Student Program.</p>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Student Curriculum</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="curriculum">
                                    <?php
                                    $stud_id = $_GET['stud_id'];
                                    $statement = "SELECT curr_id, curr_name FROM pcnhsdb.students left join curriculum using (curr_id) where stud_id = '$stud_id'";
                                    $result = DB::query($statement);
                                    foreach ($result as $row) {
                                      $curr_name = $row['curr_name'];
                                      $curr_id = $row['curr_id'];
                                      echo "<option value='$curr_id' selected>$curr_name</option>";
                                    }
                                    ?>
                                </select>
                                <p style="color: red">Default Student Curriculum.</p>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">School Name</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <?php
                                  echo <<<OPTION2
                                      <input class="form-control col-md-7 col-xs-12" required="required" type="text" name="schl_name" value="$second_school_name" placeholder="School Name">
OPTION2;
                                ?>
                                </div>
                            </div>
                            <!-- Error MSG -->

                            <!--  -->
                            <div class="item form-group">

                                <label class="control-label col-md-3 col-sm-3 col-xs-12">School Year</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" name="schl_year" placeholder="YYYY - YYYY" data-inputmask="'mask': '9999 - 9999'" value=<?php echo "'$stryr'"; ?> required="" >
                                    <div id="sy-input-error">
                                    <?php
                                        if(isset($_SESSION['error_message'])) {
                                            echo $_SESSION['error_message'];
                                            unset($_SESSION['error_message']);

                                        }
                                    ?>
                                </div>
                                </div>
                            </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Change Program</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="subjprog_id">
                                    <option value="none">-- No Selected --</option>
                                    <?php
                                    $stud_id = $_GET['stud_id'];
                                    $statement = "SELECT prog_id, prog_name FROM programs ";
                                    $result = DB::query($statement);
                                    foreach ($result as $row) {
                                      $prog_name = $row['prog_name'];
                                      $prog_id = $row['prog_id'];
                                      echo <<<SP
                                          <option value='$prog_id'>$prog_name</option>
SP;
                                    }
                                    ?>
                                </select>
                                <a style="color: red"><i class="fa fa-info-circle"></i> Select to override the default <strong>Student Program.</strong></a>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Change Curriculum</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <select class="form-control col-md-7 col-xs-12" name="curriculum_subj">
                                    <option value="none">-- No Selected --</option>
                                    <?php
                                    $stud_id = $_GET['stud_id'];
                                    $statement = "SELECT * FROM pcnhsdb.curriculum";
                                    $result = DB::query($statement);
                                    foreach ($result as $row) {
                                      $curr_name = $row['curr_name'];
                                      $curr_id = $row['curr_id'];
                                      echo "<option value='$curr_id'>$curr_name</option>";
                                    }
                                    ?>
                                </select>
                                <a style="color: red"><i class="fa fa-info-circle"></i> Select to override the default <strong>Student Curriculum.</strong></a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="ln_solid"></div>
                            <div class="form-group">
                                <!-- <div class="col-md-6"></div> -->
                                <div class="col-md-3 pull-right">
                                    <a href=<?php echo "student_info.php?stud_id=$stud_id"; ?> class="btn btn-default">Cancel</a>
                                    <button id="send" type="submit" class="btn btn-primary"> Next</button>

                                </div>
                            </div>
                        </form>
                        <div class="ln_solid"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Special Cases <small>Click only if one of the cases here applied to the student</small></h2>
                            <form class="form-horizontal form-label-left" action=<?php echo "phpinsert/special_cases_insert.php?stud_id=$stud_id&yr_level=$yr_level"; ?> method="POST">
                                 <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">School Name</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <?php
                                echo <<<OPTION2
                                    <input class="form-control col-md-7 col-xs-12" required="required" type="text" name="s_schl_name" value="$second_school_name" placeholder="School Name">
OPTION2;
                                    ?>
                                </div>
                            </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-2 col-xs-12">School Year</label>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <input type="text" class="form-control col-md-7 col-xs-12" name="s_schl_year" placeholder="YYYY - YYYY" data-inputmask="'mask': '9999 - 9999'" value=<?php echo "'$stryr'"; ?> required="">
                                        <div id="sy-input-error">
                                            <?php
                                            if(isset($_SESSION['error_message'])) {
                                            echo $_SESSION['error_message'];
                                            unset($_SESSION['error_message']);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <select class="form-control col-md-7 col-xs-12" name="remarks" required="">
                                           <option value="">NO SELECTED</option>
                                           <option value="PP">PEPT PASSER</option>
                                           <option value="D">DROPPED</option>
                                           <option value="T">TRANSFERRED</option>
                                           <option value="R">REPEATER</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-6 pull-right">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <?php include "../../resources/templates/registrar/footer.php"; ?>

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
            <script src= "../../assets/js/jquery.easy-autocomplete.js"></script>
                <!-- Scripts -->
                <script type="text/javascript">
                var options = {
                url: function(phrase) {
                return "phpscript/student_search.php?query="+phrase;
                },
                getValue: function(element) {
                return element.name;
                },
                ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                dataType: "json"
                }
                },
                preparePostData: function(data) {
                data.phrase = $("#search_key").val();
                return data;
                },
                requestDelay: 200
                };
                $("#search_key").easyAutocomplete(options);
                </script>
            <script src= "../../assets/js/custom.min.js"></script>
            <!-- Scripts -->
            <!-- Parsley -->
            <script>
                $(document).ready(function() {
                $.listen('parsley:field:validate', function() {
                validateFront();
                });
                $('#val-gr #send').on('click', function() {
                $('#val-gr').parsley().validate();
                validateFront();
                });
                var validateFront = function() {
                if (true === $('#val-gr').parsley().isValid()) {
                $('.bs-callout-info').removeClass('hidden');
                $('.bs-callout-warning').addClass('hidden');
                } else {
                $('.bs-callout-info').addClass('hidden');
                $('.bs-callout-warning').removeClass('hidden');
                }
                };
                });
                try {
                hljs.initHighlightingOnLoad();
                } catch (err) {}
            </script>
                <!-- /Parsley -->
                <!-- jquery.inputmask -->
            <script>
                $(document).ready(function() {
                    $(":input").inputmask();
                });
            </script>
                <!-- /jquery.inputmask -->

        </body>
    </html>
<?php
    ob_end_flush();
?>
