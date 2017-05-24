<!DOCTYPE html>
<?php
session_start();
// Session Timeout
$time = time();
$session_timeout = 1800; //seconds

if (isset($_SESSION['generated_form137'])) {
    unset($_SESSION['generated_form137']);
    header("location: index.php");
    die();
}
if (isset($_SESSION['generated_diploma'])) {
    unset($_SESSION['generated_diploma']);
    header("location: index.php");
    die();
}

if (isset($_SESSION['last_activity']) && ($time - $_SESSION['last_activity']) > $session_timeout) {
    $_SESSION['timeout_message'] = "You have been logged out due to inactivity. Please Login Again.";
    header("location: ../logout.php");
}
$_SESSION['last_activity'] = $time;
if (isset($_SESSION['logged_in']) && isset($_SESSION['account_type'])) {
    if ($_SESSION['account_type'] != "registrar") {
        echo "<p>Access Failed <a href='../index.php'>Back to Home</a></p>";
        die();
    }
} else {
    header('Location: ../login.php');
}
?>
<?php require_once '../resources/config.php' ?>
<html>
	<head>
		<title>Home</title>
		<link rel="shortcut icon" href="../assets/images/ico/fav.png" type="image/x-icon" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		 <!-- jQuery -->
	    <script src="../resources/libraries/jquery/dist/jquery.min.js" ></script>

	    <!-- Tablesorter themes -->
	    <!-- bootstrap -->
	    <link href="../resources/libraries/tablesorter/css/bootstrap-v3.min.css" rel="stylesheet">
	    <link href="../resources/libraries/tablesorter/css/theme.bootstrap.css" rel="stylesheet">

	    <!-- Tablesorter: required -->
	    <script src="../resources/libraries/tablesorter/js/jquery.tablesorter.js"></script>
	    <script src="../resources/libraries/tablesorter/js/jquery.tablesorter.widgets.js"></script>
		<!-- NProgress -->
		<link href="../resources/libraries/nprogress/nprogress.css" rel="stylesheet">
		<!-- Date Range Picker -->
		<link href="../resources/libraries/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
		<!-- Bootstrap -->
		<link href="../resources/libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="../resources/libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet">

		<!-- Datatables -->
		<link href="../resources/libraries/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

		<!-- Custom Theme Style -->
		<link href="../assets/css/custom.min.css" rel="stylesheet">
		<!-- Custom Theme Style -->
	    <link href="../assets/css/customstyle.css" rel="stylesheet">
	    <link href="../assets/css/easy-autocomplete-topnav.css" rel="stylesheet">
		<link href="../resources/libraries/bootstrap-tour/build/css/bootstrap-tour-standalone.min.css" rel="stylesheet">

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
		<?php include "../resources/templates/registrar/sidebar.php"; ?>
		<!-- Top Navigation -->
		<?php include "../resources/templates/registrar/top-nav.php"; ?>
		<!-- Content Here -->
		<!-- page content -->

		<div class="right_col" role="main">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-4 pull">
						<form class="form-horizontal" action="index.php" method="get">
							<fieldset>
								<div class="control-group">
									<div class="controls">
										<div class="input-prepend input-group">
											<span class="add-on input-group-addon">
												<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
											</span>
											<input type="text" name="dashboard_date" id="dashboard_date" class="form-control" value="" />
											<span class="input-group-btn">
												<button type="submit" class="btn btn-primary">Go</button>
											</span>
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
					<div id="button-wc" class="pull-right">
						<button  class="btn btn-default" onclick="start_tour();" data-toggle="tooltip" data-placement="top"
                               title="Click to start the quick tour of the site.">Start the Quick Tour</button>
					</div>
				</div>
			</div>
			<br>
            <?php
            	if(isset($_GET['dashboard_date']) && $_GET['dashboard_date'] != "") {
					$dashboard_date = $_GET['dashboard_date'];
					$from_and_to_date = explode("-", $dashboard_date);
					$sqldate_format_from = explode("/", $from_and_to_date[0]);
					$m = $sqldate_format_from[0];
					$d = $sqldate_format_from[1];
					$y = $sqldate_format_from[2];
					$m = preg_replace('/\s+/', '', $m);
					$d = preg_replace('/\s+/', '', $d);
					$y = preg_replace('/\s+/', '', $y);
					$from = $y."-".$m."-".$d;
					$sqldate_format_to = explode("/", $from_and_to_date[1]);
					$m = $sqldate_format_to[0];
					$d = $sqldate_format_to[1];
					$y = $sqldate_format_to[2];
					$m = preg_replace('/\s+/', '', $m);
					$d = preg_replace('/\s+/', '', $d);
					$y = preg_replace('/\s+/', '', $y);
					$to = $y."-".$m."-".$d;

					echo "<p>Showing summary from <b>$from</b> to <b>$to</b></p>";
            	}else {
            		$month = date('m/01/Y') . '-' . date('m/d/Y');
	                $from_and_to_date = explode("-", $month);
	                $sqldate_format_from = explode("/", $from_and_to_date[0]);
	                $m = $sqldate_format_from[0];
	                $d = $sqldate_format_from[1];
	                $y = $sqldate_format_from[2];
	                $m = preg_replace('/\s+/', '', $m);
	                $d = preg_replace('/\s+/', '', $d);
	                $y = preg_replace('/\s+/', '', $y);

	                $from = $y."-".$m."-".$d;

	                $sqldate_format_to = explode("/", $from_and_to_date[1]);
	                $m = $sqldate_format_to[0];
	                $d = $sqldate_format_to[1];
	                $y = $sqldate_format_to[2];
	                $m = preg_replace('/\s+/', '', $m);
	                $d = preg_replace('/\s+/', '', $d);
	                $y = preg_replace('/\s+/', '', $y);

	                $to = $y."-".$m."-".$d;
	                echo "<p>Showing summary from <b>$from</b> to <b>$to</b></p>";
            	}
                
            ?>
			<div class="row top_tiles">
				<a href="studentmanagement/student_list.php">
					<div id="dash-1" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="tile-stats">
							<div class="icon"><i class="fa fa-user"></i></div>
							<?php
				                $result = DB::query("SELECT count(*) as students FROM pcnhsdb.students");
				                foreach ($result as $row) {
				                  $students = $row["students"];
				                  echo "<div class='count'>$students</div>";
				                }
				              ?>
							<p>&nbsp</p>
							<h3>Total Students</h3>
							<p>&nbsp</p>
						</div>
					</div>
					</a>
					<a href="credentials/requests.php">
						<div id="dash-2" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="tile-stats">
								<div class="icon"><i class="glyphicon glyphicon-check"></i></div>
								<?php
                  $result = DB::query("SELECT count(*) as totalreq FROM pcnhsdb.requests where status = 'p';");
                  foreach ($result as $row) {
                    $totalreq = $row["totalreq"];
                    echo "<div class='count'>$totalreq</div>";
                  }
                ?>
								<p>&nbsp</p>
								<h3>New Requests</h3>
								<p>&nbsp</p>
							</div>
						</div>
					</a>
					<a href="credentials/unclaimed.php">
						<div id="dash-3" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="tile-stats">
								<div class="icon"><i class="glyphicon glyphicon-hourglass"></i></div>
								<?php
                    $result = DB::query("SELECT count(*) as unclaimed FROM pcnhsdb.requests where status = 'u' and date_processed between '$from' and '$to';");
                    foreach ($result as $row) {
                      $unclaimed = $row["unclaimed"];
                      echo "<div class='count'>$unclaimed</div>";
                    }
                ?>
								<p>&nbsp</p>
								<h3>Unclaimed Credentials</h3>
								<p>&nbsp</p>
							</div>
						</div>
					</a>
					<a href="credentials/released.php">
						<div id="dash-4" class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="tile-stats">
								<div class="icon"><i class="fa fa-paper-plane"></i></div>
								<?php
                    $result = DB::query("SELECT count(*) as released FROM pcnhsdb.requests where status = 'r' and date_released between '$from' and '$to';");
                    foreach ($result as $row) {
                      $released = $row["released"];
                      echo "<div class='count'>$released</div>";
                    }
                ?>
								<p>&nbsp</p>
								<h3>Released Credentials</h3>
								<p>&nbsp</p>
							</div>
						</div>
					</a>
				</div>
				<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Recent Credential Requests</h2>
							<ul class="nav navbar-right panel_toolbox">
							</ul>
							<a id="button-1" href="credentials/request_credential.php" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-plus"></i> New Request</a>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div id="table-1" class="recent-request table-list">
								<table class="tablesorter-bootstrap">
									<thead>
										<tr class="headings">
											<th class="column-title" data-sorter="false">Date of Request</th>
											<th class="column-title" data-sorter="false">Student Name</th>
											<th class="column-title" data-sorter="false">Requested Credential</th>
											<th class="column-title" data-sorter="false">Purpose</th>
											<th class="column-title no-link last" data-sorter="false"><span class="nobr">Action</span>
										</th>

									</tr>
								</thead>
								<tbody>
									<?php
                  $statement = "SELECT stud_id, req_id, cred_id, request_purpose, date_processed as 'date processed', concat(first_name, ' ', last_name) as 'stud_name', cred_id, cred_name, request_type FROM pcnhsdb.requests natural join students natural join credentials where status='p' order by req_id desc limit 5;";

                  $result = DB::query($statement);
                  foreach ($result as $row) {
                    $date_processed = $row['date processed'];
                    $stud_name = $row['stud_name'];
                    $cred_name = $row['cred_name'];
                    $request_purpose = $row['request_purpose'];
                    $request_purpose = strtoupper($request_purpose);
                    $cred_id = $row['cred_id'];
                    $stud_id = $row['stud_id'];
                    $req_id = $row['req_id'];
                    echo <<<UNCLAIMED
                      <tr class="odd pointer">
                          <td class=" ">$date_processed</td>
                          <td class=" ">$stud_name</td>
                          <td class=" ">$cred_name</td>
                          <td class=" ">$request_purpose</td>
                          <td class=" ">
                            <center>
                              <a href="../registrar/credentials/generate_cred.php?stud_id=$stud_id&credential=$cred_id&purpose=$request_purpose&req_id=$req_id" class="btn btn-default"> Process Request</a>
                            </center>
                          </td>
                      </tr>
UNCLAIMED;
                  }

                  ?>
									</tbody>
								</table>
							</div>
							</div>
						</div>
					</div>
				</div>
		<div class="clear-fix"></div>
		</div>
		<!-- /page content -->
		<!-- Content Here -->
		<!-- Footer -->
		<?php include "../resources/templates/registrar/footer.php"; ?>

		<!-- Scripts -->
		<!-- Bootstrap -->
		<script src="../resources/libraries/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src= "../resources/libraries/fastclick/lib/fastclick.js"></script>
		<!-- input mask -->
		<!-- Date Range Picker -->
		<script src="../resources/libraries/moment/min/moment.min.js"></script>
		<script src="../resources/libraries/bootstrap-daterangepicker/daterangepicker.js"></script>
		<!-- NProgress -->
		<script src="../resources/libraries/nprogress/nprogress.js"></script>
		<script src="../resources/libraries/bootstrap-tour/build/js/bootstrap-tour-standalone.min.js"></script>
		<!-- Custom Theme Scripts -->
		<script src= "../assets/js/jquery.easy-autocomplete.js"></script>
		<script type="text/javascript">
			$('#dashboard_date').daterangepicker({
			    ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				  },
			    startDate: moment().startOf('month'),
				endDate: moment().endOf('month')
			}, function(start, end, label) {
			  console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
			});
		</script>
		<script type="text/javascript">
	      $(function() {
	      $('.recent-request').tablesorter();
	      $('.tablesorter-bootstrap').tablesorter({
	      theme : 'bootstrap',
	      headerTemplate: '{content} {icon}',
	      widgets    : ['zebra','columns', 'uitheme']
	      });
	      });
	    </script>
		<!-- Scripts -->
		<script type="text/javascript">
		var options = {
		url: function(phrase) {
		return "studentmanagement/phpscript/student_search.php?query="+phrase;
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
		<script type="text/javascript">
			var tour = new Tour({
				  steps: [
				  {
				    element: "#button-wc",
				    placement: "left",
				    title: "Welcome",
				    content: "This tour will navigate you through the basic functionalities and links of this site."
				  },
				  {
				    element: "#dash-1",
				    placement: "bottom",
				    title: "Total Students Count",
				    content: "This will show you the number of students that are saved in the Database."
				  },
				  {
				    element: "#dash-2",
				    placement: "bottom",
				    title: "New Requests Count",
				    content: "This will show you the number of new requests count."
				  },
				  {
				    element: "#dash-3",
				    placement: "bottom",
				    title: "Unclaimed Credentials Count",
				    content: "This will show you the number of requested credentials that are not yet claimed."
				  },
				  {
				    element: "#dash-4",
				    placement: "bottom",
				    title: "Released Credentials Count",
				    content: "This will show you the number of released credentials."
				  },
				  {
				    element: "#button-1",
				    placement: "bottom",
				    title: "New Request Button",
				    content: "You can add new credential request by clicking this button."
				  },
				  {
				    element: "#table-1",
				    placement: "top",
				    title: "List of recent credential request",
				    content: "This will show you the list of five recent credential request. You can process these requests by clicking the Process Request button."
				  },
				  {
				    element: "#nav-2",
				    placement: "right",
				    title: "Credential Requests",
				    content: "You can add new request and view all the list of requested credentials here."
				  },
				  {
				    element: "#nav-3",
				    placement: "right",
				    title: "Student Management",
				    content: "You can add and view the student records here."
				  },
				  {
				    element: "#nav-4",
				    placement: "right",
				    title: "School Management",
				    content: "You can add and manage the curriculum, student subjects, student programs, and credentials here."
				  },
				  {
				    element: "#nav-5",
				    placement: "right",
				    title: "Credential Status",
				    content: "You can manage all the unclaimed and released credentials here."
				  },
				  {
				    element: "#nav-6",
				    placement: "right",
				    title: "Reports",
				    content: "You can view all the reports of the transactions made. You can also generate monthly accomplishment report and payment remittance here."
				  }

				]});

				// Initialize the tour
				tour.init();
				function start_tour() {
					tour.restart();
				}
			
		</script>
		<script src= "../assets/js/custom.min.js"></script>
		
		
	</body>
</html>
