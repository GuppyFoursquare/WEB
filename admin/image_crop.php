<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : PHN.
 * @Maintainer  : PHN.
 * @Created     : 2/09/2014
 * @Modified    :
 * @Description : Image crop functionality
********************************************************/

# SETUP -----------------------------------------------------------------------
include("check_session.php");
include("prepend.php");
//error_reporting(E_ALL);
# INPUT -----------------------------------------------------------------------
$page_title = 'Crop Image';

$redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
$iset = isset($_REQUEST['iset']) ? $_REQUEST['iset'] : '0';
if($redirect_to!='')
	 $_SESSION['redirect_to']=$redirect_to;

 $plcId = isset($_SESSION['admin_insert_image']) ? $_SESSION['admin_insert_image'] : array();

 if($iset=='1')
 {
     $_SESSION['admin_insert_image'] ="";
    if($_SESSION['redirect_to'] == 'add_edit_places' ){
        //@header("location:places.php?isCancelButtonClicked=1");
        @header("location:manage_photo.php?id=".$plcId);
    }
    if($_SESSION['redirect_to'] == 'manage_photo' ){
        @header("location:manage_photo.php?id=".$_SESSION['id']);
    }
 }
 
 $sImageName = $_SESSION['crop_image'];


# PROCESSING ------------------------------------------------------------------
if($_SESSION['redirect_to'] == 'add_edit_places' )
include('templete/image_crop.php');
else
include('templete/image_crop_places_large.php');
?>