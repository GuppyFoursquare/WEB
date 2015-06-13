<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : This page use to add or edit countries
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");
//echo $_REQUEST['step']
$id=$_REQUEST['state_id'];
if(isset($id))
{
//echo "dd";
$sPageTitle     = "Edit State";
$sPageClass     = "editstate";

}
else{
//echo "dd";

$sPageTitle     = "Add State";
$sPageClass     = "addstate";
}

$iPageSelect    = 3;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'State';
$_SESSION['parent_breadcum_url']= 'state_management.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sCountry_id     = isset($_REQUEST['state_country_id']) ? ($_REQUEST['state_country_id']) : '';
$sState_abbr     = isset($_REQUEST['state_abbr']) ? (trim($_REQUEST['state_abbr'])) : '';
$sState_name     = isset($_REQUEST['state_name']) ? (trim($_REQUEST['state_name'])) : '';
$iStateID           = isset($_REQUEST['state_id']) ? base64_decode($_REQUEST['state_id']) : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){
    if($sState_abbr == '') $iProcess = 2;
    elseif($sState_name == '') $iProcess = 2;
    
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
     
		//CHECK country NAME EXIST
        $sCategoryTitle = $sState_name;
        $sTABLE_NAME = $prefix."statemst";
        $aDetails = singleRowDetail('state_id',$sTABLE_NAME,'state_name',$sCategoryTitle);
        
        if($aDetails == 0){
            
//            $sMaxSeq = "SELECT MAX(faq_sequence) as faqSeq FROM {$prefix}faq";
//            $rMaxSeq = mysql_query($sMaxSeq) or die("Error:in seq selection".mysql_error()); 
//            if(mysql_num_rows($rMaxSeq) > 0){
//                $aRow = mysql_fetch_assoc($rMaxSeq);
//                $iSequence = $aRow['faqSeq']+1;
//            }else $iSequence = 1;
            
            //INSERT faq IN TABLE
           $sFaq = "INSERT INTO {$prefix}statemst SET
                            state_abbr='".mysql_real_escape_string($sState_abbr)."',
                            state_name='".mysql_real_escape_string($sState_name)."',
                            state_country_id = ".$sCountry_id.",
                            state_is_active=1,
                            state_is_delete=0";
							
            $rFaq = mysql_query($sFaq) or die("Error:in state selection".mysql_error());
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
    
    if($sState_abbr == '') $iProcess = 2;
    elseif($sState_name == '') $iProcess = 2;
    
	if($iProcess == 1){
        //CHECK country NAME EXIST
        $sSqlFaq = "SELECT * FROM {$prefix}statemst WHERE state_name='".mysql_real_escape_string($sState_name)."' AND state_id!=$iStateID";
        $rSqlFaq = mysql_query($sSqlFaq) or die("Error:in category selection".mysql_error());
        if(mysql_num_rows($rSqlFaq) > 0){
            $content = $sState_abbr;
            $content_ans = $sState_name;
            $iProcess = 5; 
        }else{
            //UPDATE FAQ
            $sFaq = "UPDATE {$prefix}statemst SET
                            state_abbr='".mysql_real_escape_string($sState_abbr)."',
                            state_name='".mysql_real_escape_string($sState_name)."',
                            state_country_id = ".$sCountry_id."
                            WHERE state_id=$iStateID";
            $rFaq = mysql_query($sFaq) or die("Error:in category updation".mysql_error());
           // $iLastInsertID = $iCategoryID;
            $iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 
$country_data = array();
$query_country = "SELECT * FROM yb_countrymst WHERE country_is_active = 1 AND  	country_is_delete = 0 ORDER BY country_name ASC";
$result_country = mysql_query( $query_country) or die(mysql_error());

if($iStateID>0)
{
    $sTABLE_NAME = $prefix."statemst";
    $aCatDetails = singleRowDetail('state_country_id,state_name,state_abbr',$sTABLE_NAME,'state_id',$iStateID);
    $sState_name = stripslashes($aCatDetails['state_name']);
    $sState_abbr = stripslashes($aCatDetails['state_abbr']);
    $iState_country_id = $aCatDetails['state_country_id'];
    
}


switch($iProcess){
    
	case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 5:
            $_SESSION['error_message'] = "State already exist.";
        break;
	case 6:
            $_SESSION['sucess_message'] = "State successfully added.";
			header("Location:state_management.php?isCancelButtonClicked=1");	
			die();
		 break;	
	case 7:
            $_SESSION['sucess_message'] = "State successfully updated.";
			header("Location:state_management.php?isCancelButtonClicked=1");	
			die();
		 break;		 
    
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_state.inc.php");