<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class db
{
    function __construct() {
        //require_once("includes/connection.inc.php");
    }
    
    //SQL FUNCTIONS SECTION
    //Select Query
    /**
     * Select records using this function by passing required parameters
     * @param type $tblName
     * @param type $disCol
     * @param type $where
     * @param type $order_col
     * @param type $order_by
     * @param type $group_by
     * @param type $disQuery
     * @return type 
     */
    function selectQuery($tblName, $disCol, $where, $order_col, $order_by, $group_by, $disQuery,$singleRow = 0) {
        $qry = "SELECT " . $disCol . " FROM " . $tblName;

        if ($where != '')
            $qry .= " WHERE " . $where;

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

        //execute query
        $result = mysql_query($qry);
        $resultData = array();
        if (@mysql_errno() == '0' && mysql_num_rows($result) > '0') {
            if($singleRow)
            {
                $resultData = mysql_fetch_assoc($result);
            }else{
                while($row = mysql_fetch_assoc($result)){
                    array_push($resultData, $row);
                }
            }
            return $resultData;
        } else {
            return array();
        }
    }

    
    function selectQueryResource($tblName, $disCol, $where, $order_col, $order_by, $group_by, $disQuery) {
        $qry = "SELECT " . $disCol . " FROM " . $tblName;

        if ($where != '')
            $qry .= " WHERE " . $where;

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

        //execute query
        $result = mysql_query($qry);

        if (@mysql_errno() == '0' && mysql_num_rows($result) > '0') {
            return $result;
        } else {
            return array();
        }
    }
    // Select query function
    /**
     * executeSql
     * @param type $strSql
     * @return int 
     */
    function executeSql($strSql="")
    {
        if(!empty($strSql))
        {
            $result = mysql_query($strSql);

            if (@mysql_errno() == '0' && mysql_num_rows($result) > '0') {
                return $result;
            } else {
                return array();
            }
        }
        return 0;
    }
    //Update query function
    /**
     * updateQuery
     * @param type $tblName
     * @param type $updateCol
     * @param type $updateWhere
     * @param type $disQuery
     * @return int 
     */
    function updateQuery($tblName, $updateCol, $updateWhere, $disQuery) {
        $qry = "UPDATE " . $tblName . " SET " . $updateCol;

        if ($updateWhere != '')
            $qry .= " WHERE " . $updateWhere;

        //for display query
        if (!empty($disQuery)) {
            echo $qry;
            die;
        }

        //execute query
        $result = mysql_query($qry);
        if (@mysql_errno() == '0' && @mysql_num_rows($result) > '0') {
            return 0;
        } else {
            return 1;
        }
    }

    //Inser tquery function
    /**
     * insertQuery
     * @param type $tblName
     * @param type $insertData
     * @param type $disQuery
     * @return int 
     */
    function insertQuery($tblName, $insertData, $disQuery) {
        $fields = array_keys($insertData);
        $qry = "INSERT INTO " . $tblName . "
                (`" . implode('`,`', $fields) . "`)
                VALUES('" . implode("','", $insertData) . "')";

        //for display query
        if (!empty($disQuery)) {
            echo $qry; //die;
        }

        //execute query
        $result = mysql_query($qry);

        if (@mysql_errno() == '0') {
            return mysql_insert_id();
        } else {
            return 1;
        }
    }

    //Delete query function
    /**
     * deleteQuery
     * @param type $tblName
     * @param type $where
     * @param type $disQuery
     * @return int 
     */
    function deleteQuery($tblName, $where, $disQuery) {

        $qry = "DELETE FROM " . $tblName . " WHERE " . $where;

        //for display query
        if (!empty($disQuery)) {
            echo $qry;
            die;
        }

        //execute query
        $result = mysql_query($qry);
        if (@mysql_errno() == '0') {
            return 0;
        } else {
            return 1;
        }
    }
    
    function printResult($result,$Exe = 0)
    {
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        if($Exe)
            die;
    }
    
}
?>
