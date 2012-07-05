<?php
// define environments
define('DB_DEV', "db_dev");
define('DB_TEST', "db_test");

$site_name = "ginphp.codegin.com";

$env = "";

if (SERVER_NAME == "dev." . $site_name) $env = DB_DEV;
if (SERVER_NAME == "test." . $site_name) $env = DB_TEST;

// override from CLI
if ($cli_database != "") {
    $env = $cli_database;
}

$db_type = "mysql";
$db_server = "localhost";
$db_login = "root";
$db_password = "password";
$db_name = "ginphp";

if ($env == DB_DEV) {
    $db_login = "root";
    $db_password = "password";
    $db_name = "ginphp";
} else if ($env == DB_TEST) {
    $db_login = "root";
    $db_password = "password";
    $db_name = "test";
} else {
    $db_login = "production-login";
    $db_password = "prodction-password";
    $db_name = "production-db";
}
