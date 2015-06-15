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
        
    if(isset($_GET['cat_id']))
    {                                
        
        $subCatArr = fetchCategory($obj,$_GET['cat_id']);                 
        echo json_encode(Result::$SUCCESS->setContent($subCatArr));
        
    }else{
        
        $catArr = fetchCategory($obj);          
        echo json_encode(Result::$SUCCESS->setContent($catArr));        
    }        
        
?>
