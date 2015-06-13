<?php
include('phpgraphlib.php');
include('phpgraphlib_stacked.php');
$graph = new PHPGraphLib(300,300);

$total = array('Total'=> (int)$_REQUEST['total'],
    'Active'=> (int)$_REQUEST['active'],
    'In Active'=> (int)$_REQUEST['inactive']);

$graph->addData($total );
$type = $_REQUEST['type']. 'Information ';
$graph->setTitle($type);
$graph->setTitleLocation('Center');
$graph->setDataValues(true);
$graph->setXValuesHorizontal(TRUE);

$graph->setTextColor('#373837');
$graph->setGradient('#E4213F', '#FFE6E6');
$graph->setTitle($_REQUEST['type']);
$graph->setBarOutlineColor('#DF7D7A');
$graph->setLegendTitle('Total');
$graph->createGraph();
?>