<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 14/06/2015
 * @Modified    : 02/07/2015
 * @Description : This is the category API
********************************************************/    
   
    include_once("../prepend.php");          
    include("../functions/authOperations.php");     
    
    error_reporting(E_ALL);
    
    
    $param_op           = isset($_GET['op']) ? $_GET['op'] : null;
    $param_name         = isset($_GET['name']) ? $_GET['name'] : null;
    $param_pass         = isset($_GET['pass']) ? $_GET['pass'] : null;
    $result             = Result::$SUCCESS_EMPTY;
    $resultError        = "";
    
    // --- Content-type :: application/json ---
    $jsondata           = json_decode(file_get_contents('php://input'), true);
               
    
    if($param_op){                
     
        if(strcmp(strtolower($param_op),"login")==0){
            
            if($jsondata){
                
                $result = authLoginJson($jsondata);
                
            }else{                
                
                $resultError = "Username OR Userpass parameter mismatch";
                $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);                
            }
                        
        }else if(strcmp(strtolower($param_op),"comment")==0){
                        
            // --GUPPY COMMENT IMPORTANT-- 
            // session will be created here                       
            $result = commentAdd($jsondata);                        
            
        }else{
            $resultError = "Login API - Operation parameter mismatch";
            $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
        }
        
    }       
        
    echo json_encode($result);
    
?>
