<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 07 Jan 2015
 * @Modified    : 
 * @Description : This is Places listing page
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");

$sPageTitle  = "Places";
$sPageClass  = "places";
$iPageSelect = 6;
$_SESSION['parent_breadcum'] = $sPageTitle;
$_SESSION['mid_breadcum'] = "";
$_SESSION['mid_breadcum_url'] = "";
include("check_menu_session.php");
#INPUT -------------------------------------------------------------------------

$sCommand       = isset($_REQUEST['command']) ? $_REQUEST['command'] : '';
$aOrder         = isset($_REQUEST['chorder']) && !empty ($_REQUEST['chorder']) ? $_REQUEST['chorder'] : array();
$aFeatureID    = isset($_REQUEST['id']) && !empty ($_REQUEST['id']) ? $_REQUEST['id'] : array();


#PROCESS -----------------------------------------------------------------------

if(isset($_GET['set_order'])){
    $_SESSION['set_session']=1;
}else{
    $_SESSION['set_session']=0;
}


#OUTPUT ------------------------------------------------------------------------
include("templete/places.inc.php");