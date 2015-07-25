<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Kemal Sami KARACA
 * @Created     : 23/07/2015 
 * 
 * @Modified    : Guppy Org.
 * @Programmer  : Kemal Sami KARACA
 * @ModifiedDate: 23/07/2015 
 * @Description : This file use include all required files for API
********************************************************/    

    error_reporting(E_ALL);
    
    //----- SETUP TIMEZONE -----//
    date_default_timezone_set("Europe/Berlin");


    //----- INCLUDE RESULT OBJECT -----//
    require_once("api/Result.php");    
    //----- INITIALIZE RESULT OBJECT -----//
    Result::initializeStaticObjects();    
    
    //----- GET API KEY FOR API CALL -----//
    $token = isset($_GET['token']) ? $_GET['token'] : null;
    if($token){
        session_id($token);
    }           
        
    @session_start();        
    
    
    //----- APIKEY ISSUE -----//
    // check apikey exist
    // check session apikey and request apikey equal
    // IF NOT destroy SESSION    
    $req_apikey = isset($_GET['apikey']) ? $_GET['apikey'] : null;    
    $ses_apikey = isset($_SESSION['apikey']) ? $_SESSION['apikey'] : null ;
    if(!$req_apikey || !$ses_apikey || strcmp($req_apikey,$ses_apikey)!=0){        
        
        echo json_encode(Result::$FAILURE_PERMISSION->setContent("API key permission denied"));
        // secure close connections will be added
        die;        
    }
        
    //----- INCLUDE CONNECTION FILE -----//
    require_once("includes/connection.inc.php");
    require_once("includes/db.php");
    $obj = new db();
?>
