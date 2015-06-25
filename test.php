<?php

    include("prepend.php");
    include("./api/class/PlaceClass.php");

    $latitude = "40.382877";
    $longitude = "49.822825";

    $tblName = " yb_places plc                            
                    LEFT JOIN yb_countrymst c ON plc.plc_country_id = c.country_id 
                    LEFT JOIN yb_statemst s ON plc.plc_state_id = s.state_id 
                    LEFT JOIN yb_places_rating r ON plc.plc_id = r.plc_id AND r.places_rating_is_active = 1 ";
    $disCol = " *,plc.plc_id AS plc_id,  ( 3959 * acos( cos( radians(".$latitude.") ) * cos( radians( plc_latitude ) ) * cos( radians( plc_longitude ) - radians(".$longitude.") ) + sin( radians(".$latitude.") ) * sin( radians( plc_latitude ) ) ) ) AS distance ";
    $where = " plc.plc_is_delete = 0 AND plc.plc_is_active = 1 ";
    $having = " distance < 50 ";
    $order_col = " distance ";
            
    $qry = "SELECT " . $disCol . " FROM " . $tblName;

    if ($where != '')
        $qry .= " WHERE " . $where;
    
    if ($having != '')
        $qry .= " HAVING " . $having;

    if ($order_col != '')
        $qry .= " ORDER BY " . $order_col;

    if ($order_by != '')
        $qry .= $order_by;

    if ($group_by != '')
        $qry .= ' GROUP BY ' . $group_by;

    //for display query
    if (!empty($disQuery)) {
        echo $qry;
        die;
    }
            
    $result = mysql_query($qry);                     
    $resultData = array();
    if (@mysql_errno() == '0' && mysql_num_rows($result) > '0') {
        if($singleRow)
        {
            $resultData = mysql_fetch_assoc($result);
        }else{
            while($row = mysql_fetch_object($result , 'Place')){
                echo json_encode($row);                
                array_push($resultData, utf8ize($row));
            }
        }      
    }
    
    $result = Result::$SUCCESS->setContent($resultData);
    echo json_encode($result);

    
    /**    
        * @author GUPPY Org. <kskaraca@gmail.com>
        * @param type $d array object
        * @return type
        * @version 1.0 
        * 
        * This function is used for encoding objects to JSON
        * properly.
        */
       function utf8ize($d) {
           if (is_array($d)) {
               foreach ($d as $k => $v) {
                   $d[$k] = utf8ize($v);
               }
           } else if (is_string ($d)) {
               return utf8_encode($d);
           }
           return $d;
       }
    
?>
