<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Guppy Org.
 * @Maintainer  : Guppy Org.
 * @Created     : 14/06/2015
 * @Modified    : 
 * @Description : This is the category API
********************************************************/    
   
    include("../prepend.php");    
    include("../ajax.places.php"); 
    include("../getLocationsFunction.php"); 
    //include("./class/PlaceClass.php");
    
    error_reporting(E_ALL);
    
    $param_op           = isset($_GET['op']) ? $_GET['op'] : null; 
    $param_latitude     = isset($_GET['lat']) ? $_GET['lat'] : null; 
    $param_longitude    = isset($_GET['lon']) ? $_GET['lon'] : null; 
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
            
        }else{
            $resultError = "Operation parameter mismatch";
            $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);;
        }
        
    }else{
               
        $searchText = '';
        $exactsearch = 0;
        $categories = '';
        $features = '';
        $page = 0; 
        $allRec = 0;
        //$fetchPlaces = fetchPlaces($obj,$searchText,$exactsearch,$categories,$features);
        //$fetchPlaces = utf8ize($fetchPlaces);  
        
        
        $limit = 6;    
        $tblName = " yb_places plc 
                 LEFT JOIN yb_place_gallery gal ON (plc.plc_id = gal.plc_id AND plc_is_cover_image = 1) 
                 JOIN yb_places_category plc_cat ON (plc.plc_id = plc_cat.plc_id) 
                 LEFT JOIN yb_places_features plc_fet ON (plc.plc_id = plc_fet.plc_id) 
                 LEFT JOIN yb_category subCat ON (plc_cat.plc_sub_cat_id = subCat.cat_id) 
                 LEFT JOIN yb_category pCat ON (subCat.cat_parent_id = pCat.cat_id) 
                 LEFT JOIN yb_features f ON (plc_fet.feature_id = f.feature_id) 
                ";    
        if(isset($_SESSION['is_most_popular']))
        {
            if($_SESSION['is_most_popular'] == 1)
                $tblName = $tblName." JOIN yb_places_rating plc_r ON (plc_r.plc_id = plc.plc_id) ";
        }

        $disCol = " plc.plc_id,f.feature_id,f.feature_title,subCat.cat_parent_id,pCat.cat_name as pcat_name,plc.plc_name,plc.plc_header_image,plc_gallery_media,plc.plc_email,plc.plc_contact,plc.plc_website,plc.plc_country_id,plc.plc_state_id,plc.plc_city,plc.plc_address,plc.plc_zip,plc.plc_latitude,plc.plc_longitude,plc.plc_menu,plc.plc_info_title,plc.plc_info,plc.plc_is_active,plc.plc_is_delete ";

        if(isset($_SESSION['is_most_popular']))
        {
            if($_SESSION['is_most_popular'] == 1) 
            $disCol = " AVG(plc_r.place_rating_rating) as avg_rate,plc.plc_id,f.feature_id,f.feature_title,subCat.cat_parent_id,pCat.cat_name as pcat_name,plc.plc_name,plc.plc_header_image,plc_gallery_media,plc.plc_email,plc.plc_contact,plc.plc_website,plc.plc_country_id,plc.plc_state_id,plc.plc_city,plc.plc_address,plc.plc_zip,plc.plc_latitude,plc.plc_longitude,plc.plc_menu,plc.plc_info_title,plc.plc_info,plc.plc_is_active,plc.plc_is_delete ";

        }
        $where = " plc.plc_is_active  = 1 AND plc.plc_is_delete = 0 ";
        $order_col = '';
        $order_by = '';
        if(isset($_SESSION['is_most_popular']))
        {
            if($_SESSION['is_most_popular'] == 1) {
                $order_col = 'avg_rate';
             $order_by = ' DESC';
            }


        }
                        
        $where .= " AND plc.plc_id = 1";

        $plcArr = $obj->selectQuery($tblName, $disCol, $where, $order_col, $order_by , $group_by='', $disQuery = '');            
        
        $fetchPlaces = utf8ize($plcArr);  

        $result = Result::$SUCCESS->setContent($fetchPlaces);        
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
