<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the index page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
include("prepend.php");
error_reporting(E_ALL);
$searchText = (isset($_GET['sr']) ? mysql_real_escape_string($_GET['sr']) : '');
$chbExactSearch = (isset($_GET['chbexactsearch']) ? 1 : 0);

    $formData = array();
    $catArr = fetchCategory($obj);    
    $formData['pCat'] = $catArr;
    //$obj->printResult($formData['pCat']);
    if(isset($_SESSION['is_most_popular']))
    {
        if($_SESSION['is_most_popular'] == 1)
        {
            $header_title = "YOUBAKU | Most Popular";
            $class_name = "popularact";
            $search2act = "";
        }
        else
        {
            $header_title = "YOUBAKU | Places List";
            $class_name = "";
            $search2act = "search2act";
        }
        
    }
    else
    {
        $header_title = "YOUBAKU | Places List";
        $search2act = "search2act";
    }
    

function fetchFeature($obj){
    
    $tblName = " yb_features ";
    $disCol = " feature_id,feature_title,feature_icon,feature_sequence,feature_is_active ";
    $where = " feature_is_active  = 1 AND feature_is_delete = 0";
    $order_col = '';
    $order_by = '';
    $catArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    return $catArr;
}

function fetchNewsSpecials($obj){
    
    $tblName = " yb_news ";
    $disCol = " news_id,news_photo,news_title,news_description,news_on_homepage,news_meta_keyword,news_meta_description,news_page_url,news_is_active ";
    $where = " news_is_active  = 1 AND news_is_delete = 0 ORDER BY news_id DESC LIMIT 5";
    $order_col = '';
    $order_by = '';
    $newsArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    return $newsArr;
}

include 'ajax.places.php';

include("template/home.php");
     
?>
