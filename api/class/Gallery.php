<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 25/06/2015
 * @Modified    : 
 * @Description : This is the Gallery class that contains
 *      > media properties of gallerys. For example images,
 *      > videos...
********************************************************/ 

    

class Gallery{
    
        // --- THIS VALUES SAME WITH yb_gallerys TABLE ---       
        public $plc_gallery_media;
        public $plc_gallery_is_video;
        public $plc_gallery_seq;
        public $plc_is_cover_image;
        public $plc_gallery_is_active;
    
        /*******************************************
         ************** CONSTRUCTOR ****************
         ******************************************/
        function __construct() {
            
        } 
        
        
        /**
         * 
         * @param type $gallery
         * 
         * This method used to get values from mysql_fetch_object's variable
         */
        function setPlaceObjectCoreVariables($gallery){
            $this->plc_gallery_media = $gallery->plc_gallery_media;                        
            $this->plc_gallery_is_video = $gallery->plc_gallery_is_video;
            $this->plc_gallery_seq = $gallery->plc_gallery_seq;            
            $this->plc_is_cover_image = $gallery->plc_is_cover_image;
            $this->plc_gallery_is_active = $gallery->plc_gallery_is_active;
        }
    
}

?>
