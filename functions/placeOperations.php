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
         * @param type $intime
         * @param type $outtime
         * @return string
         */
        function isOpen($intime , $outtime){
                $intime = explode(":", $intime);
                $intimehour = intval($intime[0]);
                $intimemin = intval($intime[1]);
                $intimesec = intval($intime[2]);

                $outtime = explode(":", $outtime);
                $outtimehour = intval($outtime[0]);
                $outtimemin = intval($outtime[1]);
                $outtimesec = intval($outtime[2]);

                $bakuTime = getdate(); 
                $bakuhour = intval($bakuTime['hours']);

                if($intimehour < $outtimehour){
                    if(intval($bakuTime['hours'])>$intimehour && intval($bakuTime['hours'])<$outtimehour){
                        return "1";
                    }

                }else if($intimehour > $outtimehour){
                    
                    //mytime::01, intime::08, outtime::02
                    if($bakuhour<$intimehour && $bakuhour<$outtimehour){
                        return "1";
                    }
                    
                    //mytime::23, intime::08, outtime::02 
                    if(intval($bakuTime['hours'])>$intimehour && intval($bakuTime['hours'])<($outtimehour + 24)){
                        return "1";
                    }
                    
                    //mytime::06, intime::08, outtime::02 
                    if($bakuhour<$intimehour && $bakuhour>$outtimehour){
                        return "0";
                    }
                    
                }else{
                    // $intimehour == $outtimehour
                    // which mean that place open 7x24
                    return "1";
                }

                return "0"; 
        }



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
                
                // --- DEFAULT QUERY ---
                $tblName = " yb_places plc                                     
                    LEFT JOIN yb_countrymst c ON plc.plc_country_id = c.country_id 
                    LEFT JOIN yb_statemst s ON plc.plc_state_id = s.state_id                     
                    LEFT JOIN yb_places_rating r ON plc.plc_id = r.plc_id AND r.places_rating_is_active = 1 ";                
                
                $disCol = " *,plc.plc_id AS plc_id, ";
                $disCol = $disCol . " ( 3959 * acos( cos( radians(".$latitude.") ) * cos( radians( plc_latitude ) ) * cos( radians( plc_longitude ) - radians(".$longitude.") ) + sin( radians(".$latitude.") ) * sin( radians( plc_latitude ) ) ) ) AS distance ";
                //$disCol = $disCol . " sin(radians(plc_latitude - ".$latitude.")/2) * sin(radians(plc_latitude - ".$latitude.")/2) + cos(radians(".$latitude.")) * cos(radians(plc_latitude)) * sin(radians(plc_longitude - ".$longitude.")/2) * sin(radians(plc_longitude - ".$longitude.")/2) AS distanceA, ";
                //$disCol = $disCol . " 6371 * 2 * atan2(sqrt(distanceA), sqrt(1-distanceA)) AS distance ";
                $where = " plc.plc_is_delete = 0 AND plc.plc_is_active = 1 ";
                $having = " distance < 50 ";
                $order_col = " distance ";
                $order_by = '';
                $group_by = '';
                                                
                
                // --- SETTING QUERY WITH GIVEN PARAMETERS ---
                if($subcatid){
                    $tblName    = $tblName . " LEFT JOIN yb_places_category cat ON plc.plc_id = cat.plc_id ";
                    $where      = $where . " AND cat.plc_sub_cat_id = " .$subcatid;
                }
                 
                // --- NEW PARAMETER WILL ADDED HERE ---
                // --- NEW PARAMETER WILL ADDED HERE ---
                // --- NEW PARAMETER WILL ADDED HERE ---
                // such as $distance

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
                        $place->rating_avg  = 0;
                        $place->rating_count= 0;
                        
                        if($place->rating && count($place->rating)>0){
                            $total=0;
                            for ($x = 0; $x <= count($place->rating); $x++) {
                                $total += $place->rating[$x]->place_rating_rating;
                            }
                            $place->rating_avg = floatval(sprintf('%0.2f', $total/count($place->rating)));
                            //$place->rating_avg = $total/count($place->rating);
                            $place->rating_count = count($place->rating);
                        }else{
                            $place->rating_avg  = -1;
                            $place->rating_count= -1;
                        }
                        
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
                include_once '../includes/site_constants.php';
                
                $strSqlSearch = "SELECT * FROM yb_places plc                                           
                    LEFT JOIN yb_places_rating r ON plc.plc_id = r.plc_id AND r.places_rating_is_active = 1
                    LEFT JOIN yb_users u ON r.places_rating_by = u.usr_id
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
                        
                        $placeRating->usr_first_name = $memResultData['usr_first_name']; 
                        $placeRating->usr_last_name = $memResultData['usr_last_name']; 
                        $placeRating->usr_username = $memResultData['usr_username'];
                        $placeRating->usr_profile_picture =  $memResultData['usr_profile_picture'] ? SERVER_FRONT_PATH . PROFILE_IMAGE . $memResultData['usr_profile_picture'] : "-1";
                        
                        if($memResultData['plc_id']!=null)
                            array_push($memLocation,$placeRating);                                                
                    }
                }                
                return array_filter($memLocation); 
        }
        
        
        
        function getPlaceGallery($obj, $place_id){
                include_once '../api/class/Gallery.php';                
                
                $strSqlSearch = "SELECT * FROM yb_place_gallery gal
                    WHERE gal.plc_id=" . $place_id;                               

                $memLocation = array();
                $memResult = $obj->executeSql($strSqlSearch);
                if($memResult){
                    while($memResultData = mysql_fetch_object($memResult, 'Gallery')){                        
                        //--- Create & Fetch to Place object
                        $gallery = new Gallery();
                        $gallery->setPlaceObjectCoreVariables($memResultData);
                                                
                        array_push($memLocation,$gallery);
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
                include_once '../api/class/PlaceClass.php';
                
                $tblName = " yb_places plc ";
                
                $disCol = " * ";

                $where = " plc.plc_is_active=1 "
                        . " AND plc.plc_is_delete=0 "
                        . " AND plc.plc_id=" . $param_plc_id . " ";

                
                $qry = "SELECT " . $disCol . " FROM " . $tblName;

                if ($where != '')
                    $qry .= " WHERE " . $where;

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
                        $place->gallery = getPlaceGallery($obj,$place->plc_id);
                        
                        //--- Check place isOpen ----
                        $place->plc_is_open = isOpen($place->plc_intime, $place->plc_outtime);
                        
                        //--- Comments are fetched ----
                        $place->rating = getPlacesRating($obj,$place->plc_id);
                        $place->rating_avg  = 0;
                        $place->rating_count= 0;
                        
                        if($place->rating && count($place->rating)>0){
                            $total=0;
                            for ($x = 0; $x <= count($place->rating); $x++) {
                                $total += $place->rating[$x]->place_rating_rating;
                            }
                            $place->rating_avg = floatval(sprintf('%0.2f', $total/count($place->rating)));
                            //$place->rating_avg = $total/count($place->rating);
                            $place->rating_count = count($place->rating);
                        }else{
                            $place->rating_avg  = -1;
                            $place->rating_count= -1;
                        }
                        
                        array_push($memLocation,$place);                       
                    }
                }
                       
                return $place;
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
         *
         */
        function fetchPopularPlacesFromJsonData($obj){   
            
            include '../api/class/PlaceClass.php';
            
            $qry = "SELECT AVG(plc_r.place_rating_rating) as plc_avg_rating,plc.plc_id,f.feature_id,f.feature_title,subCat.cat_parent_id,pCat.cat_name as pcat_name,plc.plc_name,plc.plc_header_image,plc_gallery_media,plc.plc_email,plc.plc_contact,plc.plc_website,plc.plc_country_id,plc.plc_state_id,plc.plc_city,plc.plc_address,plc.plc_zip,plc.plc_latitude,plc.plc_longitude,plc.plc_menu,plc.plc_info_title,plc.plc_info,plc.plc_is_active,plc.plc_is_delete 
                FROM yb_places plc 
                LEFT JOIN yb_place_gallery gal ON (plc.plc_id = gal.plc_id AND plc_is_cover_image = 1) 
                JOIN yb_places_category plc_cat ON (plc.plc_id = plc_cat.plc_id) 
                LEFT JOIN yb_places_features plc_fet ON (plc.plc_id = plc_fet.plc_id) 
                LEFT JOIN yb_category subCat ON (plc_cat.plc_sub_cat_id = subCat.cat_id) 
                LEFT JOIN yb_category pCat ON (subCat.cat_parent_id = pCat.cat_id) 
                LEFT JOIN yb_features f ON (plc_fet.feature_id = f.feature_id) 
                JOIN yb_places_rating plc_r ON (plc_r.plc_id = plc.plc_id AND places_rating_is_active=1) 
                    WHERE plc.plc_is_active = 1 AND plc.plc_is_delete = 0 
                    GROUP BY plc.plc_id ORDER BY plc_avg_rating DESC LIMIT 0,100";
            
                    
                // --- EXECUTE PART ---
                $memLocation = array();
                $memResult = $obj->executeSql($qry);                
                if($memResult){
                    while($memResultData = mysql_fetch_object($memResult, 'Place')){
                        try {
                            //--- Create & Fetch to Place object
                            $place = new Place();
                            $place->setPlaceObjectCoreVariables($memResultData);

                            //array_push($memLocation,$memResultData);                          
                            $place = getPlaceFromID($obj,$place->plc_id);
                            array_push($memLocation,$place);
                            
                        }catch(Exception $e) {
                            
                        }                         
                        
                    }
                }                
                                
                return $memLocation;            
        }
                
        /**
         *
         */
        function fetchPlacesFromJsonData($obj,$jsonData){               
            
                include '../api/class/PlaceClass.php';                                
            
                // --- QUERY PART ---
                // --- DEFAULT CASE ---
                $tblName =  " yb_places plc"
                            . " LEFT JOIN yb_places_category plc_cat ON plc.plc_id = plc_cat.plc_id "
                            . " LEFT JOIN yb_places_features plc_fea ON plc.plc_id = plc_fea.plc_id " ;
                
                $disCol     = " *,plc.plc_id AS plc_id ";
                $where      = " plc.plc_is_active  = 1 AND plc.plc_is_delete = 0 ";
                $having     = "";
                $order_col  = "";
                $order_by   = "";
                $group_by   = "";
                $exactSearch = null;
                                                
                $page=0;
                $limit = 6;                
                
                
                if(isset($_SESSION['is_most_popular']))
                {
                    if($_SESSION['is_most_popular'] == 1){                                            
                        $tblName = $tblName." JOIN yb_places_rating plc_r ON (plc_r.plc_id = plc.plc_id) ";
                        $disCol = " AVG(plc_r.place_rating_rating) as avg_rate,plc.plc_id,f.feature_id,f.feature_title,subCat.cat_parent_id,pCat.cat_name as pcat_name,plc.plc_name,plc.plc_header_image,plc_gallery_media,plc.plc_email,plc.plc_contact,plc.plc_website,plc.plc_country_id,plc.plc_state_id,plc.plc_city,plc.plc_address,plc.plc_zip,plc.plc_latitude,plc.plc_longitude,plc.plc_menu,plc.plc_info_title,plc.plc_info,plc.plc_is_active,plc.plc_is_delete ";
                        $order_col = 'avg_rate';
                        $order_by = ' DESC';
                    }                    
                }                
                
                // --- JSON PART ---                               
                if(json_decode($jsonData['subcat_list'])){
                    $where      .= " AND plc_cat.plc_sub_cat_id IN (". implode(",", json_decode($jsonData['subcat_list'])) .") ";
                }
                
                if(json_decode($jsonData['feature_list'])){
                    $where      .= " AND plc_fea.feature_id IN (". json_decode($jsonData['feature_list']) .") ";
                }
                
                if(json_decode($jsonData['location'])){
                    $location_obj = json_decode($jsonData['location']);                    
                    if( json_decode($location_obj['latitude']) && json_decode($location_obj['longitude']) ){
                        $tblName    = "(SELECT plc_id,sin(radians(plc_latitude - ". json_decode($location_obj['latitude']) .")/2) * sin(radians(plc_latitude - ".json_decode($location_obj['latitude']).")/2) + cos(radians(".json_decode($location_obj['latitude']).")) * cos(radians(plc_latitude)) * sin(radians(plc_longitude - ".json_decode($location_obj['longitude']).")/2) * sin(radians(plc_longitude - ".json_decode($location_obj['longitude']).")/2) AS haversine  FROM yb_places WHERE plc_is_delete = 0 AND plc_is_active = 1) hav, " . $tblName ;
                        $disCol     .= ",6371 * 2 * atan2(sqrt(haversine), sqrt(1-haversine)) AS distance";
                        $where      .= " AND hav.plc_id=plc.plc_id "; 
                        
                        $distance = json_decode($location_obj['distance']) ? json_decode($location_obj['distance']) : 50;                                                

                        $having = strlen($having)>0 ? ($having . " AND distance < ".$distance) : (" distance < ".$distance);                       
                        $order_col = " distance ";                        
                    }
                }
                
                if(array_key_exists('limit',$jsonData)){
                    $limit = $jsonData['limit'];
                }else{
                    $limit = 100;
                }
                
                if(array_key_exists('keyword',$jsonData)){
                    
                    $tblName    .= " LEFT JOIN yb_category cat ON (plc_cat.plc_sub_cat_id=cat.cat_id) "
                                    . "LEFT JOIN yb_category scat ON (plc_cat.plc_sub_cat_id = scat.cat_id)" ;
                    
                    $searchText = trim($jsonData['keyword']);
                    if(!empty($searchText)){
                        if($exactSearch)
                        {
                            $where .= " AND plc.plc_name LIKE '".$searchText."' ";
                        }
                        else
                        {                                                        
                            $where .= " AND (plc.plc_name LIKE '%".$searchText."%' OR cat.cat_name LIKE '%".$searchText."' OR scat.cat_name LIKE '%".$searchText."')";
                        }
                    }
                }                                   
                   
                if(json_decode($jsonData['allRec'])){ 
                    $where .= " GROUP BY plc.plc_id ";
                }else{                    
                    $where .= " GROUP BY plc.plc_id";
                    $order_by .=" LIMIT ".$page.",".$limit." ";                                        
                }  
                
                
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
                                
                
                
                // --- EXECUTE PART ---
                $memLocation = array();
                $memResult = $obj->executeSql($qry);                
                if($memResult){
                    while($memResultData = mysql_fetch_object($memResult, 'Place')){
                        
                        try {                        
                            //--- Create & Fetch to Place object
                            $place = new Place();
                            $place->setPlaceObjectCoreVariables($memResultData);                                                

    //                        //--- Comments are fetched ----
    //                        $place->rating = getPlacesRating($obj,$place->plc_id);
    //                        
    //                        //--- Returns average rating of place ---
    //                        $strSqlAverageRating = "SELECT AVG(r.place_rating_rating) AS rating_avg FROM yb_places plc                                           
    //                            LEFT JOIN yb_places_rating r ON plc.plc_id = r.plc_id AND r.places_rating_is_active = 1                             
    //                            WHERE plc.plc_is_delete = 0 AND plc.plc_is_active = 1 AND plc.plc_id = " .$place->plc_id 
    //                            . " GROUP BY r.place_rating_rating" ;                                
    //                        $memAvgResult = $obj->executeSql($strSqlAverageRating);
    //                        if($memAvgResult){
    //                            $place->plc_avg_rating = mysql_fetch_array($memAvgResult)['rating_avg'];
    //                        }                                                
    //                        
    //                        array_push($memLocation,$place);

                            //array_push($memLocation,$memResultData);                              
//                            $place = getPlaceFromID($obj,$memResultData->plc_id);
//                            array_push($memLocation,$place);
                            
                            if($memResultData && $memResultData->plc_id){
                                $place = getPlaceFromID($obj,$memResultData->plc_id);
                                array_push($memLocation,$place);
                            }else{ 
//                                Result::sendReport("EMPTY_RESULT", "placeOperations.php", "fetchPlacesFromJsonData", "result return empty");
                                return Result::$SUCCESS_EMPTY->setContent("fetching query result empty"); 
                            }
                                                    
                        }catch(Exception $e) {                            
//                            Result::sendReport("ERROR_EXCEPTION", "placeOperations.php", "fetchPlacesFromJsonData", "fetching query result error");
                            return Result::$FAILURE_EXCEPTION->setContent("fetching query result error");
                        }
                    }
                    
                }else{
                    
                    $filename = dirname( __FILE__ ) . "/../server.log";                        
                    $logcontent = file_get_contents($filename,FILE_USE_INCLUDE_PATH);

                    $date = getdate()['year']."/".getdate()['mon']."/".getdate()['mday']."-".getdate()['hours'].":".getdate()['minutes'];
                    $session = isset($_SESSION)?session_id() : "SESSION_NULL";
                    $txt = $date . " --> " . $session . " :: " . "333" . "  " . "222" . "  " . "333" . "  " . $qry . "\n";
                    $logcontent .= $txt;
                    file_put_contents($filename, $logcontent); 
                    
//                    Result::sendReport("ERROR_NULL", "placeOperations.php", "fetchPlacesFromJsonData", "query result NULL");
                    return Result::$FAILURE_EXCEPTION->setContent("query result NULL"); 
                }                
                                
                
                    $filename = dirname( __FILE__ ) . "/../server.log";                        
                    $logcontent = file_get_contents($filename,FILE_USE_INCLUDE_PATH);

                    $date = getdate()['year']."/".getdate()['mon']."/".getdate()['mday']."-".getdate()['hours'].":".getdate()['minutes'];
                    $session = isset($_SESSION)?session_id() : "SESSION_NULL";
                    $txt = $date . " --> " . $session . " :: " . "444" . "  " . "222" . "  " . "333" . "  " . $qry . "\n";                
    //                $txt .=json_encode(Result::$SUCCESS->setContent($memLocation) , JSON_HEX_QUOT|JSON_HEX_TAG); 
                    $logcontent .= $txt;
                    file_put_contents($filename, $logcontent);  
            
//                Result::sendReport("SUCCESS", "placeOperations.php", "fetchPlacesFromJsonData", "OK -- result count::" . count($memLocation));
                return Result::$SUCCESS->setContent($memLocation);
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
       
        /**
         * 
         * @param type $lat1
         * @param type $lon1
         * @param type $lat2
         * @param type $lon2
         * @return type
         * 
         * This function calculate distance between two points
         */
        function calculateDistance($lat1, $lon1, $lat2, $lon2){
            $R = 6371; // Radius of the earth in km
            $dLat = deg2rad($lat2-$lat1);  // deg2rad below
            $dLon = deg2rad($lon2-$lon1); 
            $a = sin(deg2rad($lat2-$lat1)/2) * sin(deg2rad($lat2-$lat1)/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin(deg2rad($lon2-$lon1)/2) * sin(deg2rad($lon2-$lon1)/2); 
    
            $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
  
            return $R * $c; // Distance in km
       }
    
?>
