<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : Delete record from table
********************************************************/

#PROCESS -----------------------------------------------------------------------


switch($sTableName){
    case 'yb_category' :
        $rSql=mysql_query("SELECT cat_image,cat_icon FROM $sTableName WHERE cat_id=$iID") or die("Error:in image selection".mysql_error());
        if(mysql_num_rows($rSql) > 0){
            $aRow = mysql_fetch_assoc($rSql);
            $sCatImage = stripslashes($aRow['cat_image']);
            $sCatIcon = stripslashes($aRow['cat_icon']);
            unlink("../".CATEGORY_IMAGE.$sCatImage);
            unlink("../".CATEGORY_ICON.$sCatIcon);
        }   
		
		$rDelete = mysql_query("DELETE FROM $sTableName WHERE cat_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
		
		
		case 'yb_faq' :
        $rDelete = mysql_query("DELETE FROM $sTableName WHERE faq_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;	
		
        case 'yb_countrymst' :
        $rDelete = mysql_query("DELETE FROM $sTableName WHERE country_id =$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
    
        case 'yb_statemst' :
        $rDelete = mysql_query("DELETE FROM $sTableName WHERE state_id =$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
		case 'yb_slider' :
        $rSql=mysql_query("SELECT slide_image FROM $sTableName WHERE slide_id=$iID") or die("Error:in image selection".mysql_error());
        if(mysql_num_rows($rSql) > 0){
            $aRow = mysql_fetch_assoc($rSql);
            $sSlideImage = stripslashes($aRow['slide_image']);
			unlink("../".SLIDER_IMAGE.$sSlideImage);
           
        }   
		
		$rDelete = mysql_query("DELETE FROM $sTableName WHERE slide_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
        
        
                case 'yb_home_slider' :
        $rSql=mysql_query("SELECT home_slider_image FROM $sTableName WHERE home_slider_id=$iID") or die("Error:in image selection".mysql_error());
        if(mysql_num_rows($rSql) > 0){
            $aRow = mysql_fetch_assoc($rSql);
            $sSlideImage = stripslashes($aRow['slide_image']);
			unlink("../".SLIDER_IMAGE.$sSlideImage);
           
        }   
		
		$rDelete = mysql_query("DELETE FROM $sTableName WHERE home_slider_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
        
		
		case 'yb_features' :
        $rSql=mysql_query("SELECT feature_icon FROM $sTableName WHERE feature_id=$iID") or die("Error:in image selection".mysql_error());
        if(mysql_num_rows($rSql) > 0){
            $aRow = mysql_fetch_assoc($rSql);
            $sFeatureImage = stripslashes($aRow['feature_icon']);
			unlink("../".FEATURE_ICON.$sFeatureImage);
           
        }   
		
		$rDelete = mysql_query("DELETE FROM $sTableName WHERE feature_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
		
		case 'yb_users' :
        $rDelete = mysql_query("DELETE FROM $sTableName WHERE usr_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
		
		
		case 'yb_news' :
        $rSql=mysql_query("SELECT news_photo FROM $sTableName WHERE news_id=$iID") or die("Error:in image selection".mysql_error());
        if(mysql_num_rows($rSql) > 0){
            $aRow = mysql_fetch_assoc($rSql);
            $sNewsImage = stripslashes($aRow['news_photo']);
			unlink("../".NEWS_IMAGE.$sNewsImage);
           
        }   
		
		$rDelete = mysql_query("DELETE FROM $sTableName WHERE news_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
		
		
		case 'yb_content' :
        $rDelete = mysql_query("DELETE FROM $sTableName WHERE cnt_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
		
		case 'yb_rolemst' :
        $rDelete = mysql_query("DELETE FROM $sTableName WHERE role_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
        case 'yb_places':
        $rDelete = mysql_query("UPDATE $sTableName SET plc_is_delete=1 WHERE plc_id=$iID") or die("Error:in delete record".mysql_error());
            echo 1;
        break;
		
		case 'yb_places_rating' :
        $rDelete = mysql_query("DELETE FROM $sTableName WHERE place_rating_id=$iID") or die("Error:in delete record".mysql_error());

		echo 1;
        
        break;
}


