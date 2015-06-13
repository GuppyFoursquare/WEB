<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : K.S.
 * @Maintainer  : K.S.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : This is FAQ selection page using ajax grid
********************************************************/

include("ajax.connection.php");

$_SESSION['cityStateID']='';
$_SESSION['Question']='';
	
/* Array of database columns which should be read and sent back to DataTables. Use a space where
    * you want to insert a non-database field (for example a counter or static image)
    */
$aColumns = array('faq_id AS seq','faq_question','faq_sequence','faq_is_active','faq_id');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "faq_id";

/* DB table to use */
$sTable = "yb_faq";
	
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
        $sOrder = "ORDER BY faq_sequence";
    }
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
        $sWhere=" WHERE  faq_is_delete =0 ";
    }else{
        $sWhere.=" AND  faq_is_delete =0";
    }

    if($_GET['question']!=''){
			
			$searchquestion=$_GET['question'];
			
			$searchquestion=str_replace('%', '|%',$searchquestion);
			$searchquestion=str_replace('_', '|_',$searchquestion);				
			//echo $searchquestion;
			if (strpos($searchquestion,'%') !== false || strpos($searchquestion,'_') !== false) {
				//die;
				 $ESCAPE= " ESCAPE '|' ";	
			}
			
	
            $_SESSION['Question']=trim($_GET['question']);
            $sWhere.= " AND faq_question LIKE '%" .$searchquestion."%'";
    }else{
            $_SESSION['Question']='';
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

                if ( $aColumns[$i] == "faq_id AS seq" ){
                    $id = $aRow[ $aColumns[$i] ];
                    $seqVal=$n+ $_GET['iDisplayStart'];
					$row[] = $seqVal;
                }elseif ( $aColumns[$i] == "faq_id" ){
                    $action='<a class="" href="add_edit_faq.php?faq_id='.stripslashes(base64_encode($aRow[ $aColumns[$i] ])).'"><img src="images/edit.png" style="cursor:pointer"  border="0" title="Edit" /></a>';
                    $action1='<div id="divDeleteRecord'.$aRow[$aColumns[$i]].'" name="divDeleteRecord" ><a href="javascript:;" onclick="confirmDelete('.$aRow[$aColumns[$i]].',\'yb_faq\',\'faqMasterTable\')"><img src="images/delete.png" style="cursor:pointer"  border="0" title="Delete" /></a></div>';
                    $row[] = $action;
                    if($aRow['cat_id']!='1') $row[] = $action1;
                    else $row[] = $action1;
                                
                }elseif( $aColumns[$i] == "faq_sequence" ){
                    if($_SESSION['set_session']==1){
                        $action = '<input name="id[]" id="id[]" type="hidden" size="5" value="'.$aRow['faq_id'].'" onkeypress="return keyRestrict(event,\'1234567890\')" maxlength="3" />
                                    <input type="hidden" value="'.$aRow['faq_sequence'].'" class="categoryOrder"> 
                                    <input type="text"  name="chorder[]" id="chorder'.$aRow['faq_id'].'" data-CatID="'.$aRow['faq_id'].'" class="orderValue" value="'.$aRow['faq_sequence'].'" data-CurrentOrder="'.$aRow['faq_sequence'].'" style=" width:60px; text-align:center" onkeypress="return keyRestrict(event,\'1234567890\');" maxlength="3" />';
                    }else $action = $aRow['faq_sequence'];

                    $row[] = $action;
                }elseif ( $aColumns[$i] == "faq_is_active" ){

                    if($aRow[$aColumns[$i]] == 1){
			$activeAction='<div name="divStatusChangeActive" id="divStatusChange'.$aRow['faq_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['faq_id'].',0,\'yb_faq\');">
					<img name="activeImage" id="imageStatus'.$aRow['faq_id'].'" src="images/active.png" style="cursor:pointer"  border="0" title="Active" /></a></div>';
                    }else{
                        $activeAction='<div name="divStatusChangeInactive" id="divStatusChange'.$aRow['faq_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['faq_id'].',1,\'yb_faq\');">
                        <img name="inactiveImage" id="imageStatus'.$aRow['faq_id'].'" src="images/deactive.png" style="cursor:pointer"  border="0" title="Inactive" /></a></div>';
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