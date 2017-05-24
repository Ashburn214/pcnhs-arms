<?php
	session_start();
	include('../../../resources/classes/Popover.php');
?>
<?php
	unset($_SESSION['grades_array']);
	if(isset($_SESSION['save-type'])) {
		if ($_SESSION['save-type'] == "save-to-file") {
			$out = fopen('php://output', 'a');
			$stud_id = htmlspecialchars($_POST['stud_id'], ENT_QUOTES);
			$schl_year = htmlspecialchars($_POST['schl_year'], ENT_QUOTES);
			$yr_level = htmlspecialchars($_POST['yr_level'], ENT_QUOTES);
			$average_grade = filter_var($_POST['average_grade'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
			$schl_name = htmlspecialchars($_POST['schl_name'], ENT_QUOTES);
			$total_credit = filter_var($_POST['total_credits'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
			$insertgrades = "";
			$comment = "";
			//$credit_earned = htmlspecialchars($_POST['credit_earned']);
			$average_grade = round($average_grade, 5);
			$total_credit = round($total_credit, 5);
			header('Content-type:text/csv');
			header("Content-Disposition: attachment; filename=$stud_id-year-level-$yr_level-partial-save.csv");
			header("Content-Transfer-Encoding: UTF-8");


			$list = array($_POST['subj_id'],$_POST['fin_grade'],$_POST['credit_earned']);
			foreach ($list as $fields) {
				fputcsv($out, $fields);
			}
			fclose($out);
		}elseif($_SESSION['save-type'] == "save-to-db") {
			require_once "../../../resources/config.php";
			$stud_id = htmlspecialchars($_POST['stud_id'], ENT_QUOTES);
			$schl_year = htmlspecialchars($_POST['schl_year'], ENT_QUOTES);
			$yr_level = htmlspecialchars($_POST['yr_level'], ENT_QUOTES);
			$average_grade = filter_var($_POST['average_grade'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
			$schl_name = htmlspecialchars($_POST['schl_name'], ENT_QUOTES);
			$total_credit = filter_var($_POST['total_credits'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
			$insertgrades = "";
			$comment = "";
			$willInsert = true;
			$hasSpecialGrade = false;

			$average_grade = round($average_grade, 5);
			$total_credit = round($total_credit, 5);

			$curr_id = $_GET['curr_id'];
			$curr_code = "";

			$checkcurriculum = "SELECT * FROM pcnhsdb.curriculum where curr_id = $curr_id;";
			$result = DB::query($checkcurriculum);
			if (count($result) > 0) {
				foreach ($result as $row) {
					$curr_code = $row['curr_code'];
				}
			}

			$checkgrade = "SELECT * from pcnhsdb.grades where stud_id = '$stud_id' AND yr_level = '$yr_level' and remarks is null";
		    $result = DB::query($checkgrade);
				if (count($result) > 0) {
		        $alert_type = "danger";
		        $error_message = "Student $stud_id grades for year level $yr_level is already existing.";
		        $popover = new Popover();
		        $popover->set_popover($alert_type, $error_message);
		        $_SESSION['hasgrades'] = $popover->get_popover();
		        header("location: ../student_info.php?stud_id=".$stud_id);
		        die();
		    }
//
			foreach ($_POST['subj_id'] as $key => $value) {
				$subj_id = htmlspecialchars($_POST['subj_id'][$key]);
				$fin_grade = htmlspecialchars($_POST['fin_grade'][$key]);
				$credit_earned = htmlspecialchars($_POST['credit_earned'][$key]);
				$special_grade = strtoupper(htmlspecialchars($_POST['special_grade'][$key]));
//
				if(!empty($fin_grade) && !empty($special_grade) && $curr_code == "NSEC") {
					$special_grade = "";
				}
				if(empty($fin_grade) && !empty($special_grade)) {
					$fin_grade = 99;
					$hasSpecialGrade = true;
				}

				if(!empty($special_grade) && $curr_code != "NSEC") {
					$willInsert = false;
					$alert_type = "danger";
					$error_message = "Ooops. The system did not accept the value that you entered, Special Grade fields are for NSEC Students only.";
					$popover = new Popover();
					$popover->set_popover($alert_type, $error_message);
					$_SESSION['error_pop'] = $popover->get_popover();
					header("Location: " . $_SERVER["HTTP_REFERER"]);
					die();
				}

				if($fin_grade > 74 && $credit_earned == 0 && is_numeric($credit_earned)) {
					$willInsert = false;
					$alert_type = "danger";
					$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
					$popover = new Popover();
					$popover->set_popover($alert_type, $error_message);
					$_SESSION['error_pop'] = $popover->get_popover();
					header("Location: " . $_SERVER["HTTP_REFERER"]);
					die();
				}

				if(!is_numeric($credit_earned)) {
					if($curr_code != "K-12") {
						$willInsert = false;
						$alert_type = "danger";
						$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
						$popover = new Popover();
						$popover->set_popover($alert_type, $error_message);
						$_SESSION['error_pop'] = $popover->get_popover();
						header("Location: " . $_SERVER["HTTP_REFERER"]);
						die();
					}else {
						if(strtoupper($credit_earned) == 'P') {
							$credit_earned = "PROMOTED";
						}elseif(strtoupper($credit_earned) == 'R') {
							$credit_earned = "RETAINED";
						}else {
							$credit_earned = "";
							$willInsert = false;
							$alert_type = "danger";
							$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
							$popover = new Popover();
							$popover->set_popover($alert_type, $error_message);
							$_SESSION['error_pop'] = $popover->get_popover();
							header("Location: " . $_SERVER["HTTP_REFERER"]);
							die();
						}

						if($fin_grade < 75) {
							$credit_earned = "RETAINED";;
						}
						if($fin_grade > 75) {
							$credit_earned = "PROMOTED";
						}
					}
				}
				if(is_numeric($credit_earned)) {
					if($curr_code == "K-12") {
						$willInsert = false;
						$alert_type = "danger";
						$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
						$popover = new Popover();
						$popover->set_popover($alert_type, $error_message);
						$_SESSION['error_pop'] = $popover->get_popover();
						header("Location: " . $_SERVER["HTTP_REFERER"]);
						die();
					}
				}


				if(empty($fin_grade) || empty($credit_earned)) {
					$willInsert = false;
					$alert_type = "danger";
					$error_message = "Please complete the form before saving to database.";
					$popover = new Popover();
					$popover->set_popover($alert_type, $error_message);
					$_SESSION['error_pop'] = $popover->get_popover();
					header("Location: " . $_SERVER["HTTP_REFERER"]);
					die();
				}
				if($fin_grade > 99.99 || $fin_grade < 65) {
					$willInsert = false;
					$alert_type = "danger";
					$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
					$popover = new Popover();
					$popover->set_popover($alert_type, $error_message);
					$_SESSION['error_pop'] = $popover->get_popover();
					header("Location: " . $_SERVER["HTTP_REFERER"]);
					die();
				}
		//
				if($credit_earned < 0 || $credit_earned > 100) {
					$willInsert = false;
					$alert_type = "danger";
					$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
					$popover = new Popover();
					$popover->set_popover($alert_type, $error_message);
					$_SESSION['error_pop'] = $popover->get_popover();
					header("Location: " . $_SERVER["HTTP_REFERER"]);
					die();
				}
				if($fin_grade < 75 && $fin_grade != 0 && $curr_code != "K-12") {
					$credit_earned = 0;
					$comment ="FAILED";
					// $total_credit -= 1;
					// if($total_credit < 1) {
					// 	$total_credit = 0;
					// }
				}else {
					$comment = "PASSED";
				}
		//
				if($average_grade > 99.999) {
					$willInsert = false;
					$alert_type = "danger";
					$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
					$popover = new Popover();
					$popover->set_popover($alert_type, $error_message);
					$_SESSION['error_pop'] = $popover->get_popover();
					header("Location: " . $_SERVER["HTTP_REFERER"]);
					die();
				}
				if(empty($average_grade)) {
					$willInsert = false;
					$alert_type = "danger";
					$error_message = "Ooops. The system cannot accept empty Average Grade, please check and enter a valid value.";
					$popover = new Popover();
					$popover->set_popover($alert_type, $error_message);
					$_SESSION['error_pop'] = $popover->get_popover();
					header("Location: " . $_SERVER["HTTP_REFERER"]);
					die();
				}
				if(!is_numeric($total_credit)) {
					$total_credit = "N/A";
				}
				if($hasSpecialGrade) {
					$fin_grade = 0.0;
				}
				$insertgrades = "INSERT INTO `pcnhsdb`.`studentsubjects` (`stud_id`, `subj_id`, `schl_year`, `yr_level`, `fin_grade`, `comment`, `credit_earned`,  `special_grade`) VALUES ('$stud_id', '$subj_id', '$schl_year', '$yr_level', '$fin_grade', '$comment', '$credit_earned', '$special_grade');";

				DB::query($insertgrades);
			}
			$insertaverage = "INSERT INTO `pcnhsdb`.`grades` (`stud_id`, `schl_name`, `schl_year`, `yr_level`, `average_grade`, `total_credit`, `remarks`) VALUES ('$stud_id', '$schl_name', '$schl_year', '$yr_level', '$average_grade', '$total_credit', 'REGULAR');";


			//$yr_lvl = htmlspecialchars($_POST['yr_lvl'], ENT_QUOTES);
			$school_days = htmlspecialchars($_POST['school_days'], ENT_QUOTES);
			$days_attended = htmlspecialchars($_POST['days_attended'], ENT_QUOTES);
			$total_years_in_school = htmlspecialchars($_POST['total_years_in_school'], ENT_QUOTES);
			$days_in_year = 365;

			if(!is_numeric($days_attended) || !is_numeric($school_days)) {
				$willInsert = false;
				$alert_type = "danger";
				$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
				$popover = new Popover();
				$popover->set_popover($alert_type, $error_message);
				$_SESSION['error_pop'] = $popover->get_popover();
				header("Location: " . $_SERVER["HTTP_REFERER"]);
				die();
			}
		//validate days attended.
			if(intval($days_attended) > intval($school_days)) {
				$willInsert = false;
				$alert_type = "danger";
				$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
				$popover = new Popover();
				$popover->set_popover($alert_type, $error_message);
				$_SESSION['error_pop'] = $popover->get_popover();
				header("Location: " . $_SERVER["HTTP_REFERER"]);
				die();
			}
			if(intval($days_attended) > $days_in_year || intval($school_days) > $days_in_year) {
				$willInsert = false;
				$alert_type = "danger";
				$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
				$popover = new Popover();
				$popover->set_popover($alert_type, $error_message);
				$_SESSION['error_pop'] = $popover->get_popover();
				header("Location: " . $_SERVER["HTTP_REFERER"]);
				die();
			}
			if(intval($days_attended) < 100 || intval($school_days) < 100) {
				$willInsert = false;
				$alert_type = "danger";
				$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
				$popover = new Popover();
				$popover->set_popover($alert_type, $error_message);
				$_SESSION['error_pop'] = $popover->get_popover();
				header("Location: " . $_SERVER["HTTP_REFERER"]);
				die();
			}
			if(intval($total_years_in_school) != (intval($yr_level)+6)) {
				$willInsert = false;
				$alert_type = "danger";
				$error_message = "Ooops. The system did not accept the value that you entered, please check and enter a valid value.";
				$popover = new Popover();
				$popover->set_popover($alert_type, $error_message);
				$_SESSION['error_pop'] = $popover->get_popover();
				header("Location: " . $_SERVER["HTTP_REFERER"]);
				die();
			}


			if($willInsert) {
				unset($_SESSION['grade']);
				unset($_SESSION['credits']);
				unset($_SESSION['save-type']);
				DB::query($insertaverage);
				DB::insert('attendance', array(
					'stud_id' => $stud_id,
					'schl_yr' => $schl_year,
					'yr_lvl' => $yr_level,
					'days_attended' => $days_attended,
					'school_days' => $school_days,
					'total_years_in_school' => $total_years_in_school
				));
				echo "<p>Updating Database, please wait...</p>";
				header("refresh:3;url=../student_info.php?stud_id=$stud_id");
				//$_SESSION['user_activity'][] = "ADDED NEW GRADES: $stud_id - $yr_level";
			}
		}
	}
?>
