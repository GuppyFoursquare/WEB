<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 30 Dec 2014
 * @Modified    : 
 * @Description : This is category selection page using ajax grid
********************************************************/

include("ajax.connection.php");

$_SESSION['cityStateID']='';
$_SESSION['Sessinocat_name']='';
	
/* Array of database columns which should be read and sent back to DataTables. Use a space where
    * you want to insert a non-database field (for example a counter or static image)
    */
$aColumns = array('cat_id AS seq','cat_name','cat_id AS COUNT','cat_seq','cat_is_active','cat_id');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "cat_id";

/* DB table to use */
$sTable = "yb_category";
	
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
    $sOrder = " ORDER BY  cat_id  DESC";
}
$sOrder = " ORDER BY  cat_name  ASC";

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
        $sWhere=" WHERE cat_parent_id = 0 AND cat_is_delete =0";
    }else{
        $sWhere.=" AND cat_parent_id = 0 AND cat_is_delete =0";
    }

    if($_GET['cat_name']!=''){
	
			$searchcattitle=$_GET['cat_name'];
			
			$searchcattitle=str_replace('%', '|%',$searchcattitle);
			$searchcattitle=str_replace('_', '|_',$searchcattitle);				
			//echo $searchcattitle;
			if (strpos($searchcattitle,'%') !== false || strpos($searchcattitle,'_') !== false) {
				//die;
				 $ESCAPE= " ESCAPE '|' ";	
			}
			
            $_SESSION['Sessinocat_name']=trim($_GET['cat_name']);
            $sWhere.= " AND cat_name LIKE '%" .$searchcattitle."%'";
    }else{
            $_SESSION['Sessinocat_name']='';
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

                if ( $aColumns[$i] == "cat_id AS seq" ){
                    $id = $aRow[ $aColumns[$i] ];
                    $seqVal=$n+ $_GET['iDisplayStart'];
					$row[] = $seqVal;
                }elseif ( $aColumns[$i] == "cat_id AS COUNT" ){
                             $action= '<a href=subcategory_management.php?cat_id='.$aRow['cat_id'].'><img src="images/sub_category-icon.png" style="cursor:pointer"  border="0" title="Subcategory" /></a>';
                             $row[] = $action;
                }elseif ( $aColumns[$i] == "cat_id" ){
                    $action='<a class="" href="add_edit_category.php?cat_id='.stripslashes(base64_encode($aRow[ $aColumns[$i] ])).'"><img src="images/edit.png" style="cursor:pointer"  border="0" title="Edit" /></a>';
                    $rCount = getPlaceCount($aRow[$aColumns[$i]],1);
                    $action1='<div id="divDeleteRecord'.$aRow[$aColumns[$i]].'" name="divDeleteRecord" ><a href="javascript:;" onclick="confirmDeleteCategory('.$aRow[$aColumns[$i]].',\'yb_category\',\'catMasterTable\','.$rCount.',\'\')"><img src="images/delete.png" style="cursor:pointer"  border="0" title="Delete" /></a></div>';
                    $row[] = $action;
                    if($aRow['cat_id']!='1') $row[] = $action1;
                    else $row[] = $action1;
                                
                }elseif( $aColumns[$i] == "cat_seq" ){
                    if($_SESSION['set_session']==1){
                        $action = '<input name="id[]" id="id[]" type="hidden" size="5" value="'.$aRow['cat_id'].'" onkeypress="return keyRestrict(event,\'1234567890\')" maxlength="3" />
                                    <input type="hidden" value="'.$aRow['cat_seq'].'" class="categoryOrder"> 
                                    <input type="text"  name="chorder[]" id="chorder'.$aRow['cat_id'].'" data-CatID="'.$aRow['cat_id'].'" class="orderValue" value="'.$aRow['cat_seq'].'" data-CurrentOrder="'.$aRow['cat_seq'].'" style=" width:60px; text-align:center" onkeypress="return keyRestrict(event,\'1234567890\');" maxlength="3"/>';
                    }else $action = $aRow['cat_seq'];

                    $row[] = $action;
                }elseif ( $aColumns[$i] == "cat_is_active" ){

                    if($aRow[$aColumns[$i]] == 1){
			$activeAction='<div name="divStatusChangeActive" id="divStatusChange'.$aRow['cat_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['cat_id'].',0,\'yb_category\');">
					<img name="activeImage" id="imageStatus'.$aRow['cat_id'].'" src="images/active.png" style="cursor:pointer"  border="0" title="Active" /></a></div>';
                    }else{
                        $activeAction='<div name="divStatusChangeInactive" id="divStatusChange'.$aRow['cat_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['cat_id'].',1,\'yb_category\');">
                        <img name="inactiveImage" id="imageStatus'.$aRow['cat_id'].'" src="images/deactive.png" style="cursor:pointer"  border="0" title="Inactive" /></a></div>';
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
       
        function getPlaceCount($cat_id = 0,$is_p = 0){
            $iTotal = 0;
            $tblName = " yb_places_category PC ";
            $where = " P.plc_is_delete = 0 AND PC.plc_sub_cat_id = ".$cat_id;
            $sQuery = "
		SELECT *  
		FROM  $tblName join yb_places P on (PC.plc_id = P.plc_id) WHERE 
		$where 
                GROUP BY PC.plc_id 
                ";
            if($is_p){
                $sQuery = "
		SELECT * 
		FROM yb_places_category PC
                JOIN yb_category C ON (PC.plc_sub_cat_id = C.cat_id)
                JOIN yb_places P on (PC.plc_id = P.plc_id)
                WHERE P.plc_is_delete = 0 AND C.cat_parent_id = $cat_id 
                GROUP BY PC.plc_id 
                ";
            }
            
            
            $rResultTotal = mysql_query( $sQuery) or die(mysql_error());
            /*$aResultTotal = mysql_fetch_array($rResultTotal);
            if($aResultTotal){
                $iTotal = $aResultTotal[0];
            }*/
            return mysql_num_rows($rResultTotal);
        }
?>