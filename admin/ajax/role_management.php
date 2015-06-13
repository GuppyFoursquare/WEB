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
$_SESSION['Sessinorole_type']='';
	
/* Array of database columns which should be read and sent back to DataTables. Use a space where
    * you want to insert a non-database field (for example a counter or static image)
    */
$aColumns = array('role_id AS seq','role_type','role_description','role_status','role_id');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "role_id";

/* DB table to use */
$sTable = "yb_rolemst";
	
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
    $sOrder = " ORDER BY  role_id  DESC";
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


    if ( $sWhere == "" ){
        $sWhere=" WHERE  role_removed =0 ";
    }else{
        $sWhere.=" AND  role_removed =0";
    }

    if($_GET['role_type']!=''){
	
			$searchrole_type=$_GET['role_type'];
			
			$searchrole_type=str_replace('%', '|%',$searchrole_type);
			$searchrole_type=str_replace('_', '|_',$searchrole_type);				
			//echo $searchrole_type;
			if (strpos($searchrole_type,'%') !== false || strpos($searchrole_type,'_') !== false) {
				//die;
				 $ESCAPE= " ESCAPE '|' ";	
			}
	
            $_SESSION['Sessinorole_type']=trim($_GET['role_type']);
            $sWhere.= " AND role_type LIKE '%" .$searchrole_type."%'";
    }else{
            $_SESSION['Sessinorole_type']='';
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
					 if ( $aColumns[$i] == "role_id AS seq" ){
                    $id = $aRow[ $aColumns[$i] ];
                    $seqVal=$n+ $_GET['iDisplayStart'];
					$row[] = $seqVal;
                }elseif ( $aColumns[$i] == "role_id" ){
                    $action='<a class="" href="add_edit_roles.php?role_id='.stripslashes(base64_encode($aRow[ $aColumns[$i] ])).'"><img src="images/edit.png" style="cursor:pointer"  border="0" title="Edit" /></a>';
                    $action1='<div id="divDeleteRecord'.$aRow[$aColumns[$i]].'" name="divDeleteRecord" ><a href="javascript:;" onclick="confirmDelete('.$aRow[$aColumns[$i]].',\'yb_rolemst\',\'rolesMasterTable\')"><img src="images/delete.png" style="cursor:pointer"  border="0" title="Delete" /></a></div>';
                    $row[] = $action;
                    if($aRow['role_id']!='1') $row[] = $action1;
                    else $row[] = $action1;
                                
                }elseif ( $aColumns[$i] == "role_status" ){

                    if($aRow[$aColumns[$i]] == 1){
			$activeAction='<div name="divStatusChangeActive" id="divStatusChange'.$aRow['role_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['role_id'].',0,\'yb_rolemst\');">
					<img name="activeImage" id="imageStatus'.$aRow['role_id'].'" src="images/active.png" style="cursor:pointer"  border="0" title="Active" /></a></div>';
                    }else{
                        $activeAction='<div name="divStatusChangeInactive" id="divStatusChange'.$aRow['role_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['role_id'].',1,\'yb_rolemst\');">
                        <img name="inactiveImage" id="imageStatus'.$aRow['role_id'].'" src="images/deactive.png" style="cursor:pointer"  border="0" title="Inactive" /></a></div>';
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