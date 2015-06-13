<?php
//echo $sPageClass;
switch ($sPageClass) {

    case 'faq':
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
        $_SESSION['Sessinoplc_name']='';
		$_SESSION['Sessinomember_email']='';
        break;

    case 'dashboard':
        $_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
        $_SESSION['Sessinoplc_name']='';
		$_SESSION['Sessinomember_email']='';
		break;

    case 'features':
		$_SESSION['Question']="";
		$_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
        $_SESSION['Sessinoplc_name']='';
		$_SESSION['Sessinomember_email']='';
		break;
    case 'subnewsspecials':
		$_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
        $_SESSION['Sessinoplc_name']='';
		$_SESSION['Sessinomember_email']='';
        break;
		
	case 'suboffmenu':
		 $_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
        $_SESSION['Sessinoplc_name']='';
		$_SESSION['Sessinomember_email']='';
        break;
    
     case 'subrole':
		
		$_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
        $_SESSION['Sessinoplc_name']='';
		$_SESSION['Sessinomember_email']='';
		break;
		
	case 'slider':
		$_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
		$_SESSION['Sessinoplc_name']='';	
		$_SESSION['Sessinomember_email']='';
		break;
		
	case 'subadmin':
		$_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessionuserr_name']='';
        $_SESSION['Sessinoplc_name']='';
		$_SESSION['Sessinomember_email']='';
		
		break;
		
		
	case 'category':
		$_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';	
        $_SESSION['Sessinoplc_name']='';
	    $_SESSION['Sessinomember_email']='';
		break;
		
	case 'addsubcategory':
		$_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
        $_SESSION['Sessinoplc_name']='';
		$_SESSION['Sessinomember_email']='';
		break;	
		
	 case 'submember':
        $_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
        $_SESSION['Sessinoplc_name']='';
		break;
		
	case 'subreview_ratings':
        $_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
        //$_SESSION['Sessinoplc_name']='';
	    $_SESSION['Sessinomember_email']='';
		break;
		
        case 'places':
        $_SESSION['Question']="";
		$_SESSION['Sessinofeature_title']="";
        $_SESSION['Sessinonews_title']='';
		$_SESSION['Sessinopage_heading']='';
		$_SESSION['Sessinocat_name']='';
		$_SESSION['SessionSubcat_name']='';
		$_SESSION['Sessinoslide_name']=''; 
		$_SESSION['Sessinomember_name']=''; 
		$_SESSION['Sessinorole_type']='';
		$_SESSION['Sessinouser_name']='';
		$_SESSION['Sessionuserr_name']='';
		$_SESSION['Sessinomember_email']='';
        break;
}



?>