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
$id=$_REQUEST['country_id'];
if(isset($id))
{
//echo "dd";
$sPageTitle     = "Edit Country";
$sPageClass     = "editcountry";

}
else{
//echo "dd";

$sPageTitle     = "Add Country";
$sPageClass     = "addcountry";
}

$iPageSelect    = 2;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Country';
$_SESSION['parent_breadcum_url']= 'country_management.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sCountry_abbr     = isset($_REQUEST['country_abbr']) ? (trim($_REQUEST['country_abbr'])) : '';
$sCountry_name     = isset($_REQUEST['country_name']) ? (trim($_REQUEST['country_name'])) : '';
$iCountryID           = isset($_REQUEST['country_id']) ? base64_decode($_REQUEST['country_id']) : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){
    if($sCountry_abbr == '') $iProcess = 2;
    elseif($sCountry_name == '') $iProcess = 2;
    
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
     
		//CHECK country NAME EXIST
        $sCategoryTitle = $sCountry_name;
        $sTABLE_NAME = $prefix."countrymst";
        $aDetails = singleRowDetail('country_id',$sTABLE_NAME,'country_name',$sCategoryTitle);
        
        if($aDetails == 0){
            
//            $sMaxSeq = "SELECT MAX(faq_sequence) as faqSeq FROM {$prefix}faq";
//            $rMaxSeq = mysql_query($sMaxSeq) or die("Error:in seq selection".mysql_error()); 
//            if(mysql_num_rows($rMaxSeq) > 0){
//                $aRow = mysql_fetch_assoc($rMaxSeq);
//                $iSequence = $aRow['faqSeq']+1;
//            }else $iSequence = 1;
            
            //INSERT faq IN TABLE
           $sFaq = "INSERT INTO {$prefix}countrymst SET
                            country_abbr='".mysql_real_escape_string($sCountry_abbr)."',
                            country_name='".mysql_real_escape_string($sCountry_name)."',
                            country_is_active=1,
                            country_is_delete=0";
							
            $rFaq = mysql_query($sFaq) or die("Error:in country selection".mysql_error());
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
    
    if($sCountry_abbr == '') $iProcess = 2;
    elseif($sCountry_name == '') $iProcess = 2;
    
	if($iProcess == 1){
        //CHECK country NAME EXIST
        $sSqlFaq = "SELECT * FROM {$prefix}countrymst WHERE country_name='".mysql_real_escape_string($sCountry_name)."' AND country_id!=$iCountryID";
        $rSqlFaq = mysql_query($sSqlFaq) or die("Error:in category selection".mysql_error());
        if(mysql_num_rows($rSqlFaq) > 0){
            $content = $sCountry_abbr;
            $content_ans = $sCountry_name;
            $iProcess = 5; 
        }else{
            //UPDATE FAQ
            $sFaq = "UPDATE {$prefix}countrymst SET
                            country_abbr='".mysql_real_escape_string($sCountry_abbr)."',
                            country_name='".mysql_real_escape_string($sCountry_name)."' 
                            WHERE country_id=$iCountryID";
            $rFaq = mysql_query($sFaq) or die("Error:in category updation".mysql_error());
           // $iLastInsertID = $iCategoryID;
            $iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 
if($iCountryID>0)
{
    $sTABLE_NAME = $prefix."countrymst";
    $aCatDetails = singleRowDetail('country_id,country_name,country_abbr',$sTABLE_NAME,'country_id',$iCountryID);
    $sCountry_name = stripslashes($aCatDetails['country_name']);
    $sCountry_abbr = stripslashes($aCatDetails['country_abbr']);   
}


switch($iProcess){
    
	case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 5:
            $_SESSION['error_message'] = "Country already exist.";
        break;
	case 6:
            $_SESSION['sucess_message'] = "Country successfully added.";
			header("Location:country_management.php?isCancelButtonClicked=1");	
			die();
		 break;	
	case 7:
            $_SESSION['sucess_message'] = "Country successfully updated.";
			header("Location:country_management.php?isCancelButtonClicked=1");	
			die();
		 break;		 
    
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_country.inc.php");