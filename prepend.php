<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * 
 * @Modified    : Guppy Org.
 * @Programmer  : Kemal Sami KARACA
 * @ModifiedDate: 04/07/2015 
 * @Description : This file use include all required files in project.
********************************************************/

    //sleep(1);

    error_reporting(E_ALL);
    
    //----- SETUP TIMEZONE -----//
    date_default_timezone_set("Europe/Berlin");

    //----- INCLUDE CONNECTION FILE -----//
    require_once("includes/connection.inc.php");
    require_once("includes/db.php");
    require_once("api/Result.php");
    $obj = new db();

    //----- INCLUDE RESULT OBJECT -----//
    Result::initializeStaticObjects();

    //----- INCLUDE SITE CONSTANT FILE -----//
    require_once("includes/site_constants.php");

    //----- INCLUDE ADMIN FUNCTION FILE -----//
    require_once("admin/include/function.php");
    require_once("includes/image_resize.php");
    
    //----- GET API KEY FOR API CALL -----//
    $apikey = isset($_GET['apikey']) ? $_GET['apikey'] : null;
    if($apikey){
        session_id($apikey);
    }           
        
    @session_start();
?>
