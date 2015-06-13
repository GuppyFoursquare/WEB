<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 31 Dec 2014
 * @Modified    : 
 * @Description : This is Slider listing page
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");

$sPageTitle  = "Home Slider";
$sPageClass  = "slider";
$iPageSelect = 15;
$_SESSION['parent_breadcum'] = $sPageTitle;
$_SESSION['mid_breadcum'] = "";
$_SESSION['mid_breadcum_url'] = "";
include("check_menu_session.php");
#INPUT -------------------------------------------------------------------------

$sCommand       = isset($_REQUEST['command']) ? $_REQUEST['command'] : '';
$aOrder         = isset($_REQUEST['chorder']) && !empty ($_REQUEST['chorder']) ? $_REQUEST['chorder'] : array();
$aSlideID    = isset($_REQUEST['id']) && !empty ($_REQUEST['id']) ? $_REQUEST['id'] : array();


#PROCESS -----------------------------------------------------------------------

//SAVE SLIDER ORDER
if($sCommand == 'save_order'){
    $aResult = array_combine($aSlideID, $aOrder);
    
    foreach ($aResult as $key => $value) { 
        $sUpdSeq = "UPDATE {$prefix}home_slider SET
                    home_slider_sequence=$value
                    WHERE home_slider_id=$key";
        $rUpdSeq = mysql_query($sUpdSeq) or die("Error:in sequence updation".mysql_error());
    }
    
    $query1 = "SELECT * FROM {$prefix}home_slider WHERE home_slider_is_delete = 0 ORDER BY home_slider_sequence ASC";
    $result = mysql_query($query1);
    $i = 1;
    while($row = mysql_fetch_array($result))
    {
         $sUpdSeq = "UPDATE {$prefix}home_slider SET
                    home_slider_sequence=$i
                    WHERE home_slider_id=".$row['home_slider_id'];
        $rUpdSeq = mysql_query($sUpdSeq) or die("Error:in sequence updation".mysql_error());
        $i++;
    }
    
    $_SESSION['sucess_message'] = "Slide sequence updated successfully.";
    header("location:home_slider.php?isCancelButtonClicked=1".$query_string);
    die;
}

if(isset($_GET['set_order'])){
    $_SESSION['set_session']=1;
}else{
    $_SESSION['set_session']=0;
}


#OUTPUT ------------------------------------------------------------------------
include("templete/home_slider.inc.php");