<!DOCTYPE html>
<?php require_once "../../resources/config.php"; ?>
<?php include('include_files/session_check.php'); ?>
<?php
	$stud_id = "";
	if(isset($_GET['stud_id'])) {
		$stud_id = htmlspecialchars($_GET['stud_id'], ENT_QUOTES);
	}else {
		header("location: ../index.php");
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
<html>
	<head>
		<title>Choose Credential</title>
		<link rel="shortcut icon" href="../../assets/images/ico/fav.png" type="image/x-icon" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">



		<!-- Bootstrap -->
		<link href="../../resources/libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="../../resources/libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet">

		<!-- Datatables -->
		<link href="../../resources/libraries/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

		<!-- Custom Theme Style -->
		<link href="../../assets/css/custom.min.css" rel="stylesheet">
		<link href="../../assets/css/tstheme/style.css" rel="stylesheet">
		<!-- iCheck -->
		<link href=".../../../../resources/libraries/iCheck/skins/flat/green.css" rel="stylesheet">
		<!--[if lt IE 9]>
		<script src="../../js/ie8-responsive-file-warning.js"></script>
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
			<form id="choose_cred" class="form-horizontal form-label-left" data-parsley-validate action=<?php echo "generate_cred.php?stud_id=$stud_id" ?> method="GET" >
				<div class="x_panel">
					<div class="x_title">
						<h2>Generate Credential
						</h2>
					<div class="clearfix"></div>
					<h5><b>Student ID: </b><?php echo "$stud_id"; ?></h5>
					<h5><b>Student Name: </b><?php echo "$last_name".', '."$first_name"; ?></h5>
					<h5><b>Curriculum: </b><?php echo "$curriculum"; ?></h5>
				</div>
				<div class="x_content">
					<div class="item form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Student ID</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input id="name" class="form-control col-md-7 col-xs-12" required="required" type="text" name="stud_id" readonly="" value=<?php echo "'$stud_id'"; ?>>
						</div>
					</div>
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Choose Credential <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="credential" class="form-control" name="credential" required>
							<option value="">Choose..</option>
							<?php

								$statement = "SELECT * FROM credentials";
								$result = DB::query($statement);
								foreach ($result as $row) {
									$cred_id = $row['cred_id'];
									$cred_name = $row['cred_name'];

									echo "<option value='$cred_id'>$cred_name</option>";
								}
							?>
							</select>
	                      </div>
                      </div>
				</div>
			</div>
			<div class="row no-print">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-success pull-right submit">Next</button>
					<a class="btn btn-default pull-right" href=<?php echo "../studentmanagement/student_info.php?stud_id=$stud_id"; ?>>Cancel</a>
				</div>
			</div>
		</form>

	</div>
	<!-- Contents Here -->
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
	<!-- Custom Theme Scripts -->
	<script src= "../../assets/js/custom.min.js"></script>
	<!-- iCheck -->
	<script src="../../resources/libraries/iCheck/icheck.min.js"></script>
	<!-- Scripts -->
	<!-- Parsley -->
				<script>
				$(document).ready(function() {
				$.listen('parsley:field:validate', function() {
				validateFront();
				});
				$('#choose_cred .submit').on('click', function() {
				$('#choose_cred').parsley().validate();
				validateFront();
				});
				var validateFront = function() {
				if (true === $('#choose_cred').parsley().isValid()) {
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
</body>
</html>
