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

$sPageTitle  = "Content";
$sPageClass  = "content";
$iPageSelect = 14;
$_SESSION['parent_breadcum'] = $sPageTitle;
$_SESSION['mid_breadcum'] = "";
$_SESSION['mid_breadcum_url'] = "";
include("check_menu_session.php");
#INPUT -------------------------------------------------------------------------

$sCommand       = isset($_REQUEST['command']) ? $_REQUEST['command'] : '';
$aOrder         = isset($_REQUEST['chorder']) && !empty ($_REQUEST['chorder']) ? $_REQUEST['chorder'] : array();
$aFaqID    = isset($_REQUEST['id']) && !empty($_REQUEST['id']) ? $_REQUEST['id'] : array();


#PROCESS -----------------------------------------------------------------------




#OUTPUT ------------------------------------------------------------------------
include("templete/content.inc.php");