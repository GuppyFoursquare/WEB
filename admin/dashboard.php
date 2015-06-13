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
$sPageTitle  = "Dashboard";
$sPageClass  = "dashboard";
include("check_menu_session.php");

//$total_member = 100;
//$member_active = 70;
//$member_inactive = 30;


$query = "SELECT count(usr_id) as user_count FROM  yb_users WHERE usr_user_type = 'U'";
$query_mem_count = mysql_query($query);
$query_mem_count = mysql_fetch_array($query_mem_count);

$total_member = $query_mem_count['user_count'] ? $query_mem_count['user_count'] : 0;

$query = "SELECT count(usr_id) as user_count FROM  yb_users WHERE usr_user_type = 'U' AND usr_active = 1";
$query_mem_active = mysql_query($query);
$query_mem_active = mysql_fetch_array($query_mem_active);

$member_active = $query_mem_active['user_count'] ? $query_mem_active['user_count'] : 0;

$query = "SELECT count(usr_id) as user_count FROM  yb_users WHERE usr_user_type = 'U' AND usr_active = 0";
$query_mem_inactive = mysql_query($query);
$query_mem_inactive = mysql_fetch_array($query_mem_inactive);

$member_inactive = $query_mem_inactive['user_count'] ? $query_mem_inactive['user_count'] : 0;


$query = "SELECT count(plc_id) as plc_count FROM  yb_places WHERE plc_is_delete = 0";
$query_plc_count = mysql_query($query);
$query_plc_count = mysql_fetch_array($query_plc_count);

$total_plc = $query_plc_count['plc_count'] ? $query_plc_count['plc_count'] : 0;


$query = "SELECT count(plc_id) as plc_count FROM  yb_places WHERE plc_is_delete = 0 AND plc_is_active = 1";
$query_plc_active = mysql_query($query);
$query_plc_active = mysql_fetch_array($query_plc_active);

$plc_active = $query_plc_active['plc_count'] ? $query_plc_active['plc_count'] : 0;

$query = "SELECT count(plc_id) as plc_count FROM  yb_places WHERE plc_is_delete = 0 AND plc_is_active = 0";
$query_plc_inactive = mysql_query($query);
$query_plc_inactive = mysql_fetch_array($query_plc_inactive);

$plc_inactive = $query_plc_inactive['plc_count'] ? $query_plc_inactive['plc_count'] : 0;



$query = "SELECT count(place_rating_id) as pending_reviews FROM yb_places_rating WHERE places_rating_is_active = 0";
$query_pending = mysql_query($query);
$query_pending = mysql_fetch_array($query_pending);

$pending_reviews =  $query_pending['pending_reviews'];

#OUTPUT ------------------------------------------------------------------------
include("templete/dashboard.inc.php");