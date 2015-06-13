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

if($_REQUEST['cnt_id'] != '') $sPageTitle     = "Edit Content";
else $sPageTitle     = "Add Content";

if($_REQUEST['cnt_id'] == ''){
    header("location:content.php");
}

$sPageClass     = "addtermsandconditions";
$iPageSelect    = 14;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Content';
$_SESSION['parent_breadcum_url']= 'content.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sPageHeading     = isset($_REQUEST['cnt_page_heading']) ? (trim($_REQUEST['cnt_page_heading'])) : '';
$sPageUrl     = isset($_REQUEST['cnt_url_name']) ? (trim($_REQUEST['cnt_url_name'])) : '';
$sBrowserTitle	= isset($_REQUEST['cnt_browser_title']) ? (trim($_REQUEST['cnt_browser_title'])) : '';
$sPageMetaKeyword     = isset($_REQUEST['cnt_keywords']) ? (trim($_REQUEST['cnt_keywords'])) : '';
$sPageMetaDescription     = isset($_REQUEST['cnt_meta_description']) ? (trim($_REQUEST['cnt_meta_description'])) : '';
$content_ans     = isset($_REQUEST['content_ans']) ? (trim($_REQUEST['content_ans'])) : '';
$iCntID           = isset($_REQUEST['cnt_id']) ? base64_decode($_REQUEST['cnt_id']) : '';
#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){

if($sPageHeading == '') $iProcess = 2;
    elseif($sPageUrl == '') $iProcess = 2;
	elseif($sBrowserTitle == '') $iProcess = 2;
	elseif($sPageMetaKeyword == '') $iProcess = 2;
	elseif($sPageMetaDescription == '') $iProcess = 2;
	elseif($content_ans == '') $iProcess = 2;
    
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
        
        //CHECK  NAME EXIST
        $sTABLE_NAME = $prefix."content";
        $aDetails = singleRowDetail('cnt_id',$sTABLE_NAME,'cnt_url_name',$sPageUrl);
        
        if($aDetails == 0){
           //INSERT NEWS IN TABLE
          $sCnt = "INSERT INTO {$prefix}content SET
                            cnt_page_heading='".($sPageHeading)."',
							cnt_browser_title='".mysql_real_escape_string($sBrowserTitle)."',
							cnt_is_offfmenu=1,
							cnt_content='".mysql_real_escape_string($content_ans)."',
							cnt_keywords='".mysql_real_escape_string($sPageMetaKeyword)."',
							cnt_meta_description='".mysql_real_escape_string($sPageMetaDescription)."',
							cnt_url_name='".($sPageUrl)."',
							cnt_created_on='".date("Y-m-d")."',
							cnt_created_by=".$_SESSION['yb_admin_user']."
							";
					
            $rCnt = mysql_query($sCnt) or die("Error:in Content selection".mysql_error());
            $iLastInsertID = mysql_insert_id();
			$iProcess = 6; 
        }else{ 
            
            $iProcess = 5; 
        }
    }//End validation
}//End button click



//UPDATE BUTTON CODE
if($sCommand == 'Update'){
   
    if($sPageHeading == '') $iProcess = 2;
    elseif($sPageUrl == '') $iProcess = 2;
	elseif($sBrowserTitle == '') $iProcess = 2;
	elseif($sPageMetaKeyword == '') $iProcess = 2;
	elseif($sPageMetaDescription == '') $iProcess = 2;
	elseif($content_ans == '') $iProcess = 2;
	
    if($iProcess == 1){
        //CHECK PAGE TITLE EXIST 
        $sSqlCnt = "SELECT * FROM {$prefix}content WHERE cnt_url_name='".$sPageUrl."' AND cnt_id!=$iCntID";
        $rSqlCnt = mysql_query($sSqlCnt) or die("Error:in Content selection".mysql_error());
        if(mysql_num_rows($rSqlCnt) > 0){
            $iProcess = 5;
        }else{
            //UPDATE Content
            $sCnt = "UPDATE {$prefix}content SET
                           cnt_page_heading='".($sPageHeading)."',
							cnt_browser_title='".mysql_real_escape_string($sBrowserTitle)."',
							cnt_is_offfmenu=0,
							cnt_content='".mysql_real_escape_string($content_ans)."',
							cnt_keywords='".mysql_real_escape_string($sPageMetaKeyword)."',
							cnt_meta_description='".mysql_real_escape_string($sPageMetaDescription)."',
							cnt_url_name='".($sPageUrl)."',
							cnt_modified_on='".date("Y-m-d")."',
							cnt_modified_by=".$_SESSION['yb_admin_user']."
							WHERE  cnt_id=$iCntID";
				
		   $rCnt = mysql_query($sCnt) or die("Error:in Content updation".mysql_error());
            $iLastInsertID = $iCntID;
          
			$iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 

//GET USER DETAILS

if($iCntID > 0){
    $sTABLE_NAME = $prefix."content";
    $aCatDetails = singleRowDetail('cnt_content,cnt_browser_title,cnt_page_heading,cnt_url_name,cnt_meta_description,cnt_keywords',$sTABLE_NAME,'cnt_id',$iCntID);
	$sPageHeading     = stripslashes($aCatDetails['cnt_page_heading']);
	$sPageUrl     = stripslashes($aCatDetails['cnt_url_name']);
	$sBrowserTitle     = stripslashes($aCatDetails['cnt_browser_title']);
	$sPageMetaKeyword     = stripslashes($aCatDetails['cnt_keywords']);
	$sPageMetaDescription     = stripslashes($aCatDetails['cnt_keywords']);
	$content_ans     = stripslashes($aCatDetails['cnt_content']);
	
} 
$sPageHeading     = stripslashes($sPageHeading);
	$sPageUrl     = stripslashes($sPageUrl);
	$sBrowserTitle     = stripslashes($sBrowserTitle);
	$sPageMetaKeyword     = stripslashes($sPageMetaKeyword);
	$sPageMetaDescription     = stripslashes($sPageMetaDescription);
	$content_ans     = stripslashes($content_ans);

switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "Content extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "Content extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "Content url already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "Content successfully added.";
            header("location:content.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "Content successfully updated.";
            header("location:content.php");
            die();
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_content.inc.php");