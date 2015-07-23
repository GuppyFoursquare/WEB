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
        
        
        
        
        // -------------- -------------- EDIT PART -------------- --------------
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
        // -------------- -------------- EDIT PART -------------- --------------
        
        
        
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
