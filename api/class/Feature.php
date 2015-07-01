<?php


/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 01/07/2015
 * @Modified    : 
 * @Description : This is the Feature class. 
********************************************************/ 

    

class Feature{
    
        // --- yb_features TABLE VALUES ---
        public $feature_id;
        public $feature_title;
        public $feature_icon;
        public $feature_sequence;
        public $feature_is_active;
        public $feature_is_delete;
        
        
        
        /*******************************************
         ************** CONSTRUCTOR ****************
         ******************************************/
        function __construct() {
            
        } 
        
        
        
        /**
         * 
         * @param type $feature
         * 
         * This method used to get values from mysql_fetch_object's variable
         */
        function setFeatureObjectCoreVariables($feature){
            $this->feature_id           = $feature->feature_id;
            $this->feature_title        = $feature->feature_title;
            $this->feature_icon         = SERVER_FRONT_PATH . FEATURE_ICON . $feature->feature_icon;
            $this->feature_sequence     = $feature->feature_sequence;
            $this->feature_is_active    = $feature->feature_is_active;
            $this->feature_is_delete    = $feature->feature_is_delete;            
        }
    
}

?>

