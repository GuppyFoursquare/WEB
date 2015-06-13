<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * @Modified    : 
 * @Description : Used to unset all session variables
********************************************************/
# SETUP -----------------------------------------------------------------------
session_start();
//unset the session variables
unset($_SESSION['message']);
unset($_SESSION['yb_admin_user']);
unset($_SESSION['is_active']);
unset($_SESSION['breadcum']);
unset($_SESSION['parent_breadcum']);
unset($_SESSION['parent_breadcum_url']);
unset($_SESSION['sucess_message']);

header("Location:index.php");

?>