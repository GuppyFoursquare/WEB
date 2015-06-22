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
    
    $param_op           = isset($_GET['op']) ? mysql_real_escape_string($_GET['op']) : null; 
    $param_latitude     = isset($_GET['lat']) ? mysql_real_escape_string($_GET['lat']) : null; 
    $param_longitude    = isset($_GET['lon']) ? mysql_real_escape_string($_GET['lon']) : null;     
    $param_subcategoryid= isset($_GET['scat_id']) ? mysql_real_escape_string($_GET['scat_id']) : null;
    $param_plc_id       = isset($_GET['plc_id']) ? mysql_real_escape_string($_GET['plc_id']) : null; 
    $param_src_key      = isset($_GET['src_key']) ? mysql_real_escape_string($_GET['src_key']) : ''; 
    $param_src_ekey     = isset($_GET['src_ekey']) ? mysql_real_escape_string($_GET['src_ekey']) : 0; 
    $param_src_cat      = isset($_GET['src_cat']) ? mysql_real_escape_string($_GET['src_cat']) : null;
    $param_src_fea      = isset($_GET['src_fea']) ? mysql_real_escape_string($_GET['src_fea']) : null;
    $param_src_pg       = isset($_GET['src_pg']) ?  mysql_real_escape_string($_GET['src_pg']) : 0;    
    $result             = Result::$SUCCESS_EMPTY;
    $resultError        = "";
    
    if($param_op)
    {        
        if(strcmp(strtolower($param_op),"nearme")==0){  
            if($param_latitude && $param_longitude){                                
                $result = Result::$SUCCESS->setContent(getPlacesFromLocation($obj, $param_latitude , $param_longitude , $param_subcategoryid));
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
            
        }else if(strcmp(strtolower($param_op),"search")==0){
            
            //fetchPlaces($obj,$searchText = '',$exactSearch = 0,$categories = '',$features = '',$page = 0,$allRec = 0){    
            $fetchPlaces = fetchPlaces($obj, $param_src_key, $param_src_ekey, $param_src_cat, $param_src_fea, $param_src_pg );
            $result = Result::$SUCCESS->setContent($fetchPlaces); 
            
        }else{
            $resultError = "Operation parameter mismatch";
            $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
        }
        
    }       
    
    echo json_encode($result);
    
?>
