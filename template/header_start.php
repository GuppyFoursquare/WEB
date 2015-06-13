<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the header with head tag page of project
********************************************************/

?><!DOCTYPE html>
<html >
<head>
<link rel="shortcut icon" href="images/favicon.ico" />
<base href="<?php echo SERVER_FRONT_PATH;?>" />
<title><?php echo $header_title;?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport" />
<meta name="keywords" content="youbaku"/>
<meta name="description" content="youbaku"/>

<link href="css/wcss.css" rel="stylesheet" type="text/css" />
<link href="css/responsive.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/toastmessage.css"/>
<!--===================================menu=========================================-->
		
<script src="js/jquery.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/front_comman.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#menu').slicknav();        
});
</script>
