<?php require_once "../../resources/config.php"; ?>
<?php
    session_start();
    // Session Timeout
    $time = time();
    $session_timeout = 1800; //seconds
    
    if(isset($_SESSION['last_activity']) && ($time - $_SESSION['last_activity']) > $session_timeout) {
      session_unset();
      session_destroy();
      session_start();
    }

    $_SESSION['last_activity'] = $time;
    if(!isset($_SESSION['logged_in']) && !isset($_SESSION['account_type'])){
      header('Location: ../../login.php');
    }
    
  ?>
<!DOCTYPE html>
<?php $stud_id = $_GET['stud_id'] ?>
<html>
	<head>
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
		<link href="../../css/custom.min.css" rel="stylesheet">
		<link href="../../css/tstheme/style.css" rel="stylesheet">
		
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
			<a href=<?php echo "student_info.php?stud_id=$stud_id"; ?> class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back to Previous Page</a>
			<div class="x_panel">
				<div class="x_title">
					<h2>Attendance</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
				<!-- First Year  -->
					<?php
						if(!$conn) {
		                    die("Connection failed: " . mysqli_connect_error());
		                }
		                $schl_yr1 = "";
		                $yr_lvl1 ="";
		                $days_attended1 = "";
		                $school_days1 = "";
		                $attendance1 = "SELECT * FROM pcnhsdb.attendance WHERE stud_id = '$stud_id' and yr_lvl = 1;";
		                $result = $conn->query($attendance1);
	                    if ($result->num_rows > 0) {
	                    // output data of each row
		                    while($row = $result->fetch_assoc()) {
		                    	$schl_yr1 = $row['schl_yr'];
		                    	$yr_lvl1 = $row['yr_lvl'];
		                    	$days_attended1 = $row['days_attended'];
		                    	$school_days1 = $row['school_days'];
		                    }
		                }

					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Year Level: 1<small>School Year: <?php if(!empty($schl_yr1)){ echo "$schl_yr1"; }else{echo "None";} ?></small></h2>
		                    <div class="clearfix"></div>
		                  </div>
		                  <div class="x_content">
		                    <h2>Days Attended: <?php  if(!empty($days_attended1)){ echo "$days_attended1"; }else{echo "None";}  ?></h2>
		                    <h2>Days of School: <?php if(!empty($school_days1)){ echo "$school_days1"; }else{echo "None";} ?></h2>
		                    <h2>Total Years in School: 7</h2>
		                  </div>
		                <?php
		                  	if(empty($schl_yr1) || $schl_yr1 == "" || is_null($schl_yr1)) {
		                  		echo "<a class='btn btn-success pull-right btn-xs' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=1'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  	}else {
		                  		echo "<a class='btn btn-success pull-right btn-xs disabled' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=1'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  	}
		                  ?>
		                  
		                </div>

		            </div>
				<!-- First Year  -->
				<!-- Second Year -->
					<?php
						if(!$conn) {
		                    die("Connection failed: " . mysqli_connect_error());
		                }
		                $schl_yr2 = "";
		                $yr_lvl2 ="";
		                $days_attended2 = "";
		                $school_days2 = "";
		                $attendance2 = "SELECT * FROM `attendance` WHERE stud_id = '$stud_id' and yr_lvl = 2;";
		                $result = $conn->query($attendance2);
	                    if ($result->num_rows > 0) {
	                    // output data of each row
		                    while($row = $result->fetch_assoc()) {
		                    	$schl_yr2 = $row['schl_yr'];
		                    	$yr_lvl2 = $row['yr_lvl'];
		                    	$days_attended2 = $row['days_attended'];
		                    	$school_days2 = $row['school_days'];
		                    }
		                }

					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Year Level: 2<small>School Year: <?php if(!empty($schl_yr2)){ echo "$schl_yr2"; }else{echo "None";} ?></small></h2>
		                    <div class="clearfix"></div>
		                  </div>
		                  <div class="x_content">
		                    <h2>Days Attended: <?php  if(!empty($days_attended2)){ echo "$days_attended2"; }else{echo "None";}  ?></h2>
		                    <h2>Days of School: <?php if(!empty($school_days2)){ echo "$school_days2"; }else{echo "None";} ?></h2>
		                    <h2>Total Years in School: 8</h2>
		                  </div>
		                  <?php
		                  	if(empty($schl_yr1) || $schl_yr1 == "" || is_null($schl_yr1)) {
		                  		echo "<a class='btn btn-success pull-right btn-xs disabled' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=2'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  	}else {
		                  		if(empty($schl_yr2) || $schl_yr2 == "" || is_null($schl_yr2)) {
		                  			echo "<a class='btn btn-success pull-right btn-xs' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=2'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  		}else {
		                  			echo "<a class='btn btn-success pull-right btn-xs disabled' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=2'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  		}
		                  		
		                  	}
		                  ?>
		                </div>
		            </div>
				<!-- Second Year -->
				<!-- Third Year -->
					<?php
						if(!$conn) {
		                    die("Connection failed: " . mysqli_connect_error());
		                }
		                $schl_yr3 = "";
		                $yr_lvl3 ="";
		                $days_attended3 = "";
		                $school_days3 = "";
		                $attendance3 = "SELECT * FROM `attendance` WHERE stud_id = '$stud_id' and yr_lvl = 3;";
		                $result = $conn->query($attendance3);
	                    if ($result->num_rows > 0) {
	                    // output data of each row
		                    while($row = $result->fetch_assoc()) {
		                    	$schl_yr3 = $row['schl_yr'];
		                    	$yr_lvl3 = $row['yr_lvl'];
		                    	$days_attended3 = $row['days_attended'];
		                    	$school_days3 = $row['school_days'];
		                    }
		                }

					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Year Level: 3<small>School Year: <?php if(!empty($schl_yr3)){ echo "$schl_yr3"; }else{echo "None";} ?></small></h2>
		                    <div class="clearfix"></div>
		                  </div>
		                  <div class="x_content">
		                    <h2>Days Attended: <?php  if(!empty($days_attended3)){ echo "$days_attended3"; }else{echo "None";}  ?></h2>
		                    <h2>Days of School: <?php if(!empty($school_days3)){ echo "$school_days3"; }else{echo "None";} ?></h2>
		                    <h2>Total Years in School: 9</h2>
		                  </div>
		                  <?php
		                  	if(empty($schl_yr2) || $schl_yr2 == "" || is_null($schl_yr2)) {
		                  		echo "<a class='btn btn-success pull-right btn-xs disabled' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=3'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  	}else {
		                  		if(empty($schl_yr3) || $schl_yr3 == "" || is_null($schl_yr3)) {
		                  			echo "<a class='btn btn-success pull-right btn-xs' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=3'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  		}else {
		                  			echo "<a class='btn btn-success pull-right btn-xs disabled' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=3'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  		}
		                  		
		                  	}
		                  ?>
		                </div>

		            </div>
				<!--  -->
				<!--  -->
				<?php
						if(!$conn) {
		                    die("Connection failed: " . mysqli_connect_error());
		                }
		                $schl_yr4 = "";
		                $yr_lvl4 ="";
		                $days_attended4 = "";
		                $school_days4 = "";
		                $attendance4 = "SELECT * FROM `attendance` WHERE stud_id = '$stud_id' and yr_lvl = 4;";
		                $result = $conn->query($attendance4);
	                    if ($result->num_rows > 0) {
	                    // output data of each row
		                    while($row = $result->fetch_assoc()) {
		                    	$schl_yr4 = $row['schl_yr'];
		                    	$yr_lvl4 = $row['yr_lvl'];
		                    	$days_attended4 = $row['days_attended'];
		                    	$school_days4 = $row['school_days'];
		                    }
		                }

					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
		                    <h2>Year Level: 4<small>School Year: <?php if(!empty($schl_yr4)){ echo "$schl_yr4"; }else{echo "None";} ?></small></h2>
		                    <div class="clearfix"></div>
		                  </div>
		                  <div class="x_content">
		                    <h2>Days Attended: <?php  if(!empty($days_attended4)){ echo "$days_attended4"; }else{echo "None";}  ?></h2>
		                    <h2>Days of School: <?php if(!empty($school_days4)){ echo "$school_days4"; }else{echo "None";} ?></h2>
		                    <h2>Total Years in School: 10</h2>
		                  </div>
		                  <?php
		                  	if(empty($schl_yr3) || $schl_yr3 == "" || is_null($schl_yr3)) {
		                  		echo "<a class='btn btn-success pull-right btn-xs disabled' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=4'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  	}else {
		                  		if(empty($schl_yr4) || $schl_yr4 == "" || is_null($schl_yr4)) {
		                  			echo "<a class='btn btn-success pull-right btn-xs' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=4'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  		}else {
		                  			echo "<a class='btn btn-success pull-right btn-xs disabled' href='../../registrar/studentmanagement/add_attendance.php?stud_id=$stud_id&yr_level=4'><i class='fa fa-plus m-right-xs'></i> Add Attendance</a>";
		                  		}
		                  		
		                  	}
		                  ?>
		                </div>
		            </div>
				<!--  -->
              		<div class="clearfix"></div>
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
		<script src= "../../js/custom.min.js"></script>
		<!-- Scripts -->
		<!-- validator -->
		<script>
		// initialize the validator function
		validator.message.date = 'not a real date';
		// validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
		$('form')
		.on('blur', 'input[required], input.optional, select.required', validator.checkField)
		.on('change', 'select.required', validator.checkField)
		.on('keypress', 'input[required][pattern]', validator.keypress);
		$('.multi.required').on('keyup blur', 'input', function() {
		validator.checkField.apply($(this).siblings().last()[0]);
		});
		$('form').submit(function(e) {
		e.preventDefault();
		var submit = true;
		// evaluate the form using generic validaing
		if (!validator.checkAll($(this))) {
		submit = false;
		}
		if (submit)
		this.submit();
		return false;
		});
		</script>
		<!-- /validator -->
		<!-- jquery.inputmask -->
		<script>
		$(document).ready(function() {
		$(":input").inputmask();
		});
		</script>
		<!-- /jquery.inputmask -->
		<!-- <script type="text/javascript">
			// function showSubjects(base_url) {
								// 	var curriculum = document.getElementById("curriculum").value;
								// 	alert(base_url+"?curr_id="+curriculum);
								// 	document.getElementById("subj1").innerHTML = "";
			// }
		</script> -->
		<script>
		function showSubjects() {
		var xhttp = new XMLHttpRequest();
		var curriculum = document.getElementById("curriculum").value;
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		document.getElementById("subj1").innerHTML =
		this.responseText;
		}
		};
		xhttp.open("GET", "showsubjects.php?curr_id="+curriculum, true);
		xhttp.send();
		}
		</script>
	</body>
</html>