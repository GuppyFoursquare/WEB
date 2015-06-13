<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : This page use to add or edit faq
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");
//echo $_REQUEST['step']
$id=$_REQUEST['faq_id'];
if(isset($id))
{
//echo "dd";
$sPageTitle     = "Edit FAQ";
$sPageClass     = "editfaq";

}
else{
//echo "dd";

$sPageTitle     = "Add FAQ";
$sPageClass     = "addfaq";
}

$iPageSelect    = 12;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'FAQ';
$_SESSION['parent_breadcum_url']= 'faq.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sContent     = isset($_REQUEST['content1']) ? (trim($_REQUEST['content1'])) : '';
$sContent_ans     = isset($_REQUEST['content_ans']) ? (trim($_REQUEST['content_ans'])) : '';
$iFaqID           = isset($_REQUEST['faq_id']) ? base64_decode($_REQUEST['faq_id']) : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){
    if($sContent == '') $iProcess = 2;
    elseif($sContent_ans == '') $iProcess = 2;
    
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
     
		//CHECK faq NAME EXIST
        $sTABLE_NAME = $prefix."faq";
        $aDetails = singleRowDetail('faq_id',$sTABLE_NAME,'faq_question',$sCategoryTitle);
        
        if($aDetails == 0){
            
            $sMaxSeq = "SELECT MAX(faq_sequence) as faqSeq FROM {$prefix}faq";
            $rMaxSeq = mysql_query($sMaxSeq) or die("Error:in seq selection".mysql_error()); 
            if(mysql_num_rows($rMaxSeq) > 0){
                $aRow = mysql_fetch_assoc($rMaxSeq);
                $iSequence = $aRow['faqSeq']+1;
            }else $iSequence = 1;
            
            //INSERT faq IN TABLE
           $sFaq = "INSERT INTO {$prefix}faq SET
                            faq_question='".mysql_real_escape_string($sContent)."',
							faq_answer='".mysql_real_escape_string($sContent_ans)."',
                            faq_sequence=$iSequence,
                            faq_created_on=NOW(),
							faq_created_by=1";
							
            $rFaq = mysql_query($sFaq) or die("Error:in FAQ selection".mysql_error());
            //$iLastInsertID = mysql_insert_id();
			$iProcess=6;
		}else{ 
		            $sCatName = $sCategoryTitle;
            $iProcess = 5; 
        }
    }//End validation
}//End button click


//UPDATE BUTTON CODE
if($sCommand == 'Update'){
    
    if($sContent == '') $iProcess = 2;
    elseif($sContent_ans == '') $iProcess = 2;
    
	if($iProcess == 1){
        //CHECK FAQ NAME EXIST
        $sSqlFaq = "SELECT * FROM {$prefix}faq WHERE faq_question='".mysql_real_escape_string($sContent)."' AND faq_id!=$iFaqID";
        $rSqlFaq = mysql_query($sSqlFaq) or die("Error:in category selection".mysql_error());
        if(mysql_num_rows($rSqlFaq) > 0){
            $content = $sContent;
			$content_ans = $sContent_ans;
            $iProcess = 5; 
        }else{
            //UPDATE FAQ
            $sFaq = "UPDATE {$prefix}faq SET
                             faq_question='".mysql_real_escape_string($sContent)."',
							faq_answer='".mysql_real_escape_string($sContent_ans)."',
                            faq_modified_on=NOW(),
							faq_modified_by=1
                            WHERE faq_id=$iFaqID";
            $rFaq = mysql_query($sFaq) or die("Error:in category updation".mysql_error());
           // $iLastInsertID = $iCategoryID;
            $iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 
if($iFaqID>0)
{
    $sTABLE_NAME = $prefix."faq";
    $aCatDetails = singleRowDetail('faq_question,faq_answer',$sTABLE_NAME,'faq_id',$iFaqID);
    $sContent = stripslashes($aCatDetails['faq_question']);
    $content_ans = stripslashes($aCatDetails['faq_answer']);   
}


switch($iProcess){
    
	case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 5:
            $_SESSION['error_message'] = "FAQ already exist.";
        break;
	case 6:
            $_SESSION['sucess_message'] = "FAQ successfully added.";
			header("Location:faq.php?isCancelButtonClicked=1");	
			die();
		 break;	
	case 7:
            $_SESSION['sucess_message'] = "FAQ successfully updated.";
			header("Location:faq.php?isCancelButtonClicked=1");	
			die();
		 break;		 
    
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_faq.inc.php");