<?php

    
    $token = isset($_GET['token']) ? $_GET['token'] : null;
    if($token){
        session_id($token);
    }           
        
    @session_start();  
    
    $result = "TOKEN gets successfully with id " . session_id();
    
    session_destroy();
    
    $result .= "<br> SESSION DELETED";
    
    echo $result;
    
    

?>
