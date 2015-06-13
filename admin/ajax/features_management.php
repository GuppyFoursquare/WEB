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
$_SESSION['Sessinofeature_title']='';
	$ESCAPE='';
/* Array of database columns which should be read and sent back to DataTables. Use a space where
    * you want to insert a non-database field (for example a counter or static image)
    */
$aColumns = array('feature_id AS seq','feature_title','feature_icon','feature_sequence','feature_is_active','feature_id');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "feature_id";

/* DB table to use */
$sTable = "yb_features";
	
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
    $sOrder = " ORDER BY  feature_id  DESC";
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
        $sWhere=" WHERE  feature_is_delete=0";
    }else{
        $sWhere.=" AND  feature_is_delete=0";
    }

    
	
	if($_GET['feature_title']!=''){
		    	
			$searchfeaturetitle=$_GET['feature_title'];
			
			$searchfeaturetitle=str_replace('%', '|%',$searchfeaturetitle);
			$searchfeaturetitle=str_replace('_', '|_',$searchfeaturetitle);				
			//echo $searchfeaturetitle;
			if (strpos($searchfeaturetitle,'%') !== false || strpos($searchfeaturetitle,'_') !== false) {
				//die;
				 $ESCAPE= " ESCAPE '|' ";	
			}
			
			$_SESSION['Sessinofeature_title']=trim($_GET['feature_title']);
            $sWhere.= " AND feature_title LIKE '%" .$searchfeaturetitle."%'";
			
    }else{
            $_SESSION['Sessinofeature_title']='';
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
					if ($aColumns[$i] == 'feature_icon') {
						$slider_icon = $aRow['feature_icon'];
						$path = '../'.CATEGORY_IMAGE.$slider_icon;
						$newDimensions = $path;
						$w = 50;
						$h = 50;
						$action_img='<div class="backgroung_grey"><img src="../uploads/feature_icons/'.$slider_icon.'"  height="'.$h.'" width="'.$w.'" border="0"  /></div>';
						$row[] = $action_img;
					}else if ( $aColumns[$i] == "feature_id AS seq" ){
                    $id = $aRow[ $aColumns[$i] ];
                    $seqVal=$n+ $_GET['iDisplayStart'];
					$row[] = $seqVal;
                }elseif ( $aColumns[$i] == "feature_id" ){
                    $action='<a class="" href="add_edit_features.php?feature_id='.stripslashes(base64_encode($aRow[ $aColumns[$i] ])).'"><img src="images/edit.png" style="cursor:pointer"  border="0" title="Edit" /></a>';
                    $action1='<div id="divDeleteRecord'.$aRow[$aColumns[$i]].'" name="divDeleteRecord" ><a href="javascript:;" onclick="confirmDelete('.$aRow[$aColumns[$i]].',\'yb_features\',\'featuresMasterTable\')"><img src="images/delete.png" style="cursor:pointer"  border="0" title="Delete" /></a></div>';
                    $row[] = $action;
                    if($aRow['feature_id']!='1') $row[] = $action1;
                    else $row[] = $action1;
                                
                }elseif( $aColumns[$i] == "feature_sequence" ){
                    if($_SESSION['set_session']==1){
                        $action = '<input name="id[]" id="id[]" type="hidden" size="5" value="'.$aRow['feature_id'].'" onkeypress="return keyRestrict(event,\'1234567890\')" maxlength="3" />
                                    <input type="hidden" value="'.$aRow['feature_sequence'].'" class="categoryOrder"> 
                                    <input type="text"  name="chorder[]" id="chorder'.$aRow['feature_id'].'" data-CatID="'.$aRow['feature_id'].'" class="orderValue" value="'.$aRow['feature_sequence'].'" data-CurrentOrder="'.$aRow['feature_sequence'].'" style=" width:60px; text-align:center" onkeypress="return keyRestrict(event,\'1234567890\');" maxlength="3"/>';
                    }else $action = $aRow['feature_sequence'];

                    $row[] = $action;
                }elseif ( $aColumns[$i] == "feature_is_active" ){

                    if($aRow[$aColumns[$i]] == 1){
			$activeAction='<div name="divStatusChangeActive" id="divStatusChange'.$aRow['feature_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['feature_id'].',0,\'yb_features\');">
					<img name="activeImage" id="imageStatus'.$aRow['feature_id'].'" src="images/active.png" style="cursor:pointer"  border="0" title="Active" /></a></div>';
                    }else{
                        $activeAction='<div name="divStatusChangeInactive" id="divStatusChange'.$aRow['feature_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['feature_id'].',1,\'yb_features\');">
                        <img name="inactiveImage" id="imageStatus'.$aRow['feature_id'].'" src="images/deactive.png" style="cursor:pointer"  border="0" title="Inactive" /></a></div>';
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