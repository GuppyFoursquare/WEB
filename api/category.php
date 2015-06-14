<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Guppy Org.
 * @Maintainer  : Guppy Org.
 * @Created     : 14/06/2015
 * @Modified    : 
 * @Description : This is the category API
********************************************************/    
   
    include("../prepend.php");    
    error_reporting(E_ALL);
        
    if(isset($_GET['category']))
    {         
        
        $api->setResult($_GET['category']);
//        $api->apiSuccess("asd");
//        $apiResponse = json_encode($api);
        
    }else{
        $catArr = fetchCategory($obj);                       
        $api->apiSuccess($catArr);        
    }        
        
    echo json_encode($api);
?>
