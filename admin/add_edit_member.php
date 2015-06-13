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

if($_REQUEST['usr_id'] != '') $sPageTitle     = "Edit Member";
else $sPageTitle     = "Add Member";

$sPageClass     = "addusers";
$iPageSelect    = 1;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Member';
$_SESSION['parent_breadcum_url']= 'member.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sFirstName     = isset($_REQUEST['usr_first_name']) ? (trim($_REQUEST['usr_first_name'])) : '';
$sLastName     = isset($_REQUEST['usr_last_name']) ? (trim($_REQUEST['usr_last_name'])) : '';
$sUserName     = isset($_REQUEST['usr_username']) ? (trim($_REQUEST['usr_username'])) : '';
$sUserPassword     = isset($_REQUEST['usr_password']) ? (trim($_REQUEST['usr_password'])) : '';
$sEmail     = isset($_REQUEST['usr_email']) ? (trim($_REQUEST['usr_email'])) : '';
$sUserType     = isset($_REQUEST['usr_user_type']) ? (trim($_REQUEST['usr_user_type'])) : '';

$sUserContact     = isset($_REQUEST['usr_contact']) ? (trim($_REQUEST['usr_contact'])) : '';
$sUserAddress     = isset($_REQUEST['usr_address']) ? (trim($_REQUEST['usr_address'])) : '';
$sUserCity     = isset($_REQUEST['usr_city']) ? (trim($_REQUEST['usr_city'])) : '';
$sUserState     = isset($_REQUEST['usr_state']) ? (trim($_REQUEST['usr_state'])) : '';
$sUserCountry     = isset($_REQUEST['usr_country']) ? (trim($_REQUEST['usr_country'])) : '';

$iUserID           = isset($_REQUEST['usr_id']) ? base64_decode($_REQUEST['usr_id']) : '';
$asizeofchkaccess = sizeof($_REQUEST['chkaccess']);
$sProfileImage     = isset($_FILES['txtProfileImage']['name']) ? $_FILES['txtProfileImage']['name'] : '';
$sProfileImageTemp = isset($_FILES['txtProfileImage']['tmp_name']) ? $_FILES['txtProfileImage']['tmp_name'] : '';

#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){

if($sFirstName == '') $iProcess = 2;
    elseif($sLastName == '') $iProcess = 2;
	elseif($sUserPassword == '') $iProcess = 2;
	elseif($sEmail == '') $iProcess = 2;
	
    
    //VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        $chkext = pathinfo($sProfileImage,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($sProfileImage!= '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
	
	
    //IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
        
        //CHECK USER NAME EXIST
        $sQuery="SELECT * FROM yb_users WHERE (usr_username='".mysql_real_escape_string($sUserName)."' OR usr_email='".mysql_real_escape_string($semail)."') AND usr_user_type='U'";
        $aDetails = mysql_query($sQuery);
        $row=mysql_num_rows($aDetails);
		
        		
		
        if($row == 0){
           //INSERT USER IN TABLE
           $sUser = "INSERT INTO {$prefix}users SET
                            usr_first_name='".mysql_real_escape_string($sFirstName)."',
							usr_last_name='".mysql_real_escape_string($sLastName)."',
							usr_username='".mysql_real_escape_string($sUserName)."',
							usr_password='".(md5($sUserPassword))."',
							usr_email='".($sEmail)."',
							usr_user_type='U',
							usr_contact='".mysql_real_escape_string($sUserContact)."',
							usr_address='".mysql_real_escape_string($sUserAddress)."',
							usr_city='".mysql_real_escape_string($sUserCity)."',
							usr_state='".($sUserState)."',
							usr_country='".($sUserCountry)."'
							";
            $rUser = mysql_query($sUser) or die("Error:in user selection".mysql_error());
            $iLastInsertID = mysql_insert_id();
			
			### UPLOAD PROFILE IMAGE ###
            if($sProfileImage != ''){
                $sFileName = str_replace(" ","_",$sProfileImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                $sFileName = preg_replace('/[^a-zA-Z0-9_.]/s', '', $sFileName);
				if(move_uploaded_file($sProfileImageTemp, "../".PROFILE_IMAGE.$sFileName)){
                    resizeImages($sFileName,"../".PROFILE_IMAGE,100,100);
                    mysql_query("UPDATE {$prefix}users SET usr_profile_picture='$sFileName' WHERE usr_id=$iLastInsertID") or die("Error:In profile image update".mysql_error());
                }
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
	
   
	//VALIDAE IMAGE EXTENSION
    if($iProcess == 1){
        $chkext = pathinfo($sProfileImage,PATHINFO_EXTENSION);
        $type = array('gif','jpg','jpeg','png');
        $sImgExtension = strtolower($chkext);
        if($sProfileImage!= '' && !in_array($sImgExtension, $type)){
            $iProcess = 3;
        }
    }
   
   
    if($iProcess == 1){
        //CHECK USER NAME EXIST
		$sSqlUser = "SELECT * FROM {$prefix}users WHERE usr_username='".$sUserName."' AND usr_user_type='U' AND usr_id!=$iUserID";
        $rSqlUser = mysql_query($sSqlUser) or die("Error:in user selection".mysql_error());
        if(mysql_num_rows($rSqlUser) > 0){
			$sProfileImage="";
            $iProcess = 5; 
        }else{
            //UPDATE user
           $sUser = "UPDATE {$prefix}users SET
                            usr_first_name='".mysql_real_escape_string($sFirstName)."',
							usr_last_name ='".mysql_real_escape_string($sLastName)."',
							usr_username='".mysql_real_escape_string($sUserName)."',
							usr_email ='".($sEmail)."',
							usr_user_type='U',
							usr_contact='".mysql_real_escape_string($sUserContact)."',
							usr_address='".mysql_real_escape_string($sUserAddress)."',
							usr_city='".mysql_real_escape_string($sUserCity)."',
							usr_state='".($sUserState)."',
							usr_country='".($sUserCountry)."'
							WHERE  usr_id=$iUserID";
						
            $rUser = mysql_query($sUser) or die("Error:in User updation".mysql_error());
            $iLastInsertID = $iUserID;
           // echo $sSliderImage;
			 ### UPLOAD PROFILE IMAGE ###
            if($sProfileImage!= ''){
                $sFileName = str_replace(" ","_",$sProfileImage);
                $sFileName = str_replace("'","_",$sFileName);
                $sFileName = $iLastInsertID."_".$sFileName;
                $sFileName = preg_replace('/[^a-zA-Z0-9_.]/s', '', $sFileName);
                if(move_uploaded_file($sProfileImageTemp, "../".PROFILE_IMAGE.$sFileName)){
                    resizeImages($sFileName,"../".PROFILE_IMAGE,100,100);
                    mysql_query("UPDATE {$prefix}users SET usr_profile_picture='$sFileName' WHERE usr_id=$iLastInsertID") or die("Error:In profile image update".mysql_error());
                }
            }


		   
			$iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 

//GET USER DETAILS

if($iUserID > 0){
    $sTABLE_NAME = $prefix."users";
    $aCatDetails = singleRowDetail('usr_first_name,usr_last_name,usr_username,usr_email,usr_user_type,usr_profile_picture,usr_contact,usr_address,usr_city,usr_state,usr_country',$sTABLE_NAME,'usr_id',$iUserID);
	$sFirstName     = stripslashes($aCatDetails['usr_first_name']);
	$sLastName     = stripslashes($aCatDetails['usr_last_name']);
	$sUserName     = stripslashes($aCatDetails['usr_username']);
	$sEmail     = stripslashes($aCatDetails['usr_email']);
	$sUserType     = stripslashes($aCatDetails['usr_user_type']);
	$sProfileImage	= stripslashes($aCatDetails['usr_profile_picture']);
	$sUserContact     = stripslashes($aCatDetails['usr_contact']);
	$sUserAddress     = stripslashes($aCatDetails['usr_address']);
	$sUserCity     = stripslashes($aCatDetails['usr_city']);
	$sUserState     = stripslashes($aCatDetails['usr_state']);
	$sUserCountry     = stripslashes($aCatDetails['usr_country']);

} 
        $sFirstName     = stripslashes($sFirstName);
	$sLastName     = stripslashes($sLastName);
	$sUserName     = stripslashes($sUserName);
	$sEmail     = stripslashes($sEmail);
	$sUserType     = stripslashes($sUserType);
	$sUserContact     = stripslashes($sUserContact);
	$sUserAddress     = stripslashes($sUserAddress);
	$sUserCity     = stripslashes($sUserCity);
	$sUserState     = stripslashes($sUserState);
	$sUserCountry     = stripslashes($sUserCountry);

switch($iProcess){
    case 2:
            $_SESSION['error_message'] = "Fields with * are required";
        break;
    case 3:
            $_SESSION['error_message'] = "Member image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "Member icon extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "Member name already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "Member successfully added.";
            header("location:member.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "Member successfully updated.";
            header("location:member.php");
            die();
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_member.inc.php");