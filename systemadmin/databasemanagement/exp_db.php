<!DOCTYPE html>
<?php require_once "../../resources/config.php"; ?>
<?php include ('include_files/session_check.php'); ?>

<html>
  <head>
    <title>Backup Database</title>
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
              <li class="disabled">Generate Backup</li>
            </ol>
          </div>

    <div class="clearfix"></div>
    <div class="">

        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-database"></i> Backup Database<br><br>
                        <a href = "phpscript/exp.php" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Generate Backup</a>
                    </h2>

                    <div class="clearfix"></div>
                    <br/>
                                   <?php
                                        if (isset($_SESSION['db_msg_generate'])) {
                                            echo $_SESSION['db_msg_generate'];
                                            unset($_SESSION['db_msg_generate']);
                                        }
                                        if (isset($_SESSION['db_msg_import'])) {
                                            echo $_SESSION['db_msg_import'];
                                            unset($_SESSION['db_msg_import']);
                                        }
                                  ?>
                </div>
                <div class="x_content">
                    <div class="personnel-list table-list">
                        <table id="personnelList" class="tablesorter-bootstrap">
                            <thead>
                            <tr>
                                <th>Generated Backup Files</th>
                                <th>Size</th>
                                 <th>Date Created</th>
                                <th data-sorter="false"><center>Actions</center></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                              $statement = "";
                              $start = 0;
                              $limit = 20;
                              if (isset($_SESSION['db_entry'])) {
                                $limit = $_SESSION['db_entry'];
                              }
                              else {
                                $limit = 20;
                              }
                              if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                                $start = ($page - 1) * $limit;
                              }
                              else {
                                $page = 1;
                              }

                            function get_file_size_unit($file_size){
                              switch (true) {
                                  case ($file_size/1024 < 1) :
                                      return intval($file_size ) ." Bytes" ;
                                      break;
                                  case ($file_size/1024 >= 1 && $file_size/(1024*1024) < 1)  :
                                      return intval($file_size/1024) ." KB" ;
                                      break;
                                  default:
                                  return intval($file_size/(1024*1024)) ." MB" ;
                                  }
                              }


                            function getDownloads($dir="phpscript/myBackups/"){
                                if (is_dir($dir)){
                                $dh  = opendir($dir);
                                $files=array();
                                $i=0;
                                $xclude=array('.','..','.htaccess');
                                while (false !== ($filename = readdir($dh))) {
                                   if(!in_array($filename, $xclude))
                                   {
                                    $files[$i]['name'] = $filename;
                                    $files[$i]['size'] = get_file_size_unit(filesize($dir.'/'.$filename));
                                    date_default_timezone_set('Asia/Manila');
                                    $files[$i]['date']= $mod_date=date("F d Y h:i A", filectime($dir.'/'.$filename));
                                    $i++;
                                   }
                                }
                                return $files;
                            }
                          }

                          $backup_folder = "phpscript/myBackups";
                          $downloads=getDownloads($backup_folder);

                              if(count($downloads)>0)
                                 foreach ($downloads as $k => $v) {
                                  
                                  echo <<<BULIST
                                          <tr class="odd pointer">

                                                        <td class=" "><center>$v[name]</center></td>
                                                        <td class=" "><center>$v[size]</center></td>
                                                        <td class=" "><center>$v[date]</center></td>
                                                        <td class=" ">
                                                        <center>
                                                          <a href= "$backup_folder/$v[name]" download class="btn btn-primary btn-xs">
                                                          <i class="fa fa-download"></i>  Download</a>

                                                          <a href = "import_db.php?filename=$v[name]&filesize=$v[size]&date=$v[date]" button type="submit" class="btn btn-success btn-xs"  >
                                                          <i class="fa fa-inbox"></i>  Import</a>

                                                          <a href = "phpscript/del_db.php?file=$v[name]" button type="submit" class="btn btn-danger btn-xs"  >
                                                          <i class="fa fa-remove"></i>  Remove</a>
                                                        </center>
                                                        </td>
                                            </tr>
BULIST;
                                    
                                 }
                      ?>
                            </tbody>
                        </table>
                        <?php
                          $statement = "select * from personnel";
                          $rows = DB::count($statement);
                          $total = ceil($rows / $limit);

                          echo '<div class="pull-right">
                                                <div class="col s12">
                                                <ul class="pagination center-align">';
                          if ($page > 1) {
                            echo "<li class=''><a href='personnel_list.php?page=" . ($page - 1) . "'>Previous</a></li>";
                          }
                          else if ($total <= 0) {
                            echo '<li class="disabled"><a>Previous</a></li>';
                          }
                          else {
                            echo '<li class="disabled"><a>Previous</a></li>';
                          }
                            $x = 0;
                            $y = 0;

                            if (($page + 5) <= $total) {
                              if ($page >= 3) {
                                $x = $page + 2;
                              }
                              else {
                                $x = 5;
                              }

                              $y = $page;
                              if ($y <= $total) {
                                $y-= 2;
                                if ($y < 1) {
                                  $y = 1;
                                }
                              }
                            }
                            else {
                              $x = $total;
                              $y = $total - 5;
                              if ($y < 1) {
                                $y = 1;
                              }
                            }
                            for ($i = $y; $i <= $x; $i++) {
                            
                                    if ($i == $page) {
                                        echo "<li class='active'><a href='personnel_list.php?page=$i'>$i</a></li>";
                                    }
                                      else {
                                        echo "<li class=''><a href='personnel_list.php?page=$i'>$i</a></li>";
                                      }
                                    }
                                    if ($total == 0) {
                                      echo "<li class='disabled'><a>Next</a></li>";
                                    }
                                    else if ($page != $total) {
                                      echo "<li class=''><a href='personnel_list.php?page=" . ($page + 1) . "'>Next</a></li>";
                                    }
                                    else {
                                      echo "<li class='disabled'><a>Next</a></li>";
                                    }
                                    echo "</ul></div></div>";
                                    ?>
                        </div>
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
