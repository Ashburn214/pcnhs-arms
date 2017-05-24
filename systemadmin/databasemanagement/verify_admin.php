<?php
    include '../../resources/config.php';
    include '../../resources/classes/Popover.php';
    require_once "../../systemadmin/personnelmanagement/bcrypt/Bcrypt.php";

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
      $username = $_SESSION['username'];
      $password = htmlspecialchars($_POST['password'], ENT_QUOTES);
      $row = DB::queryFirstRow("SELECT * from personnel where uname = %s",$username);
        $verifypw = Bcrypt::checkPassword($password, $row['password']);
        
        if($row['access_type']=="SYSTEM ADMINISTRATOR" && $verifypw == TRUE && $row['accnt_status'] == "ACTIVE" ) {
          $_SESSION['access_db'] = true;
          header("Location: exp_db.php");
        }else {
          $_SESSION['error_pop'] = "Wrong password.";
          die(header("Location: admin_login.php"));
        }

?>
