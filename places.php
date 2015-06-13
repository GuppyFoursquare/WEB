<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the index page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
    include("prepend.php");
    //error_reporting(E_ALL);
    $_SESSION['is_most_popular'] = 0;
    $header_title = "YOUBAKU | Places Details";
    $search2act = "search2act";
    
    $plc_id = (isset($_GET['r']) ? base64_decode($_GET['r']) : '');
    // get place details here...
        // place details
        $placeDetails = array();
        if(is_numeric($plc_id)){
            $tblName = " yb_places plc LEFT JOIN yb_countrymst c ON c.country_id = plc.plc_country_id LEFT JOIN yb_statemst s ON s.state_id = plc.plc_state_id";
            $disCol = " plc.plc_id,plc.plc_name,plc.plc_header_image,plc.plc_email,plc.plc_intime, plc.plc_outtime, plc.plc_Hours, plc.plc_meta_description, plc.plc_keywords, plc.plc_contact,plc.plc_website,plc.plc_country_id,plc.plc_state_id,plc.plc_city,plc.plc_address,plc.plc_zip,plc.plc_latitude,plc.plc_longitude,plc.plc_menu,plc.plc_info_title,plc.plc_info,plc.plc_is_active,plc.plc_is_delete,s.state_abbr,s.state_name,c.country_abbr,c.country_name ";
            $where = " plc.plc_id = ".$plc_id." AND plc.plc_is_active = 1 AND plc.plc_is_delete = 0 ";
            $placeDetails = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by='', $disQuery = '',1);
        }
        //print_r($placeDetails);die;
        $query1 = "SELECT AVG(place_rating_rating) as rate FROM yb_places_rating WHERE plc_id = ".$plc_id;
        $rate_place = mysql_query($query1);
        $rate_place = mysql_fetch_array($rate_place);
        
        $calc_rating = $rate_place['rate'];
        if($calc_rating)
        {
            if($calc_rating > 0 && $calc_rating < 0.5)
            {
                $calc_rating = 0;
            }
            if($calc_rating > 0.5 && $calc_rating < 1)
            {
                $calc_rating = 1;
            }
            if($calc_rating > 1 && $calc_rating < 1.5)
            {
                $calc_rating = 1;
            }
            if($calc_rating > 1.5 && $calc_rating < 2)
            {
                $calc_rating = 2;
            }
            if($calc_rating > 2 && $calc_rating < 2.5)
            {
                $calc_rating = 2;
            }
            if($calc_rating > 2.5 && $calc_rating < 3)
            {
                $calc_rating = 3;
            }
            if($calc_rating > 3 && $calc_rating < 3.5)
            {
                $calc_rating = 3;
            }
            if($calc_rating >3.5 && $calc_rating < 4)
            {
                $calc_rating = 4;
            }
            if($calc_rating > 4 && $calc_rating < 4.5)
            {
                $calc_rating = 4;
            }
            if($calc_rating > 4.5)
            {
                $calc_rating = 5;
            }
            
        }
        else 
        {
            $calc_rating = 0;
        }
        
        //echo $rate_place['rate'];die;
        
        $query = "SELECT r.*,u.usr_first_name,u.usr_last_name FROM yb_places_rating r LEFT JOIN yb_users u ON r.places_rating_by = u.usr_id WHERE r.places_rating_is_active = 1 AND r.plc_id = $plc_id ORDER BY places_rating_created_date DESC";
        $places_ratings = mysql_query($query);
        $places2 = mysql_query($query);;
//        while($row = mysql_fetch_array($places_ratings))
//        {
//            print_r($row);
//        }die;
        //print_r(mysql_fetch_array($places_ratings));die;
        
        if(isset($_SESSION['user_id']))
        {
            $user_id = $_SESSION['user_id'];
            $query = "SELECT place_rating_id, places_rating_is_active from yb_places_rating WHERE plc_id = ".$plc_id." AND places_rating_by = ".$user_id;
            $aDetails = mysql_query($query);
            $row=mysql_num_rows($aDetails);
            
            if($row > 0)
            {
                // Set Session values indicating that the review is already added.
                $_SESSION['review_added'] = 1;
                $aDetails = mysql_fetch_array($aDetails);
                if($aDetails['places_rating_is_active'] == 0){
                    $_SESSION['comment_inactive'] = 1;
                }
                else{
                    $_SESSION['comment_inactive'] = 0;
                }
            }
            else
            {
                $_SESSION['review_added'] = 0;
            }
            
        }
        
        /*if(isset($_SESSION['user_id']))
        {
            $sQuery1="SELECT favo_id FROM yb_places_favourites WHERE favo_plc_id=".$plc_id." AND favo_usr_id = ".$_SESSION['user_id'];
            $aDetails1 = mysql_query($sQuery1);
            $row1=mysql_num_rows($aDetails1);
            if($row1==1)
            {
                $place_in_favourite = 1;
            }
            else
            {
                $place_in_favourite = 0;
            }
        }
        else
        {
            $place_in_favourite = 0;
        }*/
        
        
        
        $latitude = $placeDetails['plc_latitude'];
        $longitude = $placeDetails['plc_longitude'];

        // get members lat lng for 5 miles
                $strSqlSearch = "SELECT plc_id,plc_name,plc_header_image,plc_latitude,plc_longitude,plc_email,plc_contact,plc_website,plc_city ,s.state_name,s.state_abbr, c.country_name , ( 3959 * acos( cos( radians(".$latitude.") ) 
                    * cos( radians( plc_latitude ) ) * cos( radians( plc_longitude ) - radians(".$longitude.") ) 
                    + sin( radians(".$latitude.") ) * sin( radians( plc_latitude ) ) ) ) 
                    AS distance 
                    FROM yb_places plc   
                    LEFT JOIN yb_countrymst c ON plc.plc_country_id = c.country_id 
                    LEFT JOIN yb_statemst s ON plc.plc_state_id = s.state_id
                    WHERE plc.plc_is_delete = 0 AND plc.plc_is_active = 1 
                    AND plc.plc_latitude <> ".$latitude ." AND plc.plc_longitude <> ".$longitude."
                    HAVING distance < 50
                    ORDER BY distance ";
                //echo $strSqlSearch;
                $memLocation = array();
                    $memResult = $obj->executeSql($strSqlSearch);
                    //print_r(mysql_fetch_array($memResult));echo '<br/>';
                    if($memResult){
                        while($memResultData = mysql_fetch_array($memResult)){

                            //array_push($memLocation, array($memResultData['plc_id'].",".$memResultData['plc_name'].",".$memResultData['plc_header_image'].",".$memResultData['plc_email'].",".$memResultData['plc_contact'].",".$memResultData['plc_website'].",".$memResultData['plc_city'].",".$memResultData['state_name'].",".$memResultData['state_abbr'].",".$memResultData['country_name'],$memResultData['plc_latitude'],$memResultData['plc_longitude']));
                            $where = 'plc_id = '.$memResultData['plc_id'].' AND plc_gallery_is_active = 1 AND plc_is_cover_image = 1';
                            $plc_Cover_Image = $obj->selectQuery('yb_place_gallery', 'plc_gallery_media', $where, $order_col = '', $order_by = '', $group_by='', $disQuery = '',1);
                            
                            if($plc_Cover_Image)
                                $place_img = $plc_Cover_Image['plc_gallery_media'];
                            else
                                $place_img = '';
                            array_push($memLocation, array(htmlentities($memResultData['plc_name']), $memResultData['plc_latitude'],$memResultData['plc_longitude'],$place_img,$memResultData['plc_header_image'],$memResultData['plc_email'],$memResultData['plc_contact'],$memResultData['plc_website'],htmlentities($memResultData['plc_city']),$memResultData['state_name'],$memResultData['state_abbr'],$memResultData['country_name']));
                        }
                    }
                    //exit;
                    //array_push($memLocation, array($memResultData['plc_id'].",".$memResultData['plc_name'].",".$memResultData['plc_header_image'].",".$memResultData['plc_email'].",".$memResultData['plc_contact'].",".$memResultData['plc_website'].",".$memResultData['plc_city'].",".$memResultData['state_name'].",".$memResultData['state_abbr'].",".$memResultData['country_name'],$memResultData['plc_latitude'],$memResultData['plc_longitude']));

                    
                    //echo $latitude.'    '; echo $longitude;die;
                    
                    $lat_long_array = json_encode($memLocation);
        
        
        
        
        
        // gallery details
            $tblName = " yb_place_gallery ";
            $disCol = " plc_gallery_id,plc_id,plc_gallery_media,plc_gallery_is_video,plc_gallery_seq,plc_is_cover_image,plc_gallery_is_active ";
            $where = " plc_id = ".$plc_id." AND plc_gallery_is_active = 1 AND plc_gallery_is_video = 0 ";
            $galDetails = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by='', $disQuery = '');
            
            $tblName = " yb_place_gallery ";
            $disCol = " plc_gallery_id,plc_id,plc_gallery_media,plc_gallery_is_video,plc_gallery_seq,plc_is_cover_image,plc_gallery_is_active ";
            $where = " plc_id = ".$plc_id." AND plc_gallery_is_active = 1 AND plc_gallery_is_video = 1 ";
            $vdoDetails = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by='', $disQuery = '');
        // end of gallery
        
        // feature details
            $tblName = " yb_places_features pf 
                        LEFT JOIN yb_features f ON (pf.feature_id = f.feature_id)";
            $disCol = " pf.*,f.feature_title,f.feature_icon ";
            $where = " pf.plc_id = ".$plc_id." AND f.feature_is_active  = 1 AND f.feature_is_delete = 0";
            $order_col = '';
            $order_by = '';
            $featureDetails = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
        // end of feature
        
    // end of place details.
        if(!empty($_POST))
        {
            $date_sel = isset($_POST['choose_date']) ? $_POST['choose_date'] : '';
            $ppl = isset($_POST['people']) ? $_POST['people'] : '';
            $time_sel = isset($_POST['select_time']) ? $_POST['select_time'] : '';
            $mem_name = isset($_POST['member_name']) ? $_POST['member_name'] : '';
            $mem_email = isset($_POST['member_email']) ? $_POST['member_email'] : '';
            $spl_wish = isset($_POST['wishes']) ? $_POST['wishes'] : '';
            
            if($date_sel!='' && $ppl!='' && $time_sel!='' && $mem_name!='' && $mem_email!='' && $spl_wish!='')
            {
                //Mail to Youbaku admin from member
                
                $to = "Youbaku admin <websites.tester@gmail.com>";
                $subject = "Table reservation query";
                $msg = "Hello admin,  <br/><br/> ".
                        "The following user has inquired for a table reservation at ".$placeDetails['plc_name'].
                        "<br/>The details are as follows.<br/><br/>".
                        "Member Name: ".$mem_name."<br/>
                         Place of reservation: ".$placeDetails['plc_name']."<br/>
                         Member Email: ".$mem_email."<br/>
                         Date of reservation: ".$date_sel."<br/>
                         Time of reservation: ".$time_sel."<br/>
                         Special Wishes: ".$spl_wish."<br/>
                         <br/><br/>Thank you.<br/>Youbaku Support Team.<br/>".
                        "<a href=\"http://www.youbaku.az/index.php\"> www.youbaku.az</a>";
                $headers = "MIME-Version: 1.0" . "\r\n".
                           "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                           "From: Youbaku".'<'.$mem_email.'>'."\r\n" .
                           "Reply-To:".$mem_name.'<'.$mem_email.'>'.' \r\n'. 
                           "X-Mailer: PHP/" . phpversion();

                $mail_sent = mail($to,$subject,$msg,$headers);
                
                
                //Mail to restaurant admin from Youbaku admin.
                
                $to = "Restaurant admin <".$placeDetails['plc_email'].">";
                $subject = "Table reservation query";
                $msg = "Hello admin,  <br/><br/> ".
                        "The following user has inquired for a table reservation at ".$placeDetails['plc_name'].
                        "<br/>The details are as follows.<br/><br/>".
                        "Member Name: ".$mem_name."<br/>
                         Place of reservation: ".$placeDetails['plc_name']."<br/>
                         Member Email: ".$mem_email."<br/>
                         Date of reservation: ".$date_sel."<br/>
                         Time of reservation: ".$time_sel."<br/>
                         Special Wishes: ".$spl_wish."<br/>
                         <br/><br/>Thank you.<br/>Youbaku Support Team.<br/>".
                        "<a href=\"http://www.youbaku.az/index.php\"> www.youbaku.az</a>";
                $headers = "MIME-Version: 1.0" . "\r\n".
                           "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                           "From: Youbaku".'<'.$mem_email.'>'."\r\n" .
                           "Reply-To: Youbaku admin".'<websites.tester@gmail.com>'.' \r\n'. 
                           "X-Mailer: PHP/" . phpversion();

                $mail_sent = mail($to,$subject,$msg,$headers);
                
                
                // Mail to member from youbaku admin.
                
                $to = $mem_email;
                $subject = "Table reservation query";
                $msg = "Hello".$mem_name.",  <br/><br/> Your table reservation entry for ".$placeDetails['plc_name']." has been noted. We will get back to you soon.<br/><br/>Thank you.<br/>Youbaku Support Team.<br/>".
                        "<a href=\"http://www.youbaku.az/index.php\"> www.youbaku.az</a>";
                $headers = "MIME-Version: 1.0" . "\r\n".
                           "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                           "From: Youbaku <noreply@youbaku.az>" . "\r\n" .
                           "Reply-To: Administrator <websites.tester@gmail.com>" . "\r\n" .
                           "X-Mailer: PHP/" . phpversion();

                $mail_sent = mail($to,$subject,$msg,$headers);
                if($mail_sent)
                {
                    $_SESSION['sucess_message'] = "Table reservation query noted.";
                    //header('location:'.SITE_PATH.'index.php');
                }
                else
                {
                    $_SESSION['error_message'] = "Cannot send mail. Server configuration error.";
                    //header('location:'.SITE_PATH.'index.php');
                }
                
            }
            else
            {
                $_SESSION['error_message'] = "Please fill up all the mandatory fields.";
            }
        }
            
    include("template/places.php");
?>
