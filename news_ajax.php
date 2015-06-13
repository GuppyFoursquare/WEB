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

    $tblName = " yb_news ";
    $disCol = " news_id,news_photo,news_title,news_description,news_on_homepage,news_meta_keyword,news_meta_description,news_page_url,news_is_active,news_created_on ";
    $where = " news_is_active  = 1 AND news_is_delete = 0";
    if(!empty($news_str))
        $where = " news_is_active  = 1 AND news_is_delete = 0 AND news_page_url= '".$news_str."' ";
    $order_col = '';
    $order_by = '';
    $newsArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    return $newsArr;

?>
