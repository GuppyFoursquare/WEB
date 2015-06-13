<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : Change status
********************************************************/

#PROCESS -----------------------------------------------------------------------



switch($sTableName){
    case yb_category:
				$rStatus = mysql_query("UPDATE $sTableName SET cat_is_active=$iAction WHERE cat_id=$iID") or die("Error:in status updation".mysql_error());
        break;
		
	//Case For FAQ Status Change	
    case yb_faq:
            $rStatus = mysql_query("UPDATE $sTableName SET faq_is_active=$iAction WHERE faq_id=$iID") or die("Error:in status updation".mysql_error());
        break;
	
	//Case For Slider Status Change
	case yb_slider:
			$rStatus = mysql_query("UPDATE $sTableName SET slide_is_active=$iAction WHERE slide_id=$iID") or die("Error:in status updation".mysql_error());
        break;
    
        case yb_home_slider:
			$rStatus = mysql_query("UPDATE $sTableName SET home_slider_is_active=$iAction WHERE home_slider_id=$iID") or die("Error:in status updation".mysql_error());
        break;
		
	case yb_features:
			$rStatus = mysql_query("UPDATE $sTableName SET feature_is_active=$iAction WHERE feature_id=$iID") or die("Error:in status updation".mysql_error());
        break;	
		
	case yb_users:
			$rStatus = mysql_query("UPDATE $sTableName SET usr_active=$iAction WHERE usr_id=$iID") or die("Error:in status updation".mysql_error());
        break;

	case yb_news:
			$rStatus = mysql_query("UPDATE $sTableName SET news_is_active=$iAction WHERE news_id=$iID") or die("Error:in status updation".mysql_error());
        break;	
	
	case yb_content:
			$rStatus = mysql_query("UPDATE $sTableName SET cnt_isactive=$iAction WHERE cnt_id=$iID") or die("Error:in status updation".mysql_error());
        break;		
	
	case yb_rolemst:
			$rStatus = mysql_query("UPDATE $sTableName SET role_status=$iAction WHERE role_id=$iID") or die("Error:in status updation".mysql_error());
        break;
        case yb_places:
			$rStatus = mysql_query("UPDATE $sTableName SET plc_is_active=$iAction WHERE plc_id=$iID") or die("Error:in status updation".mysql_error());
        break;
        break;
	case yb_places_rating:
			$rStatus = mysql_query("UPDATE $sTableName SET  	places_rating_is_active=$iAction WHERE place_rating_id=$iID") or die("Error:in status updation".mysql_error());
        break;
        case yb_countrymst:
			$rStatus = mysql_query("UPDATE $sTableName SET  	country_is_active=$iAction WHERE country_id=$iID") or die("Error:in status updation".mysql_error());
        break;
        case yb_statemst:
			$rStatus = mysql_query("UPDATE $sTableName SET  	state_is_active=$iAction WHERE state_id=$iID") or die("Error:in status updation".mysql_error());
        break;
}
if ($iAction == 1) {
    echo $activeAction = '<div name="divStatusChangeActive" id="divStatusChange' . $iID . '"><a  href="javascript:;" onclick="confirmStatus(' . $iID . ',0,\''.$sTableName.'\');">
                    <img name="activeImage" id="imageStatus' . $iID . '" src="images/active.png" style="cursor:pointer"  border="0" title="Active" /></a></div>';
} else {
    echo $activeAction = '<div name="divStatusChangeInactive" id="divStatusChange' . $iID . '"><a  href="javascript:;" onclick="confirmStatus(' . $iID . ',1,\''.$sTableName.'\');">
                    <img name="inactiveImage" id="imageStatus' . $iID . '" src="images/deactive.png" style="cursor:pointer"  border="0" title="Inactive" /></a></div>';
}
