<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Guppy Org.
 * @Maintainer  : Guppy Org.
 * @Created     : 14/06/2015
 * @Modified    : 16/06/2015
 * @Description : This is the category API
********************************************************/    
   
    include("../prepend.php");        
    include("../functions/authOperations.php");     
    
    error_reporting(E_ALL);
    
    $param_op           = isset($_GET['op']) ? $_GET['op'] : null;
    $param_name         = isset($_GET['name']) ? $_GET['name'] : null;
    $param_pass         = isset($_GET['pass']) ? $_GET['pass'] : null;
    $result             = Result::$SUCCESS_EMPTY;
    $resultError        = "";
    
    if($param_op){
        
        if(strcmp(strtolower($param_op),"login")==0){
            
            if($param_name && $param_pass){
                $result = authLogin( $param_name , $param_pass );
            }else{                
                $resultError = "Username OR Userpass parameter mismatch";
                $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
            }
                        
        }else{
            $resultError = "Operation parameter mismatch";
            $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
        }
        
    }       
    
    echo json_encode($result);
    
?>
