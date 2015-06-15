<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Guppy Org.
 * @Maintainer  : Guppy Org.
 * @Created     : 14 jun 2015
 * @Modified    : 
 * @Description : This is the API result object
********************************************************/    

    include './ResourceBundle.php';

    class Result
    {
        public static $SUCCESS;
        public static $SUCCESS_EMPTY;
        
        public $status;
        public $code;
        public $content;
        
        /*******************************************
         ************** CONSTRUCTOR ****************
         ******************************************/
        function __construct($code,$status) {
            $this->status = $status; 
            $this->code = $code; 
        }                
        
        static function initializeStaticObjects(){
            Result::$SUCCESS            = new Result(ResultGuppy001Code , ResultGuppy001Status);
            Result::$SUCCESS_EMPTY      = new Result(ResultGuppy010Code , ResultGuppy010Status);
        }
        
        function setStatus($status) { 
            $this->status = $status; 
        }
        function setCode($code) { 
            $this->code = $code; 
        }
        
        function setContent($content){
            $resultObj = new Result($this->code, $this->status);
            $resultObj->content = $content;
            return $resultObj;
        }
        
        
        /*
        function apiSuccess($resVal){
            $this->status = ResultGuppy001Status;
            $this->code   = ResultGuppy001Code;
            $this->content = $resVal;
        }
         */
        
    }

?>
