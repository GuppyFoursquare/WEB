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
$header_title = "YOUBAKU | Registration";
$_SESSION['is_most_popular'] = 0;
if(empty($_POST))
{
    if(isset($_SESSION['user_id']))
    {
        header('location:index.php');
    }
    else
    {
        $countries=mysql_query("SELECT * FROM yb_countrymst WHERE country_is_active = 1 AND  country_is_delete = 0 ORDER BY country_name ASC");
        $states=mysql_query("SELECT * FROM yb_statemst");
        
        $query = "SELECT * FROM yb_content
              WHERE cnt_is_offfmenu = 0 AND 
              cnt_id = 6
              LIMIT 1";
        $content = mysql_query($query);
        $rows = mysql_num_rows($content);
        $content = mysql_fetch_array($content);
        
        include("template/register.php");
    }
}
else
{
    if((!isset($_POST['username']) || !isset($_POST['password'])) && !isset($_POST['recovery_email']))
    {
        
        $sFirstName = isset($_POST['mem_first_name']) ? $_POST['mem_first_name'] : '';
        $sLastName = isset($_POST['mem_last_name']) ? $_POST['mem_last_name'] : '';
        $sdob = isset($_POST['mem_dob']) ? $_POST['mem_dob'] : '';
        $semail = isset($_POST['mem_email']) ? $_POST['mem_email'] : '';
        $sUserName = isset($_POST['mem_user_name']) ? $_POST['mem_user_name'] : '';
        $sPassword = isset($_POST['mem_password']) ? $_POST['mem_password'] : '';
        $sRePassword = isset($_POST['cmem_password']) ? $_POST['cmem_password'] : '';
        $sContact = isset($_POST['mem_mob']) ? $_POST['mem_mob'] : '';
        $sCountry = isset($_POST['ddlCountrySelect']) ? $_POST['ddlCountrySelect'] : '';
        $sState = isset($_POST['ddlStateSelect']) ? $_POST['ddlStateSelect'] : '';
        $sCity = isset($_POST['txtCity']) ? $_POST['txtCity'] : '';
        $sAddress = isset($_POST['txtAddress']) ? $_POST['txtAddress'] : '';
        $sImage_name = isset($_FILES['image1']['name']) ? $_FILES['image1']['name'] : '';

        $sProfileImageTemp = isset($_FILES['image1']['tmp_name']) ? $_FILES['image1']['tmp_name'] : '';
        if($sImage_name != ''){
                    $sFileName = str_replace(" ","_",$sImage_name);
                    $sFileName = str_replace("'","_",$sFileName);
                    $sFileName = $iLastInsertID."_".$sFileName;
                    $sFileName = preg_replace('/[^a-zA-Z0-9_.]/s', '', $sFileName);
                                    if(move_uploaded_file($sProfileImageTemp, PROFILE_IMAGE.$sFileName)){
                        resizeImages($sFileName,PROFILE_IMAGE,100,100);
                                    }
        }

        $sQuery="SELECT * FROM yb_users WHERE (usr_username='".mysql_real_escape_string($sUserName)."' OR usr_email='".mysql_real_escape_string($semail)."') AND usr_user_type='U'";
        $aDetails = mysql_query($sQuery);
        $row=mysql_num_rows($aDetails);

        if($row == 0)
        {

            $query = "INSERT INTO yb_users SET
                usr_first_name = '".mysql_real_escape_string($sFirstName)."',
                usr_last_name = '".mysql_real_escape_string($sLastName)."',
                usr_dob = '".date('Y-m-d',strtotime($sdob))."',
                usr_username = '".mysql_real_escape_string($sUserName)."',
                usr_password = '".(md5($sPassword))."',
                usr_email = '".mysql_real_escape_string($semail)."',
                usr_contact = '".mysql_real_escape_string($sContact)."',
                usr_address = '".mysql_real_escape_string($sAddress)."',
                usr_city = '".mysql_real_escape_string($sCity)."',
                usr_state = ".mysql_real_escape_string($sState).",
                usr_country = ".mysql_real_escape_string($sCountry).",
                usr_profile_picture = '".mysql_real_escape_string($sFileName)."',
                usr_active = 1,
                usr_delete = 0,
                usr_user_type = 'U'

            ";

            $rUser = mysql_query($query) or die("Error:in user selection".mysql_error());
            $iLastInsertID = mysql_insert_id();

            $_SESSION['user_id'] = $iLastInsertID;
            $_SESSION['usr_username'] = mysql_real_escape_string($sUserName);
            $_SESSION['usr_first_name'] = mysql_real_escape_string($sFirstName);
            $_SESSION['usr_last_name'] = mysql_real_escape_string($sLastName);
            $_SESSION['usr_dob'] = mysql_real_escape_string($sdob);
            $_SESSION['usr_email'] = mysql_real_escape_string($semail);
            $_SESSION['usr_contact'] = mysql_real_escape_string($sContact);
            $_SESSION['usr_address'] = mysql_real_escape_string($sAddress);
            $_SESSION['usr_city'] = mysql_real_escape_string($sCity);
            $_SESSION['usr_state'] = mysql_real_escape_string($sState);
            $_SESSION['usr_country'] = mysql_real_escape_string($sCountry);
            $_SESSION['usr_profile_picture'] = mysql_real_escape_string($sFileName);
            
            // Send mail to Youbaku admin regarding new user registration
            
            $to = "Youbaku admin <info@youbaku.com>";
            $subject = "New user registration.";
            $msg = "Hello admin,  <br/><br/> ".
                    "The following user has registered on the website. <br/>The details are as follows.<br/><br/>".
                    "Name: ".mysql_real_escape_string($sFirstName).' '.mysql_real_escape_string($sLastName)."<br/>
                     Email: ".mysql_real_escape_string($semail)."<br/>
                     Contact: ".mysql_real_escape_string($sContact)."<br/>
                     <br/><br/>Thank you.<br/>Youbaku Support Team.<br/>".
                    "<a href=\"http://www.youbaku.com/index.php\"> www.youbaku.com</a>";
            $headers = "MIME-Version: 1.0" . "\r\n".
                       "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                       "From: Youbaku".'<'.mysql_real_escape_string($semail).'>'."\r\n" .
                       "Reply-To:".mysql_real_escape_string($sFirstName).' '.mysql_real_escape_string($sLastName).'<'.mysql_real_escape_string($semail).'>'.' \r\n'. 
                       "X-Mailer: PHP/" . phpversion();

            $mail_sent = mail($to,$subject,$msg,$headers);


            //Mail to the sender acknowledging confirmation of account creation.

            $to = mysql_real_escape_string($semail);
            $subject = "Youbaku - Registration successful.";
            $msg = "Hello ".mysql_real_escape_string($sFirstName).' '.mysql_real_escape_string($sLastName).",  <br/><br/> Thank you for your interest in registering with us. We will get back to you soon.<br/><br/>Thank you.<br/>Youbaku Support Team.<br/>".
                    "<a href=\"http://www.youbaku.az/index.php\"> www.youbaku.az</a>";
            $headers = "MIME-Version: 1.0" . "\r\n".
                       "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                       "From: Youbaku <info@youbaku.com>" . "\r\n" .
                       "Reply-To: Youbaku admin <info@youbaku.com>" . "\r\n" .
                       "X-Mailer: PHP/" . phpversion();

            $mail_sent = mail($to,$subject,$msg,$headers);
            
            
            
            $_SESSION['sucess_message'] = "Account successfully created.";
            header('location:index.php');
        }
        else
        {
            $_SESSION['error_message'] = "Account already exists.";
            $countries=mysql_query("SELECT * FROM yb_countrymst");
            $states=mysql_query("SELECT * FROM yb_statemst");
            include("template/register.php");
            //header('location:register.php');
        }
    }
    else
    {
        $countries=mysql_query("SELECT * FROM yb_countrymst");
        $states=mysql_query("SELECT * FROM yb_statemst");
        include("template/register.php");
    }
}

?>
