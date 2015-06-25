<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 14/06/2015
 * @Modified    : 25/06/2015
 * @Description : This is the place API
********************************************************/    
   
    include("../prepend.php");        
    include("../functions/placeOperations.php"); 
    //include("./class/PlaceClass.php");
    
    error_reporting(E_ALL);
        
    // --- Default Content-type ---
    $param_op           = isset($_GET['op']) ? mysql_real_escape_string($_GET['op']) : null; 
    $param_latitude     = isset($_GET['lat']) ? mysql_real_escape_string($_GET['lat']) : null; 
    $param_longitude    = isset($_GET['lon']) ? mysql_real_escape_string($_GET['lon']) : null;     
    $param_subcategoryid= isset($_GET['scat_id']) ? mysql_real_escape_string($_GET['scat_id']) : null;
    $param_plc_id       = isset($_GET['plc_id']) ? mysql_real_escape_string($_GET['plc_id']) : null; 
    $param_src_key      = isset($_GET['src_key']) ? mysql_real_escape_string($_GET['src_key']) : ''; 
    $param_src_ekey     = isset($_GET['src_ekey']) ? mysql_real_escape_string($_GET['src_ekey']) : 0;           // ekey --> exact serch 
    $param_src_cat      = isset($_GET['src_cat']) ? $_GET['src_cat'] : null;                                    // --GUPPY COMMENT IMPORTANT-- Burada "mysql_real_escape_string" kullanılacaktır
    $param_src_fea      = isset($_GET['src_fea']) ? $_GET['src_fea'] : null;
    $param_src_pg       = isset($_GET['src_pg']) ?  $_GET['src_pg'] : 0;    
    $result             = Result::$SUCCESS_EMPTY;
    $resultError        = "";
      
    // --- Content-type :: application/json ---
    $jsondata           = json_decode(file_get_contents('php://input'), true);
    
    
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
            
            // --- FILTERING ---
            // --- If json data does not exist then FETCH ALL places
            if($jsondata){                
                
                $json_subcategory_list = array_key_exists('subcat_list',$jsondata) ? $jsondata['subcat_list'] : null;
                $json_keyword = array_key_exists('keyword',$jsondata) ? $jsondata['keyword'] : null;
                
                if($json_subcategory_list || $json_keyword){
                    $fetchPlaces = fetchPlaces($obj, $json_keyword, $param_src_ekey, $json_subcategory_list, $param_src_fea, $param_src_pg );
                    $result = Result::$SUCCESS->setContent($fetchPlaces);
                    
                }else{
                    $resultError = "Search Operation parameter mismatch";
                    $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
                }
                
            }else{
                $fetchPlaces = fetchPlaces($obj, $param_src_key, $param_src_ekey, $param_src_cat, $param_src_fea, $param_src_pg );
                $result = Result::$SUCCESS->setContent($fetchPlaces); 
            }
        }else{
            $resultError = "Operation parameter mismatch";
            $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
        }
        
    }                  
    
    // --- removing null values ---
    $result = Result::object_unset_nulls($result);
    
    // --- return result ---
    echo json_encode($result, JSON_HEX_QUOT|JSON_HEX_TAG);    
    
    
?>
