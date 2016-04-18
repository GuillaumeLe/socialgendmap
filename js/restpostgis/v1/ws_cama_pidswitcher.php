<?php
/**
 * CAMA Pid Switcher
 * Switch a common pid for a tax pid and vice versa.
 * 
 * @param 		string 		$pid 			Parcel ID
 * @param 		string		$pidtype		Parcel ID type being sent, tax or common
 * @param 		string		$format			format of output, either json or xml
 * @return 		string						resulting json or xml string
 */


# Includes
require_once("../../inc/error.inc.php");
require_once("../../inc/database.inc.php");
require_once("../../inc/security.inc.php");

# Set arguments for error email 
$err_user_name = "Tobin";
$err_email = "tobin.bradley@mecklenburgcountync.gov";

# Retrive URL arguments
try {
	$pid = $_REQUEST['pid'];
	$pidtype = $_REQUEST['pidtype'];
	$format = $_REQUEST['format'];
} 
catch (Exception $e) {
    trigger_error("Caught Exception: " . $e->getMessage(), E_USER_ERROR);
}

# Performs the query and returns XML or JSON
try {
	$sql = "select id_pid as parcel_id, id_common_pid as common_parcel_id from dbo.tb_PubOwner";
	if ($pidtype == "tax") { $sql .= " where id_pid = ?"; }
	elseif ($pidtype == "common") { $sql .= " where id_common_pid = ?"; }
	else { trigger_error("Caught Exception: pidtype must be either tax or cama", E_USER_ERROR); }
	$sql = sanitizeSQL($sql);
	$camaconn = camaConnection();

    /*** fetch into an PDOStatement object ***/
    $recordSet = $camaconn->prepare($sql);
    $recordSet->bindParam(1, $pid);
    $recordSet->execute();

	if ($format == 'xml') {
		require_once("../../inc/xml.pdo.inc.php");
		header("Content-Type: text/xml");
		echo rs2xml($recordSet);
	}
	elseif ($format == 'json') {
		require_once("../../inc/json.pdo.inc.php");
		header("Content-Type: application/json");
		echo rs2json($recordSet);
	}
	else {
		trigger_error("Caught Exception: format must be xml or json.", E_USER_ERROR);
	}
}
catch (Exception $e) {
	trigger_error("Caught Exception: " . $e->getMessage(), E_USER_ERROR);
}

?>