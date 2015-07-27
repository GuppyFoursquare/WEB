<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Guppy Org.
 * @Maintainer  : Guppy Org.
 * @Created     : 13 jun 2015
 * @Modified    : 
 * @Description : This is the router page for API calls
********************************************************/    

    //----- INCLUDE RESULT OBJECT -----//
    require_once("Result.php");    
    //----- INITIALIZE RESULT OBJECT -----//
    Result::initializeStaticObjects();
    
//    echo dirname( __FILE__ ) ;die;
    
    Result::sendReport("API ROUTER","bb","cc","dd2");
    echo "testLog finisherd";die;

?>
