<?php
	require_once "../../../resources/config.php";
	include('../../../resources/classes/Popover.php');
	session_start();

	$stud_id = strtoupper(htmlspecialchars(filter_var($_POST['stud_id'], FILTER_SANITIZE_STRING)));
	$first_name = strtoupper(htmlspecialchars(filter_var($_POST['first_name'], FILTER_SANITIZE_STRING)));
	$mid_name = strtoupper(htmlspecialchars(filter_var($_POST['mid_name'], FILTER_SANITIZE_STRING)));
	$last_name = strtoupper(htmlspecialchars(filter_var($_POST['last_name'], FILTER_SANITIZE_STRING)));
	$gender = htmlspecialchars(filter_var($_POST['gender'], FILTER_SANITIZE_STRING));

	$birth_date = htmlspecialchars(filter_var($_POST['birthdate']));

	$province = strtoupper(htmlspecialchars(filter_var($_POST['birth_place_province'], FILTER_SANITIZE_STRING)));
	$towncity = strtoupper(htmlspecialchars(filter_var($_POST['birth_place_towncity'], FILTER_SANITIZE_STRING)));
	$barangay = strtoupper(htmlspecialchars(filter_var($_POST['birth_place_barangay'], FILTER_SANITIZE_STRING)));

	$second_school_name = strtoupper(htmlspecialchars(filter_var($_POST['second_school_name'], FILTER_SANITIZE_STRING)));
	$program = htmlspecialchars(filter_var($_POST['program'], FILTER_SANITIZE_STRING));
	$curriculum = htmlspecialchars(filter_var($_POST['curriculum'], FILTER_SANITIZE_STRING));

	$pname = strtoupper(htmlspecialchars(filter_var($_POST['pname'], FILTER_SANITIZE_STRING)));
	$parent_occupation = strtoupper(htmlspecialchars(filter_var($_POST['occupation'], FILTER_SANITIZE_STRING)));
	$parent_address = strtoupper(htmlspecialchars(filter_var($_POST['parent_address'], FILTER_SANITIZE_STRING)));

	$primary_schl_name = strtoupper(htmlspecialchars(filter_var($_POST['schl_name'], FILTER_SANITIZE_STRING)));
	$primary_schl_year = htmlspecialchars($_POST['schl_year'], FILTER_SANITIZE_STRING);
	$total_elem_years = htmlspecialchars(filter_var($_POST['total_elem_years'], FILTER_SANITIZE_STRING));
	$gpa = htmlspecialchars(filter_var($_POST['gpa'], FILTER_SANITIZE_STRING));
	$willInsert = true;


// validate gpa
	if($gpa > 99.99 || $gpa < 75) {
		$willInsert = false;
		$alert_type = "danger";
		$error_message = "Ooops. The system did not accept the value that you entered. You have entered an invalid Average Grade.";
		$popover = new Popover();
		$popover->set_popover($alert_type, $error_message);
		$_SESSION['error_pop'] = $popover->get_popover();
		header("Location: " . $_SERVER["HTTP_REFERER"]);

	}

	$validate_p_schl_yr = explode("-", $primary_schl_year);
	$year1 = $validate_p_schl_yr[0];
	$year2 = $validate_p_schl_yr[1];
// validate primary school year
	if(intval($year1) > intval($year2) || intval($year2) != (intval($year1)+1) ) {
		$willInsert = false;
		$alert_type = "danger";
		$error_message = "Ooops. The system did not accept the value that you entered. You have entered an Invalid Primary School Year.";
		$popover = new Popover();
		$popover->set_popover($alert_type, $error_message);
		$_SESSION['error_pop'] = $popover->get_popover();
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
// validate empty inputs
	if(empty($stud_id) || empty($first_name) || empty($last_name) || empty($province) || empty($towncity) || empty($pname) || empty($parent_occupation) || empty($parent_address) || empty($primary_schl_name) || empty($primary_schl_year) || empty($total_elem_years) || empty($gender) || empty($second_school_name)) {

		$willInsert = false;
		$alert_type = "danger";
		$error_message = "Ooops. The system did not accept the value that you entered. Please make sure that the form is complete before adding student.";
		$popover = new Popover();
		$popover->set_popover($alert_type, $error_message);
		$_SESSION['error_pop'] = $popover->get_popover();
		header("Location: " . $_SERVER["HTTP_REFERER"]);

	}
// Duplicate Checker
	$selectStudents = "SELECT * from students where stud_id = '$stud_id' and (first_name = '$first_name' and last_name = '$last_name' and birth_date = '$birth_date');";

	$res = DB::query($selectStudents);

	if (count($res) > 0) {
		$willInsert = false;
			$alert_type = "danger";
			$error_message = "Ooops. The system did not accept the value that you entered. Duplicate Student found.";
			$popover = new Popover();
			$popover->set_popover($alert_type, $error_message);
			$_SESSION['error_pop'] = $popover->get_popover();
			header("Location: " . $_SERVER["HTTP_REFERER"]);
	}

	if($willInsert) {
		DB::insert('students', array(
			'stud_id' => $stud_id,
			'first_name' => $first_name,
			'mid_name' => $mid_name,
			'last_name' => $last_name,
			'gender' => $gender,
			'birth_date' => $birth_date,
			'barangay' => $barangay,
			'towncity' => $towncity,
			'province' => $province,
			'second_school_name' => $second_school_name,
			'curr_id' => $curriculum,
			'prog_id' => $program
		));
		DB::insert('parent', array(
			'stud_id' => $stud_id,
			'pname' => $pname,
			'occupation' => $parent_occupation,
			'address' => $parent_address
		));
		DB::insert('primaryschool', array(
			'stud_id' => $stud_id,
			'psname' => $primary_schl_name,
			'pschool_year' => $primary_schl_year,
			'total_elem_years' => $total_elem_years,
			'gen_average' => $gpa
		));
	// Generate Success Popover
		$alert_type = "success";
		$message = "Added Student Successfully.";
		$popover = new Popover();
		$popover->set_popover($alert_type, $message);
		$_SESSION['success'] = $popover->get_popover();


    //USER LOGS
    date_default_timezone_set('Asia/Manila');
    $act_msg= "ADDED STUDENT RECORD OF: $stud_id - $first_name $mid_name $last_name";
    $username = $_SESSION['username'];
	$currTime = date("h:i:s A");
    $log_id = null;
    $currDate = date("Y-m-d");
    $accnt_type = $_SESSION['accnt_type'];

    DB::insert('user_logs', array(
              'log_id' => $log_id,
              'user_name' => $username,
              'time' => $currTime,
              'log_date' => $currDate,
              'account_type' => $accnt_type,
              'user_act' => $act_msg,
    ));

		header("Location: ../student_info.php?stud_id=$stud_id");
	}

?>
