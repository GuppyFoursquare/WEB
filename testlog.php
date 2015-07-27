l<?php

        

    

//    echo exec('whoami') . "<br>";
//    echo getcwd()."<br><br>";    
//    die;
    
    
    
    //----- INCLUDE RESULT OBJECT -----//
    require_once("api/Result.php");    
    //----- INITIALIZE RESULT OBJECT -----//
    Result::initializeStaticObjects();
    
//    echo dirname( __FILE__ ) ;die;
    
    Result::sendReport("Result ClassSample","bb","cc","dd2");
    echo "testLog finisherd";die;
    

?>
