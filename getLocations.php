<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : A.D.
 * @Maintainer  : A.D.
 * @Created     : 02 feb 2015
 * @Modified    : 
 * @Description : This is the reset password page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
    include("prepend.php");
    
    $latitude1 = (isset($_GET['lat']) ? $_GET['lat'] : '');
    $longitude1 = (isset($_GET['long']) ? $_GET['long'] : '');
    
    
    $strSqlSearch = "SELECT plc_id,plc_name,plc_header_image,plc_latitude,plc_longitude,plc_email,plc_contact,plc_website,plc_city ,s.state_name,s.state_abbr, c.country_name , ( 3959 * acos( cos( radians(".$latitude1.") ) 
            * cos( radians( plc_latitude ) ) * cos( radians( plc_longitude ) - radians(".$longitude1.") ) 
            + sin( radians(".$latitude1.") ) * sin( radians( plc_latitude ) ) ) ) 
            AS distance 
            FROM yb_places plc   
            LEFT JOIN yb_countrymst c ON plc.plc_country_id = c.country_id 
            LEFT JOIN yb_statemst s ON plc.plc_state_id = s.state_id
            WHERE plc.plc_is_delete = 0 AND plc.plc_is_active = 1 
            HAVING distance < 50
            ORDER BY distance ";
        //echo $strSqlSearch;
        
        $memLocation = array();
        $memResult = $obj->executeSql($strSqlSearch);
        if($memResult){
            while($memResultData = mysql_fetch_array($memResult)){

                //array_push($memLocation, array($memResultData['plc_id'].",".$memResultData['plc_name'].",".$memResultData['plc_header_image'].",".$memResultData['plc_email'].",".$memResultData['plc_contact'].",".$memResultData['plc_website'].",".$memResultData['plc_city'].",".$memResultData['state_name'].",".$memResultData['state_abbr'].",".$memResultData['country_name'],$memResultData['plc_latitude'],$memResultData['plc_longitude']));
                $where = 'plc_id = '.$memResultData['plc_id'].' AND plc_gallery_is_active = 1 AND plc_is_cover_image = 1';
                $plc_Cover_Image = $obj->selectQuery('yb_place_gallery', 'plc_gallery_media', $where, $order_col = '', $order_by = '', $group_by='', $disQuery = '',1);
                if($plc_Cover_Image)
                    $place_img = $plc_Cover_Image['plc_gallery_media'];
                else
                    $place_img = '';
                array_push($memLocation, array(htmlentities($memResultData['plc_name']), $memResultData['plc_latitude'],$memResultData['plc_longitude'],$place_img,$memResultData['plc_header_image'], base64_encode($memResultData['plc_id']),$memResultData['plc_email'],$memResultData['plc_contact'],$memResultData['plc_website'],htmlentities($memResultData['plc_city']),$memResultData['state_name'],$memResultData['state_abbr'],$memResultData['country_name']));
            }
        }
        //array_push($memLocation, array($memResultData['plc_id'].",".$memResultData['plc_name'].",".$memResultData['plc_header_image'].",".$memResultData['plc_email'].",".$memResultData['plc_contact'].",".$memResultData['plc_website'].",".$memResultData['plc_city'].",".$memResultData['state_name'].",".$memResultData['state_abbr'].",".$memResultData['country_name'],$memResultData['plc_latitude'],$memResultData['plc_longitude']));


        $lat_long_array = json_encode($memLocation);
        echo $lat_long_array;
    
?>
