<!DOCTYPE html>
<?php require_once "../../resources/config.php"; ?>
<?php include "include_files/session_check.php"; ?>
<html>
	<head>
		<title>Accomplishment Report</title>
		<link rel="shortcut icon" href="../../assets/images/ico/fav.png" type="image/x-icon" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		
		
		<!-- Bootstrap -->
		<link href="../../resources/libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="../../resources/libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- Date Range Picker -->
		<link href="../../resources/libraries/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
		<!-- Datatables -->
		<link href="../../resources/libraries/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
		
		<!-- Custom Theme Style -->
		<link href="../../assets/css/custom.css" rel="stylesheet">
		<link href="../../assets/css/tstheme/style.css" rel="stylesheet">
		
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
					<li><a href="#">Reports</a></li>
					<li class="active">Accomplishment Reports</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Accomplishment Reports</h2>
							<ul class="nav navbar-right panel_toolbox">
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
						<form action="preview_accomp.php" method="POST">
							
							<label for="r_fm" class="col-md-3">Records and File Management</label>
							<br>
							<div class="col-md-12 pull-right">
								<textarea class="resizable_textarea form-control" name="r_fm" style="height:150px;"></textarea>
							</div>
							
							
							
							<div class="col-md-12">
								<label for="fm" class="col-md-2">Registrar's Services</label>
								
								
								<div id="date"  class="col-md-7">
									<?php 
												$accomplishment_date = $_SESSION['accomplishment_date'];
												$accomplishment_date = explode("/", $accomplishment_date);
												$a_month = $accomplishment_date[0];
												$a_year = substr($accomplishment_date[2], 0, 4);
									
												if($a_month < 10) {
												$a_month = substr($a_month, 1, 1);
												}
												$month_array = array('January','February','March','April','May','June','July','August','September','October','November','December');
									$monthstr = $month_array[$a_month-1]; ?>
									<!-- <?php // echo $accomplishment_date; ?> -->
									<p>Accomplished and Released Credentials in the month of <?php echo $monthstr; ?> year <?php echo $a_year; ?>.</p>
								</div>
							</div>
							
							
							<label for=
							"fm" class="col-md-2">Financial Management</label>
							<br>
							<div class="col-md-12 pull-right">
								<textarea class="resizable_textarea form-control" name="fm" style="height:150px;"></textarea>
							</div>
							
							
							
							<label id="ot" class="col-md-2">Other Tasks</label>
							<div class="col-md-12 pull-right">
								<textarea class="resizable_textarea form-control" name="ot" style="height:150px;"></textarea>
							</div>
							<!--             <div class="form-group"> -->
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Choose Signatory (Checked by)<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="credential" class="form-control" name="signatory1">
								<option value="">-- Choose Signatory --</option>
								<option value="" disabled="">-- Head Teacher --</option>
								<?php
									if(!$conn) {
										die("Connection failed: " . mysqli_connect_error());
									}
									$statement = "SELECT * FROM signatories WHERE position='HEAD TEACHER'";
									$result = $conn->query($statement);
									if ($result->num_rows > 0) {
										// output data of each row
										while($row = $result->fetch_assoc()) {
											$sign_id1 = $row['sign_id'];
											$sign_name1 = $row['first_name'].' '.$row['mname'].' '.$row['last_name'];
											echo "<option value='$sign_id1'>$sign_name1</option>";
										}
									}
								?>
								<option value="" disabled="">-- Principal --</option>
								<?php
										if(!$conn) {
											die("Connection failed: " . mysqli_connect_error());
										}
										$statement = "SELECT * FROM signatories WHERE position='PRINCIPAL'";
										$result = $conn->query($statement);
										if ($result->num_rows > 0) {
											// output data of each row
											while($row = $result->fetch_assoc()) {
												$sign_id1 = $row['sign_id'];
												$sign_name1 = $row['first_name'].' '.$row['mname'].' '.$row['last_name'];
												echo "<option value='$sign_id1'>$sign_name1</option>";
											}
										}
								?>
							</select>
						</div>
						<!-- 			</div> -->
						<div class="col-md-12"></div>
						<!-- 			<div class="form-group"> -->
						<label class="control-label col-md-3 col-sm-3 col-xs-12">Choose Signatory (Verified by)<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<select id="credential" class="form-control" name="signatory2">
								<option value="">-- Choose Signatory --</option>
								<option value="" disabled="">-- Head Teacher --</option>
								<?php
									if(!$conn) {
										die("Connection failed: " . mysqli_connect_error());
									}
									$statement = "SELECT * FROM signatories WHERE position='HEAD TEACHER'";
									$result = $conn->query($statement);
									if ($result->num_rows > 0) {
										// output data of each row
										while($row = $result->fetch_assoc()) {
											$sign_id2 = $row['sign_id'];
											$sign_name2 = $row['first_name'].' '.$row['mname'].' '.$row['last_name'];
											echo "<option value='$sign_id2'>$sign_name2</option>";
										}
									}
								?>
								<option value="" disabled="">-- Principal --</option>
								<?php
										if(!$conn) {
											die("Connection failed: " . mysqli_connect_error());
										}
										$statement = "SELECT * FROM signatories WHERE position='PRINCIPAL'";
										$result = $conn->query($statement);
										if ($result->num_rows > 0) {
											// output data of each row
											while($row = $result->fetch_assoc()) {
												$sign_id2 = $row['sign_id'];
												$sign_name2 = $row['first_name'].' '.$row['mname'].' '.$row['last_name'];
												echo "<option value='$sign_id2'>$sign_name2</option>";
											}
										}
								?>
							</select>
						</div>
						<!-- 			</div> -->
						<button id="generatebutton" class="btn btn-primary pull-right" type="submit"><i class="fa fa-print m-right-xs"></i> Generate Credentials</button>
					</form>
					</div>
					<!-- <?php // $accomplishment_date = $_GET['accomplishment_date'];?>
					<?php // echo $accomplishment_date;?> -->
					
				</div>
				
			</div>
		</div>
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
	<!-- Date Range Picker -->
	<script src="../../resources/libraries/moment/min/moment.min.js"></script>
	<script src="../../resources/libraries/bootstrap-daterangepicker/daterangepicker.js"></script>
	
	<script src= "../../resources/libraries/parsleyjs/dist/parsley.min.js"></script>
	<!-- Custom Theme Scripts -->
	<script src= "../../assets/js/custom.js"></script>
	<script type="text/javascript">
		$('textarea').autoResize();
	</script>
	
</body>
</html>