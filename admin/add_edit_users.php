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

if($_REQUEST['usr_id'] != '') $sPageTitle     = "Edit Sub Admin";
else $sPageTitle     = "Add Sub Admin";

$sPageClass     = "addusers";
$iPageSelect    = 10;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Sub Admin';
$_SESSION['parent_breadcum_url']= 'users.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sFirstName     = isset($_REQUEST['usr_first_name']) ? (trim($_REQUEST['usr_first_name'])) : '';
$sLastName     = isset($_REQUEST['usr_last_name']) ? (trim($_REQUEST['usr_last_name'])) : '';
$sUserName     = isset($_REQUEST['usr_username']) ? (trim($_REQUEST['usr_username'])) : '';
$sUserPassword     = isset($_REQUEST['usr_password']) ? (trim($_REQUEST['usr_password'])) : '';
$sEmail     = isset($_REQUEST['usr_email']) ? (trim($_REQUEST['usr_email'])) : '';
$sUserType     = isset($_REQUEST['usr_user_type']) ? (trim($_REQUEST['usr_user_type'])) : '';
$iUserID           = isset($_REQUEST['usr_id']) ? base64_decode($_REQUEST['usr_id']) : '';
$asizeofchkaccess=sizeof($_REQUEST['chkaccess']);
$sProfileImage     = isset($_FILES['txtProfileImage']['name']) ? $_FILES['txtProfileImage']['name'] : '';
$sProfileImage = preg_replace('/[^A-Za-z0-9\-.]/', '', $sProfileImage);
$sProfileImageTemp = isset($_FILES['txtProfileImage']['tmp_name']) ? $_FILES['txtProfileImage']['tmp_name'] : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){

if($sFirstName == '') $iProcess = 2;
    elseif($sLastName == '') $iProcess = 2;
	elseif($sUserPassword == '') $iProcess = 2;
	elseif($sUserType == '') $iProcess = 2;
	elseif($sEmail == '') $iProcess = 2;
	elseif($sUserType == '') $iProcess = 2;
    
    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        $chkext = pathinfo($sProfileImage,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($sProfileImage!= '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
    
    $sTABLE_NAME = $prefix."users";
    $aEmailRow = singleRowDetail('usr_id',$sTABLE_NAME,'usr_email',$sEmail);
    if($aEmailRow != 0){
        $iProcess = 8;
    }
	
	
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
        
        //CHECK USER NAME EXIST
        $sTABLE_NAME = $prefix."users";
        $aDetails = singleRowDetail('usr_id',$sTABLE_NAME,'usr_username',$sUserName);
        
        if($aDetails == 0){
           //INSERT USER IN TABLE
           $sUser = "INSERT INTO {$prefix}users SET
                            usr_first_name='".mysql_real_escape_string($sFirstName)."',
							usr_last_name='".mysql_real_escape_string($sLastName)."',
							usr_username='".$sUserName."',
							usr_password='".md5($sUserPassword)."',
							usr_email='".$sEmail."',
							usr_user_type='Sub-Admin'
							
							";
            $rUser = mysql_query($sUser) or die("Error:in user selection".mysql_error());
            $iLastInsertID = mysql_insert_id();
			
			### UPLOAD PROFILE IMAGE ###
            if($sProfileImage != ''){
                $sFileName = str_replace(" ","_",$sProfileImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
				if(move_uploaded_file($sProfileImageTemp, "../".PROFILE_IMAGE.$sFileName)){
                    resizeImages($sFileName,"../".PROFILE_IMAGE,50,50);
                    mysql_query("UPDATE {$prefix}users SET usr_profile_picture='$sFileName' WHERE usr_id=$iLastInsertID") or die("Error:In profile image update".mysql_error());
                }
            }
			
			// INSERT USER MENU ACCESS IN TABLE
			foreach ($_REQUEST['chkaccess'] as $value) {
                       $sUser = "INSERT INTO {$prefix}user_access SET
                            usr_id='".mysql_real_escape_string($iLastInsertID)."',
							opt_option_id =".$value."
                           ";
					 $rUser = mysql_query($sUser) or die("Error:in user selection".mysql_error());
						
                    }
                
			
			
			$iProcess = 6; 
        }else{ 
            $sProfileImage="";
            $iProcess = 5; 
        }
    }//End validation
}//End button click



//UPDATE BUTTON CODE
if($sCommand == 'Update'){
   
    if($sFirstName == '') $iProcess = 2;
    elseif($sLastName == '') $iProcess = 2;
	elseif($sUserName == '') $iProcess = 2;
	elseif($sEmail == '') $iProcess = 2;
	elseif($sUserType == '') $iProcess = 2;
   
	//VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        $chkext = pathinfo($sProfileImage,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($sProfileImage!= '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
    
        $sSqlUser = "SELECT * FROM {$prefix}users WHERE usr_email='".$sEmail."' AND  	usr_id!=$iUserID";
        $rSqlUser = mysql_query($sSqlUser) or die("Error:in user selection".mysql_error());
        if(mysql_num_rows($rSqlUser) > 0){
            $iProcess = 8;
        }
        
   
    if($iProcess == 1){
        //CHECK USER NAME EXIST
        $sSqlUser = "SELECT * FROM {$prefix}users WHERE usr_username='".$sUserName."' AND  	usr_id!=$iUserID";
        $rSqlUser = mysql_query($sSqlUser) or die("Error:in user selection".mysql_error());
        if(mysql_num_rows($rSqlUser) > 0){
			$sProfileImage="";
            $iProcess = 5; 
        }else{
            //UPDATE user
           $sUser = "UPDATE {$prefix}users SET
                            usr_first_name='".$sFirstName."',
							usr_last_name ='".mysql_real_escape_string($sLastName)."',
							usr_username='".mysql_real_escape_string($sUserName)."',
							usr_email ='".$sEmail."',
							usr_user_type='Sub-Admin'
							WHERE  usr_id=$iUserID";
						
            $rUser = mysql_query($sUser) or die("Error:in User updation".mysql_error());
            $iLastInsertID = $iUserID;
           // echo $sSliderImage;
			 ### UPLOAD PROFILE IMAGE ###
            if($sProfileImage!= ''){
                $sFileName = str_replace(" ","_",$sProfileImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                if(move_uploaded_file($sProfileImageTemp, "../".PROFILE_IMAGE.$sFileName)){
                    resizeImages($sFileName,"../".PROFILE_IMAGE,50,70);
                    mysql_query("UPDATE {$prefix}users SET usr_profile_picture='$sFileName' WHERE usr_id=$iLastInsertID") or die("Error:In profile image update".mysql_error());
                }
            }





		  $rDelete = mysql_query("DELETE FROM {$prefix}user_access WHERE usr_id=$iUserID") or die("Error:in delete record".mysql_error());
		   
			foreach ($_REQUEST['chkaccess'] as $value) {
                          $sUser = "INSERT INTO {$prefix}user_access SET
                            usr_id='".mysql_real_escape_string($iLastInsertID)."',
							opt_option_id =".$value."
                           ";
					 $rUser = mysql_query($sUser) or die("Error:in user selection".mysql_error());
						
                    }	
		   
		   
		   
			$iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 

//GET USER DETAILS

if($iUserID > 0){
    $sTABLE_NAME = $prefix."users";
    $aCatDetails = singleRowDetail('usr_first_name,usr_last_name,usr_username,usr_email,usr_user_type,usr_profile_picture',$sTABLE_NAME,'usr_id',$iUserID);
	$sFirstName     = stripslashes($aCatDetails['usr_first_name']);
	$sLastName     = stripslashes($aCatDetails['usr_last_name']);
	$sUserName     = stripslashes($aCatDetails['usr_username']);
	$sEmail     = stripslashes($aCatDetails['usr_email']);
	$sUserType     = stripslashes($aCatDetails['usr_user_type']);
	$sProfileImage	= stripslashes($aCatDetails['usr_profile_picture']);
		$options = array();
        $access_query = "SELECT * FROM yb_user_access WHERE usr_id = " . $iUserID . ";";
        $access_qry = mysql_query($access_query) or die("error" . mysql_error());
        while ($role = mysql_fetch_array($access_qry)) {
            $options[] = $role['opt_option_id'];
        }

} 


switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "sub admin image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "sub admin icon extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "sub admin name already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "sub admin successfully added.";
            header("location:users.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "sub admin successfully updated.";
            header("location:users.php");
            die();
        break;
    case 8:
        $_SESSION['error_message'] = "sub admin email already exist.";
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_users.inc.php");