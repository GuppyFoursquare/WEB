<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : A.D.
 * @Maintainer  : A.D.
 * @Created     : 19 jan 2015
 * @Modified    : 
 * @Description : This page concerns with the map display after clicking on the main page.
********************************************************/

#SETUP -----------------------------------------------------------------------
include("prepend.php");
$_SESSION['is_most_popular'] = 0;
//Get the latitude and longitude
$mapact = "mapact";
$header_title = "YOUBAKU | Near Me";
// These lat long are to be fetched from the current location of the user.
if(isset($_SESSION['user_id']))
{
//    $latitude = 40.3953;
//    $longitude = 49.8822;
    
    $selQuery = "SELECT mem.usr_address,mem.usr_city,mem.usr_state,mem.usr_country,s.state_name, c.country_name 
                FROM yb_users mem
                LEFT JOIN yb_countrymst c ON mem.usr_country = c.country_id 
                LEFT JOIN yb_statemst s ON mem.usr_state = s.state_id
                WHERE mem.usr_delete = 0 AND mem.usr_active = 1 
                AND mem.usr_id = ".$_SESSION['user_id'];
    $result_array = $obj->executeSql($selQuery);
    $result_array = mysql_fetch_array($result_array);
    

    $address = $result_array['usr_address']." ".$result_array['usr_city']." ".$result_array['state_name']." ".$result_array['country_name']." ";
    $prepAddr = str_replace(' ', '+', $address);
	
    //$str = 'http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false';
    //$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
    //$output = json_decode($geocode);
	
	$str = 'http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false';
//    $geocode = file_get_contents($str);
	    
		$ch = curl_init();
	    curl_setopt ($ch, CURLOPT_URL, $str);
	    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
	    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	    $geocode = curl_exec($ch);
	    if (curl_errno($ch)) 
		{
	      $contents = '';
	    } 
		else 
		{
	      curl_close($ch);
	    }

    
    	$output = json_decode($geocode);

	    
    if (!empty($output->results[0])) {
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
    }
    


    //$latitude = 53.4707785;  //Default Lat Long
	//$longitude = 9.9834184;

// get members lat lng for 5 miles
        $strSqlSearch = "SELECT plc_id,plc_name,plc_header_image,plc_latitude,plc_longitude,plc_email,plc_contact,plc_website,plc_city ,s.state_name,s.state_abbr, c.country_name , ( 3959 * acos( cos( radians(".$latitude.") ) 
            * cos( radians( plc_latitude ) ) * cos( radians( plc_longitude ) - radians(".$longitude.") ) 
            + sin( radians(".$latitude.") ) * sin( radians( plc_latitude ) ) ) ) 
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
            
            //print_r($plc_Cover_Image);die;
            //echo "<pre>";
            //echo $memLocation[0][3];
           // print_r($lat_long_array);die;
        // end of member lat,lng
    
    
}
else
{
//    $latitude = 40.3953;
//    $longitude = 49.8822;
    //$latitude = 53.4707785;  //Default Lat Long
    //$longitude = 9.9834184;
}



            

include("template/nearme.php");

?>
