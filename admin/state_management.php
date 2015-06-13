<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : This is faq listing page
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");

$sPageTitle  = "States";
$sPageClass  = "states";
$iPageSelect = 3;
$_SESSION['parent_breadcum'] = $sPageTitle;
$_SESSION['mid_breadcum'] = "";
$_SESSION['mid_breadcum_url'] = "";
include("check_menu_session.php");
#INPUT -------------------------------------------------------------------------

$sCommand       = isset($_REQUEST['command']) ? $_REQUEST['command'] : '';
$aOrder         = isset($_REQUEST['chorder']) && !empty ($_REQUEST['chorder']) ? $_REQUEST['chorder'] : array();
$aFaqID    = isset($_REQUEST['id']) && !empty($_REQUEST['id']) ? $_REQUEST['id'] : array();


#PROCESS -----------------------------------------------------------------------

//SAVE CATEGORY ORDER
if($sCommand == 'save_order'){
    $aResult = array_combine($aFaqID, $aOrder);
    foreach ($aResult as $key => $value) { 
        $sUpdSeq = "UPDATE {$prefix}faq SET
                    faq_sequence=$value
                    WHERE faq_id=$key";
        $rUpdSeq = mysql_query($sUpdSeq) or die("Error:in sequence updation".mysql_error());
    }
    $_SESSION['sucess_message'] = "FAQ sequence updated successfully.";
    header("location:faq.php?isCancelButtonClicked=1".$query_string);
    die;
}

if(isset($_GET['set_order'])){
    $_SESSION['set_session']=1;
}else{
    $_SESSION['set_session']=0;
}


#OUTPUT ------------------------------------------------------------------------
include("templete/state_management.inc.php");