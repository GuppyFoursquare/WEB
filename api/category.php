<?php

/******************** PAGE DETAILS ********************/
/* @Programmer  : Guppy Org.
 * @Maintainer  : Guppy Org.
 * @Created     : 14/06/2015
 * @Modified    : 
 * @Description : This is the category API
********************************************************/    
   
    require_once("../prependAPI.php"); 
    require_once("../admin/include/function.php");
    
    try{
        
        if(isset($_GET['cat_id']))
        {                                
            $subCatArr = fetchCategory($obj,$_GET['cat_id']);                 
            echo json_encode(Result::$SUCCESS->setContent($subCatArr));

        }else{

            $catArr = fetchCategory($obj);          
            echo json_encode(Result::$SUCCESS->setContent($catArr));
        } 
        
    } catch (Exception $ex) {

        echo json_encode(Result::$FAILURE_EXCEPTION->setContent("API->category exception"));
        
    } finally {
        //----- CONNECTION CLOSE -----//
        mysql_close();
    }
        
?>
