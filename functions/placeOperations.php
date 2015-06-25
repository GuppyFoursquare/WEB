<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 16/06/2015
 * @Modified    : 
 * @Description : This is the general functions for PLACEs
********************************************************/
                

        /**
         * 
         * @param type $latitude
         * @param type $longitude
         * @return string
         */
        function getPlacesQuery($latitude , $longitude){
            
                                   
                $strSqlSearch = "SELECT "
                        . "*,"
                        . "( 3959 * acos( cos( radians(".$latitude.") ) * cos( radians( plc_latitude ) ) * cos( radians( plc_longitude ) - radians(".$longitude.") ) + sin( radians(".$latitude.") ) * sin( radians( plc_latitude ) ) ) ) AS distance 
                    FROM yb_places plc   
                    LEFT JOIN yb_countrymst c ON plc.plc_country_id = c.country_id 
                    LEFT JOIN yb_statemst s ON plc.plc_state_id = s.state_id
                    WHERE plc.plc_is_delete = 0 AND plc.plc_is_active = 1 
                    HAVING distance < 50
                    ORDER BY distance ";
                
                return $strSqlSearch;
        }               
                          
        
        /**
         * 
         * @param type $latitude
         * @param type $longitude
         * @return array
         * 
         */
        function getPlacesFromLocation($obj,$latitude,$longitude,$subcatid){
                include '../api/class/PlaceClass.php';
                
//                    $strSqlSearch = "SELECT "
//                            . "*,"
//                            . "( 3959 * acos( cos( radians(".$latitude.") ) * cos( radians( plc_latitude ) ) * cos( radians( plc_longitude ) - radians(".$longitude.") ) + sin( radians(".$latitude.") ) * sin( radians( plc_latitude ) ) ) ) AS distance 
//                        FROM yb_places plc   
//                        LEFT JOIN yb_places_category cat ON plc.plc_id = cat.plc_id 
//                        LEFT JOIN yb_countrymst c ON plc.plc_country_id = c.country_id 
//                        LEFT JOIN yb_statemst s ON plc.plc_state_id = s.state_id 
//                        LEFT JOIN yb_places_rating r ON plc.plc_id = r.plc_id AND r.places_rating_is_active = 1
//                        WHERE plc.plc_is_delete = 0 AND plc.plc_is_active = 1 AND cat.plc_sub_cat_id = " .$subcatid. "  
//                        HAVING distance < 50
//                        ORDER BY distance "; 
                
                
                
//                $strSqlSearch = "SELECT "
//                        . "*,plc.plc_id AS plc_id,"
//                        . "( 3959 * acos( cos( radians(".$latitude.") ) * cos( radians( plc_latitude ) ) * cos( radians( plc_longitude ) - radians(".$longitude.") ) + sin( radians(".$latitude.") ) * sin( radians( plc_latitude ) ) ) ) AS distance 
//                    FROM yb_places plc                            
//                    LEFT JOIN yb_countrymst c ON plc.plc_country_id = c.country_id 
//                    LEFT JOIN yb_statemst s ON plc.plc_state_id = s.state_id 
//                    LEFT JOIN yb_places_rating r ON plc.plc_id = r.plc_id AND r.places_rating_is_active = 1
//                    WHERE plc.plc_is_delete = 0 AND plc.plc_is_active = 1   
//                    HAVING distance < 50
//                    ORDER BY distance "; 
                                
                
                $tblName = " yb_places plc                            
                    LEFT JOIN yb_countrymst c ON plc.plc_country_id = c.country_id 
                    LEFT JOIN yb_statemst s ON plc.plc_state_id = s.state_id 
                    LEFT JOIN yb_places_rating r ON plc.plc_id = r.plc_id AND r.places_rating_is_active = 1 ";
                
                $disCol = " *,plc.plc_id AS plc_id,  ( 3959 * acos( cos( radians(".$latitude.") ) * cos( radians( plc_latitude ) ) * cos( radians( plc_longitude ) - radians(".$longitude.") ) + sin( radians(".$latitude.") ) * sin( radians( plc_latitude ) ) ) ) AS distance ";
                $where = " plc.plc_is_delete = 0 AND plc.plc_is_active = 1 ";
                $having = " distance < 50 ";
                $order_col = " distance ";
                $order_by = '';
                $group_by = '';

                $qry = "SELECT " . $disCol . " FROM " . $tblName;

                if ($where != '')
                    $qry .= " WHERE " . $where;

                if ($having != '')
                    $qry .= " HAVING " . $having;

                if ($order_col != '')
                    $qry .= " ORDER BY " . $order_col;

                if ($order_by != '')
                    $qry .= $order_by;

                if ($group_by != '')
                    $qry .= ' GROUP BY ' . $group_by;

                //for display query
                if (!empty($disQuery)) {
                    echo $qry;
                    die;
                }                                          
                                                
                $memLocation = array();
                $memResult = $obj->executeSql($qry);
                if($memResult){
                    while($memResultData = mysql_fetch_object($memResult, 'Place')){
                        
                        //--- Create & Fetch to Place object
                        $place = new Place();
                        $place->setPlaceObjectCoreVariables($memResultData);
                        
                        //--- Comments are fetched ----
                        $place->rating = getPlacesRating($obj,$place->plc_id);
                        
                        //--- Returns average rating of place ---
                        $strSqlAverageRating = "SELECT AVG(r.place_rating_rating) AS rating_avg FROM yb_places plc                                           
                            LEFT JOIN yb_places_rating r ON plc.plc_id = r.plc_id AND r.places_rating_is_active = 1                             
                            WHERE plc.plc_is_delete = 0 AND plc.plc_is_active = 1 AND plc.plc_id = " .$place->plc_id 
                            . " GROUP BY r.place_rating_rating" ;                                
                        $memAvgResult = $obj->executeSql($strSqlAverageRating);
                        if($memAvgResult){
                            $place->plc_avg_rating = mysql_fetch_array($memAvgResult)['rating_avg'];
                        }                                                
                        
                        array_push($memLocation,$place);
                    }
                }                
                                
                return $memLocation; 
        }
                        
        
        /**
         * 
         * @param type $obj
         * @param type $place_id
         * @return array
         */
        function getPlacesRating($obj, $place_id){            
                include_once '../api/class/PlacesRating.php';                            
                
                $strSqlSearch = "SELECT * FROM yb_places plc                                           
                    LEFT JOIN yb_places_rating r ON plc.plc_id = r.plc_id AND r.places_rating_is_active = 1
                    WHERE plc.plc_is_delete = 0 AND plc.plc_is_active = 1 AND plc.plc_id = " .$place_id ;                                
                
                $memLocation = array();
                $memResult = $obj->executeSql($strSqlSearch);
                if($memResult){
                    while($memResultData = mysql_fetch_assoc($memResult )){                        
                        $placeRating = new PlaceRating();                                                    
                        $placeRating->place_rating_id = $memResultData['place_rating_id'];
                        $placeRating->place_rating_rating = $memResultData['place_rating_rating'];
                        $placeRating->place_rating_comment = $memResultData['place_rating_comment'];
                        $placeRating->places_rating_by = $memResultData['places_rating_by'];
                        $placeRating->places_rating_created_date = $memResultData['places_rating_created_date'];
                        $placeRating->places_rating_modified_date = $memResultData['places_rating_modified_date'];
                        $placeRating->places_rating_is_active = $memResultData['places_rating_is_active']; 
                        
                        if($memResultData['plc_id']!=null)
                            array_push($memLocation,$placeRating);                                                
                    }
                }                
                return array_filter($memLocation); 
        }
        
        
        /**
         * 
         * @param type $obj
         * @param type $placeid
         * 
         * This function return place with a given id
         */
        function getPlaceFromID($obj,$param_plc_id){
            
                $tblName = " yb_places plc ";
                $disCol = " plc.plc_id,"
                        . "plc.plc_name,"
                        . "plc.plc_header_image,"
                        . "plc.plc_email,"
                        . "plc.plc_contact,"
                        . "plc.plc_website,"
                        . "plc.plc_intime,"
                        . "plc.plc_outtime,"
                        . "plc.plc_country_id,"
                        . "plc.plc_state_id,"
                        . "plc.plc_city,"
                        . "plc.plc_address,"
                        . "plc.plc_meta_description,"
                        . "plc.plc_keywords,"
                        . "plc.plc_zip,"
                        . "plc.plc_latitude,"
                        . "plc.plc_longitude,"
                        . "plc.plc_menu,"
                        . "plc.plc_info_title,"
                        . "plc.plc_info_title";

                $where = " plc.plc_is_active=1 "
                        . " AND plc.plc_is_delete=0 "
                        . " AND plc.plc_id=" . $param_plc_id . " ";

                $order_col = '';
                $order_by = '';              

                $fetchPlace = $obj->selectQuery($tblName, $disCol, $where, $order_col, $order_by , $group_by='', $disQuery = '');
                $fetchPlace = utf8ize($fetchPlace);  
            
                return $fetchPlace;
        }
        
        
        /**
         * 
         * @param type $obj
         * @param type $searchText
         * @param type $exactSearch
         * @param type $categories
         * @param type $features
         * @param type $page
         * @param type $allRec
         * @return array
         * 
         * This function provides fetching places with given search parameters
         * 
         */
        function fetchPlaces($obj,$searchText = '',$exactSearch = 0,$categories = '',$features = '',$page = 0,$allRec = 0){    
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

                $disCol = " plc.plc_id,f.feature_id,f.feature_title,subCat.cat_parent_id,pCat.cat_name as pcat_name,plc.plc_name,plc.plc_header_image,plc_gallery_media,plc.plc_email,plc.plc_contact,plc.plc_website,plc.plc_country_id,plc.plc_state_id,plc.plc_city,plc.plc_address,plc.plc_zip,plc.plc_latitude,plc.plc_longitude,plc.plc_menu,plc.plc_info_title,plc.plc_info_title,plc.plc_is_active,plc.plc_is_delete ";

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
                $searchText = trim($searchText);
                if(!empty($searchText)){
                    if($exactSearch)
                    {
                        $where .= " AND plc.plc_name LIKE '".$searchText."' ";
                    }
                    else
                    {
                        //$where .= " AND plc.plc_name LIKE '%".$searchText."%' ";
                                    $where .= " AND (plc.plc_name LIKE '%".$searchText."%' OR pCat.cat_name LIKE '%".$searchText."' OR subCat.cat_name LIKE '%".$searchText."')";
                    }
                }
                //echo (!empty($categories));die;
                if(!empty($categories)){
                    $where .= " AND plc_cat.plc_sub_cat_id IN (". implode(',',$categories).") ";
                }
                if(!empty($features)){
                    $where .= " AND plc_fet.feature_id IN (". implode(',',$features).") ";
                }
                if($page>0 && $page != "All")
                    $page = $page * $limit;

                if($allRec)
                    $where .= "GROUP BY plc.plc_id ";
                else
                {
                    $cmp = strcmp($order_by, '');
                    if($cmp == 0)
                    {
                        $where .= "GROUP BY plc.plc_id LIMIT ".$page.",".$limit." ";
                    }
                    else
                    {
                        $where .= "GROUP BY plc.plc_id";
                        $order_by .=" LIMIT ".$page.",".$limit." ";
                    }

                }


                $plcArr = $obj->selectQuery($tblName, $disCol, $where, $order_col, $order_by , $group_by='', $disQuery = '');    
                $flag = 0;
                $final_array = array();
                if($exactSearch)
                {
                    if($categories)
                    {
                        foreach($plcArr as $rec)
                        {
                            //$i = 0;
                            $flag = true;
                            foreach($categories as $cat)
                            {
                                $query = "SELECT plc_id FROM yb_places_category WHERE plc_id = ".$rec['plc_id']." AND plc_sub_cat_id = ".$cat;
                                $res = mysql_query($query);

                                if(mysql_num_rows($res) > '0')
                                    $flag = $flag && true;
                                else
                                    $flag = $flag && false;
                            }
                            //echo $flag."<br/>";
                            if($flag)
                            {
                                //print_r($flag);die;
                                array_push($final_array, $rec);
                            }
                        }
                    }

                    if($features)
                    {
                        if($final_array)
                        {
                            $final_array1 = array();
                            foreach($final_array as $rec)
                            {
                                //$i = 0;
                                $flag = true;
                                foreach($features as $cat)
                                {
                                    $query = "SELECT plc_id FROM yb_places_features WHERE plc_id = ".$rec['plc_id']." AND feature_id = ".$cat;
                                    $res = mysql_query($query);

                                    if(mysql_num_rows($res) > '0')
                                        $flag = $flag && true;
                                    else
                                        $flag = $flag && false;
                                }
                                //echo $flag."<br/>";
                                if($flag)
                                {
                                    //print_r($flag);die;
                                    array_push($final_array1, $rec);
                                }
                            }
                            return $final_array1;
                        }
                        else
                        {
                            foreach($plcArr as $rec)
                            {
                                //$i = 0;
                                $flag = true;
                                foreach($features as $cat)
                                {
                                    $query = "SELECT plc_id FROM yb_places_features WHERE plc_id = ".$rec['plc_id']." AND feature_id = ".$cat;
                                    $res = mysql_query($query);

                                    if(mysql_num_rows($res) > '0')
                                        $flag = $flag && true;
                                    else
                                        $flag = $flag && false;
                                }
                                //echo $flag."<br/>";
                                if($flag)
                                {
                                    //print_r($flag);die;
                                    array_push($final_array, $rec);
                                }
                            }
                            return $final_array;   
                        }
                    }
                    //die;
                    return $final_array;
                }

                $plcArr = utf8ize($plcArr);
                return $plcArr;
        }
        
        
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
