<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 31 Dec 2014
 * @Modified    : 
 * @Description : This page use to add or edit Slide
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");
$obj = new db();
if($_REQUEST['plc_id'] != '') $sPageTitle     = "Edit Places";
else $sPageTitle     = "Add Places";

$sPageClass     = "addplaces";
$iPageSelect    = 6;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Places';
$_SESSION['parent_breadcum_url']= 'places.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

    $sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
     
    $iPlaceId           = isset($_REQUEST['plc_id']) ? base64_decode($_REQUEST['plc_id']) : '';
    $txtname = isset($_POST['txtname']) ? (trim($_POST['txtname'])) : '';
    $txtinTime = isset($_POST['txtinTime']) ? (trim($_POST['txtinTime'])) : '';
    $txtoutTime = isset($_POST['txtoutTime']) ? (trim($_POST['txtoutTime'])) : '';
    $chbHours = isset($_POST['chbHours']) ? 1 : 0;
    $selSubCat = isset($_POST['selSubCat']) ? $_POST['selSubCat'] : '';
    $selFeatures = isset($_POST['selFeatures']) ? $_POST['selFeatures'] : '';
    $txtheader_image = isset($_FILES['txtheader_image']['name']) ? ($_FILES['txtheader_image']['name']) : '';
    $txtheader_imageTemp = isset($_FILES['txtheader_image']['tmp_name']) ? ($_FILES['txtheader_image']['tmp_name']) : '';
    $txtemail = isset($_POST['txtemail']) ? (trim($_POST['txtemail'])) : '';
    $txtcontact = isset($_POST['txtcontact']) ? (trim($_POST['txtcontact'])) : '';
    $txtwebsite = isset($_POST['txtwebsite']) ? (trim($_POST['txtwebsite'])) : '';
    $txtmetadescription = isset($_POST['txtmetadescription']) ? (trim($_POST['txtmetadescription'])) : '';
    $txtmetakeywords = isset($_POST['txtmetakeywords']) ? (trim($_POST['txtmetakeywords'])) : '';
    $selCountry = isset($_POST['selCountry']) ? (trim($_POST['selCountry'])) : '';
    $selState = isset($_POST['selState']) ? (trim($_POST['selState'])) : '';
    $txtcity = isset($_POST['txtcity']) ? (trim($_POST['txtcity'])) : '';
    $txtaddress = isset($_POST['txtaddress']) ? (trim($_POST['txtaddress'])) : '';
    $txtzip = isset($_POST['txtzip']) ? (trim($_POST['txtzip'])) : '';
    $txtlatitude = isset($_POST['txtlatitude']) ? (trim($_POST['txtlatitude'])) : '';
    $txtlongitude = isset($_POST['txtlongitude']) ? (trim($_POST['txtlongitude'])) : '';
    $txtmenu = isset($_FILES['txtmenu']['name']) ? (trim($_FILES['txtmenu']['name'])) : '';
    $txtmenuTemp = isset($_FILES['txtmenu']['tmp_name']) ? (trim($_FILES['txtmenu']['tmp_name'])) : '';
    $txtinfo_title = isset($_POST['txtinfo_title']) ? (trim($_POST['txtinfo_title'])) : '';
    $txtinfo = isset($_POST['txtinfo']) ? (trim($_POST['txtinfo'])) : '';
    $uploadeImageName = "";
    $iPlacesID           = isset($_REQUEST['plc_id']) ? base64_decode($_REQUEST['plc_id']) : '';

#PROCESS -----------------------------------------------------------------------

    
//INSERT BUTTON CODE
if($sCommand == 'Save'){
    
    if($txtname == '') $iProcess = 2;
    elseif(count($selSubCat) <=0 ) $iProcess = 2;
//    //elseif(count($selFeatures) <= 0) $iProcess = 2;
//    elseif($txtheader_image == '') $iProcess = 2;
//    elseif($txtemail == '') $iProcess = 2;
//    elseif($txtcontact == '') $iProcess = 2;
//    elseif($txtwebsite == '') $iProcess = 2;
//    elseif($selCountry == '') $iProcess = 2;
//    elseif($selState == '') $iProcess = 2;
//    elseif($txtcity == '') $iProcess = 2;
//    elseif($txtaddress == '') $iProcess = 2;
//    elseif($txtzip == '') $iProcess = 2;
    elseif($txtlatitude == '') $iProcess = 2;
    elseif($txtlongitude == '') $iProcess = 2;
//    elseif($txtmenu == '') $iProcess = 2;
//    elseif($txtinfo_title == '') $iProcess = 2;
//    elseif($txtinfo == '') $iProcess = 2;

    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1 && $txtheader_image != ''){
        $chkext = pathinfo($txtheader_image,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($txtheader_image != '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
    
    //VALIDAE PDF EXTENSION
    if($iProcess == 1 && $txtmenu != ''){
        $chkext = pathinfo($txtmenu,PATHINFO_EXTENSION);
        $type = array('pdf');
        $sImgExtension = strtolower($chkext);
        if($txtmenu != '' && !in_array($sImgExtension, $type)){
            $iProcess = 4;
        }
    }
   
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
           
           //INSERT PLACES IN TABLE
           $sPlaces = "INSERT INTO {$prefix}places SET
                            plc_name='".mysql_real_escape_string($txtname)."',
                            plc_email='".$txtemail."',
                            plc_contact='".mysql_real_escape_string($txtcontact)."',
                            plc_website='".$txtwebsite."',
                            
                            plc_intime='".date("H:i:s",  strtotime($txtinTime))."',
                            plc_outtime='".date("H:i:s",  strtotime($txtoutTime))."',
                            plc_Hours=".$chbHours.",
                            
                            plc_meta_description='".$txtmetadescription."',
                            plc_keywords='".$txtmetakeywords."',
                            plc_country_id='".$selCountry."',
                            plc_state_id='".$selState."',
                            plc_city='".mysql_real_escape_string($txtcity)."',
                            plc_address='".mysql_real_escape_string($txtaddress)."',
                            plc_zip='".mysql_real_escape_string($txtzip)."',
                            plc_latitude='".$txtlatitude."',
                            plc_longitude='".$txtlongitude."',
                            plc_info_title='".mysql_real_escape_string($txtinfo_title)."',
                            plc_info='".mysql_real_escape_string($txtinfo)."'
                            ";
            $rPlaces = mysql_query($sPlaces) or $_SESSION['error_message'] = "Error:in places selection".mysql_error();
            $iLastInsertID = mysql_insert_id();
            
            if($iLastInsertID){
                // insert categories
                if(count($selSubCat)){
                    foreach($selSubCat as $key => $value){
                        $sPlaces = "INSERT INTO {$prefix}places_category SET
                                plc_id='".$iLastInsertID."',
                                plc_sub_cat_id='".$value."'
                            ";
                        $rPlaces = mysql_query($sPlaces);
                    }
                }
                // insert features
                if(count($selFeatures)){
                    foreach($selFeatures as $key => $value){
                        $sPlaces = "INSERT INTO {$prefix}places_features SET
                                plc_id='".$iLastInsertID."',
                                feature_id='".$value."'
                            ";
                        $rPlaces = mysql_query($sPlaces);
                    }
                }
            }
            

            ### UPLOAD PLACESS IMAGE ###
            if($txtheader_image != ''){
                $sFileName = str_replace(" ","_",$txtheader_image);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                $sFileName = preg_replace('/[^A-Za-z0-9\-.]/', '', $sFileName);
                    if(copy($txtheader_imageTemp, SET_UPLOAD_PATH.PLACES_HEADER_IMAGE.$sFileName)){
                        copy($txtheader_imageTemp, SET_UPLOAD_PATH.PLACES_HEADER_IMAGE_ORG.$sFileName);
                    $uploadeImageName =  $sFileName;
                    //resizeImages($sFileName,SET_UPLOAD_PATH.PLACES_HEADER_IMAGE,155,155);
                    $file_for_dimention = SET_UPLOAD_PATH.PLACES_HEADER_IMAGE .$sFileName;
                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                                if($dwidth == PLACES_HEADER_IMAGE_WIDTH || $dheight == PLACES_HEADER_IMAGE_HEIGHT)
                                {
                                    // nothing to do
                                }
                                elseif($dwidth <= PLACES_HEADER_IMAGE_WIDTH || $dheight <= PLACES_HEADER_IMAGE_HEIGHT)
                                {
                                    $w = PLACES_HEADER_IMAGE_WIDTH;
                                    $h = PLACES_HEADER_IMAGE_HEIGHT;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'exact',SET_UPLOAD_PATH.PLACES_HEADER_IMAGE);
                                }else{
                                    
                                    $w = PLACES_HEADER_IMAGE_WIDTH;
                                    $h = PLACES_HEADER_IMAGE_HEIGHT;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'maxheight',SET_UPLOAD_PATH.PLACES_HEADER_IMAGE);
                                    
                                    $w = PLACES_HEADER_IMAGE_WIDTH;
                                    $h = PLACES_HEADER_IMAGE_HEIGHT;
                                    resizeImageProperSave(SET_UPLOAD_PATH.PLACES_HEADER_IMAGE.$sFileName, $w, $h,'maxwidth',SET_UPLOAD_PATH.PLACES_HEADER_IMAGE);
                                }
                    mysql_query("UPDATE {$prefix}places SET plc_header_image='$sFileName' WHERE plc_id=$iLastInsertID") or $_SESSION['error_message'] = "Error:In header image update".mysql_error();
                }
            }
            
            
            ### UPLOAD PLACESS PDF ###
            if($txtmenu != ''){
                $sFileName = str_replace(" ","_",$txtmenu);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                $sFileName = preg_replace('/[^A-Za-z0-9\-.]/', '', $sFileName);
                    if(copy($txtmenuTemp, SET_UPLOAD_PATH.PLACES_MENU_PDF.$sFileName)){
                        mysql_query("UPDATE {$prefix}places SET plc_menu='$sFileName' WHERE plc_id=$iLastInsertID") or $_SESSION['error_message'] = "Error:In menu pdf update".mysql_error();
                }
            }

            $iProcess = 6; 
        
    }//End validation
}//End button click



//UPDATE BUTTON CODE
if($sCommand == 'Update'){
   
     if($txtname == '') $iProcess = 2;
        elseif(count($selSubCat) <=0 ) $iProcess = 2;
//        //elseif(count($selFeatures) <= 0) $iProcess = 2;
//        elseif($txtemail == '') $iProcess = 2;
//        elseif($txtcontact == '') $iProcess = 2;
//        elseif($txtwebsite == '') $iProcess = 2;
//        elseif($selCountry == '') $iProcess = 2;
//        elseif($selState == '') $iProcess = 2;
//        elseif($txtcity == '') $iProcess = 2;
//        elseif($txtaddress == '') $iProcess = 2;
//        elseif($txtzip == '') $iProcess = 2;
        elseif($txtlatitude == '') $iProcess = 2;
        elseif($txtlongitude == '') $iProcess = 2;
//        elseif($txtinfo_title == '') $iProcess = 2;
//        elseif($txtinfo == '') $iProcess = 2;
    
    
    
    //VALIDAE IMAGE EXTENSION
    if(!empty($txtheader_image))
    if($iProcess == 1){
        if($txtheader_image != ''){
            $chkext = pathinfo($txtheader_image,PATHINFO_EXTENSION);
            $type = array('gif','jpg','jpeg','png');
            $sImgExtension = strtolower($chkext);
            if($txtheader_image != '' && !in_array($sImgExtension, $type)){
                $iProcess = 3;
            }
        }//Cat image not blank
    }
    
    //VALIDAE PDF EXTENSION
    if(!empty($txtmenu))
    if($iProcess == 1){
        $chkext = pathinfo($txtmenu,PATHINFO_EXTENSION);
        $type = array('pdf');
        $sImgExtension = strtolower($chkext);
        if($txtmenu != '' && !in_array($sImgExtension, $type)){
            $iProcess = 4;
        }
    }
    
    
    if($iProcess == 1){
            //UPDATE PLACES
                        $sPlaces = "UPDATE {$prefix}places SET
                                    plc_name='".mysql_real_escape_string($txtname)."',
                                    plc_email='".$txtemail."',
                                    plc_contact='".mysql_real_escape_string($txtcontact)."',
                                    plc_website='".$txtwebsite."',
                                    
                                    plc_intime='".date("H:i:s",  strtotime($txtinTime))."',
                                    plc_outtime='".date("H:i:s",  strtotime($txtoutTime))."',
                                    plc_Hours=".$chbHours.",
                                    
                                    plc_meta_description='".$txtmetadescription."',
                                    plc_keywords='".$txtmetakeywords."',
                                    plc_country_id='".$selCountry."',
                                    plc_state_id='".$selState."',
                                    plc_city='".mysql_real_escape_string($txtcity)."',
                                    plc_address='".mysql_real_escape_string($txtaddress)."',
                                    plc_zip='".mysql_real_escape_string($txtzip)."',
                                    plc_latitude='".$txtlatitude."',
                                    plc_longitude='".$txtlongitude."',
                                    plc_info_title='".mysql_real_escape_string($txtinfo_title)."',
                                    plc_info='".mysql_real_escape_string($txtinfo)."'
                            WHERE plc_id=$iPlacesID";
            $rPlaces = mysql_query($sPlaces) or $_SESSION['error_message'] = "Error:in places updation".mysql_error();
            $iLastInsertID = $iPlacesID;
            
            if($iLastInsertID){
                // delete old entries
                        $sDelete = "DELETE FROM {$prefix}places_category WHERE 
                                plc_id='".$iLastInsertID."'
                            ";
                        $sDelete = mysql_query($sDelete);
                // insert categories
                if(count($selSubCat)){
                    foreach($selSubCat as $key => $value){
                        $sPlaces = "INSERT INTO {$prefix}places_category SET
                                plc_id='".$iLastInsertID."',
                                plc_sub_cat_id='".$value."'
                            ";
                        $rPlaces = mysql_query($sPlaces);
                    }
                }
                
                // delete old entries
                        $sDelete = "DELETE FROM {$prefix}places_features WHERE 
                                plc_id='".$iLastInsertID."'
                            ";
                        $sDelete = mysql_query($sDelete);
                // insert features
                if(count($selFeatures)){
                    foreach($selFeatures as $key => $value){
                        $sPlaces = "INSERT INTO {$prefix}places_features SET
                                plc_id='".$iLastInsertID."',
                                feature_id='".$value."'
                            ";
                        $rPlaces = mysql_query($sPlaces);
                    }
                }
            }
           
            ### UPLOAD PLACES IMAGE ###
            if($txtheader_image!= ''){
                $sFileName = str_replace(" ","_",$txtheader_image);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                $sFileName = preg_replace('/[^A-Za-z0-9\-.]/', '', $sFileName);
                if(copy($txtheader_imageTemp, SET_UPLOAD_PATH.PLACES_HEADER_IMAGE.$sFileName)){
                    copy($txtheader_imageTemp, SET_UPLOAD_PATH.PLACES_HEADER_IMAGE_ORG.$sFileName);
                    
                    $uploadeImageName =  $sFileName;
                    //resizeImages($sFileName,SET_UPLOAD_PATH.PLACES_HEADER_IMAGE,155,155);
                    $file_for_dimention = SET_UPLOAD_PATH.PLACES_HEADER_IMAGE .$sFileName;
                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                                if($dwidth == PLACES_HEADER_IMAGE_WIDTH || $dheight == PLACES_HEADER_IMAGE_HEIGHT)
                                {
                                    // nothing to do
                                }
                                elseif($dwidth <= PLACES_HEADER_IMAGE_WIDTH || $dheight <= PLACES_HEADER_IMAGE_HEIGHT)
                                {
                                    $w = PLACES_HEADER_IMAGE_WIDTH;
                                    $h = PLACES_HEADER_IMAGE_HEIGHT;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'exact',SET_UPLOAD_PATH.PLACES_HEADER_IMAGE);
                                }else{
                                    
                                    $w = PLACES_HEADER_IMAGE_WIDTH;
                                    $h = PLACES_HEADER_IMAGE_HEIGHT;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'maxheight',SET_UPLOAD_PATH.PLACES_HEADER_IMAGE);
                                    
                                    $w = PLACES_HEADER_IMAGE_WIDTH;
                                    $h = PLACES_HEADER_IMAGE_HEIGHT;
                                    resizeImageProperSave(SET_UPLOAD_PATH.PLACES_HEADER_IMAGE.$sFileName, $w, $h,'maxwidth',SET_UPLOAD_PATH.PLACES_HEADER_IMAGE);
                                }
                    mysql_query("UPDATE {$prefix}places SET plc_header_image='$sFileName' WHERE plc_id=$iLastInsertID") or $_SESSION['error_message'] = "Error:In places icon update".mysql_error();
                }
                
                
            }
            
            ### UPLOAD PLACESS PDF ###
                if($txtmenu != ''){
                    $sFileName = str_replace(" ","_",$txtmenu);
                    $sFileName = str_replace("'","_",$sFileName);
                    $sFileName = $iLastInsertID."_".$sFileName;
                    $sFileName = preg_replace('/[^A-Za-z0-9\-.]/', '', $sFileName);
                        if(copy($txtmenuTemp, SET_UPLOAD_PATH.PLACES_MENU_PDF.$sFileName)){
                            mysql_query("UPDATE {$prefix}places SET plc_menu='$sFileName' WHERE plc_id=$iLastInsertID") or $_SESSION['error_message'] = "Error:In menu pdf update".mysql_error();
                    }
                }
           $iProcess = 7; 
    }//End validation
    
    
}//Update 



//GET PLACESS DETAILS
$placeCatArr = array();
$placeFeatArr = array();
if($iPlacesID > 0){
    $sTABLE_NAME = $prefix."places";
    $aDetails = singleRowDetail('plc_id,plc_name,plc_header_image,plc_email,plc_contact,plc_website,plc_intime,plc_outtime, plc_Hours, plc_meta_description,plc_keywords, plc_country_id,plc_state_id,plc_city,plc_address,plc_zip,plc_latitude,plc_longitude,plc_menu,plc_info_title,plc_info,plc_is_active,plc_is_delete',$sTABLE_NAME,'plc_id',$iPlacesID);
    $txtname = htmlentities(stripslashes($aDetails['plc_name']));
    $txtheader_image = ($aDetails['plc_header_image']);
    $txtemail = ($aDetails['plc_email']);
    $txtcontact = stripslashes($aDetails['plc_contact']);
    $txtwebsite = ($aDetails['plc_website']);
    $txtinTime = date("H:i",strtotime($aDetails['plc_intime']));
    $txtoutTime = date("H:i",strtotime($aDetails['plc_outtime']));
    $chbHours = $aDetails['plc_Hours'];
    $txtmetadescription = ($aDetails['plc_meta_description']);
    $txtmetakeywords = ($aDetails['plc_keywords']);
    $selCountry = stripslashes($aDetails['plc_country_id']);
    $selState = stripslashes($aDetails['plc_state_id']);
    $txtcity = stripslashes($aDetails['plc_city']);
    $txtaddress = stripslashes($aDetails['plc_address']);
    $txtzip = stripslashes($aDetails['plc_zip']);
    $txtlatitude = ($aDetails['plc_latitude']);
    $txtlongitude = ($aDetails['plc_longitude']);
    $txtmenu = ($aDetails['plc_menu']);
    $txtinfo_title = htmlentities(stripslashes($aDetails['plc_info_title']));
    $txtinfo = stripslashes($aDetails['plc_info']);
    
    // get place categories
        $tblName = " yb_places_category ";
        $disCol = " plc_sub_cat_id";
        $where = " plc_id = ".$iPlacesID ;
        $order_col = '';
        $order_by = '';
        $placeCatArrS = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
        $i = 0;
        foreach($placeCatArrS as $catKey=>$catVal){
            array_push($placeCatArr, $catVal['plc_sub_cat_id']);
        }
    // end of place categories
    // get place feature
        $tblName = " yb_places_features ";
        $disCol = " feature_id";
        $where = " plc_id = ".$iPlacesID ;
        $order_col = '';
        $order_by = '';
        $placeFeatArrS = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
        $i = 0;
        foreach($placeFeatArrS as $fetKey=>$fetVal){
            array_push($placeFeatArr, $fetVal['feature_id']);
        }
    // end of place categories
} 
switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "Places image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "Places icon extension should be pdf";
        break;
    case 5:
            $_SESSION['error_message'] = "Places name already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "Places successfully added.";
       
            if($_FILES['txtheader_image']['name'] != ''){
                $_SESSION['id'] =$iLastInsertID;
                $_SESSION['crop_image'] = $uploadeImageName;
                @header("Location:image_crop.php?redirect_to=add_edit_places");
                die;
            }else{
                header("location:places.php");
                die();
            }
        break;
    case 7:
            $_SESSION['sucess_message'] = "Places successfully updated.";
            if($_FILES['txtheader_image']['name'] != ''){
                $_SESSION['id'] =$iLastInsertID;
                $_SESSION['crop_image'] = $uploadeImageName;
                @header("Location:image_crop.php?redirect_to=add_edit_places");
                die;
            }else{
                header("location:places.php");
                die();
            }
        break;
}


    
    $catMaster = array();
    $tblName = " yb_category ";
    $disCol = " cat_id,cat_name,cat_parent_id";
    $where = " cat_is_active  = 1 AND cat_is_delete = 0 AND cat_parent_id = 0" ;
    $order_col = '';
    $order_by = '';
    $catArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    if($catArr){
        foreach($catArr as $pCat){
            array_push($catMaster,$pCat);
            // child category
                $where = " cat_is_active  = 1 AND cat_is_delete = 0 AND cat_parent_id = ".$pCat['cat_id'] ;
                $order_col = '';
                $order_by = '';
                $catChildArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
                if($catChildArr){
                    foreach($catChildArr AS $subCat){
                        array_push($catMaster,$subCat);
                    }
                }
            // end
        }
    }
    
    // select Feature
    $tblName = " yb_features ";
    $disCol = " feature_id,feature_title";
    $where = " feature_is_active  = 1 AND feature_is_delete = 0 " ;
    $order_col = '';
    $order_by = '';
    $featureArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
   

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_places.inc.php");