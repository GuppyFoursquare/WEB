<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Guppy Org.
 * @Maintainer  : Guppy Org.
 * @Created     : 14/06/2015
 * @Modified    : 16/06/2015
 * @Description : This is the category API
********************************************************/    
   
    include("../prepend.php");        
    include("../functions/placeOperations.php"); 
    //include("./class/PlaceClass.php");
    
    error_reporting(E_ALL);
    
    $param_op           = isset($_GET['op']) ? $_GET['op'] : null; 
    $param_latitude     = isset($_GET['lat']) ? $_GET['lat'] : null; 
    $param_longitude    = isset($_GET['lon']) ? $_GET['lon'] : null; 
    $param_plc_id       = isset($_GET['plc_id']) ? $_GET['plc_id'] : null; 
    $result             = Result::$SUCCESS_EMPTY;
    $resultError        = "";
    
    if($param_op)
    {        
        if(strcmp(strtolower($param_op),"nearme")==0){  
            if($param_latitude && $param_longitude){
                $result = Result::$SUCCESS->setContent(getPlacesFromLocation($obj, $param_latitude , $param_longitude));
            }else{                
                $resultError = "Latitude OR Longitude parameter mismatch";
                $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
            }
                        
        }else if(strcmp(strtolower($param_op),"info")==0){
            
            if($param_plc_id){               
                
                $fetchPlace = getPlaceFromID($obj,$param_plc_id);
                $result = Result::$SUCCESS->setContent($fetchPlace); 
                
            }else{
                $resultError = "Place id parameter mismatch";
                $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);  
            }
            
        }else{
            $resultError = "Operation parameter mismatch";
            $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
        }
        
    }       
    
    echo json_encode($result);
    
    /************************************************************
     *********************** FUNCTIONS **************************
     ************************************************************/
    
    /**    
     * @author GUPPY Org. <kskaraca@gmail.com>
     * @param type $d array object
     * @return type
     * @version 1.0 
     * 
     * This function is used for encoding objects to JSON
     * properly.
     */
    function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }
    
?>
