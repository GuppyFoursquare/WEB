<?php
/******************** PAGE DETAILS *********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * @Modified    : Kemal Sami KARACA
 * @Date        : 25/06/2015
 * @Description : This file use for database connection. 
********************************************************/
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

#connect to the server and database starts here
//----- DATABASE HOST -----//
//define('DB_HOST', "127.0.0.3");
define('DB_HOST', "localhost");
//define('DB_HOST', "localhost");

//----- DATABASE NAME -----//
//define('DB_DATABASE', "db454503");
define('DB_DATABASE', "youbaku");
//define('DB_DATABASE', "beratald_youbaku");

//----- DATABASE USERNAME -----//
//define('DB_USERNAME', "db454503");
define('DB_USERNAME', "root");
//define('DB_USERNAME', "beratald_youbaku");

//----- DATABASE PASSWORD -----//
//define('DB_PASSWORD', "TkEeMQ7v");
define('DB_PASSWORD', "");
//define('DB_PASSWORD', "Kemal1234");


//mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die("Error: Could not connect to the server.");
$conn = @mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_DATABASE) or die("Error: Could not select database");

//Set mysql to fetch utf-8 characters
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);

//----- DATABASE TABLE PREFIX -----//
$prefix = "yb_";

//----- PROJECT SALT(Use if needed) -----//
$salt = "YouBaku";

?>
