<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 02/07/2015
 * @Modified    : 02/07/2015
 * @Description : This is the feature API
********************************************************/        
    
    include("../prependAPI.php");        
    include("../functions/featureOperations.php"); 
    include("./class/Feature.php");        
    
    
    
    try{
    
        // --- Default Content-type ---
        $param_op           = isset($_GET['op']) ? mysql_real_escape_string($_GET['op']) : null;       
        $result             = Result::$SUCCESS_EMPTY;
        $resultError        = "";

        // --- Content-type :: application/json ---
        $jsondata           = json_decode(file_get_contents('php://input'), true);


        if($param_op)
        {
            if(strcmp(strtolower($param_op),"list")==0){  
                $result = Result::$SUCCESS->setContent(getFeatures($obj) );
            }
        }   

        // --- removing null values ---
        $result = Result::object_unset_nulls($result);

        // --- return result ---
        echo json_encode($result, JSON_HEX_QUOT|JSON_HEX_TAG);   
       
    } catch (Exception $ex) {        
        echo json_encode(Result::$FAILURE_EXCEPTION->setContent("API->feature exception"));
    }
    
        //----- CONNECTION CLOSE -----//
        mysql_close();
        
?>
