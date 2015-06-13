<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 dec 2014
 * @Modified    : 
 * @Description : To check session 
********************************************************/

# SETUP -----------------------------------------------------------------------
if(session_id()=='') { session_start(); }

# INPUT -----------------------------------------------------------------------
$iAdminUserID= isset($_SESSION['yb_admin_user']) ? $_SESSION['yb_admin_user'] : 0;

//empty the breadcrumps
$_SESSION['parent_breadcum'] = '';
$_SESSION['parent_breadcum_url'] = '';
$_SESSION['breadcum'] = '';
//this file will check wheather session is set or not
if(!$iAdminUserID){
    header("Location:index.php");
    die;
}

?>