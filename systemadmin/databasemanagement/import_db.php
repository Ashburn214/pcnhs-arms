<!DOCTYPE html>
<?php require_once "../../resources/config.php"; ?>
<?php include ('include_files/session_check.php'); ?>
<?php
  $filename = $_GET['filename'];
  $filesize = $_GET['filesize'];
  $date = $_GET['date'];

  $_SESSION['file'] = $filename;
  $_SESSION['size'] = $filesize;
  $_SESSION['date'] = $date;

?>


<html>
  <head>
    <title>Import Database</title>
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
    <link href="../../assets/css/easy-autocomplete-custom.css" rel="stylesheet">

  </head>
    <body class="nav-md">
      <?php include "../../resources/templates/admin/sidebar.php"; ?>
      <?php include "../../resources/templates/admin/top-nav.php"; ?>
      <!-- Content Start -->
      <div class="right_col" role="main">

          <div class="col-md-5">
            <ol class="breadcrumb">
              <li><a href="../index.php">Home</a></li>
              <li class="active">Import Database</li>
            </ol>
          </div>

    <div class="clearfix"></div>
    <div class="">

        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                               <?php
                                  if (isset($_SESSION['db_msg_import_2'])) {
                                      echo $_SESSION['db_msg_import_2'];
                                      unset($_SESSION['db_msg_import_2']);
                                        }
                                  ?>
            <br>
                <div class="x_title">
                      <p><strong>Note:  <i class="fa fa-info-circle"></i> </strong> Importing a backup file will <strong>overwrite</strong> the current database.</p>
                    <h2><i class="fa fa-database"></i> Import Database <br> <br>
                      <strong>File name : </strong> <?php echo $filename ?><br><br>
                      <strong>File size : </strong> <?php echo $filesize ?><br><br>
                      <strong>Date created :</strong> <?php echo $date ?>
                    </h2>
            <br><br><br><br>                        
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">

            <form id="import_db" method="POST"  action = "phpscript/db_import.php">
              <div>
                <input name="db_uname" type="text"  class="form-control" placeholder="Database Username" required=""
                          data-parsley-minlength="4"
                          data-parsley-minlength-message="User Name should be greater than 4 characters"
                          data-parsley-maxlength="50"
                          data-parsley-maxlength-message="Error">
              </div>

              <div>
                <input name="db_pw" type="password" class="form-control" placeholder="Database Password" required="" 
                          data-parsley-minlength="4"
                          data-parsley-minlength-message="Password should be greater than 4 characters"
                          data-parsley-maxlength="50"
                          data-parsley-maxlength-message="Error">
              </div>

              <div>
                <input name="pw" type="password" class="form-control" placeholder="Account Password" required="" 
                          data-parsley-minlength="4"
                          data-parsley-minlength-message="Password should be greater than 4 characters"
                          data-parsley-maxlength="50"
                          data-parsley-maxlength-message="Error">
              </div>

              <div>
                <button id="compose" class="btn btn-sm btn-success btn-block" type="submit">IMPORT DATABASE</button>
              </div>

              <div class="clearfix"></div>
            </form>

          </section>
        </div>

      </div>

                    <div class="clearfix"></div>
                    <br/>
                </div>
                <div class="x_content">
                  <div class="row">
              </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content End -->
<?php include "../../resources/templates/admin/footer.php"; ?>
<!-- Scripts -->
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
<script src= "../../assets/js/custom.min.js"></script>
<script src= "../../assets/js/jquery.easy-autocomplete.js"></script>
<!-- Scripts -->
    <script>
        $(document).ready(function() {
            $.listen('parsley:field:validate', function() {
                validateFront();
            });
            $('#import_db .btn').on('click', function() {
                $('#import_db').parsley().validate();
                validateFront();
            });
            var validateFront = function() {
                if (true === $('#import_db').parsley().isValid()) {
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
<script type="text/javascript">
      function changeEntries(val) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
           location.reload();
          }
        };
        xhttp.open("GET", "include_files/db_entry.php?db_entry="+val, true);
        xhttp.send();
      }
</script>
    <script type="text/javascript">
      $(function() {
      $('.personnel-list').tablesorter();
      $('.tablesorter-bootstrap').tablesorter({
      theme : 'bootstrap',
      headerTemplate: '{content} {icon}',
      widgets    : ['zebra','columns', 'uitheme']
      });
      });
    </script>
</body>
</html>
