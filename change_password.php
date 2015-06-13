<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the index page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
include("prepend.php");
$_SESSION['is_most_popular'] = 0;
$header_title = "YOUBAKU | Change Password";
$editclass = "loginact";
if(empty($_POST))
{
    if(!isset($_SESSION['user_id']))
    {
        header('location:'.SITE_PATH.'index.php');
    }
    else
    {
        include("template/change_password.php");
    }
}
else
{
    if(!isset($_SESSION['user_id']))
    {
        header('location:'.SITE_PATH.'index.php');
    }
    else
    {
        if(isset($_POST['mem_password']) && isset($_POST['cmem_password']) )
        {
            $compare_str = strcmp($_POST['mem_password'], $_POST['cmem_password']);
            if($compare_str == 0)
            {
                
                $sQuery = "UPDATE yb_users SET
                usr_password = '".md5($_POST['mem_password'])."'
                WHERE usr_id = ".$_SESSION['user_id'];
                
                $aDetails = mysql_query($sQuery);
                
                
                $_SESSION['sucess_message'] = "Password has been successfully reset.";
                header('location:'.SITE_PATH.'index.php');
            }
            else
            {
                $_SESSION['error_message'] = "The passwords entered do not match.";
                header('location:'.$_SERVER['REQUEST_URI']);
            }
        }
        else
        {
            $_SESSION['error_message'] = "Please enter password.";
            header('location:'.$_SERVER['REQUEST_URI']);
        }
    }
}

?>
