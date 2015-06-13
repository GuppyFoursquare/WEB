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

if($_REQUEST['home_slider_id'] != '') $sPageTitle     = "Edit Image";
else $sPageTitle     = "Add Image";

$sPageClass     = "addslide";
$iPageSelect    = 15;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Slider';
$_SESSION['parent_breadcum_url']= 'home_slider.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sSliderTitle     = isset($_REQUEST['slide_title']) ? (trim($_REQUEST['slide_title'])) : '';
$sSliderLink     = isset($_REQUEST['slide_link']) ? (trim($_REQUEST['slide_link'])) : '';
$sSlideImage     = isset($_FILES['txtSlideImage']['name']) ? $_FILES['txtSlideImage']['name'] : '';
$sSlideImage = preg_replace('/[^A-Za-z0-9\-.]/', '', $sSlideImage);
$sSlideImageTemp = isset($_FILES['txtSlideImage']['tmp_name']) ? $_FILES['txtSlideImage']['tmp_name'] : '';
$iSlideID           = isset($_REQUEST['home_slider_id']) ? base64_decode($_REQUEST['home_slider_id']) : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){
    if($sSliderTitle == '') $iProcess = 2;
    elseif($sSlideImage == '') $iProcess = 2;
    
    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        $chkext = pathinfo($sSlideImage,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($sSlideImage != '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
   
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
        
        //CHECK SLIDER NAME EXIST
        $sTABLE_NAME = $prefix."home_slider";
        $aDetails = singleRowDetail('home_slider_id',$sTABLE_NAME,'home_slider_title',$sSliderTitle);
        
        if($aDetails == 0){
            
            $sMaxSeq = "SELECT MAX(home_slider_sequence) as sliderSeq FROM {$prefix}home_slider";
            $rMaxSeq = mysql_query($sMaxSeq) or die("Error:in seq selection".mysql_error()); 
            if(mysql_num_rows($rMaxSeq) > 0){
                $aRow = mysql_fetch_assoc($rMaxSeq);
                $iSequence = $aRow['sliderSeq']+1;
            }else $iSequence = 1;
            
            //INSERT SLIDER IN TABLE
           $sSlider = "INSERT INTO {$prefix}home_slider SET
                            home_slider_title='".mysql_real_escape_string($sSliderTitle)."',
                            home_slider_link='".mysql_real_escape_string($sSliderLink)."',
                            home_slider_sequence=$iSequence
                            ";
            $rSlider = mysql_query($sSlider) or die("Error:in SLIDER selection".mysql_error());
            $iLastInsertID = mysql_insert_id();

		//	echo $sSlideImage;
            ### UPLOAD SLIDER IMAGE ###
            if($sSlideImage != ''){
                $sFileName = str_replace(" ","_",$sSlideImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
				if(move_uploaded_file($sSlideImageTemp, "../".SLIDER_IMAGE.$sFileName)){
                    resizeImages($sFileName,"../".SLIDER_IMAGE,1696,972);
                    mysql_query("UPDATE {$prefix}home_slider SET home_slider_image='$sFileName' WHERE home_slider_id=$iLastInsertID") or die("Error:In profile image update".mysql_error());
                }
            }

			$iProcess = 6; 
        }else{ 
            $sSlideImage="";
            $iProcess = 5; 
        }
    }//End validation
}//End button click



//UPDATE BUTTON CODE
if($sCommand == 'Update'){
   
    if($sSliderTitle == '') $iProcess = 2;
    
    
    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        if($sSlideImage != ''){
            $chkext = pathinfo($sSlideImage,PATHINFO_EXTENSION);
            $type = array('gif','jpg','jpeg','png');
            $sImgExtension = strtolower($chkext);
            if($sSlideImage != '' && !in_array($sImgExtension, $type)){
                $iProcess = 3;
            }
        }//Cat image not blank
    }
    
    if($iProcess == 1){
        //CHECK SLIDER NAME EXIST
        $sSqlSlide = "SELECT * FROM {$prefix}home_slider WHERE home_slider_title='".$sSliderTitle."' AND home_slider_id!=$iSlideID";
        $rSqlSlide = mysql_query($sSqlSlide) or die("Error:in slider selection".mysql_error());
        if(mysql_num_rows($rSqlSlide) > 0){
            //$sCatName = $sCategoryTitle;
			$sSlideImage="";
            $iProcess = 5; 
        }else{
            //UPDATE SLIDER
            $sSlider = "UPDATE {$prefix}home_slider SET
                            home_slider_title='".mysql_real_escape_string($sSliderTitle)."',
                            home_slider_link='".mysql_real_escape_string($sSliderLink)."'
                            WHERE home_slider_id=$iSlideID";
            $rSlider = mysql_query($sSlider) or die("Error:in slider updation".mysql_error());
            $iLastInsertID = $iSlideID;
           // echo $sSliderImage;
			
            ### UPLOAD SLIDER IMAGE ###
            if($sSlideImage!= ''){
                $sFileName = str_replace(" ","_",$sSlideImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                if(move_uploaded_file($sSlideImageTemp, "../".SLIDER_IMAGE.$sFileName)){
                    resizeImages($sFileName,"../".SLIDER_IMAGE,1696,972);
                    mysql_query("UPDATE {$prefix}home_slider SET home_slider_image='$sFileName' WHERE home_slider_id=$iLastInsertID") or die("Error:In profile image update".mysql_error());
                }
            }

            ### UPLOAD CATEGORY ICON ###
            /*if($sCategoryIcon != ''){
                $sFileName = str_replace(" ","_",$sCategoryIcon);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                if(move_uploaded_file($sCategoryIconTemp, "../".SLIDER_IMAGE.$sFileName)){
                    resizeImages($sFileName,"../".SLIDER_IMAGE,55,55);
                    mysql_query("UPDATE {$prefix}category SET cat_icon='$sFileName' WHERE cat_id=$iLastInsertID") or die("Error:In profile image update".mysql_error());
                }//End upload icon
            }//End icon image check*/
            $iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 

//GET SLIDER DETAILS

if($iSlideID > 0){
    $sTABLE_NAME = $prefix."home_slider";
    $aCatDetails = singleRowDetail('home_slider_title,home_slider_image,home_slider_link',$sTABLE_NAME,'home_slider_id',$iSlideID);
    $sSliderTitle = stripslashes($aCatDetails['home_slider_title']);
    $sSliderLink = stripslashes($aCatDetails['home_slider_link']);
    $sSlideImage = ($aCatDetails['home_slider_image']);
} 


switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "Image image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "Image icon extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "Image title already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "Image successfully added.";
            header("location:home_slider.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "Image successfully updated.";
            header("location:home_slider.php");
            die();
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_home_slider.inc.php");