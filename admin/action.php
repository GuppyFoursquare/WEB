<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : All ajax action perform using this page
********************************************************/

# SETUP -----------------------------------------------------------------------
include("prepend.php");

# INPUT -----------------------------------------------------------------------
$sStep = mysql_real_escape_string($_REQUEST['step']);

#PROCESS ----------------------------------------------------------------------

switch($sStep){
    case 'changeRecordStatus':
            $iAction    = isset($_REQUEST['action']) ? $_REQUEST['action'] : 0;
            $iID        = isset($_REQUEST['table_id']) ? $_REQUEST['table_id'] : 0;
            $sTableName = isset($_REQUEST['table_name']) ? $_REQUEST['table_name'] : 0;
            
            include("ajax/ajax.changestatus.php");
            
        break;
    
    case 'deleteRecord':
            $iID        = isset($_REQUEST['table_id']) ? $_REQUEST['table_id'] : 0;
            $sTableName = isset($_REQUEST['table_name']) ? $_REQUEST['table_name'] : 0;
            include("ajax/ajax.deleterecord.php");
            
        break;
    case 'get_lat_lng':
            $address = $_POST['address']; // Google HQ
            $prepAddr = str_replace(' ', '+', $address);
            //echo $prepAddr."||";
            $str = 'http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false';
            $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
            $output = json_decode($geocode);
            /* get valid city from output */
            $json = $output;
	    foreach ($json->results as $result)
	    {
	        foreach($result->address_components as $addressPart) {
	            if((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
	                $city = $addressPart->long_name;
	            else if((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
	                $state = $addressPart->long_name;
	            else if((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
	                $country = $addressPart->long_name;
	        }
	    }
            if (!empty($output->results[0])) {
                $lat = $output->results[0]->geometry->location->lat;
                $long = $output->results[0]->geometry->location->lng;
                $resultarr['lat'] = $lat;
                $resultarr['long'] = $long;
                $resultarr['city'] = $city;
                echo json_encode($resultarr);
            }
            else
                echo '';
            die;
    break;
}
