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

if($_REQUEST['news_id'] != '') $sPageTitle     = "Edit News & Specials";
else $sPageTitle     = "Add News & Specials";

$sPageClass     = "addnewsspecials";
$iPageSelect    = 7;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'News & Specials';
$_SESSION['parent_breadcum_url']= 'news_specials.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sNewsTitle     = isset($_REQUEST['news_title']) ? (trim($_REQUEST['news_title'])) : '';
$sNewsPageUrl     = isset($_REQUEST['news_page_url']) ? (trim($_REQUEST['news_page_url'])) : '';
$sNewsMetaKeyword     = isset($_REQUEST['news_meta_keyword']) ? (trim($_REQUEST['news_meta_keyword'])) : '';
$sNewsMetaDescription     = isset($_REQUEST['news_meta_description']) ? (trim($_REQUEST['news_meta_description'])) : '';
$content_ans     = isset($_REQUEST['content_ans']) ? (trim($_REQUEST['content_ans'])) : '';
$iNewsID           = isset($_REQUEST['news_id']) ? base64_decode($_REQUEST['news_id']) : '';
$sNewsImage     = isset($_FILES['txtNewsImage']['name']) ? $_FILES['txtNewsImage']['name'] : '';
$sNewsImage = preg_replace('/[^A-Za-z0-9\-.]/', '', $sNewsImage);
$sNewsImageTemp = isset($_FILES['txtNewsImage']['tmp_name']) ? $_FILES['txtNewsImage']['tmp_name'] : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){

if($sNewsTitle == '') $iProcess = 2;
    elseif($sNewsPageUrl == '') $iProcess = 2;
	elseif($sNewsMetaKeyword == '') $iProcess = 2;
	elseif($sNewsMetaDescription == '') $iProcess = 2;
	elseif($content_ans == '') $iProcess = 2;
	elseif($sNewsImage == '') $iProcess = 2;
    
    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        $chkext = pathinfo($sNewsImage,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($sNewsImage!= '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
	
	
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
        
        //CHECK NEWS NAME EXIST
        $sTABLE_NAME = $prefix."news";
        $aDetails = singleRowDetail('news_id',$sTABLE_NAME,'news_page_url',$sNewsPageUrl);
        
        if($aDetails == 0){
           //INSERT NEWS IN TABLE
          $sNews = "INSERT INTO {$prefix}news SET
                            news_title='".mysql_real_escape_string($sNewsTitle)."',
							news_description='".mysql_real_escape_string($content_ans)."',
							news_meta_keyword='".mysql_real_escape_string($sNewsMetaKeyword)."',
							news_meta_description='".mysql_real_escape_string($sNewsMetaDescription)."',
							news_page_url='".mysql_real_escape_string($sNewsPageUrl)."',
							news_created_on='".date("Y-m-d")."',
							news_created_by=".$_SESSION['yb_admin_user']."
							";
            $rNews = mysql_query($sNews) or die("Error:in news selection".mysql_error());
            $iLastInsertID = mysql_insert_id();
			
            ### UPLOAD NEWS IMAGE ###
            if($sNewsImage != ''){
                $sFileName = str_replace(" ","_",$sNewsImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                    if(move_uploaded_file($sNewsImageTemp, "../".NEWS_IMAGE.$sFileName)){
                    //resizeImages($sFileName,"../".NEWS_IMAGE,165,165);
                    $file_for_dimention = SET_UPLOAD_PATH.NEWS_IMAGE .$sFileName;
                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                    if($dwidth == 160 || $dheight == 160)
                    {
                        // nothing to do
                    }
                    elseif($dwidth <= 160 || $dheight <= 160)
                    {
                        $w = 160;
                        $h = 160;
                        resizeImageProperSave($file_for_dimention, $w, $h,'exact',SET_UPLOAD_PATH.NEWS_IMAGE);
                    }else{

                        $w = 160;
                        $h = 160;
                        //resizeImageProperSave($file_for_dimention, $w, $h,'maxheight',SET_UPLOAD_PATH.NEWS_IMAGE);

                        $w = 160;
                        $h = 160;
                        resizeImageProperSave(SET_UPLOAD_PATH.NEWS_IMAGE.$sFileName, $w, $h,'maxwidth',SET_UPLOAD_PATH.NEWS_IMAGE);
                    }
                    mysql_query("UPDATE {$prefix}news SET news_photo='$sFileName' WHERE news_id=$iLastInsertID") or die("Error:In news image update".mysql_error());
                }
            }
			
			$iProcess = 6; 
        }else{ 
            $sNewsImage="";
            $iProcess = 5; 
        }
    }//End validation
}//End button click



//UPDATE BUTTON CODE
if($sCommand == 'Update'){
   
    if($sNewsTitle == '') $iProcess = 2;
    elseif($sNewsPageUrl == '') $iProcess = 2;
	elseif($sNewsMetaKeyword == '') $iProcess = 2;
	elseif($sNewsMetaDescription == '') $iProcess = 2;
	elseif($content_ans == '') $iProcess = 2;
	
	
	
	//VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        $chkext = pathinfo($sNewsImage,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($sNewsImage!= '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
   
   
    if($iProcess == 1){
        //CHECK NEWS TITLE EXIST
		$sSqlNews = "SELECT * FROM {$prefix}news WHERE news_page_url='".$sNewsPageUrl."' AND  	news_id!=$iNewsID";
        $rSqlNews = mysql_query($sSqlNews) or die("Error:in News selection".mysql_error());
        if(mysql_num_rows($rSqlNews) > 0){
            $iProcess = 5; 
        }else{
            //UPDATE News
            $sNews = "UPDATE {$prefix}news SET
                            news_title='".mysql_real_escape_string($sNewsTitle)."',
                            news_description='".mysql_real_escape_string($content_ans)."',
                            news_meta_keyword='".mysql_real_escape_string($sNewsMetaKeyword)."',
                            news_meta_description='".mysql_real_escape_string($sNewsMetaDescription)."',
                            news_page_url='".mysql_real_escape_string($sNewsPageUrl)."',
                            news_modified_on='".date("Y-m-d")."',
                            news_modified_by=".$_SESSION['yb_admin_user']."
                            WHERE  news_id=$iNewsID";
            //echo $sNews;die;
            $rNews = mysql_query($sNews) or die("Error:in News updation".mysql_error());
            $iLastInsertID = $iNewsID;
           // echo $sSliderImage;
            ### UPLOAD NEWS IMAGE ###
            if($sNewsImage!= ''){
                $sFileName = str_replace(" ","_",$sNewsImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                if(move_uploaded_file($sNewsImageTemp, "../".NEWS_IMAGE.$sFileName)){
                    //resizeImages($sFileName,"../".NEWS_IMAGE,160,160);
                    //resizeImageProperSave("../".NEWS_IMAGE.$sFileName, 160,160,$type='maxwidth',"../".NEWS_IMAGE.$sFileName);
                    $file_for_dimention = SET_UPLOAD_PATH.NEWS_IMAGE .$sFileName;
                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                    if($dwidth == 160 || $dheight == 160)
                    {
                        // nothing to do
                    }
                    elseif($dwidth <= 160 || $dheight <= 160)
                    {
                        $w = 160;
                        $h = 160;
                        resizeImageProperSave($file_for_dimention, $w, $h,'exact',SET_UPLOAD_PATH.NEWS_IMAGE);
                    }else{

                        $w = 160;
                        $h = 160;
                        //resizeImageProperSave($file_for_dimention, $w, $h,'maxheight',SET_UPLOAD_PATH.NEWS_IMAGE);

                        $w = 160;
                        $h = 160;
                        resizeImageProperSave(SET_UPLOAD_PATH.NEWS_IMAGE.$sFileName, $w, $h,'maxwidth',SET_UPLOAD_PATH.NEWS_IMAGE);
                    }
                    mysql_query("UPDATE {$prefix}news SET news_photo='$sFileName' WHERE news_id=$iLastInsertID") or die("Error:In news image update".mysql_error());
                }
            }

		   
            $iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 

//GET USER DETAILS

if($iNewsID > 0){
    $sTABLE_NAME = $prefix."news";
    $aCatDetails = singleRowDetail('news_photo,news_title,news_description,news_meta_keyword,news_meta_description,news_page_url',$sTABLE_NAME,'news_id',$iNewsID);
	$sNewsTitle     = stripslashes($aCatDetails['news_title']);
	$sNewsPageUrl     = stripslashes($aCatDetails['news_page_url']);
	$sNewsMetaKeyword     = stripslashes($aCatDetails['news_meta_keyword']);
	$sNewsMetaDescription     = stripslashes($aCatDetails['news_meta_description']);
	$content_ans     = stripslashes($aCatDetails['news_description']);
	
	$sNewsImage     = stripslashes($aCatDetails['news_photo']);
	
} 


switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "News image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "News image extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "News url already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "News successfully added.";
            header("location:news_specials.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "News successfully updated.";
            header("location:news_specials.php");
            die();
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_news_specials.inc.php");