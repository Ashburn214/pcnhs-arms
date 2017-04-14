<!DOCTYPE html>
<?php require_once "../../resources/config.php"; ?>
<?php include('include_files/session_check.php'); ?>

<html>
  <head>
    <title>Personnel Accounts</title>
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

  </head>
    <body class="nav-md">
      <?php include "../../resources/templates/admin/sidebar.php"; ?>
      <?php include "../../resources/templates/admin/top-nav.php"; ?>
      <!-- Content Start -->
      <div class="right_col" role="main">
          
          <div class="col-md-5">
            <ol class="breadcrumb">
              <li><a href="../index.php">Home</a></li>
              <li class="disabled">Personnel Accounts</li>
              <li class="active">View Personnel Accounts</li>
            </ol>
          </div>

    <form class="form-horizontal form-label-left" action="personnel_list.php" method="GET">

        <div class="form-group">
            <div class="col-sm-5"></div>
            <div class="col-sm-7">
                <div class="input-group">

                    <input type="text" class="form-control" name="search_key" placeholder="Search Personnel Username or ID">
                    <span class="input-group-btn">
                  <button class="btn btn-primary">Go</button>
                </span>
                </div>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>
    <div class="">

        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-users"></i> Personnel Accounts 
                    </h2>
                    <div class="clearfix"></div>
                    <br/>
                      <?php
                            if(isset($_SESSION['success_personnel_delete'])) {
                               echo $_SESSION['success_personnel_delete'];
                               unset($_SESSION['success_personnel_delete']);
                              }
                      ?>
                </div>
                <div class="x_content">
                                                        <div class="row">
                    <form class="form-horizontal form-label-left">
                        <div class="form-group">
                          <label class="control-label col-md-10">Show Number Of Entries:</label>
                          <div class="col-sm-2">
                              <select class="form-control" onchange="changeEntries(this.value)">
                                <option value="20" 
                                  <?php if(isset($_SESSION['entry'])){if($_SESSION['entry'] == 20) {echo "selected";}} ?>
                                  >20</option>
                                <option value="50"
                                   <?php if(isset($_SESSION['entry'])){if($_SESSION['entry'] == 50) {echo "selected";}} ?>
                                  >50</option>
                                <option value="100"
                                   <?php if(isset($_SESSION['entry'])){if($_SESSION['entry'] == 100) {echo "selected";}} ?>
                                >100</option>
                              </select>
                          </div>
                        </div>
                      </form>
              </div>



                    <div class="personnel-list">
                        <table id="personnelList" class="tablesorter-bootstrap">
                            <thead>
                            <tr>
                                <th data-sorter="false">Personnel ID</th>
                                <th data-sorter="false">Username</th>
                                <th data-sorter="false">Position</th>
                                <th data-sorter="false">Access Type</th>
                                <th data-sorter="false">Account Status</th>
                                <th data-sorter="false">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                           $start=0;
                           $limit=10;

                            if(isset($_GET['page'])){
                              $page=$_GET['page'];
                              $start=($page-1)*$limit;
                            }else{
                              $page=1;
                            }
                            
                            if(!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
                            if (isset($_GET['search_key'])){
                                $search = $_GET['search_key'];
                                $statement = "SELECT * FROM pcnhsdb.personnel 
                                WHERE (per_id LIKE '%$search%') 
                                AND (per_id NOT LIKE '1' and per_id NOT LIKE '2') 
                                OR (uname LIKE '%$search%')
                                AND (uname NOT LIKE 'admin' and uname NOT LIKE 'registrar') 
                                OR (first_name LIKE '%$search%')
                                AND (first_name NOT LIKE 'admin' and first_name NOT LIKE 'registrar')
                                LIMIT $start, $limit";
                            }else{
                                $statement = "SELECT * FROM pcnhsdb.personnel
                                WHERE uname NOT LIKE 'registrar' 
                                AND uname NOT LIKE 'admin' 
                                LIMIT $start, $limit";
                            }

                            $result = $conn->query($statement);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $per_id = $row['per_id'];
                                    $uname = $row['uname'];
                                    $password = $row['password'];
                                    $last_name = $row['last_name'];
                                    $first_name = $row['first_name'];
                                    $mname = $row ['mname'];
                                    $position = $row ['position'];
                                    $access_type = $row ['access_type'];
                                    $accnt_status = $row ['accnt_status'];
                                    echo <<<PERSONNELLIST
                    <tr class="odd pointer">
                                                        <td class=" ">$per_id</td>
                                                        <td class=" ">$uname</td>
                                                        <td class=" ">$position</td>
                                                        <td class=" ">$access_type</td>
                                                        <td class=" ">$accnt_status</td>
                                                        <td class=" ">
                                                        <center>
                                                          <a href= "personnel_view.php?per_id=$per_id" class="btn btn-default">
                                                        <i class="fa fa-user"></i>View</a>
                                                        </center>
                                                        </td>
                                                        
                                            </tr>
PERSONNELLIST;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    $statement = "select * from personnel";
                    $rows = mysqli_num_rows(mysqli_query($conn, $statement));
                    $total = ceil($rows/$limit);
                    

                    echo '<div class="pull-right">
                      <div class="col s12">
                      <ul class="pagination center-align">';
                      if($page > 1) {
                        echo "<li class=''><a href='personnel_list.php?page=".($page-1)."'>Previous</a></li>";
                      }else if($total <= 0) {
                        echo '<li class="disabled"><a>Previous</a></li>';
                      }else {
                        echo '<li class="disabled"><a>Previous</a></li>';
                      }
                      // Google Like Pagination
                      $x = 0;
                      $y = 0;
                      if(($page+5) <= $total) {
                        if($page >= 3) {
                          $x = $page + 2;

                        }else {
                          $x = 5;
                        }

                        $y = $page;
                        if($y <= $total) {
                          $y -= 2;
                          if($y < 1) {
                            $y = 1;
                          }
                        }
                      }else {
                        $x = $total;
                        $y = $total - 5;
                        if($y < 1) {
                          $y = 1;
                        }
                      }
                      // Google Like Pagination
                      for($i = $y;$i <= $x; $i++) {
                        if($i==$page) {
                          echo "<li class='active'><a href='personnel_list.php?page=$i'>$i</a></li>";
                        } else {
                            echo "<li class=''><a href='personnel_list.php?page=$i'>$i</a></li>";
                          }
                      }


                      if($total == 0) {
                        echo "<li class='disabled'><a>Next</a></li>";
                      }else if($page!=$total) {
                        echo "<li class=''><a href='personnel_list.php?page=".($page+1)."'>Next</a></li>";
                      }else {
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
<script type="text/javascript" src=<?php echo "../../resources/libraries/tablesorter/jquery.tablesorter.js" ?>></script>
<!-- Scripts -->
<script type="text/javascript">
      function changeEntries(val) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
           location.reload();
          }
        };
        xhttp.open("GET", "../index_entry.php?entry="+val, true);
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