<?php

    include("./prepend.php");     

    $param_op           = isset($_GET['op']) ? $_GET['op'] : null;     
    $param_name         = isset($_GET['name']) ? $_GET['name'] : null;
    $param_pass         = isset($_GET['pass']) ? $_GET['pass'] : null;
        
    
    $result = Result::$SUCCESS;
    
    if($param_op){
        if(strcmp(strtolower($param_op),"login")==0){                        
            
            session_id("123");
            @session_start();
                  
            $_SESSION['name'] = "kemalsamikaracax";
            
            $result = Result::$SUCCESS->setContent("name value :: " . $_SESSION['name'] . " " . session_id());            
            
            
//            $array = array("session" => session_id());
//            $result = Result::$SUCCESS->setContent($array);
            
        }else if(strcmp(strtolower($param_op),"check")==0){
            
            session_id("124");
            @session_start();
            
            $result = Result::$SUCCESS->setContent("name value :: " . $_SESSION['name'] . " " . session_id());
            
        }else{
            session_id("123");
            @session_start();            
            $result = Result::$SUCCESS->setContent("name value :: " . $_SESSION['name'] . " " . session_id());
                        
        }
    }
            
    
    header('Cookie: PHPSESSID='.session_id());
    
    echo json_encode($result, JSON_HEX_QUOT|JSON_HEX_TAG);    
?>
