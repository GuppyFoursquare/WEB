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
        public static $FAILURE_AUTH;
        public static $FAILURE_PARAM_MISMATCH;
        public static $FAILURE_EXCEPTION;
        public static $FAILURE_PERMISSION;
        public static $FAILURE_MYSQL_INSERT;        
        public static $FAILURE_COMMENT_MULTIPLE;
                
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
            Result::$SUCCESS                    = Result::$SUCCESS ? Result::$SUCCESS->setContent(null) : new Result(ResultGuppy001Code , ResultGuppy001Status);
            Result::$SUCCESS_EMPTY              = Result::$SUCCESS_EMPTY ? Result::$SUCCESS_EMPTY->setContent(null) : new Result(ResultGuppy010Code , ResultGuppy010Status);
            Result::$FAILURE_AUTH               = Result::$FAILURE_AUTH ? Result::$FAILURE_AUTH->setContent(null) : new Result(ResultGuppy101Code , ResultGuppy101Status);
            Result::$FAILURE_PARAM_MISMATCH     = Result::$FAILURE_PARAM_MISMATCH ? Result::$FAILURE_PARAM_MISMATCH->setContent(null) : new Result(ResultGuppy511Code , ResultGuppy511Status);
            Result::$FAILURE_EXCEPTION          = Result::$FAILURE_EXCEPTION ? Result::$FAILURE_EXCEPTION->setContent(null) : new Result(ResultGuppy521Code , ResultGuppy521Status);
            Result::$FAILURE_PERMISSION         = Result::$FAILURE_PERMISSION ? Result::$FAILURE_PERMISSION->setContent(null) : new Result(ResultGuppy531Code , ResultGuppy531Status);
            Result::$FAILURE_MYSQL_INSERT       = Result::$FAILURE_MYSQL_INSERT ? Result::$FAILURE_MYSQL_INSERT->setContent(null) : new Result('result.guppy.551' , 'FAILURE_MYSQL_INSERT');            
            Result::$FAILURE_COMMENT_MULTIPLE   = Result::$FAILURE_COMMENT_MULTIPLE ? Result::$FAILURE_COMMENT_MULTIPLE->setContent(null) : new Result('result.guppy.611' , 'FAILURE_COMMENT_MULTIPLE');
        }
        
        
        function getContent(){
            return $this->content;
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
                       
        function checkResult($res){
            if(!is_null($res)){
                return (strcmp($this->code, $res->code)==0);
            }else{
                return false;
            }
        }
        
        /**
         * 
         * @param type $obj
         * @return type
         * 
         * This function removes null values from object
         */
        static function object_unset_nulls($obj)
        {            
            $arrObj = is_object($obj) ? get_object_vars($obj) : $obj;
            foreach($arrObj as $key => $val)
            {
                $val = (is_array($val) || is_object($val)) ? Result::object_unset_nulls($val) : $val;
                if (is_array($obj))
                    $obj[$key] = $val;
                else
                    $obj->$key = $val;
                if($val == null)
                    unset($obj->$key);
            }
            return $obj;
        }                
        
    }

?>
