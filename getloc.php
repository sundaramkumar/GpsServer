<?
putenv("TZ=Asia/Calcutta");
error_reporting(E_ERROR);
define('DB_TYPE', 'mysql');
define('USERNAME', 'root');
define('PASSWORD', 'secRet123');
define('HOSTNAME', 'localhost');
define('DATABASE', 'test');

$conn = mysql_connect(HOSTNAME,USERNAME,PASSWORD);
if(!$conn)
    die('Could not connect: ' . mysql_error());

$db_selected = mysql_select_db(DATABASE,$conn);
if (!$db_selected)
    die ('Cannot use Customers Database : ' . mysql_error());

// array for JSON response
$response = array();

if($_POST){
	$lat = $_POST['LAT'];
	$long = $_POST['LONG'];
	file_put_contents("test.txt", $lat."-".$long."-".date("Y-m-d H:i:s")."\r\n", FILE_APPEND);
	
	$iqry = "INSERT INTO gpsdata(lat,lon,posdatetime) VALUES('".$lat."','".$long."','".date("Y-m-d H:i:s")."')";
			$iRes = mysql_query($iqry);
			
	if ($iRes) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Successfully inserted.";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
 
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>