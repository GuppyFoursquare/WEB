<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Kemal Sami KARACA
 * @Created     : 23/07/2015 
 * 
 * @Modified    : Guppy Org.
 * @Programmer  : Kemal Sami KARACA
 * @ModifiedDate: 23/07/2015 
 * @Description : This file use include all required files for API
********************************************************/    

    error_reporting(E_ALL);
    
    //----- SETUP TIMEZONE -----//
    date_default_timezone_set("Europe/Berlin");


    //----- INCLUDE RESULT OBJECT -----//
    require_once("api/Result.php");    
    //----- INITIALIZE RESULT OBJECT -----//
    Result::initializeStaticObjects();    
    
    //----- GET API KEY FOR API CALL -----//
    $token = isset($_GET['token']) ? $_GET['token'] : null;
    if($token){
        session_id($token);
    }           
        
    @session_start();        
    
    
    //----- INCLUDE CONNECTION FILE -----//
    require_once("includes/connection.inc.php");
    require_once("includes/db.php");
    $obj = new db();
    
    
    //----- APIKEY ISSUE -----//
    // check apikey exist
    // check session apikey and request apikey equal
    // IF NOT destroy SESSION    
    $req_apikey = isset($_GET['apikey']) ? $_GET['apikey'] : null;    
    $ses_apikey = isset($_SESSION['apikey']) ? $_SESSION['apikey'] : null ;
    if(!$req_apikey || !$ses_apikey || strcmp($req_apikey,$ses_apikey)!=0){        
        
        if($req_apikey && $token){
            $apiQuery="SELECT * FROM yb_api_keys WHERE api_token = '".$token."' AND api_key = '".$req_apikey."'";            
            $qRes = mysql_query($apiQuery);
            $rowCount=mysql_num_rows($qRes);
                        
            //UPDATE 
            if($rowCount==1)
            {
                $rowArray=mysql_fetch_assoc($qRes);
                $_SESSION['apikey'] = $rowArray['api_key'];                                                                
                
                $sQuery="SELECT usr_id,usr_first_name,usr_last_name,usr_dob,usr_username,usr_email,usr_contact,usr_address,usr_city,usr_state,usr_country,usr_zip,usr_profile_picture FROM yb_users WHERE usr_id='".$rowArray['api_user_id']."' AND usr_user_type='U'";
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
                
                }else{
                    echo json_encode(Result::$FAILURE_AUTH->setContent("User " . $rowArray['api_user_id'] . " cannot find "));
                    // secure close connections will be added
                    mysql_close();
                    die;
                }      
                
            }else{
                echo json_encode(Result::$FAILURE_PERMISSION->setContent("prependAPI SELECT result row count!=1 "));
                // secure close connections will be added
                mysql_close();
                die;
            }
            
        }else{
            echo json_encode(Result::$FAILURE_PERMISSION->setContent("apikey OR token missing"));
            // secure close connections will be added
            mysql_close();
            die; 
        }  
        
    }
            
?>
