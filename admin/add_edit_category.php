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

if($_REQUEST['cat_id'] != '') $sPageTitle     = "Edit Categories";
else $sPageTitle     = "Add Categories";

$sPageClass     = "addcategory";
$iPageSelect    = 4;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Categories';
$_SESSION['parent_breadcum_url']= 'category.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sCategoryTitle     = isset($_REQUEST['cat_name']) ? mysql_real_escape_string(trim($_REQUEST['cat_name'])) : '';
$sCategoryImage     = isset($_FILES['txtCatImage']['name']) ? $_FILES['txtCatImage']['name'] : '';
$sCategoryImage = preg_replace('/[^A-Za-z0-9\-.]/', '', $sCategoryImage);
$sCategoryImageTemp = isset($_FILES['txtCatImage']['tmp_name']) ? $_FILES['txtCatImage']['tmp_name'] : '';
$sCatColor      = isset($_REQUEST['txtCatColor']) ? $_REQUEST['txtCatColor'] : '';

$iCategoryID           = isset($_REQUEST['cat_id']) ? base64_decode($_REQUEST['cat_id']) : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){
    if($sCategoryTitle == '') $iProcess = 2;
    elseif($sCategoryImage == '') $iProcess = 2;
    elseif($sCatColor == '') $iProcess = 2;
    
    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        $chkext = pathinfo($sCategoryImage,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($sCategoryImage != '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
   
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
        
        //CHECK CATEGORY NAME EXIST
       $sQuery="SELECT * FROM yb_category WHERE cat_name='".$sCategoryTitle."' AND cat_parent_id=0";
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
                            cat_name='".$sCategoryTitle."',
                            cat_color='".mysql_real_escape_string($sCatColor)."',
                            cat_seq=$iSequence,
                            cat_created_date=NOW()";
            $rCategory = mysql_query($sCategory) or die("Error:in category selection".mysql_error());
            $iLastInsertID = mysql_insert_id();

            ### UPLOAD CATEGORY IMAGE ###
            if($sCategoryImage != ''){
                $sFileName = str_replace(" ","_",$sCategoryImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                if(move_uploaded_file($sCategoryImageTemp, "../".CATEGORY_IMAGE.$sFileName)){
                    //resizeImages($sFileName,"../".CATEGORY_IMAGE,155,155);
                    $file_for_dimention = "../".CATEGORY_IMAGE .$sFileName;
                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);
                                if($dwidth == 150 || $dheight == 150)
                                {
                                    // nothing to do
                                }
                                elseif($dwidth <= 150 || $dheight <= 150)
                                {
                                    $w = 150;
                                    $h = 150;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'exact',"../".CATEGORY_IMAGE);
                                }else{
                                    
                                    $w = 150;
                                    $h = 150;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'maxheight',"../".CATEGORY_IMAGE);
                                    
                                    $w = 150;
                                    $h = 150;
                                    resizeImageProperSave("../".CATEGORY_IMAGE.$sFileName, $w, $h,'maxwidth',"../".CATEGORY_IMAGE);
                                    $w = 150;
                                    $h = 150;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'exact',"../".CATEGORY_IMAGE);
                                }
                    mysql_query("UPDATE {$prefix}category SET cat_image='$sFileName' WHERE cat_id=$iLastInsertID") or die("Error:In profile image update".mysql_error());
                }
            }

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
    
    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        if($sCategoryImage != ''){
            $chkext = pathinfo($sCategoryImage,PATHINFO_EXTENSION);
            $type = array('gif','jpg','jpeg','png');
            $sImgExtension = strtolower($chkext);
            if($sCategoryImage != '' && !in_array($sImgExtension, $type)){
                $iProcess = 3;
            }
        }//Cat image not blank
        
    }
    
    if($iProcess == 1){
        //CHECK CATEGORY NAME EXIST
        $sSqlCat = "SELECT * FROM {$prefix}category WHERE cat_name='".$sCategoryTitle."' AND cat_id!=$iCategoryID AND cat_parent_id=0";
        $rSqlCat = mysql_query($sSqlCat) or die("Error:in category selection".mysql_error());
        if(mysql_num_rows($rSqlCat) > 0){
            $sCatName = $sCategoryTitle;
            $iProcess = 5; 
        }else{
            //UPDATE CATEGORY
            $sCategory = "UPDATE {$prefix}category SET
                            cat_name='".$sCategoryTitle."',
                            cat_color='".mysql_real_escape_string($sCatColor)."',
                            cat_modified_date=NOW()
                            WHERE cat_id=$iCategoryID";
            $rCategory = mysql_query($sCategory) or die("Error:in category updation".mysql_error());
            $iLastInsertID = $iCategoryID;
            
            ### UPLOAD CATEGORY IMAGE ###
            if($sCategoryImage != ''){
                $sFileName = str_replace(" ","_",$sCategoryImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                if(move_uploaded_file($sCategoryImageTemp, "../".CATEGORY_IMAGE.$sFileName)){
                    //resizeImages($sFileName,"../".CATEGORY_IMAGE,150,150);
                    $file_for_dimention = "../".CATEGORY_IMAGE .$sFileName;
                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                                if($dwidth == 150 || $dheight == 150)
                                {
                                    // nothing to do
                                }
                                elseif($dwidth <= 150 || $dheight <= 150)
                                {
                                    $w = 150;
                                    $h = 150;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'exact',"../".CATEGORY_IMAGE);
                                }else{
                                    
                                    $w = 150;
                                    $h = 150;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'maxheight',"../".CATEGORY_IMAGE);
                                    
                                    $w = 150;
                                    $h = 150;
                                    resizeImageProperSave("../".CATEGORY_IMAGE.$sFileName, $w, $h,'maxwidth',"../".CATEGORY_IMAGE);
                                    $w = 150;
                                    $h = 150;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'exact',"../".CATEGORY_IMAGE);
                                }
                                        
                    mysql_query("UPDATE {$prefix}category SET cat_image='$sFileName' WHERE cat_id=$iLastInsertID") or die("Error:In profile image update".mysql_error());
                }
            }
            $iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 

//GET CATEGORY DETAILS
if($iCategoryID > 0){
    $sTABLE_NAME = $prefix."category";
    $aCatDetails = singleRowDetail('cat_name,cat_image,cat_color',$sTABLE_NAME,'cat_id',$iCategoryID);
    $sCategory_Title = stripslashes($aCatDetails['cat_name']);
    $sCategory_Image = stripslashes($aCatDetails['cat_image']);
    $sCatColor  = stripslashes($aCatDetails['cat_color']);
} 


switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "Category image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "Category icon extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "Category name already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "Category successfully added.";
            header("location:category.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "Category successfully updated.";
            header("location:category.php");
            die();
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_category.inc.php");