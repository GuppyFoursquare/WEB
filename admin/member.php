<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 1 Jan 2015
 * @Modified    : 
 * @Description : This is Slider listing page
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");

$sPageTitle  = "Member ";
$sPageClass  = "submember";
$iPageSelect = 1;
$_SESSION['parent_breadcum'] = $sPageTitle;
$_SESSION['mid_breadcum'] = "";
$_SESSION['mid_breadcum_url'] = "";


include("check_menu_session.php");

#INPUT -------------------------------------------------------------------------
//
#PROCESS -----------------------------------------------------------------------

#OUTPUT ------------------------------------------------------------------------
include("templete/member.inc.php");