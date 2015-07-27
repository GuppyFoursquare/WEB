<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 14/06/2015
 * @Modified    : 02/07/2015
 * @Description : This is the category API
********************************************************/    
   
    include_once("../prependAPI.php");
    include("../functions/authOperations.php");     
    include_once("class/User.php");
    
    
    try{
        
        $param_op           = isset($_GET['op']) ? $_GET['op'] : null;
        $param_name         = isset($_GET['name']) ? $_GET['name'] : null;
        $param_pass         = isset($_GET['pass']) ? $_GET['pass'] : null;        
        $op                 = isset($_POST['op']) ? $_POST['op'] : '';
        $result             = Result::$SUCCESS_EMPTY;
        $resultError        = "";

        // --- Content-type :: application/json ---
        $jsondata           = json_decode(file_get_contents('php://input'), true);

        
        
        
        // To get file data content-type should be multipart/form-data 
        // THIS PART WILL BE USED FOR REGISTER
        if (strpos(getallheaders()['Content-Type'],'multipart/form-data') !== false){
            
            $sFirstName = isset($_POST['mem_first_name']) ? $_POST['mem_first_name'] : null;
            $sLastName = isset($_POST['mem_last_name']) ? $_POST['mem_last_name'] : null;
            $sdob = isset($_POST['mem_dob']) ? $_POST['mem_dob'] : null;
            
            $result = $sFirstName . " - " . $sLastName . " - " . $sdob;
        }else {
            $result = "goy goy";
        }
        
        
        if($param_op){                

            if(strcmp(strtolower($param_op),"login")==0){

                if($jsondata){

                    $result = authLoginJson($jsondata);

                }else{                

                    $resultError = "Username OR Userpass parameter mismatch";
                    $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
                }

            }else if(strcmp(strtolower($param_op),"comment")==0){

                // --GUPPY COMMENT IMPORTANT-- 
                // session will be created here                       
                $result = commentAdd($jsondata);                        

            }else{
                $resultError = "Login API - Operation parameter mismatch";
                $result = Result::$FAILURE_PARAM_MISMATCH->setContent($resultError);
            }

        
        }else if($jsondata){
            
            if(array_key_exists('op',$jsondata)){
                
                if(strcmp(strtolower($jsondata['op']),"login")==0){  
                    $result = authLoginJson($jsondata);
                    
                }else if(strcmp(strtolower($jsondata['op']),"register")==0){

                    $sFirstName         = $jsondata['mem_first_name'] ? $jsondata['mem_first_name'] : null;
                    $sLastName          = $jsondata['mem_last_name'] ? $jsondata['mem_last_name'] : null; 
                    $sUserName          = $jsondata['mem_user_name'] ? $jsondata['mem_user_name'] : null; 
                    $sPassword          = $jsondata['mem_password'] ? $jsondata['mem_password'] : null; 
                    $sRePassword        = $jsondata['cmem_password'] ? $jsondata['cmem_password'] : null;
                    $semail             = $jsondata['mem_email'] ? $jsondata['mem_email'] : null; 

                    if($sFirstName && $sLastName && $sUserName && $sPassword && $sRePassword && $semail){

                        $result = "all parameter get perfect";
                        if(strcmp($sPassword,$sRePassword)==0){

                            $sQuery="SELECT * FROM yb_users WHERE (usr_username='".mysql_real_escape_string($sUserName)."' OR usr_email='".mysql_real_escape_string($semail)."') AND usr_user_type='U'";
                            $aDetails = mysql_query($sQuery);
                            $row=mysql_num_rows($aDetails);

                            if($row == 0)
                            {

                                $query = "INSERT INTO yb_users SET
                                    usr_first_name = '".mysql_real_escape_string($sFirstName)."',
                                    usr_last_name = '".mysql_real_escape_string($sLastName)."',
                                    usr_dob = '',
                                    usr_username = '".mysql_real_escape_string($sUserName)."',
                                    usr_password = '".(md5($sPassword))."',
                                    usr_email = '".mysql_real_escape_string($semail)."',
                                    usr_contact = '',
                                    usr_address = '',
                                    usr_city = '',
                                    usr_state = '',
                                    usr_country = '',
                                    usr_profile_picture = '',
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
                                $_SESSION['usr_email'] = mysql_real_escape_string($semail);


                                $to = "Youbaku admin <info@youbaku.com>";
                                $subject = "New user registration.";
                                $msg = "Hello admin,  <br/><br/> ".
                                        "The following user has registered on the website. <br/>The details are as follows.<br/><br/>".
                                        "Name: ".mysql_real_escape_string($sFirstName).' '.mysql_real_escape_string($sLastName)."<br/>
                                         Email: ".mysql_real_escape_string($semail)."<br/>
                                         Contact: <br/>
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


                                $user = new User();
                                $user->getUserInfoFromSession();
                                $result = Result::$SUCCESS->setContent($user);                            

                            }else if($row == 1){
                                $result = Result::$SUCCESS_EMPTY->setContent("case-2.1.2-");
                            }else if($row > 1){
                                $result = Result::$SUCCESS_EMPTY->setContent("case-2.1.3-");
                            }else{
                                $result = Result::$SUCCESS_EMPTY->setContent("case-2.1.1-");
                            }                        
                        }else{
                            $result = Result::$SUCCESS_EMPTY->setContent("case-3.1-");
                        }

                    }else{
                        $result = Result::$FAILURE_PARAM_MISMATCH->setContent("miising parameter error");
                    }
                        

                }else if(strcmp(strtolower($jsondata['op']),"info")==0){                

                    $user = new User();
                    $user->getUserInfoFromSession();
                    $result = Result::$SUCCESS->setContent($user);
                    
                }else{
                    $result = Result::$FAILURE_PARAM_MISMATCH->setContent("op parameter mismatch");                    
                }                    
                
                
            }
            
        }               
        
        
    } catch (Exception $ex) {

        echo json_encode(Result::$FAILURE_EXCEPTION->setContent("API->auth exception"));
        
    } 
    
    
        // --- removing null values ---
        $result = Result::object_unset_nulls($result);

        // --- return result ---
        echo json_encode($result, JSON_HEX_QUOT|JSON_HEX_TAG); 
    
        //----- CONNECTION CLOSE -----//
        mysql_close();
    
?>
