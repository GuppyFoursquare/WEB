<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 1 Jan 2015
 * @Modified    : 
 * @Description : This is Slider listing page
********************************************************/

#SETUP -------------------------------------------------------------------------
session_start();
include("../includes/connection.inc.php");
$action=$_REQUEST['action'];
$role_id=$_REQUEST['user_type'];
$iUserID=$_SESSION['yb_admin_user'];
//echo "233";
if($action=="select_role")
{
	//echo "233";
	$role=array();
	$sQuery="SELECT * FROM yb_role_access WHERE role_id=".$role_id;
	$rQuery=mysql_query($sQuery);
	$i=0;
	while($rowQuery=mysql_fetch_assoc($rQuery))
	{
		$role[$i] = $rowQuery['opt_option_id'];
		$i++;
	}
	echo json_encode($role);
}
if($action=="select_password")
{
	$sSQL   = "SELECT u.usr_id FROM {$prefix}users as u
                    WHERE u.usr_id='$iUserID' AND u.usr_password='".md5($role_id)."'";
$rLogin = mysql_query($sSQL) or die("Error: in login".mysql_error());
				if(mysql_num_rows($rLogin) > 0){
					echo "0";
				}else{
				echo "1";}
}
