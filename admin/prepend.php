<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * @Modified    : 
 * @Description : This file use include all required files in project.
********************************************************/

//----- SETUP TIMEZONE -----//
date_default_timezone_set("Europe/Berlin");

//----- INCLUDE CONNECTION FILE -----//
require_once("../includes/connection.inc.php");

//----- INCLUDE SITE CONSTANT FILE -----//
require_once("../includes/site_constants.php");

//----- INCLUDE ADMIN FUNCTION FILE -----//
require_once("include/function.php");

//----- INCLUDE RESIZE CLASS -----//
require_once("../includes/image_resize.php");

//----- INCLUDE DB CLASS FILE -----//
require_once("../includes/db.php");
?>
