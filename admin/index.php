<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * @Modified    : 
 * @Description : This is the index page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
session_start();
include("prepend.php");

$iAdminUserID= isset($_SESSION['yb_admin_user']) ? $_SESSION['yb_admin_user'] : 0;
//this file will check wheather session is set or not
if($iAdminUserID){
    header("Location:dashboard.php");
    die;
}

$iProceed = 1;
$sPageTitle = "Login";

# INPUT ------------------------------------------------------------------------
$sCommand       = isset($_REQUEST['btnSubmit']) ? $_REQUEST['btnSubmit'] : '';
$sUserName      = isset($_REQUEST['txtUsername']) ? trim($_REQUEST['txtUsername']) : '';
$sPassword      = isset($_REQUEST['txtPassword']) ? trim($_REQUEST['txtPassword']) : '';

# PROCESS ----------------------------------------------------------------------

if($sCommand == 'Login'){
    
    //Validation
    if(empty($sUserName)){
        $iProceed = 0;
    }elseif(empty($sPassword)){
        $iProceed = 0;
    }
    
    if($iProceed == 1){
      $sSQL   = "SELECT u.usr_id FROM {$prefix}users as u
                    WHERE u.usr_username='$sUserName' AND u.usr_password='".md5($sPassword)."' AND (u.usr_user_type = 'A' OR u.usr_user_type = 'Sub-Admin')";
        $rLogin = mysql_query($sSQL) or die("Error: in login".mysql_error());
        if(mysql_num_rows($rLogin) > 0){
            $aRow = mysql_fetch_assoc($rLogin);
            $_SESSION['yb_admin_user'] = $aRow['usr_id'];
            header("location:dashboard.php");
            die();
        }else $msg = "Please enter correct login details.";
    }else $msg = "Please enter login details.";
    
}

include("templete/index.inc.php");

?>
