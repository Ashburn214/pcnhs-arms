<?php
require_once "../../../resources/config.php";
session_start();
date_default_timezone_set('Asia/Manila');
$curr_month = date('F');
$username = $_SESSION['username'];
$account_type = $_SESSION['account_type'];

$query = "SELECT * from backups where month = '$curr_month';";
$result1 = DB::query($query);

 if (count($result1) > 0) {
    foreach ($result1 as $row) {
      if ($curr_month === "June" && $row['status'] == 0) {

          $updatestmnt = "UPDATE `pcnhsdb`.`backups`
                          SET `status`='1'
                          WHERE backups.month = 'June'";
          DB::query($updatestmnt);

          include ('auto_exp.php');

        }else if ($curr_month === "September" && $row['status'] == 0) {
          
          $updatestmnt = "UPDATE `pcnhsdb`.`backups`
                          SET `status`='1'
                          WHERE backups.month = 'September'";
          DB::query($updatestmnt);

          include ('auto_exp.php');

        }else if ($curr_month === "December" && $row['status'] == 0) {
          
          $updatestmnt = "UPDATE `pcnhsdb`.`backups`
                          SET `status`='1'
                          WHERE backups.month = 'December'";
          DB::query($updatestmnt);

          include ('auto_exp.php');

        }else if ($curr_month === "March" && $row['status'] == 0) {
          
          $updatestmnt = "UPDATE `pcnhsdb`.`backups`
                          SET `status`='0'";
          DB::query($updatestmnt);
        
                     include ('auto_exp.php');
        } 
        else{
          
          if ($account_type == "registrar") {
            header("Location: ../../../registrar/index.php");
          }else if ($account_type == "systemadmin"){
            header("Location: ../../index.php");
          
          } 
        }
    }
} else{

    if ($account_type == "registrar") {
      header("Location: ../../../registrar/index.php");
    }else if ($account_type == "systemadmin"){
      header("Location: ../../index.php");
          
    } 
}

?>