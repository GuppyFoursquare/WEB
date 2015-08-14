<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 16/06/2015
 * @Modified    : 02/07/2015
 * @Description : This is the general functions for Authentication
********************************************************/
                       

        // -------------- -------------- LOGIN PART -------------- --------------
        function authLoginJson($jsonData){
            
            if(array_key_exists('name',$jsonData) && array_key_exists('pass',$jsonData)){                
                return authLogin($jsonData['name'] , $jsonData['pass']);                
            }
                    
            return Result::$FAILURE_PARAM_MISMATCH->setContent("Login JSON - Username OR Password parameter mismatch ");            
        }
        // -------------- -------------- LOGIN PART -------------- --------------
        
        
        // -------------- -------------- LOGIN PART -------------- --------------
        function authLogin($username , $userpass){
              
                try{                                    
                    
                    if($username && $userpass){                        
                        
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
                            
                            $res = array(                                
                                "usr_username" => $_SESSION['usr_username'],
                                "usr_email" => $_SESSION['usr_email']
                                );
                            
                            //INSERT TOKEN AND APIKEY TO TABLE
                            $apiKeyInsertQuery="INSERT INTO yb_api_keys (api_token, api_key, api_client_agent,api_user_id) VALUES ('". session_id() ."', '". $_SESSION['apikey'] ."', 'mobile' , '" . $_SESSION['user_id'] . "')";
                            $aResult = mysql_query($apiKeyInsertQuery);
                            if (!$aResult) {
                                return Result::$FAILURE_MYSQL_INSERT->setContent("Login apikey&token insert error");
                            }                            
                            
                            return Result::$SUCCESS->setContent($res); 

                        }else{

                            $_SESSION['error_message'] = "Please enter correct username and password.";
                            $_SESSION['login_fail'] = 1;

                            return Result::$FAILURE_AUTH->setContent($_SESSION['error_message']);
                        }

                    }else{
                        $errorMsg = "Username OR Password parameter mismatch - authOperations";
                        return Result::$FAILURE_PARAM_MISMATCH->setContent($errorMsg);
                    }
                    
                } catch (Exception $ex) {                    
                    return Result::$FAILURE_EXCEPTION->setContent($ex);
                }            
        }
        // -------------- -------------- LOGIN PART -------------- --------------
        
        
        
        
        
        
        
        
        
        
        // -------------- -------------- REGISTER PART -------------- --------------
        function authRegister($jsonData){
            
            
            $sFirstName = array_key_exists('mem_first_name',$jsonData) ? $jsonData['mem_first_name'] : '';
            $sLastName = array_key_exists('mem_last_name',$jsonData) ? $jsonData['mem_last_name'] : '';
            $sdob = array_key_exists('mem_dob',$jsonData) ? $jsonData['mem_dob'] : '';
            $semail = array_key_exists('mem_email',$jsonData) ? $jsonData['mem_email'] : '';
            $sUserName = array_key_exists('mem_user_name',$jsonData) ? $jsonData['mem_user_name'] : '';
            $sPassword = array_key_exists('mem_password',$jsonData) ? $jsonData['mem_password'] : '';
            $sRePassword = array_key_exists('cmem_password',$jsonData) ? $jsonData['cmem_password'] : '';
            $sContact = array_key_exists('mem_mob',$jsonData) ? $jsonData['mem_mob'] : '';
            $sCountry = array_key_exists('ddlCountrySelect',$jsonData) ? $jsonData['ddlCountrySelect'] : '';
            $sState = array_key_exists('ddlStateSelect',$jsonData) ? $jsonData['ddlStateSelect'] : '';
            $sCity = array_key_exists('txtCity',$jsonData) ? $jsonData['txtCity'] : '';
            $sAddress = array_key_exists('txtAddress',$jsonData) ? $jsonData['txtAddress'] : '';            
                                    
            
            $sImage_name = isset($_FILES['image1']['name']) ? $_FILES['image1']['name'] : '';
            
            
                    
            return Result::$SUCCESS_EMPTY;
        }
        // -------------- -------------- REGISTER PART -------------- --------------
        
        
        
        
        
        
        
        
        
        
        // -------------- -------------- COMMENT PART -------------- --------------
        function commentAdd($jsonData){                                                                   
                   
                if($jsonData)
                {                                           
                    if(isset($_SESSION['user_id'])){
                                                                        
                        $place_id   = array_key_exists('plc_id',$jsonData) ? $jsonData['plc_id'] : null;
                        $message    = array_key_exists('message',$jsonData) ? $jsonData['message'] : null; 
                        $score      = array_key_exists('score',$jsonData) ? $jsonData['score'] : null;                         
                        $user_id    = $_SESSION['user_id'];                        
                                                                        
                        $query = "SELECT place_rating_id from yb_places_rating WHERE plc_id = ".$place_id." AND places_rating_by = ".$user_id;
                        $aDetails = mysql_query($query);
                        $row=mysql_num_rows($aDetails);

                        // --GUPPY COMMENT IMPORTANT--
                        // Score check will be added
                        
                        if($row > 0){
                            
                            return Result::$FAILURE_COMMENT_MULTIPLE->setContent("Review already added.");  
                            
                        }else{                            
                            
                            $time = date('Y/m/d G:i:s ', time());
                            $query = "INSERT INTO yb_places_rating SET
                                plc_id = '".($place_id)."',
                                places_rating_by = '".($user_id)."',
                                place_rating_rating = '".($score)."',
                                place_rating_comment = '".mysql_real_escape_string($message)."',
                                places_rating_created_date = '".$time."',
                                places_rating_is_active = 0
                            ";

                            $rUser = mysql_query($query) or die("Error:in review insertion".mysql_error());
                            $iLastInsertID = mysql_insert_id();
                                                        
                            return $iLastInsertID ?
                                        Result::$SUCCESS->setContent("Review added successfully.") : 
                                        Result::$FAILURE_MYSQL_INSERT->setContent("Failed to add review");                                 
                        }

                    }else
                    {                        
                        return Result::$FAILURE_AUTH->setContent("Please login to add rating.");  
                    }
                    
                }else
                {
                    return Result::$FAILURE_PERMISSION->setContent("GET Operation not allowed");  
                }
                            
        }
        // -------------- -------------- COMMENT PART -------------- --------------
        
        
        
        
        
        
        
        
        
        // -------------- -------------- COMMENT PART -------------- --------------
        function sendBookingRequest($jsonData){                                                                   
                   
                if($jsonData)
                {                                      
                    
                    
                    if(!$_SESSION['usr_email'] || !$_SESSION['usr_username'] || !$_SESSION['usr_first_name'] || !$_SESSION['usr_last_name']){
                        // GET USER INFO FROM DB
                        return Result::$FAILURE_AUTH->setContent("MISSING SESSION PARAMETERS");  
                    }
                    
                    if(isset($_SESSION['user_id'])){
                                   
                        $plc_id             = array_key_exists('plc_id',$jsonData) ? $jsonData['plc_id'] : null;
                        $book_comer_count   = array_key_exists('book_comer_number',$jsonData) ? $jsonData['book_comer_number'] : null;
                        $book_date          = array_key_exists('book_date',$jsonData) ? $jsonData['book_date'] : null; 
                        $book_time          = array_key_exists('book_time',$jsonData) ? $jsonData['book_time'] : null; 
                        $book_contact       = array_key_exists('book_contact',$jsonData) ? $jsonData['book_contact'] : null; 
                        $book_detail        = array_key_exists('book_detail',$jsonData) ? $jsonData['book_detail'] : null; 
                        
                        if(!$plc_id){
                            return Result::$FAILURE_PARAM_MISMATCH->setContent("Place id have to be given");  
                        }else if(!$book_comer_count){
                            return Result::$FAILURE_PARAM_MISMATCH->setContent("Comer count have to be given");  
                        }else if(!$book_date){
                            return Result::$FAILURE_PARAM_MISMATCH->setContent("Reservation date have to be given");  
                        }else if(!$book_time){
                            return Result::$FAILURE_PARAM_MISMATCH->setContent("Reservation time have to be given");  
                        }else if(!$book_contact){
                            return Result::$FAILURE_PARAM_MISMATCH->setContent("Contact number have to be given");  
                        }else if(!$book_detail){
                            return Result::$FAILURE_PARAM_MISMATCH->setContent("Detail have to be given");  
                        }
                        
                        
                        // GET place mail address
                        $query = "SELECT * FROM yb_places WHERE plc_id = ".$plc_id;
                        $aDetails = mysql_query($query);
                        $row=mysql_num_rows($aDetails);
                        
                        if($row == 1){
                            
                            $rowArray=mysql_fetch_assoc($aDetails);
                            $place_mail=$rowArray['plc_email'];
                            $place_name=$rowArray['plc_name'];
                            
                            
                            
                            // Send mail to Youbaku admin regarding new user registration            
                            $to = "Youbaku admin <info@youbaku.com>";
                            $subject = "User booking request ";
                            $msg = "Hello admin,  <br/><br/> ".
                                    "The following user has used reservation system on mobile device. <br/>The details are as follows.<br/><br/>".
                                    "Name: ". $_SESSION['usr_first_name'] .' '. $_SESSION['usr_last_name'] ."<br/>
                                     Email: ". $_SESSION['usr_email'] ."<br/>
                                     Contact: ". $book_contact ."<br/>
                                     <br/><br/>Thank you.<br/>Youbaku Support Team.<br/>".
                                    "<a href=\"http://www.youbaku.com/index.php\"> www.youbaku.com</a>";
                            $headers = "MIME-Version: 1.0" . "\r\n".
                                       "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                                       "From: Youbaku".'<'. $_SESSION['usr_email'] .'>'."\r\n" .
                                       "X-Mailer: PHP/" . phpversion();

                            $mail_sent_youbaku = mail($to,$subject,$msg,$headers);
                            
                            
                            
                            //Mail to the sender acknowledging confirmation of reservation.    
                            $to = mysql_real_escape_string($place_mail);
                            $subject = "Youbaku - Reservation Request.";
                            $msg = "Hello " . $place_name . ",  " . 
                                    "<br/><br/> Reservation request successfully done. Thank you.<br/>Youbaku Support Team.<br/>".
                                    "<a href=\"http://www.youbaku.az/index.php\"> www.youbaku.az</a>";
                            $headers = "MIME-Version: 1.0" . "\r\n".
                                       "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                                       "From: Youbaku <info@youbaku.com>" . "\r\n" .
                                       "Reply-To: Youbaku admin <info@youbaku.com>" . "\r\n" .
                                       "X-Mailer: PHP/" . phpversion();

                            $mail_sent_restaurant = mail($to,$subject,$msg,$headers);
                            
                            
                            
                            //Mail to the sender acknowledging about of reservation.    
                            $to = mysql_real_escape_string($_SESSION['usr_email']);
                            $subject = "Youbaku - Reservation successful.";
                            $msg = "Hello " . $_SESSION['usr_first_name'] . ",  <br/><br/> Reservation request's details are as follows. <br/><br/>".
                                    "Name: ". $_SESSION['usr_first_name'] .' '. $_SESSION['usr_last_name'] ."<br/>
                                        Email: ". $_SESSION['usr_email'] ."<br/>
                                        Contact: ". $book_contact ."<br/>
                                        Date: ". $book_date . " - " . $book_time . "<br/>
                                        Person Count: ". $book_comer_count . "<br/>    
                                        Detail: ". $book_detail . "<br/>".
                                    "Thank you.<br/>Youbaku Support Team.<br/>".
                                    "<a href=\"http://www.youbaku.az/index.php\"> www.youbaku.az</a>";
                            $headers = "MIME-Version: 1.0" . "\r\n".
                                       "Content-type: text/html; charset=iso-8859-1" . "\r\n".
                                       "From: Youbaku <info@youbaku.com>" . "\r\n" .
                                       "Reply-To: Youbaku admin <info@youbaku.com>" . "\r\n" .
                                       "X-Mailer: PHP/" . phpversion();

                            $mail_sent_user = mail($to,$subject,$msg,$headers);
                          
                            
                            return Result::$SUCCESS->setContent("Successful Reservation");
                            
                        }else{                            
                            
                            return Result::$FAILURE_COMMENT_MULTIPLE->setContent("Mysql ERROR");  
                            
                        }
                        
                        
                        return Result::$SUCCESS_EMPTY->setContent("");
                        

                    }else{                        
                        
                        return Result::$FAILURE_AUTH->setContent("Please login to add rating.");  
                    }
                    
                }else
                {
                    return Result::$FAILURE_PARAM_MISMATCH->setContent("Parameter mismatch");  
                }
                            
        }
        // -------------- -------------- COMMENT PART -------------- --------------
        
        
        
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
