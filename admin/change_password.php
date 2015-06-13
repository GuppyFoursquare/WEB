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

$sPageTitle  = "Change Password";
$sPageClass  = "subchnagepassword";

$_SESSION['parent_breadcum'] = $sPageTitle;
$_SESSION['mid_breadcum'] = "";
$_SESSION['mid_breadcum_url'] = "";

#INPUT -------------------------------------------------------------------------
$sCommand           = isset($_REQUEST['step']) ? $_REQUEST['step'] : '';
$iUserID=$_SESSION['yb_admin_user'];
$sUserOldPassword     = isset($_REQUEST['usr_old_password']) ? mysql_real_escape_string(trim($_REQUEST['usr_old_password'])) : '';
$sUserNewPassword     = isset($_REQUEST['usr_password']) ? mysql_real_escape_string(trim($_REQUEST['usr_password'])) : '';


$userId           = isset($_REQUEST['usr_id']) ? base64_decode($_REQUEST['usr_id']) : '';
$p           = isset($_REQUEST['p']) ? $_REQUEST['p'] : '';
$cancelUrl = "dashboard.php?isCancelButtonClicked=1";

if($userId > 0){
    $iUserID = $userId;
    if($p == "sub"){
    $iPageSelect = 8;
    $_SESSION['parent_breadcum'] = "Sub Admin";
    $_SESSION['parent_breadcum_url'] = "users.php";
    $_SESSION['mid_breadcum'] = $sPageTitle;
    $_SESSION['mid_breadcum_url'] = "";
    $cancelUrl = "users.php?isCancelButtonClicked=1";
    }
    else{
        $iPageSelect = 1;
        $_SESSION['parent_breadcum'] = "Member";
        $_SESSION['parent_breadcum_url'] = "member.php";
        $_SESSION['mid_breadcum'] = $sPageTitle;
        $_SESSION['mid_breadcum_url'] = "";
        $cancelUrl = "member.php?isCancelButtonClicked=1";
    }
}
$sUsername = '';
if($userId){
    $sSQL   = "SELECT u.usr_id,u.usr_username FROM {$prefix}users as u
                WHERE u.usr_id='$userId' ";
        $sDetails = mysql_query($sSQL) or die("Error: in login".mysql_error());
        if(mysql_num_rows($sDetails) > 0){
            $row = mysql_fetch_assoc($sDetails);
            $sUsername = $row['usr_username'];
        }
}

//Change password Only When User Login

if($sCommand=="AdminUpdate")
{
        $sSQL   = "SELECT u.usr_id FROM {$prefix}users as u
                WHERE u.usr_id='$iUserID' AND u.usr_password='".md5($sUserOldPassword)."'";
        $rLogin = mysql_query($sSQL) or die("Error: in login".mysql_error());
        if(mysql_num_rows($rLogin) > 0){
                    $sUser = "UPDATE {$prefix}users SET
        usr_password='".mysql_real_escape_string(md5($sUserNewPassword))."'
                                    WHERE  usr_id=$iUserID";
                    $rUser = mysql_query($sUser) or die("Error:in User updation".mysql_error());
                    $_SESSION['sucess_message'] = "Password successfully updated.";
        }
        else{
            $_SESSION['error_message'] = "Old Password Not Valid.";
        }
}
elseif($sCommand == "UserUpdate")
{
        $sUser = "UPDATE {$prefix}users SET
                    usr_password='".mysql_real_escape_string(md5($sUserNewPassword))."'
                    WHERE  usr_id=$iUserID";
                $rUser = mysql_query($sUser) or die("Error:in User updation".mysql_error());
                $_SESSION['sucess_message'] = "Password successfully updated.";
                if($p == "sub"){
                    header("location:users.php");
                    die();
                }
                else{
                    header("location:member.php");
                    die();
                }
}

#OUTPUT ------------------------------------------------------------------------
include("templete/change_password.php");