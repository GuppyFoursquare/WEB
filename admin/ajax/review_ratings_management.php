<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 31 Dec 2014
 * @Modified    : 
 * @Description : This is Slider list page using ajax grid
********************************************************/

include("ajax.connection.php");

$_SESSION['cityStateID']='';
$_SESSION['Sessinomember_name']='';
	
/* Array of database columns which should be read and sent back to DataTables. Use a space where
    * you want to insert a non-database field (for example a counter or static image)
    */    
$aColumns = array('place_rating_id AS seq','plc_name','place_rating_rating','place_rating_comment','usr_first_name','places_rating_is_active','place_rating_id');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "place_rating_id";

/* DB table to use */
$sTable = "yb_places_rating,yb_places,yb_users";
	
/**********
* Paging
***/
$sLimit = "";
if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
{
    $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
    mysql_real_escape_string( $_GET['iDisplayLength'] );
}


/**********
* Ordering
*/
$sOrder = "";
if ( isset( $_GET['iSortCol_0'] ) )
{
    $sOrder = "ORDER BY  ";
    for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
    {
        if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
        {
            $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                   ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
        }
    }

    $sOrder = substr_replace( $sOrder, "", -2 );
    if ( $sOrder == "ORDER BY" ){
        $sOrder = "";
    }
}
if ($sOrder == '') {
    $sOrder = " ORDER BY  place_rating_id  DESC";
}


/*********************************************************************************
* Filtering
* NOTE this does not match the built-in DataTables filtering which does it
* word by word on any field. It's possible to do here, but concerned about efficiency
* on very large tables, and MySQL's regex functionality is very limited
****************/
$sWhere = "";
if (isset($_GET['sSearch']) && $_GET['sSearch'] != ""  )
{
    $sWhere = "WHERE (";
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
    }
    $sWhere = substr_replace( $sWhere, "", -3 );
    $sWhere .= ')';
}

    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ ){
        if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' ){
            if ( $sWhere == "" ){
                $sWhere = "WHERE ";
            }else{
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
	//echo $_REQUEST['plc_id'];
	if($_REQUEST['plc_id']!="")
	{
			
			if ( $sWhere == "" ){
			$sWhere="WHERE usr_id=places_rating_by AND yb_places_rating.plc_id=yb_places.plc_id AND yb_places_rating.plc_id=".base64_decode($_REQUEST['plc_id']);
			}else{
				$sWhere.="";
			}
    
	}
        else if($_REQUEST['pending']!="")
	{
			
			if ( $sWhere == "" ){
			$sWhere="WHERE usr_id=places_rating_by AND yb_places_rating.plc_id=yb_places.plc_id AND yb_places_rating.places_rating_is_active=0";
			}else{
				$sWhere.="";
			}
    
	}
	else{	
			if ( $sWhere == "" ){
			$sWhere="WHERE usr_id=places_rating_by AND yb_places_rating.plc_id=yb_places.plc_id";
			}else{
				$sWhere.="";
			}
	}

    if($_GET['usr_usernamer']!=''){
			
			$searchusr_usernamer=$_GET['usr_usernamer'];
			
			$searchusr_usernamer=str_replace('%', '|%',$searchusr_usernamer);
			$searchusr_usernamer=str_replace('_', '|_',$searchusr_usernamer);				
			//echo $searchusr_usernamer;
			if (strpos($searchusr_usernamer,'%') !== false || strpos($searchusr_usernamer,'_') !== false) {
				//die;
				 $ESCAPE= " ESCAPE '|' ";	
			}
	
            $_SESSION['Sessionuserr_name']=trim($_GET['usr_usernamer']);
            $sWhere.= " AND yb_users.usr_first_name LIKE '%" .$searchusr_usernamer."%'";
    }else{
            $_SESSION['Sessionuserr_name']='';
    }


	/*****************
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$ESCAPE
		$sOrder
		$sLimit
	";
	//echo $sQuery;
	//die();
	$rResult = mysql_query($sQuery) or die(mysql_error());

	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];

	/* Total data set length */
	if ( $sWhere == "" ) $sWhere="";
	else $sWhere.=" ";

	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
		$sWhere
		$ESCAPE
	";
	$rResultTotal = mysql_query( $sQuery) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];


	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);

	$cntRecord=0;
	$n=1;

	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
            $cntRecord++;
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
				if ( $aColumns[$i] == "place_rating_id AS seq" ){
                $id = $aRow[ $aColumns[$i] ];
                $seqVal=$n+ $_GET['iDisplayStart'];
				$row[] = $seqVal;
                }elseif ( $aColumns[$i] == "place_rating_rating" ){
                            switch($aRow[$aColumns[$i]]){
                            case 1:
                                    $row[] = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" />';
                            break;
                            case 2:
                                    $row[] = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" />';
                            break;
                            case 3:
                                    $row[] = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" />';
                            break;	
                            case 4:
                                    $row[] = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Rating" />';
                            break;	
                            case 5:
                                    $row[] = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Rating" />';
                            break;	
                            }		
                    }elseif ( $aColumns[$i] == "place_rating_id" ){
                        
                        if($_REQUEST['plc_id']){
                            $str = '&plc_id='.$_REQUEST['plc_id'];
                        }
                        else if($_REQUEST['pending'])
                        {
                            $str = '&pending='.$_REQUEST['pending'];
                        }
                        else
                        {
                            $str = '';
                        }
                    $action='<a class="" href="add_edit_review_ratings.php?place_rating_id='.stripslashes(base64_encode($aRow[ $aColumns[$i] ])).$str.'"><img src="images/edit.png" style="cursor:pointer"  border="0" title="Edit" /></a>';
                    $action1='<div id="divDeleteRecord'.$aRow[$aColumns[$i]].'" name="divDeleteRecord" ><a href="javascript:;" onclick="confirmDelete('.$aRow[$aColumns[$i]].',\'yb_places_rating\',\'reviewMasterTable\')"><img src="images/delete.png" style="cursor:pointer"  border="0" title="Delete" /></a></div>';
                    $row[] = $action;
                    if($aRow['place_rating_id']!='1') $row[] = $action1;
                    else $row[] = $action1;
                                
                }elseif ( $aColumns[$i] == "places_rating_is_active" ){

                    if($aRow[$aColumns[$i]] == 1){
			/*$activeAction='<div name="divStatusChangeActive" id="divStatusChange'.$aRow['place_rating_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['place_rating_id'].',0,\'yb_places_rating\');">
					<img name="activeImage" id="imageStatus'.$aRow['place_rating_id'].'" src="images/active.png" style="cursor:pointer"  border="0" title="Active" /></a></div>';*/
                        
                        $activeAction='<div name="divStatusChangeActive" id="divStatusChange'.$aRow['place_rating_id'].'"><a  href="javascript:;" >
					<img name="activeImage" id="imageStatus'.$aRow['place_rating_id'].'" src="images/active.png" style="cursor:pointer"  border="0" title="Active" /></a></div>';
                    }else{
                        $activeAction='<div name="divStatusChangeInactive" id="divStatusChange'.$aRow['place_rating_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['place_rating_id'].',1,\'yb_places_rating\');">
                        <img name="inactiveImage" id="imageStatus'.$aRow['place_rating_id'].'" src="images/deactive.png" style="cursor:pointer"  border="0" title="Inactive" /></a></div>';
                    }
                    $row[] = $activeAction;

                }else if ( $aColumns[$i] != ' ' ){
                    /* General output */
                     $row[] = stripslashes($aRow[ $aColumns[$i] ]);
                }
            }
            $output['aaData'][] = $row;
            $n++;
	}
	echo json_encode( $output );
        

?>