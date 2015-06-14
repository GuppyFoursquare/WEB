<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the index page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
#

include("prepend.php");
error_reporting(E_ALL);
$_SESSION['is_most_popular'] = 0;
$header_title = "YOUBAKU";
function fetchSliderImg($obj){
    
    $tblName = " yb_slider ";
    $disCol = " slide_id,slide_title,slide_image,slide_link,slide_sequence,slide_is_active,slide_is_delete ";
    $where = " slide_is_active  = 1 AND slide_is_delete = 0";
    $order_col = '';
    $order_by = '';
    $sliArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    return $sliArr;
}

$sliderArr = fetchSliderImg($obj);

include("template/index.php");

?>
