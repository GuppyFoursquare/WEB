<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : This is subcategory listing page
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");

$sPageTitle  = "Sub categories";
$sPageClass  = "subcategory";
$iPageSelect = 4;
$_SESSION['mid_breadcum']           = "";
$_SESSION['mid_breadcum_url']       = "";
$_SESSION['parent_breadcum']        = 'Categories';
$_SESSION['parent_breadcum_url']    = 'category.php';
$_SESSION['breadcum']               = $sPageTitle;
include("check_menu_session.php");
#INPUT -------------------------------------------------------------------------

#PROCESS -------------------------------------------------------------------------

if (isset($_REQUEST['cat_id'])) $_SESSION['cat_id']= $_REQUEST['cat_id'];
$iCatID = $_SESSION['cat_id'];
$isCancelButtonClicked=isset($_GET['isCancelButtonClicked']) ? $_GET['isCancelButtonClicked'] : 0;

if ($iCatID != '') {
    
    $sCategory = "SELECT cat_name FROM {$prefix}category WHERE cat_id=$iCatID";
    $rCategory = mysql_query($sCategory) or die("Error:in category selection".mysql_error());
    if(mysql_num_rows($rCategory) > 0){
        $opt = mysql_fetch_assoc($rCategory);
        $cat_name = $opt['cat_name'];
        $_SESSION['cat_name']=  $cat_name;
    }    
}
include("templete/subcategory_management.inc.php");
