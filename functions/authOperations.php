<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 16/06/2015
 * @Modified    : 
 * @Description : This is the general functions for Authentication
********************************************************/
                                  
        
        function authLogin($username , $userpass){
                  
                if($username && $userpass)
                {
                    $sQuery="SELECT usr_id,usr_first_name,usr_last_name,usr_dob,usr_username,usr_email,usr_contact,usr_address,usr_city,usr_state,usr_country,usr_zip,usr_profile_picture FROM yb_users WHERE usr_username='".$username."' AND usr_password = '".md5($userpass)."' AND usr_user_type='U'";
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
                        $_SESSION['token'] = md5(uniqid(mt_rand(), true));                        

                        return Result::$SUCCESS->setContent($_SESSION['token']);                    
                        
                    }else{
                        
                        $_SESSION['error_message'] = "Please enter correct username and password.";
                        $_SESSION['login_fail'] = 1;
                        
                        return Result::$FAILURE_AUTH->setContent($_SESSION['error_message']);
                    }
                                    
                }else{
                    $errorMsg = "Username OR Password parameter mismatch";
                    return Result::$FAILURE_PARAM_MISMATCH->setContent($errorMsg);
                }                
            
        }
        
        /**    
        * @author GUPPY Org. <kskaraca@gmail.com>
        * @param type $d array object
        * @return type
        * @version 1.0 
        * 
        * This function is used for encoding objects to JSON
        * properly.
        */
       function utf8ize($d) {
           if (is_array($d)) {
               foreach ($d as $k => $v) {
                   $d[$k] = utf8ize($v);
               }
           } else if (is_string ($d)) {
               return utf8_encode($d);
           }
           return $d;
       }
    
?>
