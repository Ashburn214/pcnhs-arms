<!DOCTYPE html>
<html>
	<head>
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
	    <link href="../../css/custom.min.css" rel="stylesheet">
	    <link href="../../css/tstheme/style.css" rel="stylesheet">
		
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
			
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Unclaimed Credentials</h2>
							<ul class="nav navbar-right panel_toolbox">
							</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="table-responsive">
							<table class="table table-striped jambo_table">
								<thead>
									<tr class="headings">
										<th class="column-title">Date Processed</th>
										<th class="column-title">Student Name</th>
										<th class="column-title">Requested Credential</th>
										<th class="column-title no-link last"><span class="nobr">Mark as</span>
									</th>
									
								</tr>
							</thead>
							<tbody>
								
							<tr class="odd pointer">
								<td class=" ">11/11/2016</td>
								<td class=" ">Juan Migu</td>
								<td class=" ">Form 137</td>
								<td class=" last"><a class="btn btn-default btn-xs" href="#"><i class="fa fa-paper-plane"></i> Released</a></td>
							</tr>
							<tr class="odd pointer">
								<td class=" ">11/12/2016</td>
								<td class=" ">Jake Ross</td>
								<td class=" ">Form 137</td>
								<td class=" last"><a class="btn btn-default btn-xs" href="#"><i class="fa fa-paper-plane"></i> Released</a></td>
							</tr>
							<tr class="odd pointer">
								<td class=" ">11/14/2016</td>
								<td class=" ">Kaiser Ken</td>
								<td class=" ">Form 137</td>
								<td class=" last"><a class="btn btn-default btn-xs" href="#"><i class="fa fa-paper-plane"></i> Released</a></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
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
		<script src= "../../resources/libraries/parsleyjs/dist/parsley.min.js"></script>
		<!-- Custom Theme Scripts -->
		<script src= "../../js/custom.min.js"></script>
	<!-- Scripts -->
</body>
</html>