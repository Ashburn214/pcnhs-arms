<!DOCTYPE html>
<?php include('include_files/session_check.php'); ?>
<?php require_once "../../resources/config.php"; ?>
<html>
  <head>
    <title>Student List</title>
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
      <div class="col-md-5">
        <ol class="breadcrumb">
          <li><a href="../index.php">Home</a></li>
          <li class="disabled">Student Management</li>
          <li class="active">Student List</li>
        </ol>
      </div>
      <form class="form-horizontal form-label-left" action="student_list.php" method="GET">
        
        <div class="form-group">
          <div class="col-sm-5"></div>
          <div class="col-sm-7">
            <div class="input-group">
              
                <input type="text" class="form-control" name="search_key" placeholder="Search Student...">
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
              <h2>Student List</h2>
              <div class="clearfix"></div>
              <br/>
              
            </div>
            <div class="x_content">
              <div class="row">
               <form class="form-horizontal form-label-left" action="student_list.php" method="GET">
                <div class="form-group">
                  <label class="control-label col-md-10">Search Student by School Year:</label>
                  <div class="input-group">
                      <input class="form-control" type="text" name="schl_year" placeholder="YYYY - YYYY" data-inputmask="'mask': '9999 - 9999'">
                      <span class="input-group-btn">
                        <button class="btn btn-primary">Go</button>
                      </span>
                  </div>
                </div>
              </form>
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
              <?php
                if(isset($_GET['schl_year']) && $_GET['schl_year'] != "") {
                  $school_year2 = $_GET['schl_year'];
                  echo "<p>Showing Students in School Year of $school_year2</p>";
                }
              ?>
              <div class="stud-list">
                <table class="tablesorter-bootstrap">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Last Name</th>
                      <th>First Name</th>
                      <th>Middle Name</th>
                      <th>Curriculum</th>
                      <th>Date Modified</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php
                    $statement = "";
                    $start=0;
                    $limit;

                    if(isset($_SESSION['entry'])){
                      $limit = $_SESSION['entry'];
                    }else {
                      $limit = 20;
                    }

                    if(isset($_GET['page'])){
                      $page=$_GET['page'];
                      $start=($page-1)*$limit;
                    }else{
                      $page=1;
                    }

                    if(!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                    }

                    

                    if(isset($_GET['search_key']) && $_GET['search_key'] != "") {
                      $search = htmlspecialchars(filter_var($_GET['search_key'], FILTER_SANITIZE_STRING), ENT_QUOTES);
                      $statement = "select * from students left join curriculum on students.curr_id = curriculum.curr_id where last_name like '%$search' or first_name like '%$search' or stud_id like '%$search' or concat(first_name,' ',last_name) like '%$search' or concat(last_name,' ',first_name,' ',mid_name) like '%$search' or concat(first_name,' ',mid_name,' ',last_name) like '%$search' limit $start, $limit";
                    }else {
                      $statement = "select * from students left join curriculum on students.curr_id = curriculum.curr_id limit $start, $limit";
                    }

                    if(isset($_GET['schl_year']) && $_GET['schl_year'] != "") {
                      $school_year = htmlspecialchars($_GET['schl_year'], ENT_QUOTES);
                      $school_year1 = explode("-", $school_year);
                      $from = $school_year1[0];
                      $to = $school_year1[1];
                      $statement = "SELECT * FROM pcnhsdb.students natural join grades where schl_year between '$from' and '$to' and yr_level = 4;";
                      
                    }
                    
                    

                    $result = $conn->query($statement);
                    if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
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

                    $date_modified = $row['date_modified'];

                    echo <<<STUDLIST
                    <tr>
                      <td>$stud_id</td>
                      <td>$last_name</td>
                      <td>$first_name</td>
                      <td>$mid_name</td>
                      <td>$curr_code</td>
                      <td>$date_modified</td>
                      <td>
                        <center>
                          <a href="../../registrar/studentmanagement/student_info.php?stud_id=$stud_id" class="btn btn-primary btn-xs"><i class="fa fa-user"></i> View </a>
                        </center>
                      </td>
                    </tr>
STUDLIST;
                      }
                    }
                    ?>
                  </tbody>
                </table>
                <?php
                  $statement = "select * from students left join curriculum on students.curr_id = curriculum.curr_id";
                    $rows = mysqli_num_rows(mysqli_query($conn, $statement));
                    $total = ceil($rows/$limit);
                    
                    echo "<p>Showing $limit Entries</p>";

                    echo '<div class="pull-right">
                      <div class="col s12">
                      <ul class="pagination center-align">';
                      if($page > 1) {
                        echo "<li class=''><a href='student_list.php?page=".($page-1)."'>Previous</a></li>";
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
                          echo "<li class='active'><a href='student_list.php?page=$i'>$i</a></li>";
                        } else {
                            echo "<li class=''><a href='student_list.php?page=$i'>$i</a></li>";
                          }
                      }


                      if($total == 0) {
                        echo "<li class='disabled'><a>Next</a></li>";
                      }else if($page!=$total) {
                        echo "<li class=''><a href='student_list.php?page=".($page+1)."'>Next</a></li>";
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
    <script src= "../../assets/js/custom.min.js"></script>
    <!-- NProgress -->
    <script src="../../resources/libraries/nprogress/nprogress.js"></script>
    <!-- <script type="text/javascript" src="../../resources/libraries/tablesorter/jquery.tablesorter.js"></script> -->
    <!-- Scripts -->
    
   
    <!-- Change Entry -->
    <script type="text/javascript">
      function changeEntries(val) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
           location.reload();
          }
        };
        xhttp.open("GET", "phpscript/showentry.php?entry="+val, true);
        xhttp.send();
      }
    </script>
    <!--  -->
    <!-- jquery.inputmask -->
    <script>
      $(document).ready(function() {
        $(":input").inputmask();
      });
    </script>
    <!-- /jquery.inputmask -->
    <script type="text/javascript">
  
    $(function() {

      $('.stud-list').tablesorter();



      $('.tablesorter-bootstrap').tablesorter({
        theme : 'bootstrap',
        headerTemplate: '{content} {icon}',
        widgets    : ['zebra','columns', 'uitheme']
      });

    });
    
    </script>
  </body>
</html>