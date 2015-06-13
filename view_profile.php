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
    //error_reporting(E_ALL);
    $header_title = "YOUBAKU | Edit Profile";
    $editclass = "loginact";
    $_SESSION['is_most_popular'] = 0;
    
    if(!empty($_POST))
    {
        $usr_id = $_SESSION['user_id'];
        
        $sFirstName = isset($_POST['mem_first_name']) ? $_POST['mem_first_name'] : '';
        $sLastName = isset($_POST['mem_last_name']) ? $_POST['mem_last_name'] : '';
        $semail = isset($_POST['mem_email']) ? $_POST['mem_email'] : '';
        $sUserName = isset($_POST['mem_user_name']) ? $_POST['mem_user_name'] : '';
        $sContact = isset($_POST['mem_mob']) ? $_POST['mem_mob'] : '';
        $sCountry = isset($_POST['ddlCountrySelect']) ? $_POST['ddlCountrySelect'] : '';
        $sState = isset($_POST['ddlStateSelect']) ? $_POST['ddlStateSelect'] : '';
        $sCity = isset($_POST['txtCity']) ? $_POST['txtCity'] : '';
        $sAddress = isset($_POST['txtAddress']) ? $_POST['txtAddress'] : '';
        $sImage_name = isset($_FILES['image1']['name']) ? $_FILES['image1']['name'] : '';
        
        
        $sProfileImageTemp = isset($_FILES['image1']['tmp_name']) ? $_FILES['image1']['tmp_name'] : '';
        if($sImage_name != ''){
                    $sFileName = str_replace(" ","_",$sImage_name);
                    $sFileName = str_replace("'","_",$sFileName);
                    $sFileName = $iLastInsertID."_".$sFileName;
                    $sFileName = preg_replace('/[^a-zA-Z0-9_.]/s', '', $sFileName);
                                    if(move_uploaded_file($sProfileImageTemp, PROFILE_IMAGE.$sFileName)){
                        resizeImages($sFileName,PROFILE_IMAGE,100,100);
                                    }
        }
        else
        {
            $sFileName = $_SESSION['usr_profile_picture'];
        }
        //usr_profile_picture = '".mysql_real_escape_string($sFileName)."'
        $sQuery = "UPDATE yb_users SET
                usr_first_name = '".mysql_real_escape_string($sFirstName)."',
                usr_last_name = '".mysql_real_escape_string($sLastName)."',
                usr_contact = '".mysql_real_escape_string($sContact)."',
                usr_address = '".mysql_real_escape_string($sAddress)."',
                usr_city = '".mysql_real_escape_string($sCity)."',
                usr_state = ".mysql_real_escape_string($sState).",
                usr_country = ".mysql_real_escape_string($sCountry).",
                usr_profile_picture = '".mysql_real_escape_string($sFileName)."'
               
                WHERE usr_id = ".$usr_id;
        $aDetails = mysql_query($sQuery);
        
        
        //$_SESSION['usr_username'] = mysql_real_escape_string($sUserName);
        $_SESSION['usr_first_name'] = mysql_real_escape_string($sFirstName);
        $_SESSION['usr_last_name'] = mysql_real_escape_string($sLastName);
        //$_SESSION['usr_email'] = mysql_real_escape_string($semail);
        $_SESSION['usr_contact'] = mysql_real_escape_string($sContact);
        $_SESSION['usr_address'] = mysql_real_escape_string($sAddress);
        $_SESSION['usr_city'] = mysql_real_escape_string($sCity);
        $_SESSION['usr_state'] = mysql_real_escape_string($sState);
        $_SESSION['usr_country'] = mysql_real_escape_string($sCountry);
        $_SESSION['usr_profile_picture'] = mysql_real_escape_string($sFileName);
        
        $_SESSION['sucess_message'] = "Profile updated successfully.";
        header('location:'.SITE_PATH.'index.php');
    }
    else
    {
        if(isset($_REQUEST['username']))
        {
            if(!isset($_SESSION['user_id']))
            {
                header('location:'.SITE_PATH.'index.php');
            }
            else
            {
                $usr_id = $_SESSION['user_id'];
                $username = $_REQUEST['username'];
                $sQuery="SELECT * FROM yb_users WHERE (usr_username='".mysql_real_escape_string($username)."') AND usr_user_type='U' AND usr_id = ".$usr_id;
                $aDetails = mysql_query($sQuery);
                $row=mysql_num_rows($aDetails);

                if($row == 0)
                {
                    $_SESSION['error_message'] = "Sorry, the user does not exist.";
                    header('location:'.SITE_PATH.'index.php');
                }
                else
                {
                    $countries=mysql_query("SELECT * FROM yb_countrymst WHERE country_id = ".$_SESSION['usr_country']);
                    
                    $states=mysql_query("SELECT * FROM yb_statemst WHERE state_id = ".$_SESSION['usr_state']);
                    
                    $countries = mysql_fetch_assoc($countries);
                    $states = mysql_fetch_assoc($states);
                    
                    
                    $query = "SELECT pr.place_rating_id, plc.plc_name, plc.plc_latitude, plc.plc_longitude,plc.plc_header_image, pr.plc_id, pr.place_rating_rating, pr.place_rating_comment, pr.places_rating_by, pr.places_rating_is_active, pg.plc_gallery_media FROM yb_places_rating pr 
                              LEFT JOIN yb_places plc ON plc.plc_id = pr.plc_id  
                              LEFT JOIN yb_place_gallery pg ON pr.plc_id = pg.plc_id 
                              WHERE pr.places_rating_by = ".$_SESSION['user_id']." AND pg.plc_is_cover_image = 1 ORDER BY pr.place_rating_rating DESC";
                    $my_comments = mysql_query($query);
                    $memResult = mysql_query($query);
                    $rows = mysql_num_rows($my_comments);
                    
                    $memLocation = array();
                    if($memResult){
                        while($memResultData = mysql_fetch_array($memResult)){

                            
                            if($memResultData['plc_gallery_media'])
                                $place_img = $memResultData['plc_gallery_media'];
                            else
                                $place_img = '';
                            array_push($memLocation, array(htmlentities($memResultData['plc_name']), $memResultData['plc_latitude'],$memResultData['plc_longitude'],$place_img,$memResultData['plc_header_image']));
                        }
                    }
                    //exit;
                    //array_push($memLocation, array($memResultData['plc_id'].",".$memResultData['plc_name'].",".$memResultData['plc_header_image'].",".$memResultData['plc_email'].",".$memResultData['plc_contact'].",".$memResultData['plc_website'].",".$memResultData['plc_city'].",".$memResultData['state_name'].",".$memResultData['state_abbr'].",".$memResultData['country_name'],$memResultData['plc_latitude'],$memResultData['plc_longitude']));

                    
                    //echo $latitude.'    '; echo $longitude;die;
                    
                    $lat_long_array = json_encode($memLocation);
                    
                    
                    include("template/view_profile.php");
                }
            }
        
        }
        else
        {
            $_SESSION['error_message'] = "The account does not exist.";
            header('location:'.SITE_PATH.'index.php');
        }

    }
?>
