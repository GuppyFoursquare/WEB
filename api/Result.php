<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Guppy Org.
 * @Maintainer  : Guppy Org.
 * @Created     : 14 jun 2015
 * @Modified    : 
 * @Description : This is the API result object
********************************************************/    

    include './resultConstant.php';

    class Result
    {
        public $status;
        public $code;
        public $result;
        
        function __construct() {
            $status = 'result.guppy.010';
            $code   = $ResultGuppy001;
            $result = null; 
        }
        
        function setStatus($status) { 
            $this->status = $status; 
        }
        function setCode($code) { 
            $this->code = $code; 
        }
        function setResult($result) { 
            $this->result = $result; 
        }
                
        function apiSuccess($resVal){
            $this->status = 'SUCCESS';
            $this->code   = 'result.guppy.010';
            $this->result = $resVal;
        }
        
    }

?>
