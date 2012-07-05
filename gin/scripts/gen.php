<?php
require 'build.class.php';
include '../helpers/utils.inc.php';
include '../lib/adodb5/adodb.inc.php';

// set to dev database
$cli_database = "db_dev";
include '../config/database.inc.php';

$gen_option = $argv[1];
$gen_option2 = "";
if (isset($argv[2])) $gen_option2 = $argv[2];


if ($gen_option == "") {
	die("must supply a gen option: models, controllers, views, all");
} else {
	echo "generating $gen_option...";
}

$conn=&ADONewConnection("mysql");
$conn->Connect($db_server,$db_login,$db_password,$db_name);
$table_array = buildTableArray($db_name);

$build = new build($table_array);
if (method_exists($build,$gen_option)) {
    if ($gen_option2 != ""){
        $build->$gen_option($gen_option2);
    } else {
        $build->$gen_option();
    }
} else {
    die("Build Option [".$gen_option."] does not exist.");
}

echo "done building\n";

function buildTableArray($dbname) {
	global $conn;
	$sql = "SHOW TABLES from $dbname";
	$rs = $conn->Execute($sql);
	$tables = array();
	while (!$rs->EOF) {
		$table = $rs->fields[0];
		$sql2 = "show columns from $table";
		$rs2 = $conn->Execute($sql2);
		$fields = array();
		while (!$rs2->EOF) {
			//$fdata = array();
			$fields[$rs2->fields[0]] = array('type'=>$rs2->fields[1],'null'=>$rs2->fields[2]);
			//array_push($fields, $fdata);
			$rs2->MoveNext();
		}
		$tables[$table] = $fields; // push each set of fields into an index by table name
		$rs->MoveNext();
	}
	return $tables;
}
?>