<?php

        

    

//    echo exec('whoami') . "<br>";
//    echo getcwd()."<br><br>";    
//    die;
    
    
    
    //----- INCLUDE RESULT OBJECT -----//
    require_once("api/Result.php");    
    //----- INITIALIZE RESULT OBJECT -----//
    Result::initializeStaticObjects();
    

    
    
    Result::sendReport("Result ClassSample","bb","cc","dd");
    echo "testLog finisherd";die;
    

?>
