<?php require_once "../../resources/config.php"; ?>
<?php include('include_files/session_check.php'); ?>
<!DOCTYPE html>
<html>
		<head>
		<title>Released Credentials</title>
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
	    <!-- Date Range Picker -->
		<link href="../../resources/libraries/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
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
		<!-- Sidebar -->
		<?php include "../../resources/templates/registrar/sidebar.php"; ?>
		<!-- Top Navigation -->
		<?php include "../../resources/templates/registrar/top-nav.php"; ?>
		<!-- Contents Here -->
		<div class="right_col" role="main">
			<div class="col-md-9">
				<ol class="breadcrumb">
				  <li><a href="../index.php">Home</a></li>
				  <li><a href="#">Credentials</a></li>
				  <li class="active">Released Credentials</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Released Credentials</h2>
							<ul class="nav navbar-right panel_toolbox">
							</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<!-- Date Picker -->
						<div class="row">
							<div class="col-md-4">
								Select Date
								<form class="form-horizontal" action="released.php" method="get">
									<fieldset>

										<div class="control-group">
											<div class="controls">
												<div class="input-prepend input-group">
													<span class="add-on input-group-addon">
														<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
													</span>
													<input type="text" name="released_date" id="released_date" class="form-control" value=" " />
													<span class="input-group-btn">
														<button type="submit" class="btn btn-primary">Go</button>
													</span>
												</div>
											</div>
										</div>

									</fieldset>
								</form>
							</div>
							<br>
							<?php
									$released_date = "";
									if(isset($_GET['released_date'])) {
										$released_date = $_GET['released_date'];
										$released_date = preg_replace('/\s+/', '', $released_date);

									}else {
										$date_from = date("m/01/Y");
										$date_to = date("m/d/Y");
										$released_date = $date_from.' - '.$date_to;
										$released_date = preg_replace('/\s+/', '', $released_date);
									}


								?>
						</div>
	                      <!-- Date Picker -->
						<div class="released-list">
							<table class="tablesorter-bootstrap">
								<thead>
									<tr class="headings">
										<th class="column-title">Date Released</th>
										<th class="column-title">Student Name</th>
										<th class="column-title">Requested Credential/s</th>
									</th>

								</tr>
							</thead>
							<tbody>
							<?php
								$start=0;
								$limit=20;
								if(isset($_GET['page'])){
									$page=$_GET['page'];
									$start=($page-1)*$limit;
								}else{
									$page=1;
								}
								if(isset($_GET['released_date'])) {
				                    	$released_date = $_GET['released_date'];
				                    	$from_and_to_date = explode("-", $released_date);
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


										$statement = "SELECT stud_id, date_released as 'date released', concat(first_name, ' ' ,last_name) as 'stud_name', cred_name FROM pcnhsdb.requests natural join students natural join credentials where status='r' and date_released between '$from' and '$to' order by date_released desc limit $start, $limit;";
				                    }else {
				                    	$released_date = date('m/01/y').'-'.date('m/d/y');
				                    	$from_and_to_date = explode("-", $released_date);
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
				                    	$statement = "SELECT stud_id, date_released as 'date released', concat(first_name, ' ' ,last_name) as 'stud_name', cred_name FROM pcnhsdb.requests natural join students natural join credentials where status='r' order by date_released desc limit $start, $limit;";
				                    }
								
								$result = DB::query($statement);
								if (count($result) > 0) {
									foreach ($result as $row) {
										$date_released = $row['date released'];
										$stud_name = $row['stud_name'];
										$cred_name = $row['cred_name'];
										$stud_id = $row['stud_id'];
										echo <<<RELEASED
										<tr class="odd pointer">
											<td class=" ">$date_released</td>
											<td class=" "><a href="../studentmanagement/student_info.php?stud_id=$stud_id">$stud_name</a></td>
											<td class=" ">$cred_name</td>
										</tr>
RELEASED;
									}
								}

							?>
					</tbody>
				</table>
				<?php
							if(isset($_GET['released_date'])) {
				                    	$released_date = $_GET['released_date'];
				                    	$from_and_to_date = explode("-", $released_date);
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


										$statement = "SELECT stud_id, date_released as 'date released', concat(first_name, ' ' ,last_name) as 'stud_name', cred_name FROM pcnhsdb.requests natural join students natural join credentials where status='r' and date_released between '$from' and '$to' order by date_released;";
				                    }else {
				                    	$released_date = date('m/01/y').'-'.date('m/d/y');
				                    	$from_and_to_date = explode("-", $released_date);
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
				                    	$statement = "SELECT stud_id, date_released as 'date released', concat(first_name, ' ' ,last_name) as 'stud_name', cred_name FROM pcnhsdb.requests natural join students natural join credentials where status='r' order by date_released;";
				                    }

							$result = DB::query($statement);
							$rows = count($result);

							$total = ceil($rows/$limit);
							if(isset($_GET['released_date'])) {
								$released_date = $_GET['released_date'];
								echo '<div class="pull-right">
									<div class="col s12">
											<ul class="pagination center-align">';
													if($page > 1) {
													echo "<li class=''><a href='released.php?released_date=$released_date&page=".($page-1)."'>Previous</a></li>";
													}else if($total <= 0) {
													echo '<li class="disabled"><a>Previous</a></li>';
													}else {
													echo '<li class="disabled"><a>Previous</a></li>';
													}
													for($i = 1;$i <= $total; $i++) {
													if($i==$page) {
													echo "<li class='active'><a href='released.php?released_date=$released_date&page=$i'>$i</a></li>";
													} else {
													echo "<li class=''><a href='released.php?released_date=$released_date&page=$i'>$i</a></li>";
													}
													}
													if($total == 0) {
													echo "<li class='disabled'><a>Next</a></li>";
													}else if($page!=$total) {
													echo "<li class=''><a href='released.php?released_date=$released_date&page=".($page+1)."'>Next</a></li>";
													}else {
													echo "<li class='disabled'><a>Next</a></li>";
													}
											echo "</ul></div></div>";
										}else {
											echo '<div class="pull-right">
									<div class="col s12">
											<ul class="pagination center-align">';
													if($page > 1) {
													echo "<li class=''><a href='released.php?page=".($page-1)."'>Previous</a></li>";
													}else if($total <= 0) {
													echo '<li class="disabled"><a>Previous</a></li>';
													}else {
													echo '<li class="disabled"><a>Previous</a></li>';
													}
													for($i = 1;$i <= $total; $i++) {
													if($i==$page) {
													echo "<li class='active'><a href='released.php?page=$i'>$i</a></li>";
													} else {
													echo "<li class=''><a href='released.php?page=$i'>$i</a></li>";
													}
													}
													if($total == 0) {
													echo "<li class='disabled'><a>Next</a></li>";
													}else if($page!=$total) {
													echo "<li class=''><a href='released.php?page=".($page+1)."'>Next</a></li>";
													}else {
													echo "<li class='disabled'><a>Next</a></li>";
													}
											echo "</ul></div></div>";
										}
							

									?>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<!-- Contents Here -->
<?php include "../../resources/templates/registrar/footer.php"; ?>
		<!-- Scripts -->
		<!-- Bootstrap -->
		<script src="../../resources/libraries/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src= "../../resources/libraries/fastclick/lib/fastclick.js"></script>
		<!-- input mask -->
		<script src= "../../resources/libraries/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
		<script src= "../../resources/libraries/parsleyjs/dist/parsley.min.js"></script>
		<!-- Date Range Picker -->
			<script src="../../resources/libraries/moment/min/moment.min.js"></script>
			<script src="../../resources/libraries/bootstrap-daterangepicker/daterangepicker.js"></script>
		<!-- NProgress -->
	  <script src="../../resources/libraries/nprogress/nprogress.js"></script>
		<!-- Custom Theme Scripts -->
		<script src= "../../assets/js/jquery.easy-autocomplete.js"></script>
		<script type="text/javascript">
			$('#released_date').daterangepicker({
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
		<script type="text/javascript">
		$(function() {
		$('.released-list').tablesorter();
		$('.tablesorter-bootstrap').tablesorter({
		theme : 'bootstrap',
		headerTemplate: '{content} {icon}',
		widgets    : ['zebra','columns', 'uitheme']
		});
		});
		</script>
	<!-- Scripts -->
</body>
</html>
