<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : A.D.
 * @Maintainer  : A.D.
 * @Created     : 02 feb 2015
 * @Modified    : Guppy Org.
 * @ModifiedBy  : Kemal Sami KARACA 
 * @ModifiedDate: 16/06/2015
 * @Description : This is the reset password page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
    include("prepend.php");
    
    $latitude1 = (isset($_GET['lat']) ? $_GET['lat'] : '');
    $longitude1 = (isset($_GET['long']) ? $_GET['long'] : '');    
    
    echo json_encode(getPlacesFromLocationArray($obj,$latitude1 , $longitude1));
    
    
    
    
    /**
     * @param type $latitude
     * @param type $longitude
     * @return array
     * 
     *  !!! IMPORTANT !!!
     *      This function returns place array not object
     */
    function getPlacesFromLocationArray($obj,$latitude,$longitude){

            $memLocation = array();
            $memResult = $obj->executeSql(getPlacesQuery($latitude,$longitude));
            if($memResult){
                while($memResultData = mysql_fetch_array($memResult)){

                    //array_push($memLocation, array($memResultData['plc_id'].",".$memResultData['plc_name'].",".$memResultData['plc_header_image'].",".$memResultData['plc_email'].",".$memResultData['plc_contact'].",".$memResultData['plc_website'].",".$memResultData['plc_city'].",".$memResultData['state_name'].",".$memResultData['state_abbr'].",".$memResultData['country_name'],$memResultData['plc_latitude'],$memResultData['plc_longitude']));
                    $where = 'plc_id = '.$memResultData['plc_id'].' AND plc_gallery_is_active = 1 AND plc_is_cover_image = 1';
                    $plc_Cover_Image = $obj->selectQuery('yb_place_gallery', 'plc_gallery_media', $where, $order_col = '', $order_by = '', $group_by='', $disQuery = '',1);
                    if($plc_Cover_Image)
                        $place_img = $plc_Cover_Image['plc_gallery_media'];
                    else
                        $place_img = '';                        

                    array_push($memLocation, array($memResultData['plc_id'], htmlentities($memResultData['plc_name']), $memResultData['plc_latitude'],$memResultData['plc_longitude'],$place_img,$memResultData['plc_header_image'], base64_encode($memResultData['plc_id']),$memResultData['plc_email'],$memResultData['plc_contact'],$memResultData['plc_website'],htmlentities($memResultData['plc_city']),$memResultData['state_name'],$memResultData['state_abbr'],$memResultData['country_name']));                        
                }
            }
            //array_push($memLocation, array($memResultData['plc_id'].",".$memResultData['plc_name'].",".$memResultData['plc_header_image'].",".$memResultData['plc_email'].",".$memResultData['plc_contact'].",".$memResultData['plc_website'].",".$memResultData['plc_city'].",".$memResultData['state_name'].",".$memResultData['state_abbr'].",".$memResultData['country_name'],$memResultData['plc_latitude'],$memResultData['plc_longitude']));

            return $memLocation;            
    }
                        
?>
