<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : A.D.
 * @Maintainer  : A.D.
 * @Created     : 02 feb 2015
 * @Modified    : 
 * @Description : This is the reset password page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
    include("prepend.php");
    //error_reporting(E_ALL);
    $header_title = "YOUBAKU | Reset Password";
    $_SESSION['is_most_popular'] = 0;
    if(!empty($_POST))
    {
        $user_id = $_POST['usr_id'];
        $pass = $_POST['reset_password'];
        $new_pass = $_POST['reset_password_confirm'];
        
        $compare_pass = strcmp($pass,$new_pass);
        if($compare_pass == 0)
        {
            $sQuery = "UPDATE yb_users SET usr_password = '".md5($_POST['reset_password'])."' WHERE usr_id = ".$user_id." LIMIT 1";
            $aDetails = mysql_query($sQuery);
            $_SESSION['sucess_message'] = "Password has been successfully reset.";
            header('location:index.php');
        }
        else
        {
            $_SESSION['error_message'] = "Passwords do not match.";
            header('location:'.$_SERVER['REQUEST_URI']);
        }
    }
    else
    {
        if(isset($_REQUEST['link']))
        {
            $hash_link = $_REQUEST['link'];
            $sQuery="SELECT usr_id,usr_first_name,usr_last_name,usr_username,usr_email,usr_contact,usr_address,usr_city,usr_state,usr_country,usr_zip,usr_profile_picture FROM yb_users WHERE usr_forget_password_hash='".$hash_link."' AND usr_user_type='U'";
            $aDetails = mysql_query($sQuery);
            $row=mysql_num_rows($aDetails);
            $aDetails = mysql_fetch_array($aDetails);

            if($row == 1)
            {
                $usr_id = $aDetails['usr_id'];
                include("template/update_password.php");
            }
            else
            {
                $_SESSION['error_message'] = "Account does not exist.";
                header('location:index.php');
            }
        }
        else 
        {

            $_SESSION['error_message'] = "Account does not exist.";
            //include("template/update_password.php");
            header('location:index.php');

        }
    }
    
?>
