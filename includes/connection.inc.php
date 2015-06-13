<?php
/******************** PAGE DETAILS *********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * @Modified    : 
 * @Description : This file use for database connection. 
********************************************************/
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

#connect to the server and database starts here
//----- DATABASE HOST -----//
define('DB_HOST', "127.0.0.3");

//----- DATABASE NAME -----//
define('DB_DATABASE', "db454503");

//----- DATABASE USERNAME -----//
define('DB_USERNAME', "db454503");

//----- DATABASE PASSWORD -----//
define('DB_PASSWORD', "TkEeMQ7v");


//mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die("Error: Could not connect to the server.");
mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_DATABASE) or die("Error: Could not select database");

//----- DATABASE TABLE PREFIX -----//
$prefix = "yb_";

//----- PROJECT SALT(Use if needed) -----//
$salt = "YouBaku";

?>
