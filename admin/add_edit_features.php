<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 31 Dec 2014
 * @Modified    : 
 * @Description : This page use to add or edit Slide
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");

if($_REQUEST['feature_id'] != '') $sPageTitle     = "Edit Feature";
else $sPageTitle     = "Add Feature";

$sPageClass     = "addfeature";
$iPageSelect    = 5;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Feature';
$_SESSION['parent_breadcum_url']= 'features.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
//$sFeatureTitle     = isset($_REQUEST['feature_title']) ? trim($_REQUEST['feature_title']) : '';
$sFeatureTitle=isset($_POST['feature_title'])   ? mysql_real_escape_string(trim($_POST['feature_title']))   : ''; 
$sFeatureImage     = isset($_FILES['txtFeatureImage']['name']) ? $_FILES['txtFeatureImage']['name'] : '';
$sFeatureImage = preg_replace('/[^A-Za-z0-9\-.]/', '', $sFeatureImage);
$sFeatureImageTemp = isset($_FILES['txtFeatureImage']['tmp_name']) ? $_FILES['txtFeatureImage']['tmp_name'] : '';
$iFeatureID           = isset($_REQUEST['feature_id']) ? base64_decode($_REQUEST['feature_id']) : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){
    if($sFeatureTitle== '') $iProcess = 2;
    elseif($sFeatureImage== '') $iProcess = 2;
    
    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        $chkext = pathinfo($sFeatureImage,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($sFeatureImage != '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
   
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
        
        //CHECK FEATURES TITLE EXIST
        $sTABLE_NAME = $prefix."features";
        $aDetails = singleRowDetail('feature_id',$sTABLE_NAME,'feature_title',$sFeatureTitle);
        
        if($aDetails == 0){
            
            $sMaxSeq = "SELECT MAX(feature_sequence) as featureSeq FROM {$prefix}features";
            $rMaxSeq = mysql_query($sMaxSeq) or die("Error:in seq selection".mysql_error()); 
            if(mysql_num_rows($rMaxSeq) > 0){
                $aRow = mysql_fetch_assoc($rMaxSeq);
                $iSequence = $aRow['featureSeq']+1;
            }else $iSequence = 1;
            
            //INSERT FEATURE IN TABLE
           $sFeature = "INSERT INTO {$prefix}features SET
                            feature_title='".$sFeatureTitle."',
							feature_sequence=$iSequence
                            ";
            $rFeature = mysql_query($sFeature) or die("Error:in feature selection".mysql_error());
            $iLastInsertID = mysql_insert_id();

            ### UPLOAD FEATURES IMAGE ###
            if($sFeatureImage != ''){
                $sFileName = str_replace(" ","_",$sFeatureImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                    if(move_uploaded_file($sFeatureImageTemp, "../".FEATURE_ICON.$sFileName)){
                    //resizeImages($sFileName,"../".FEATURE_ICON,155,155);
                    $file_for_dimention = "../".FEATURE_ICON .$sFileName;
                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                                if($dwidth == 50 || $dheight == 50)
                                {
                                    // nothing to do
                                }
                                elseif($dwidth <= 50 || $dheight <= 50)
                                {
                                    $w = 50;
                                    $h = 50;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'exact',"../".FEATURE_ICON);
                                }else{
                                    
                                    $w = 50;
                                    $h = 50;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'maxheight',"../".FEATURE_ICON);
                                    
                                    $w = 50;
                                    $h = 50;
                                    resizeImageProperSave("../".FEATURE_ICON.$sFileName, $w, $h,'maxwidth',"../".FEATURE_ICON);
                                    $w = 50;
                                    $h = 50;
                                    resizeImageProperSave($file_for_dimention, $w, $h,'exact',"../".FEATURE_ICON);
                                }
                    mysql_query("UPDATE {$prefix}features SET feature_icon='$sFileName' WHERE feature_id=$iLastInsertID") or die("Error:In feature image update".mysql_error());
                }
            }

			$iProcess = 6; 
        }else{ 
            $sFeatureImage="";
            $iProcess = 5; 
        }
    }//End validation
}//End button click



//UPDATE BUTTON CODE
if($sCommand == 'Update'){
   
     if($sFeatureTitle== '') $iProcess = 2;
    
    
    
    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        if($sFeatureImage != ''){
            $chkext = pathinfo($sFeatureImage,PATHINFO_EXTENSION);
            $type = array('gif','jpg','jpeg','png');
            $sImgExtension = strtolower($chkext);
            if($sFeatureImage != '' && !in_array($sImgExtension, $type)){
                $iProcess = 3;
            }
        }//Cat image not blank
    }
    
    if($iProcess == 1){
        //CHECK FEATURE NAME EXIST
        $sSqlFeature = "SELECT * FROM {$prefix}features WHERE feature_title='".$sFeatureTitle."' AND feature_id!=$iFeatureID";
        $rSqlFeature = mysql_query($sSqlFeature) or die("Error:in feature selection".mysql_error());
        if(mysql_num_rows($rSqlFeature) > 0){
            //$sCatName = $sCategoryTitle;
            $sFeatureImage="";
			$iProcess = 5; 
        }else{
            //UPDATE FEATURE
				$sFeature = "UPDATE {$prefix}features SET
                            feature_title='".$sFeatureTitle."'
							WHERE feature_id=$iFeatureID";
            $rFeature = mysql_query($sFeature) or die("Error:in feature updation".mysql_error());
            $iLastInsertID = $iFeatureID;
           
            ### UPLOAD FEATURE IMAGE ###
            if($sFeatureImage!= ''){
                $sFileName = str_replace(" ","_",$sFeatureImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                if(move_uploaded_file($sFeatureImageTemp, "../".FEATURE_ICON.$sFileName)){
                    //resizeImages($sFileName,"../".FEATURE_ICON,155,155);
                    $file_for_dimention = "../".FEATURE_ICON .$sFileName;
                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                                if($dwidth == 50 || $dheight == 50)
                                {
                                    // nothing to do
                                }
                                elseif($dwidth <= 50 || $dheight <= 50)
                                {
                                    $w = 50;
                                    $h = 50;
                                    //resizeImageProperSave($file_for_dimention, $w, $h,'exact',"../".FEATURE_ICON);
                                }else{
                                    
                                    $w = 50;
                                    $h = 50;
                                    //resizeImageProperSave($file_for_dimention, $w, $h,'maxheight',"../".FEATURE_ICON);
                                    
                                    $w = 50;
                                    $h = 50;
                                    //resizeImageProperSave("../".FEATURE_ICON.$sFileName, $w, $h,'maxwidth',"../".FEATURE_ICON);
                                    $w = 50;
                                    $h = 50;
                                    //resizeImageProperSave($file_for_dimention, $w, $h,'exact',"../".FEATURE_ICON);
                                }
                    mysql_query("UPDATE {$prefix}features SET feature_icon='$sFileName' WHERE feature_id=$iLastInsertID") or die("Error:In feature icon update".mysql_error());
                }
            }
           $iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 

//GET FEATURES DETAILS

if($iFeatureID > 0){
    $sTABLE_NAME = $prefix."features";
    $aCatDetails = singleRowDetail('feature_title,feature_icon',$sTABLE_NAME,'feature_id',$iFeatureID);
	$sFeatureTitle = stripslashes($aCatDetails['feature_title']);
    $sFeatureImage = $aCatDetails['feature_icon'];   
} 
switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "Feature image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "Feature icon extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "Feature name already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "Feature successfully added.";
            header("location:features.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "Feature successfully updated.";
            header("location:features.php");
            die();
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_features.inc.php");