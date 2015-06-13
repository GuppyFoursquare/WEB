<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the index page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
include("prepend.php");

$_SESSION['is_most_popular'] = 0;

$search_val = (isset($_GET['sr']) ? mysql_real_escape_string($_GET['sr']) : '');
$chbExactSearch = (isset($_GET['chbexactsearch']) ? 1 : 0);

if($chbExactSearch)
{
    header('location:'.SITE_PATH.'home?chbexactsearch=on&sr='.$search_val);
}
else
{
    header('location:'.SITE_PATH.'home?sr='.$search_val);
}

?>
