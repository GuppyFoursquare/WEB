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
$_SESSION['is_most_popular'] = 0;
error_reporting(E_ALL);
$news_str = (isset($_GET['r']) ? $_GET['r'] : '');
//echo $news_str;die;
$formData = array();
$header_title = "YOUBAKU | News";

function fetchNewsSpecials($obj,$news_str = '',$page = 0){
    
    $tblName = " yb_news ";
    $disCol = " news_id,news_photo,news_title,news_description,news_on_homepage,news_meta_keyword,news_meta_description,news_page_url,news_is_active,news_created_on ";
    $where = " news_is_active  = 1 AND news_is_delete = 0";
    if(!empty($news_str))
        $where = " news_is_active  = 1 AND news_is_delete = 0 AND news_page_url= '".$news_str."' ";
    
    $limit = 5;
    if($page > 0){
        $page = $page - 1;
        $page = $page * $limit;
    }
    //echo $page;die;
    $where .= " ORDER BY news_id DESC  LIMIT ".$page.",".$limit;
    
    $order_col = '';
    $order_by = '';
    $newsArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    return $newsArr;
}

function countAllNewsSpecial($obj,$news_str = ''){
    
    $tblName = " yb_news ";
    $disCol = " news_id,news_photo,news_title,news_description,news_on_homepage,news_meta_keyword,news_meta_description,news_page_url,news_is_active,news_created_on ";
    $where = " news_is_active  = 1 AND news_is_delete = 0";
    if(!empty($news_str))
        $where = " news_is_active  = 1 AND news_is_delete = 0 AND news_page_url= '".$news_str."' ";
    
    $order_col = '';
    $order_by = '';
    $newsArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    return count($newsArr);
}



function fetchNewsDetails($obj,$news_str = '',$singleRow = 0){
    
    $tblName = " yb_news ";
    $disCol = " news_id,news_photo,news_title,news_description,news_on_homepage,news_meta_keyword,news_meta_description,news_page_url,news_is_active,news_created_on ";
    $where = " news_is_active  = 1 AND news_is_delete = 0";
    if(!empty($news_str))
        $where = " news_is_active  = 1 AND news_is_delete = 0 AND news_page_url= '".$news_str."' ";
    $order_col = '';
    $order_by = '';
    $newsArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '',$singleRow);
    return $newsArr;
}


$pagingpagename = "news/".$news_str."/";
$noofrecords = countAllNewsSpecial($obj);
$page = 0;
$pagesize = 5;
 $CURR_URI = $_SERVER['REQUEST_URI'];
 $CURR_URI = explode('?', $CURR_URI);
 if(array_key_exists(1,$CURR_URI)){
     $CURR_URI = explode('=', $CURR_URI[1]);
     $page = $CURR_URI[1];
 }
$extra_parameters = "";

// news listing...
$newsS = fetchNewsSpecials($obj,'',$page);

// news details.
$pageNews = fetchNewsDetails($obj,$news_str,1);
include 'ajax.places.php';

include("template/news.php");
?>
