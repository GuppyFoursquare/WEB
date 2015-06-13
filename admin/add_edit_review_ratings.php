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
//echo isset($_REQUEST['pending']);die;
if(isset($_REQUEST['plc_id'])){
    $pid = '?plc_id='.$_REQUEST['plc_id'];
}
if(isset($_REQUEST['pending'])){
    $pid = '?pending='.$_REQUEST['pending'];
}
 else {
    $pid = '';
}

if($_REQUEST['place_rating_id'] != '') $sPageTitle     = "Edit Review & Ratings";
else $sPageTitle     = "Add Review & Ratings";

$sPageClass     = "addreview_ratings";
$iPageSelect    = 13;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Review & Ratings';
$_SESSION['parent_breadcum_url']= 'review_ratings.php'.$pid;
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sPlaceRating     = isset($_REQUEST['place_rating_rating']) ? mysql_real_escape_string(trim($_REQUEST['place_rating_rating'])) : '';
$sPlaceComment     = isset($_REQUEST['place_rating_comment']) ? mysql_real_escape_string(trim($_REQUEST['place_rating_comment'])) : '';
$iPlaceRatingID           = isset($_REQUEST['place_rating_id']) ? base64_decode($_REQUEST['place_rating_id']) : '';
$iPlaceID           = isset($_REQUEST['place_id']) ? $_REQUEST['place_id'] : '';
$iPending           = isset($_REQUEST['pending']) ? $_REQUEST['pending'] : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){

}//End button click



//UPDATE BUTTON CODE
if($sCommand == 'Update'){
   
    if($sPlaceRating == '') $iProcess = 2;
    elseif($sPlaceComment == '') $iProcess = 2;
	
	if($iProcess == 1){
       
           //UPDATE user
           $sReviewRating = "UPDATE {$prefix}places_rating SET
                            place_rating_rating ='".mysql_real_escape_string($sPlaceRating)."',
							place_rating_comment ='".mysql_real_escape_string($sPlaceComment)."'
							WHERE  place_rating_id=$iPlaceRatingID";
						
            $rReviewRating = mysql_query($sReviewRating) or die("Error:in User updation".mysql_error());
            $iLastInsertID = $iPlaceRatingID;
			$iProcess = 7; 
			
    }//End validation
    
    
}//Update 

//GET USER DETAILS

if($iPlaceRatingID > 0){
    $sTABLE_NAME = $prefix."places_rating";
    $aCatDetails = singleRowDetail('place_rating_rating ,place_rating_comment',$sTABLE_NAME,'place_rating_id',$iPlaceRatingID);
	$sPlaceRating = stripslashes($aCatDetails['place_rating_rating']);
	$sPlaceComment = stripslashes($aCatDetails['place_rating_comment']);
	
} 
if($iPlaceID != ''){
    $str1 = '?plc_id='.$iPlaceID;
}
else if($iPending != ''){
    $str1 = '?pending='.$iPending;
}
else
{
    $str1 = '';
}

switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "Review & Ratings image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "Review & Ratings icon extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "Review & Ratings already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "Review & Ratings successfully added.";
            header("location:review_ratings.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "Review & Ratings successfully updated.";
            header("location:review_ratings.php".$str1);
            die();
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_review_ratings.inc.php");