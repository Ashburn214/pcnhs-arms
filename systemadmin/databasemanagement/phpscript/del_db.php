<?php
require_once "../../../resources/config.php";

session_start();

$file=$_GET['file'];
$username = $_SESSION['username'];
unlink('myBackups/'.$_GET['file']);

	//USER LOGS
    date_default_timezone_set('Asia/Manila');
    $act_msg= "DELETED BACKUP FILE : $file";
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

header("location: ../exp_db.php");
?>
