<!DOCTYPE html>
<?php include('include_files/session_check.php'); ?>
<?php require_once "../../resources/config.php"; ?>
<html>
  <head>
    <title>Validate Request</title>
    <link rel="shortcut icon" href="../../assets/images/ico/fav.png" type="image/x-icon" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


      <!-- jQuery -->
      <script src="../../resources/libraries/jquery/dist/jquery.min.js" ></script>

      <!-- Tablesorter themes -->
      <!-- bootstrap -->
      <link href="../../resources/libraries/tablesorter/css/bootstrap-v3.min.css" rel="stylesheet">
      <link href="../../resources/libraries/tablesorter/css/theme.bootstrap.css" rel="stylesheet">

      <!-- Tablesorter: required -->
      <script src="../../resources/libraries/tablesorter/js/jquery.tablesorter.js"></script>
      <script src="../../resources/libraries/tablesorter/js/jquery.tablesorter.widgets.js"></script>

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
       <!-- Custom Theme Style -->
      <link href="../../assets/css/customstyle.css" rel="stylesheet">
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
    <?php include "../../resources/templates/registrar/sidebar.php"; ?>
    <?php include "../../resources/templates/registrar/top-nav.php"; ?>
    <!-- Content Start -->
    <div class="right_col" role="main">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-9">
          <a class="btn btn-default" href=<?php echo "request_credential.php"; ?>><i class="fa fa-arrow-circle-left"></i> Back</a>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Verify Student</h2>
              <div class="clearfix"></div>
              <br/>

            </div>
            <div class="x_content">

              <div class="validate-request">
                <table class="tablesorter-bootstrap">
                  <thead>
                    <tr>
                      <th data-sorter="false">Student ID</th>
                      <th data-sorter="false">Last Name</th>
                      <th data-sorter="false">First Name</th>
                      <th data-sorter="false">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $others = "";
                    if(isset($_GET['others']) && $_GET['others'] != "") {
                        $others = $_GET['others'];
                      }else {
                        $others = "";
                    }
                    $stud_id = "";
                    $cred_id = $_GET['credential'];
                    $purpose = $_GET['purpose'];
                    if($_GET['full-name']) {
                      $search = htmlspecialchars($_GET['full-name']);
                      $statement = "select * from students left join curriculum on students.curr_id = curriculum.curr_id where concat(first_name, ' ', last_name) like '$search%' or stud_id like '$search'";


                      $result = DB::query($statement);
                      if (count($result) > 0) {
                    		foreach ($result as $row) {
                    $stud_id = $row['stud_id'];
                    $first_name = $row['first_name'];
                    $mid_name = $row['mid_name'];
                    $last_name = $row['last_name'];
                    $gender = $row['gender'];
                    $birth_date = $row['birth_date'];


                    //$yr_grad = $row['yr_grad'];
                    $program = $row['prog_id'];
                    $curriculum = $row['curr_id'];
                    $curr_code = $row['curr_code'];
                    $check_if_graduate_statement = "SELECT yr_level from grades where stud_id = '$stud_id' and yr_level = 4;";
                    $check_if_graduate = DB::query($check_if_graduate_statement);
                      if(count($check_if_graduate) > 0) {
                        echo <<<STUDLIST
                      <tr>
                        <td>$stud_id</td>
                        <td>$last_name</td>
                        <td>$first_name</td>
                        <td>
                          <span class="">
                          <center>
                            <a href="../../registrar/credentials/generate_cred.php?stud_id=$stud_id&credential=$cred_id&purpose=$purpose&others=$others&new_request=true" class="btn btn-default"><i class="fa fa-plus"></i> Add Request</a>

                            <a href="../../registrar/studentmanagement/student_info.php?stud_id=$stud_id" class="btn btn-default"><i class="fa fa-user"></i> View Profile</a>
                            </center>
                          </span>
                        </td>
                      </tr>
STUDLIST;
                      }else {
                        echo <<<STUDLIST
                      <tr>
                        <td>$stud_id</td>
                        <td>$last_name</td>
                        <td>$first_name</td>
                        <td>
                          <span class="">
                          <center>
                            <a class="btn btn-default" data-toggle="tooltip" data-placement="top"
                               title="The record of this student is still incomplete. You cannot add new credential request for this student."><i class="fa fa-plus"></i> Add Request</a>

                            <a href="../../registrar/studentmanagement/student_info.php?stud_id=$stud_id" class="btn btn-default"><i class="fa fa-user"></i> View Profile</a>
                            </center>
                          </span>
                        </td>
                      </tr>
STUDLIST;
                      }
                    
                      }
                    }
                    }else {
                      echo "<p>No Result</p>";
                    }

                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Content End -->
    <?php include "../../resources/templates/registrar/footer.php"; ?>

    <!-- Scripts -->
    <!-- Bootstrap -->
    <script src="../../resources/libraries/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src= "../../resources/libraries/fastclick/lib/fastclick.js"></script>
    <!-- input mask -->
    <script src= "../../resources/libraries/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src= "../../resources/libraries/parsleyjs/dist/parsley.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src= "../../assets/js/jquery.easy-autocomplete.js"></script>
  <script type="text/javascript">
        var options = {
          url: function(phrase) {
            return "../../registrar/studentmanagement/phpscript/student_search.php?query="+phrase;
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
    <!-- NProgress -->
    <script src="../../resources/libraries/nprogress/nprogress.js"></script>

    <!-- Scripts -->
    <script type="text/javascript">
    $(function() {
    $('.validate-request').tablesorter();
    $('.tablesorter-bootstrap').tablesorter({
    theme : 'bootstrap',
    headerTemplate: '{content} {icon}',
    widgets    : ['zebra','columns', 'uitheme']
    });
    });
    </script>
    <!--  -->
  </body>
</html>
