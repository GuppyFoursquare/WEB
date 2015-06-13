<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * @Modified    : 
 * @Description : This is category listing page
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");

$sPageTitle  = "Categories";
$sPageClass  = "category";
$iPageSelect = 4;
$_SESSION['parent_breadcum'] = $sPageTitle;
$_SESSION['mid_breadcum'] = "";
$_SESSION['mid_breadcum_url'] = "";
include("check_menu_session.php");
#INPUT -------------------------------------------------------------------------

$sCommand       = isset($_REQUEST['command']) ? $_REQUEST['command'] : '';
$aOrder         = isset($_REQUEST['chorder']) && !empty ($_REQUEST['chorder']) ? $_REQUEST['chorder'] : array();
$aCategoryID    = isset($_REQUEST['id']) && !empty ($_REQUEST['id']) ? $_REQUEST['id'] : array();


#PROCESS -----------------------------------------------------------------------

//SAVE CATEGORY ORDER
if($sCommand == 'save_order'){
    $aResult = array_combine($aCategoryID, $aOrder);
    foreach ($aResult as $key => $value) { 
        $sUpdSeq = "UPDATE {$prefix}category SET
                    cat_seq=$value
                    WHERE cat_id=$key";
        $rUpdSeq = mysql_query($sUpdSeq) or die("Error:in sequence updation".mysql_error());
    }
    
    
    $query1 = "SELECT * FROM {$prefix}category WHERE cat_is_delete = 0 AND cat_parent_id = 0 ORDER BY cat_seq ASC";
    $result = mysql_query($query1);
    $i = 1;
    while($row = mysql_fetch_array($result))
    {
        
         $sUpdSeq = "UPDATE {$prefix}category SET
                    cat_seq=$i
                    WHERE cat_id=".$row['cat_id'];
        $rUpdSeq = mysql_query($sUpdSeq) or die("Error:in sequence updation".mysql_error());
        $i++;
    }
    
    $_SESSION['sucess_message'] = "Category sequence updated successfully.";
    header("location:category.php?isCancelButtonClicked=1".$query_string);
    die;
}

if(isset($_GET['set_order'])){
    $_SESSION['set_session']=1;
}else{
    $_SESSION['set_session']=0;
}


#OUTPUT ------------------------------------------------------------------------
include("templete/category.inc.php");