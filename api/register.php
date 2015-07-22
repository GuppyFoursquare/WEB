<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 22/07/2015
 * @Modified    : xx/xx/2015
 * @Description : Mobile devices HAVE TO take apikey to use API
 *                  
********************************************************/    
   

    error_reporting(E_ALL);
    
    //----- SETUP TIMEZONE -----//
    date_default_timezone_set("Europe/Berlin");
    
    require_once("./Result.php");
    
    //----- INCLUDE RESULT OBJECT -----//
    Result::initializeStaticObjects();    

    
    //----- INITIALIZATION -----//
    $result             = Result::$SUCCESS_EMPTY;
    $resultError        = "";            
               
    
    //----- START SESSION FOR INCOMING REQUEST -----//
    @session_start();
    
    
    //-----  -----//
    $apikey = md5(uniqid("guppy_project" , true));
    $_SESSION['apikey'] = $apikey; 
    $res = array(
        "token" => session_id(), 
        "apikey" => $_SESSION['apikey']
        );
    
    
    $result = Result::$SUCCESS->setContent($res);
    
    echo json_encode($result);
    
?>
