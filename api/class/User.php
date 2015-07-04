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
    
}

?>

