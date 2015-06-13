<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * @Modified    : 
 * @Description : This file use to define all constants which is used in project.
********************************************************/

/*****************defining constants starts here*****************/
$sPathString = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
if($_SERVER['HTTP_HOST'] == "youbaku.az"){ 
    define(SITEPATH,str_replace("\\","",$sPathString)."/");
}else{ define(SITEPATH,str_replace("\\","",$sPathString)."/"); }
$FRONTPATH = "http://" . $_SERVER['HTTP_HOST'] . "/";
define('SERVER_FRONT_PATH', $FRONTPATH);
define('SITE_PATH', $FRONTPATH);
define(SITENAME, " | YOUBAKU");
define(SITETITLE, "youbaku");
define(ADMINHOMEPAGE, "dashboard.php");
define(ADMIN_SITENAME, " | YOUBAKU Admin");
define(MANDATORY, "<span style='color:#FF0000'>* Indicates Required Field</span>");
define(REDSTAR,"<font color='#ff0000' >*</font>");
define(FROMEMAIL,"From: YOUBAKU <".$sFromEmail.">\n");
define(CONTENTTYPE,"Content-type: text/html; charset=iso-8859-1\n");
define(XMAILER,"X-Mailer: PHP/".phpversion()."\n");
define(MIMEVERSION,"MIME-Version: 1.0\n");
define(REPLYTO,"Reply-To: YOUBAKU <".$sFromEmail.">\n");

define(MAILHEADER,"<table cellspacing='0' cellpadding='0' border='0' style='width:527px;height:344px'>
                   <tbody><tr><td><img src='".SITEPATH."images/logo.jpg' border=0></td></tr><tr><td>");

define(MAILFOOTER,"</td></tr><tr><td></td></tr></tbody></table>");

define(SENDEMAIL,MAILHEADER.MAILBODY.MAILFOOTER);

//---- IMAGES PATH ----//
define(IMAGE_PATH,"images/");
define(DEFAULT_IMAGE_PATH,"images/no-img.jpg");
define(CATEGORY_IMAGE,"uploads/category_images/");
define(CATEGORY_DEFAULT_ICON,"uploads/category_icons/default.png");
define(SLIDER_IMAGE,"uploads/slider_images/");
define(FEATURE_ICON,"uploads/feature_icons/");
define(PLACES_HEADER_IMAGE,"uploads/places_header_images/");
define(PLACES_HEADER_IMAGE_ORG,"uploads/places_header_images/org/");
define(PLACES_MENU_PDF,"uploads/places_menu_pdf/");
define(PROFILE_IMAGE,"uploads/profile_images/");
define(NEWS_IMAGE,"uploads/news_images/");

define(PLACES_LARGE_IMAGE_PATH,"uploads/places_images/large/");
define(PLACES_MEDIUM_IMAGE_PATH,"uploads/places_images/medium/");
define(PLACES_SMALL_IMAGE_PATH,"uploads/places_images/small/");
define(PLACES_ORIGINAL_IMAGE_PATH,"uploads/places_images/org/");

define(PLACES_VIDEO_PATH,"uploads/places_video/");



/* ================ define image size constants ===================== */ 
    define(SET_UPLOAD_PATH,"../");
// HEDER IMAGE TOP BANNER
    /*define(PLACES_HEADER_IMAGE_WIDTH,1280);
    define(PLACES_HEADER_IMAGE_HEIGHT,1057);*/
    
// DETAILS IMAGE 
   /* define(PLACES_LARGE_IMAGE_WIDTH,580);
    define(PLACES_LARGE_IMAGE_HEIGHT,479);    
    
// LISTING IMAGE 
    define(PLACES_MEDIUM_IMAGE_WIDTH,230);
    define(PLACES_MEDIUM_IMAGE_HEIGHT,190);    

// DETAILS IMAGE 
    define(PLACES_SMALL_IMAGE_WIDTH,70);
    define(PLACES_SMALL_IMAGE_HEIGHT,57);   */     


// HEDER IMAGE TOP BANNER
	define(PLACES_HEADER_IMAGE_WIDTH,1280);
    define(PLACES_HEADER_IMAGE_HEIGHT,746);
// DETAILS IMAGE 
    define(PLACES_LARGE_IMAGE_WIDTH,600);
    define(PLACES_LARGE_IMAGE_HEIGHT,350);    
    
// LISTING IMAGE 
    define(PLACES_MEDIUM_IMAGE_WIDTH,220);
    define(PLACES_MEDIUM_IMAGE_HEIGHT,128);    

// DETAILS IMAGE 
    define(PLACES_SMALL_IMAGE_WIDTH,75);
    define(PLACES_SMALL_IMAGE_HEIGHT,41);

/*****************defining constants ends here*****************/
?>