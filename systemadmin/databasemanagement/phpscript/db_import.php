<?php
include("php-mysqlimporter.php");
include ('../../../resources/classes/Popover.php');
require_once "../../../resources/config.php";
require_once "../../personnelmanagement/bcrypt/Bcrypt.php";

session_start();

$user_db = DB::$user;
$password_db = DB::$password;

$db_uname = htmlspecialchars(filter_var($_POST['db_uname'], FILTER_SANITIZE_STRING));
$db_password = htmlspecialchars(filter_var($_POST['db_pw'], FILTER_SANITIZE_STRING));
$password = htmlspecialchars(filter_var($_POST['pw'], FILTER_SANITIZE_STRING));
$username = $_SESSION['username'];
$file = $_SESSION['file'];
$size = $_SESSION['size'];
$date = $_SESSION['date'];

$pwCheck = "SELECT * from personnel where uname = '$username';";
$resultCheckPw = DB::query($pwCheck);

if (count($resultCheckPw) > 0) {
  foreach ($resultCheckPw as $row) {
  		$verifypw = Bcrypt::checkPassword($password, $row['password']);
			if ($verifypw == TRUE) { 
				if ($db_uname === $user_db && $db_password === $password_db) {
					$mysqlImport = new MySQLImporter("localhost", $db_uname, $db_password);
					
					$mysqlImport->doImport("./myBackups/$file", "pcnhsdb", true, true);

					//USER LOGS
				    date_default_timezone_set('Asia/Manila');
				    $act_msg= "IMPORTED BACKUP FILE : $file";
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

					$alert_type = "info";
					$message = "Imported Database Backup Succesfully";
					$popover = new Popover();
					$popover->set_popover($alert_type, $message);

					$_SESSION['db_msg_import'] = $popover->get_popover();

					header("location: ../exp_db.php");
				  	}else{
					  	$alert_type = "danger";
						$message = "Incorrect database username or password";
						$popover = new Popover();
						$popover->set_popover($alert_type, $message);

						$_SESSION['db_msg_import_2'] = $popover->get_popover();	
						header("location: ../import_db.php?filename=$file&filesize=$size&date=$date");
				  	}
				  	
				}else{
						$alert_type = "danger";
						$message = "Incorrect account password";
						$popover = new Popover();
						$popover->set_popover($alert_type, $message);

						$_SESSION['db_msg_import_2'] = $popover->get_popover();	
						header("location: ../import_db.php?filename=$file&filesize=$size&date=$date");
			}
				 
		}
	}

?>