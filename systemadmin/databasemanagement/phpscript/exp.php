<?php
require_once "../../../resources/config.php";
include ('../../../resources/classes/Popover.php');

session_start();

$host = 'localhost';
$user = DB::$user;
$password = DB::$password;
$database = DB::$dbName;

define('HOST', $host ) ; 
define('USER', $user ) ; 
define('PASSWORD', $password ) ; 
define('DB_NAME', $database ) ;
define('BACKUP_DIR', './myBackups' );

date_default_timezone_set('Asia/Manila');
$fileName = 'PCNHSDB-' . date('H.i.s').'.sql' ; 

if(function_exists('max_execution_time')) {
if( ini_get('max_execution_time') > 0 )   set_time_limit(0) ;
}

if (!file_exists(BACKUP_DIR)) mkdir(BACKUP_DIR , 0700) ;
if (!is_writable(BACKUP_DIR)) chmod(BACKUP_DIR , 0700) ; 

$content = 'Allow from all' ; 
$file = new SplFileObject(BACKUP_DIR . '/.htaccess', "w") ;
$file->fwrite($content) ;
$mysqli = new mysqli(HOST , USER , PASSWORD , DB_NAME) ;
if (mysqli_connect_errno())
{
   printf("Connect failed: %s", mysqli_connect_error());
   exit();
}


$return='';
$return .= "--\n";
$return .= "-- A Mysql Backup System \n";
$return .= "--\n";
$return .= '-- Export created: ' . date("Y/m/d") . ' on ' . date("h:i") . "\n\n\n";
$return = "--\n";
$return .= "-- Database : " . DB_NAME . "\n";
$return .= "--\n";
$return .= "-- --------------------------------------------------\n";
$return .= "-- ---------------------------------------------------\n";
$return .= 'SET AUTOCOMMIT = 0 ;' ."\n" ;
$return .= 'SET FOREIGN_KEY_CHECKS=0 ;' ."\n" ;
$tables = array() ; 

$result = $mysqli->query('SHOW TABLES' ) ; 

while ($row = $result->fetch_row()) 
{
    $tables[] = $row[0] ;
}

foreach($tables as $table)
{ 

    $result = $mysqli->query('SELECT * FROM '. $table) ; 

    $num_fields = $mysqli->field_count  ;

    $return .= "--\n" ;
    $return .= '-- Tabel structure for table `' . $table . '`' . "\n" ;
    $return .= "--\n" ;
    $return.= 'DROP TABLE  IF EXISTS `'.$table.'`;' . "\n" ; 

    $shema = $mysqli->query('SHOW CREATE TABLE '.$table) ;

    $tableshema = $shema->fetch_row() ; 

    $return.= $tableshema[1].";" . "\n\n" ; 

    while($rowdata = $result->fetch_row()) 
    { 
        $return .= 'INSERT INTO `'.$table .'`  VALUES ( '  ;
        for($i=0; $i<$num_fields; $i++)
        {   
        $return .= '"'.$mysqli->real_escape_string($rowdata[$i]) . "\"," ;
        }
        $return = substr("$return", 0, -1) ; 
        $return .= ");" ."\n" ;
    } 
 $return .= "\n\n" ; 
}


$mysqli->close() ;
$return .= 'SET FOREIGN_KEY_CHECKS = 1 ; '  . "\n" ; 
$return .= 'COMMIT ; '  . "\n" ;
$return .= 'SET AUTOCOMMIT = 1 ; ' . "\n"  ; 

$dir = BACKUP_DIR .'/'.$fileName;
$file = file_put_contents($dir, $return) ; 

    //USER LOGS
    date_default_timezone_set('Asia/Manila');
    $act_msg= "GENERATED BACKUP FILE : $fileName";
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
$message = "Generated Backup Succesfully";
$popover = new Popover();
$popover->set_popover($alert_type, $message);

$_SESSION['db_msg_generate'] = $popover->get_popover();


header("location: ../exp_db.php");
 
?>