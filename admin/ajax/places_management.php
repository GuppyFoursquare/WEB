<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 07 Jan 2015
 * @Modified    : 
 * @Description : This is Places list page using ajax grid
********************************************************/

include("ajax.connection.php");

$_SESSION['cityStateID']='';
$_SESSION['Sessinoplc_name']='';
	
/* Array of database columns which should be read and sent back to DataTables. Use a space where
    * you want to insert a non-database field (for example a counter or static image)
    */
$aColumns = array('plc_id AS seq','plc_name','plc_id AS gallery','plc_id AS rating','plc_is_active','plc_id');

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "plc_id";

/* DB table to use */
$sTable = "yb_places";
	
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
        $sOrder = "ORDER BY plc_name";
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
        $sWhere=" WHERE  plc_is_delete=0";
    }else{
        $sWhere.=" AND  plc_is_delete=0";
    }

    if($_GET['plc_name']!=''){
			
			$searchplc_name=$_GET['plc_name'];
			
			$searchplc_name=str_replace('%', '|%',$searchplc_name);
			$searchplc_name=str_replace('_', '|_',$searchplc_name);				
			//echo $searchplc_name;
			if (strpos($searchplc_name,'%') !== false || strpos($searchplc_name,'_') !== false) {
				//die;
				 $ESCAPE= " ESCAPE '|' ";	
			}
			
            $_SESSION['Sessinoplc_name']=trim($_GET['plc_name']);
            $sWhere.= " AND plc_name LIKE '%" .$searchplc_name."%'";
    }else{
            $_SESSION['Sessinoplc_name']='';
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
                if ( $aColumns[$i] == "plc_id AS seq" ){
                    $id = $aRow[ $aColumns[$i] ];
                    $seqVal=$n+ $_GET['iDisplayStart'];
                    $row[] = $seqVal;
                }elseif ( $aColumns[$i] == "plc_id" ){
                    $action='<a class="" href="add_edit_places.php?plc_id='.stripslashes(base64_encode($aRow[ $aColumns[$i] ])).'"><img src="images/edit.png" style="cursor:pointer"  border="0" title="Edit" /></a>';
                    $action1='<div id="divDeleteRecord'.$aRow[$aColumns[$i]].'" name="divDeleteRecord" ><a href="javascript:;" onclick="confirmDelete('.$aRow[$aColumns[$i]].',\'yb_places\',\'placesMasterTable\')"><img src="images/delete.png" style="cursor:pointer"  border="0" title="Delete" /></a></div>';
                    $row[] = $action;
                    if($aRow['plc_id']!='1') $row[] = $action1;
                    else $row[] = $action1;
                                
                }
                elseif ( $aColumns[$i] == "plc_id AS gallery" ){
                    $action='<a class="" href="manage_photo.php?id='.stripslashes($aRow[ 'plc_id' ]).'"><img src="images/gallery.png" style="cursor:pointer"  border="0" title="Gallery" /></a>';
                    $row[] = $action;
                }
                elseif ( $aColumns[$i] == "plc_id AS rating" ){
                    $ratAvg = getAvgRating($aRow['plc_id']);
                    $action='<a class="" href="review_ratings.php?plc_id='.stripslashes(base64_encode($aRow[ 'plc_id' ])).'">';
                    $stars = "";
                    
                    
                    if($ratAvg)
                    {
                        if($ratAvg >= 0 && $ratAvg < 0.5)
                        {
                            $stars = '<img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg > 0.5 && $ratAvg < 1)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg >= 1 && $ratAvg < 1.5)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg > 1.5 && $ratAvg < 2)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg >= 2 && $ratAvg < 2.5)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg > 2.5 && $ratAvg < 3)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg >= 3 && $ratAvg < 3.5)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg >3.5 && $ratAvg < 4)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg >= 4 && $ratAvg < 4.5)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg > 4.5)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg == 0.5)
                        {
                            $stars = '<img src="images/star-5.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg == 1.5)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-5.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg == 2.5)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-5.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg == 3.5)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-5.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else if($ratAvg == 4.5)
                        {
                            $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-5.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                        }
                        else
                        {
                            $stars = $ratAvg;
                        }
                    }
                    else 
                    {
                        $stars = '<img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                    }
                    
                    
                    /*
                    switch($ratAvg){
                            case 1:
                                    $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                            break;
                            case 2:
                                    $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                            break;
                            case 3:
                                    $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                            break;	
                            case 4:
                                    $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                            break;	
                            case 5:
                                    $stars = '<img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-4.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                            break;
                            default :
                                    $stars = '<img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" /><img src="images/star-1.png" style="cursor:pointer"  border="0" title="Review & Ratings" />';
                            break;
                        }*/
                     
                     $action = $action.$stars."</a>";
                     $row[] = $action;
                }elseif ( $aColumns[$i] == "plc_is_active" ){

                    if($aRow[$aColumns[$i]] == 1){
			$activeAction='<div name="divStatusChangeActive" id="divStatusChange'.$aRow['plc_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['plc_id'].',0,\'yb_places\');">
					<img name="activeImage" id="imageStatus'.$aRow['plc_id'].'" src="images/active.png" style="cursor:pointer"  border="0" title="Active" /></a></div>';
                    }else{
                        $activeAction='<div name="divStatusChangeInactive" id="divStatusChange'.$aRow['plc_id'].'"><a  href="javascript:;" onclick="confirmStatus('.$aRow['plc_id'].',1,\'yb_places\');">
                                        <img name="inactiveImage" id="imageStatus'.$aRow['plc_id'].'" src="images/deactive.png" style="cursor:pointer"  border="0" title="Inactive" /></a></div>';
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
        
        function getAvgRating($plc_id = 0){
            $sqlGetAvgRat="SELECT AVG(place_rating_rating) as avg_rating
                            FROM yb_places_rating
                            WHERE plc_id=$plc_id";
            $rsAvg=  mysql_query($sqlGetAvgRat) or die('Rating Error'.mysql_error());
            $numRow= mysql_num_rows($rsAvg);
              if($numRow){
                   $rsAvgRows=mysql_fetch_assoc($rsAvg);
                  //$number=round($rsAvgRows['avg_rating']);
                   $number=$rsAvgRows['avg_rating'];
              }  else {
                  $number=0;
              }
            //return round($number);
              return $number;
        }
?>