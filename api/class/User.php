<?php


/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 01/07/2015
 * @Modified    : 
 * @Description : This is the User class. 
********************************************************/ 

    

class User{
    
        // --- yb_users TABLE VALUES ---
        public $usr_id;
        public $usr_first_name;
        public $usr_last_name;
        public $usr_dob;
        public $usr_username;
        public $usr_password;
        public $usr_email;
        public $usr_contact;
        public $usr_address;
        public $usr_city;
        public $usr_state;
        public $usr_country;
        public $usr_zip;
        public $usr_profile_picture;
        public $usr_active;
        public $usr_delete;
        public $usr_forget_password_hash;
        public $usr_user_type;
        public $usr_created_by;
        public $usr_created_date;
        public $usr_modified_by;
        
        /*******************************************
         ************** CONSTRUCTOR ****************
         ******************************************/
        function __construct() {
            
        }         
        
        
        /**
         * 
         * @param type $user
         * 
         * This method used to get values from mysql_fetch_object's variable
         */
        function setFeatureObjectCoreVariables($user){
            $this->usr_id               = $user->usr_id;            
        }
        
        
        function getUserInfoFromSession(){
            $this->usr_username         = isset($_SESSION['usr_username']) ? $_SESSION['usr_username'] : '';
            $this->usr_first_name       = isset($_SESSION['usr_first_name']) ? $_SESSION['usr_first_name'] : '';
            $this->usr_last_name        = isset($_SESSION['usr_last_name']) ? $_SESSION['usr_last_name'] : '';
            $this->usr_email            = isset($_SESSION['usr_email']) ? $_SESSION['usr_email'] : '';
            $this->usr_profile_picture  = isset($_SESSION['usr_profile_picture']) ? $_SESSION['usr_profile_picture'] : '';
            $this->usr_country          = isset($_SESSION['usr_country']) ? $_SESSION['usr_country'] : '';
            $this->usr_address          = isset($_SESSION['usr_address']) ? $_SESSION['usr_address'] : '';
            $this->usr_country          = isset($_SESSION['usr_country']) ? $_SESSION['usr_country'] : '';
            $this->usr_profile_picture  = isset($_SESSION['usr_profile_picture']) ? $_SESSION['usr_profile_picture'] : '';
        }
    
}

?>

