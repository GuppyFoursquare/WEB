<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 5 jan 2014
 * @Modified    : 
 * @Description : This page use to add or edit role
********************************************************/

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");

if($_REQUEST['role_id'] != '') $sPageTitle     = "Edit Role";
else $sPageTitle     = "Add Role";

$sPageClass     = "addrole";
$iPageSelect    = 9;
$iProcess       = 1;
$_SESSION['mid_breadcum']       = "";
$_SESSION['mid_breadcum_url']   = "";
$_SESSION['parent_breadcum']    = 'Role';
$_SESSION['parent_breadcum_url']= 'roles.php';
$_SESSION['breadcum']           = $sPageTitle;

#INPUT -------------------------------------------------------------------------

$sCommand           = isset($_REQUEST['btnSave']) ? $_REQUEST['btnSave'] : '';
$sRoleType     = isset($_REQUEST['role_type']) ? (trim($_REQUEST['role_type'])) : '';
$sRoleDescription     = isset($_REQUEST['role_description']) ? (trim($_REQUEST['role_description'])) : '';
$iRoleID           = isset($_REQUEST['role_id']) ? base64_decode($_REQUEST['role_id']) : '';
$asizeofchkaccess=sizeof($_REQUEST['chkaccess']);
#PROCESS -----------------------------------------------------------------------

//INSERT BUTTON CODE
if($sCommand == 'Save'){
if($sRoleType == '') $iProcess = 2;
    elseif($sRoleDescription == '') $iProcess = 2;
	elseif($asizeofchkaccess == '0') $iProcess = 2;
	
	//IF ALL FIELDS ARE VALID THEN ENTER IN LOOP
    if($iProcess == 1){
        
        //CHECK ROLE NAME EXIST
        $sTABLE_NAME = $prefix."rolemst";
        $aDetails = singleRowDetail('role_id',$sTABLE_NAME,'role_type',$sRoleType);
        
        if($aDetails == 0){
           //INSERT ROLE IN TABLE
           $sRole = "INSERT INTO {$prefix}rolemst SET
                            role_type='".mysql_real_escape_string($sRoleType)."',
							role_description='".mysql_real_escape_string($sRoleDescription)."'
							";
            $rRole = mysql_query($sRole) or die("Error:in Role selection".mysql_error());
            $iLastInsertID = mysql_insert_id();
			
			// INSERT USER MENU ACCESS IN TABLE
			foreach ($_REQUEST['chkaccess'] as $value) {
                     $sRoleacess = "INSERT INTO {$prefix}role_access SET
                            role_id='".mysql_real_escape_string($iLastInsertID)."',
							opt_option_id =".$value."
                           ";
					 $rRoleacess = mysql_query($sRoleacess) or die("Error:in Role Access selection".mysql_error());
						
                    }
                
			
			
			$iProcess = 6; 
        }else{ 
            
            $iProcess = 5; 
        }
    }//End validation
}//End button click



//UPDATE BUTTON CODE
if($sCommand == 'Update'){
   
   if($sRoleType == '') $iProcess = 2;
    elseif($sRoleDescription == '') $iProcess = 2;
	elseif($asizeofchkaccess == '0') $iProcess = 2;
   
    if($iProcess == 1){
        //CHECK ROLE EXIST
        $sSqlRole = "SELECT * FROM {$prefix}rolemst WHERE role_type='".$sRoleType."' AND  	role_id!=$iRoleID";
        $rSqlRole = mysql_query($sSqlRole) or die("Error:in Role selection".mysql_error());
        if(mysql_num_rows($rSqlRole) > 0){
            $iProcess = 5; 
        }else{
            //UPDATE Role
            $sRole = "UPDATE {$prefix}rolemst SET
                            role_type='".mysql_real_escape_string($sRoleType)."',
							role_description='".mysql_real_escape_string($sRoleDescription)."'
							WHERE  role_id=$iRoleID";
            $rRole = mysql_query($sRole) or die("Error:in role updation".mysql_error());
            $iLastInsertID = $iRoleID;
           // echo $sSliderImage;
		$rDelete = mysql_query("DELETE FROM {$prefix}role_access WHERE role_id=$iRoleID") or die("Error:in delete record".mysql_error());
		   
			foreach ($_REQUEST['chkaccess'] as $value) {
                      $sRoleacess = "INSERT INTO {$prefix}role_access SET
                            role_id='".mysql_real_escape_string($iLastInsertID)."',
							opt_option_id =".$value."
                           ";
					 $rRoleacess = mysql_query($sRoleacess) or die("Error:in Role selection".mysql_error());
						
                    }	
		   
		   
		   
			$iProcess = 7; 
        }//Check unique cat name
    }//End validation
    
    
}//Update 

//GET USER DETAILS

if($iRoleID > 0){
    $sTABLE_NAME = $prefix."rolemst";
    $aCatDetails = singleRowDetail('role_type,role_description',$sTABLE_NAME,'role_id',$iRoleID);
	$sRoleType = stripslashes($aCatDetails['role_type']);
	$sRoleDescription = stripslashes($aCatDetails['role_description']);
	
		$options = array();
        $access_query = "SELECT * FROM yb_role_access WHERE role_id = " . $iRoleID . ";";
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
            $_SESSION['error_message'] = "User image extension should be jpg,jpeg,png or gif";
        break;
    case 4:
            $_SESSION['error_message'] = "Role icon extension should be jpg,jpeg,png or gif";
        break;
    case 5:
            $_SESSION['error_message'] = "Role already exist.";
        break;
    case 6:
            $_SESSION['sucess_message'] = "Role successfully added.";
            header("location:roles.php");
            die();
        break;
    case 7:
            $_SESSION['sucess_message'] = "Role successfully updated.";
            header("location:roles.php");
            die();
        break;
}

#OUTPUT ------------------------------------------------------------------------
include("templete/add_edit_roles.inc.php");