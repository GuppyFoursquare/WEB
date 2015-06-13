<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : This is connection file for ajax data grid
********************************************************/
/*

/*
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
#connect to the server and database starts here
//----- DATABASE HOST -----//
define('DB_HOST', "192.168.43.32");

//----- DATABASE NAME -----//
define('DB_DATABASE', "youbaku");

//----- DATABASE USERNAME -----//
define('DB_USERNAME', "ex_user");

//----- DATABASE PASSWORD -----//
define('DB_PASSWORD', "youbaku");

mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die("Error: Could not connect to the server.");
mysql_select_db(DB_DATABASE) or die("Error: Could not select database");
*/
@session_start();
require_once '../../includes/connection.inc.php';
?>