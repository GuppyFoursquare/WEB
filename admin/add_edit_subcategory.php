<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * @Modified    : 
 * @Description : This page use to add or edit category
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");

$sPageTitle     = "Add Sub Category";
$sPageClass     = "addsubcategory";
$iPageSelect    = 4;
$iProcess       = 1;
$sCategories    = '';

$_SESSION['mid_breadcum'] = "Sub Categories";
$_SESSION['mid_breadcum_url'] = "subcategory_management.php";
$_SESSION['parent_breadcum'] = 'Categories';
$_SESSION['parent_breadcum_url'] = 'category.php';
$_SESSION['breadcum'] = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sCategoryTitle     = isset($_REQUEST['cat_name']) ? mysql_real_escape_string(trim($_REQUEST['cat_name'])) : '';
$iParentCategory    = isset($_REQUEST['selCategory']) ? mysql_real_escape_string(trim($_REQUEST['selCategory'])) : 1;

$iCategoryID           = isset($_REQUEST['cat_id']) ? base64_decode($_REQUEST['cat_id']) : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){
    if($sCategoryTitle == '') $iProcess = 2;
    
      
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
        
        //CHECK CATEGORY NAME EXIST
		$sQuery="SELECT * FROM yb_category WHERE cat_name='".$sCategoryTitle."' AND cat_parent_id=".$iParentCategory."";
        $aDetails = mysql_query($sQuery);
        $row=mysql_num_rows($aDetails);
        if($row == 0){
            
            $sMaxSeq = "SELECT MAX(cat_seq) as categorySeq FROM {$prefix}category";
            $rMaxSeq = mysql_query($sMaxSeq) or die("Error:in seq selection".mysql_error()); 
            if(mysql_num_rows($rMaxSeq) > 0){
                $aRow = mysql_fetch_assoc($rMaxSeq);
                $iSequence = $aRow['categorySeq']+1;
            }else $iSequence = 1;
            
            //INSERT CATEGORY IN TABLE
            $sCategory = "INSERT INTO {$prefix}category SET
                            cat_name='".mysql_real_escape_string($sCategoryTitle)."',
                            cat_parent_id='".mysql_real_escape_string($iParentCategory)."',
                            cat_seq=$iSequence,
                            cat_created_date=NOW()";
            $rCategory = mysql_query($sCategory) or die("Error:in category selection".mysql_error());
            $iLastInsertID = mysql_insert_id();

            $iProcess = 6; 
        }else{ 
            $sCatName = $sCategoryTitle;
            $iProcess = 5; 
        }
    }//End validation
}//End button click



//UPDATE BUTTON CODE
if($sCommand == 'Update'){
    
    if($sCategoryTitle == '') $iProcess = 2;
    
    if($iProcess == 1){
	//CHECK CATEGORY NAME EXIST
        $sSqlCat = "SELECT * FROM {$prefix}category WHERE cat_name='".$sCategoryTitle."' AND  cat_parent_id=".$iParentCategory." AND cat_id!=$iCategoryID";
        $rSqlCat = mysql_query($sSqlCat) or die("Error:in category selection".mysql_error());
        if(mysql_num_rows($rSqlCat) > 0){
            $sCatName = $sCategoryTitle;
            $iProcess = 5; 
        }else{
            //UPDATE CATEGORY
            $sCategory = "UPDATE {$prefix}category SET
                            cat_name='".mysql_real_escape_string($sCategoryTitle)."',
                            cat_parent_id='".mysql_real_escape_string($iParentCategory)."',
                            cat_modified_date=NOW()
                            WHERE cat_id=$iCategoryID";
            $rCategory = mysql_query($sCategory) or die("Error:in category updation".mysql_error());
            $iLastInsertID = $iCategoryID;
            $iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 

//GET CATEGORY DETAILS
if($iCategoryID > 0){
    $sTABLE_NAME = $prefix."category";
    $aCatDetails = singleRowDetail('cat_name,cat_image',$sTABLE_NAME,'cat_id',$iCategoryID);
    $sCategory_Title = stripslashes($aCatDetails['cat_name']);
} 

//GET CATEGORY LIST
$sCategoryList = "SELECT * FROM {$prefix}category WHERE cat_parent_id=0  ORDER BY cat_name ASC";
$rCategoryList = mysql_query($sCategoryList) or die("Error:in category list selection".mysql_error());
if(mysql_num_rows($rCategoryList) > 0){
    while($aRow = mysql_fetch_assoc($rCategoryList)){
        if($aRow['cat_id'] == $_SESSION['cat_id']) $sSelected = 'selected="selected"';
        else $sSelected = '';
            
        $sCategories .='<option '.$sSelected.' value="'.$aRow['cat_id'].'">'.stripslashes($aRow['cat_name']).'</option>';
    }
}


 


switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "Sub category image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "Sub category icon extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "Sub category name already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "Sub category successfully added.";
            header("location:subcategory_management.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "Sub category successfully updated.";
            header("location:subcategory_management.php?isCancelButtonClicked=1");
            die();
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_subcategory.inc.php");