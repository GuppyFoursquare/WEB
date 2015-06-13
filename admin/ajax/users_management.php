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
$_SESSION['Sessinouser_name']='';
	
/* Array of database columns which should be read and sent back to DataTables. Use a space where
    * you want to insert a non-database field (for example a counter or static image)
    */
$aColumns = array('usr_id AS seq','usr_first_name','usr_last_name','usr_username','usr_id AS changepassword','usr_email','usr_active','usr_id');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "usr_id";

/* DB table to use */
$sTable = "yb_users";
	
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
    $sOrder = " ORDER BY  usr_id  DESC";
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
        $sWhere=" WHERE  usr_delete =0 AND usr_user_type='Sub-Admin'";
    }else{
        $sWhere.=" AND  usr_delete =0";
    }

    if($_GET['usr_username']!='' && $_GET['usr_email']!=''){
            $_SESSION['Sessinomember_name']=trim($_GET['usr_username']);
			$_SESSION['Sessinomember_email']=trim($_GET['usr_email']);
            $sWhere.= " AND usr_username LIKE '%" . mysql_real_escape_string(trim($_GET['usr_username']))."%' AND usr_email LIKE '%" . mysql_real_escape_string(trim($_GET['usr_email']))."%'";
    }else{
            if($_GET['usr_username']!=''){
            $_SESSION['Sessinomember_name']=trim($_GET['usr_username']);
            $sWhere.= " AND usr_username LIKE '%" . mysql_real_escape_string(trim($_GET['usr_username']))."%'";
			}else{		
			$_SESSION['Sessinomember_name']='';}
			
			if($_GET['usr_email']!=''){
            $_SESSION['Sessinomember_email']=trim($_GET['usr_email']);
            $sWhere.= " AND usr_email LIKE '%" . mysql_real_escape_string(trim($_GET['usr_email']))."%'";
			}else{		
			$_SESSION['Sessinomember_email']='';}
		 
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
                if ( $aColumns[$i] == "usr_id AS seq" ){
                    $id = $aRow[ $aColumns[$i] ];
                    $seqVal=$n+ $_GET['iDisplayStart'];
					$row[] = $seqVal;
                }elseif ( $aColumns[$i] == "usr_id" ){
                    $action='<a class="" href="add_edit_users.php?usr_id='.stripslashes(base64_encode($aRow[ $aColumns[$i] ])).'"><img src="images/edit.png" style="cursor:pointer"  border="0" title="Edit" /></a>';
                    $action1='<div id="divDeleteRecord'.$aRow[$aColumns[$i]].'" name="divDeleteRecord" ><a href="javascript:;" onclick="confirmDelete('.$aRow[$aColumns[$i]].',\'yb_users\',\'usersMasterTable\')"><img src="images/delete.png" style="cursor:pointer"  border="0" title="Delete" /></a></div>';
                    $row[] = $action;
                    if($aRow['usr_id']!='1') $row[] = $action1;
                    else $row[] = $action1;
                }elseif ( $aColumns[$i] == "usr_id AS changepassword" ){
                    $action='<a class="" href="change_password.php?p=sub&usr_id='.stripslashes(base64_encode($aRow[ 'changepassword' ])).'"><img src="images/change_pass.png" style="cursor:pointer"  border="0" title="Change Password" /></a>';
                    $row[] = $action;
                }elseif ( $aColumns[$i] == "usr_active" ){

                    if($aRow[$aColumns[$i]] == 1){
			$activeAction='<div name="divStatusChangeActive" id="divStatusChange'.$aRow['usr_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['usr_id'].',0,\'yb_users\');">
					<img name="activeImage" id="imageStatus'.$aRow['usr_id'].'" src="images/active.png" style="cursor:pointer"  border="0" title="Active" /></a></div>';
                    }else{
                        $activeAction='<div name="divStatusChangeInactive" id="divStatusChange'.$aRow['usr_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['usr_id'].',1,\'yb_users\');">
                        <img name="inactiveImage" id="imageStatus'.$aRow['usr_id'].'" src="images/deactive.png" style="cursor:pointer"  border="0" title="Inactive" /></a></div>';
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