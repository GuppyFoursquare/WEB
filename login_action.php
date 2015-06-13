<?php   
    include_once("prepend.php");
$_SESSION['is_most_popular'] = 0;
    if(!empty($_POST))
    {
        
        if(isset($_POST['username']) && isset($_POST['password']))
        {
            
            $sQuery="SELECT usr_id,usr_first_name,usr_last_name,usr_dob,usr_username,usr_email,usr_contact,usr_address,usr_city,usr_state,usr_country,usr_zip,usr_profile_picture FROM yb_users WHERE usr_username='".$_POST['username']."' AND usr_password = '".md5($_POST['password'])."' AND usr_user_type='U'";
            $aDetails = mysql_query($sQuery);
            $row=mysql_num_rows($aDetails);
            
            if($row==1)
            {
                $rowArray=mysql_fetch_assoc($aDetails);
                $_SESSION['user_id'] = $rowArray['usr_id'];
                $_SESSION['usr_username'] = $rowArray['usr_username'];
                $_SESSION['usr_first_name'] = $rowArray['usr_first_name'];
                $_SESSION['usr_last_name'] = $rowArray['usr_last_name'];
                $_SESSION['usr_dob'] = $rowArray['usr_dob'];
                $_SESSION['usr_email'] = $rowArray['usr_email'];
                $_SESSION['usr_contact'] = $rowArray['usr_contact'];
                $_SESSION['usr_address'] = $rowArray['usr_address'];
                $_SESSION['usr_city'] = $rowArray['usr_city'];
                $_SESSION['usr_state'] = $rowArray['usr_state'];
                $_SESSION['usr_country'] = $rowArray['usr_country'];
                $_SESSION['usr_zip'] = $rowArray['usr_zip'];
                $_SESSION['usr_profile_picture'] = $rowArray['usr_profile_picture'];
                
                $link_redirect = isset($_POST['redirect_link']) ? 'http://'.$_SERVER['HTTP_HOST'].base64_decode(urldecode($_POST['redirect_link'])) : SITE_PATH.'index.php';
                header('location:'.$link_redirect);
            }
            else
            {
                
                $_SESSION['error_message'] = "Please enter correct username and password.";
                $_SESSION['login_fail'] = 1;
                $link_redirect = isset($_POST['redirect_link']) ? 'http://'.$_SERVER['HTTP_HOST'].base64_decode(urldecode($_POST['redirect_link'])) : SITE_PATH.'index.php';
                header('location:'.$link_redirect);
            }
        }
        else if(isset($_POST['recovery_email']))
        {
            
            $sQuery="SELECT usr_id,usr_first_name,usr_last_name,usr_username,usr_email,usr_contact,usr_address,usr_city,usr_state,usr_country,usr_zip,usr_profile_picture FROM yb_users WHERE usr_email='".mysql_real_escape_string($_POST['recovery_email'])."' AND usr_user_type='U'";
            $aDetails = mysql_query($sQuery);
            $row=mysql_num_rows($aDetails);
            $aDetails = mysql_fetch_array($aDetails);
            
            $md5_str = $aDetails['usr_email'].$aDetails['usr_id'];
            
            if($row == 1)
            {
                //The account details exists...
                //echo md5(mysql_real_escape_string($_POST['recovery_email']));
                $md5_str  = md5($md5_str);
                $sQuery = "UPDATE yb_users SET usr_forget_password_hash = '".$md5_str."' WHERE usr_id = ".$aDetails['usr_id']." LIMIT 1";
                $aDetails = mysql_query($sQuery);
                
                
                $to = $_POST['recovery_email'];
                $subject = "Password Recovery";
                $msg = "Hello, <br/><br/> Please click the link to reset your password : ".SITE_PATH.'reset_password.php?link='.$md5_str.'<br/><br/>Thank you.<br/>Youbaku Support Team.<br/>'.
                        "<a href='http://www.youbaku.az/index.php'> www.youbaku.az</a>";
                $headers = 'MIME-Version: 1.0' . "\r\n".
                           'Content-type: text/html; charset=iso-8859-1' . "\r\n".
                           'From: websites.tester@gmail.com' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

                $mail_sent = mail($to,$subject,$msg,$headers);
                if($mail_sent)
                {
                    $_SESSION['sucess_message'] = "Password reset link has been sent to your email.";
                    header('location:'.SITE_PATH.'index.php');
                }
                else
                {
                    $_SESSION['error_message'] = "Cannot send mail. Check your SMTP server config.";
                    header('location:'.SITE_PATH.'index.php');
                }
                
            }
            else
            {
                $_SESSION['error_message'] = "Account does not exist.";
                $_SESSION['no_account_exists'] = 1;
                header('location:'.SITE_PATH.'index.php');
            }
            
//            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
//            $new_password = substr( str_shuffle( $chars ), 0, 8 );
            
        }
    }
?>
