<?php
    include 'config.php';
    include 'classes/Popover.php';
    require_once "../systemadmin/personnelmanagement/bcrypt/Bcrypt.php";

    session_start();

    // if(!$conn) {
    //   $popover = new Popover();
    //   $popover->set_popover("danger", "Cannot connect to the database. Please set the proper configuration settings.");
    //   $_SESSION['error_pop'] = $popover->get_popover();
    //   die(header("Location: ../login.php"));
    // }
    date_default_timezone_set('Asia/Manila');
    $_SESSION['sDate'] = date("Y-m-d");
    $_SESSION['liTime'] = date("h:i:sa");

        $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
        $password = htmlspecialchars($_POST['password'], ENT_QUOTES);
        $row = DB::queryFirstRow("SELECT * from personnel where uname = %s",$username);
        if(is_null($row)) {
          $popover = new Popover();
          $popover->set_popover("danger", "Please check your Username or Password.");
          $_SESSION['error_pop'] = $popover->get_popover();
          die(header("Location: ../login.php"));
        }
        $verifypw = Bcrypt::checkPassword($password, $row['password']);
        if($row['access_type']=="SYSTEM ADMINISTRATOR" && $verifypw == TRUE && $row['accnt_status'] == "ACTIVE" ) {
          $_SESSION['username'] = $row['username'];
          $_SESSION['first_name'] = $row['first_name'];
          $_SESSION['last_name'] = $row['last_name'];
          $_SESSION['per_id'] = $row['per_id'];
          $_SESSION['account_type'] = "systemadmin";
          $_SESSION['logged_in'] = "true";
          $_SESSION['accnt_status'] = "ACTIVE";
          $_SESSION['username'] = $username;
          $_SESSION['accnt_type'] = "SYSTEM ADMINISTRATOR";
          $log_id = null;
          $_SESSION['log_id'] = $log_id;


          header("Location: ../systemadmin/databasemanagement/phpscript/auto_backup.php");

        }else if($row['access_type']=="REGISTRAR" && $verifypw == TRUE && $row['accnt_status'] == "ACTIVE" ) {
          $_SESSION['username'] = $row['username'];
          $_SESSION['first_name'] = $row['first_name'];
          $_SESSION['last_name'] = $row['last_name'];
          $_SESSION['per_id'] = $row['per_id'];
          $_SESSION['account_type'] = "registrar";
          $_SESSION['logged_in'] = "true";
          $_SESSION['accnt_status'] = "ACTIVE";
          $_SESSION['username'] = $username;
          $_SESSION['accnt_type'] = "REGISTRAR";
          $log_id = null;
          $_SESSION['log_id'] = $log_id;


          header("Location: ../systemadmin/databasemanagement/phpscript/auto_backup.php");

        }else {
          $popover = new Popover();
          $popover->set_popover("danger", "You have entered an Invalid Username or Password.");
          $_SESSION['error_pop'] = $popover->get_popover();
          die(header("Location: ../login.php"));
        }

?>
