<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : Kemal Sami KARACA
 * @Maintainer  : Guppy Org.
 * @Created     : 02/07/2015
 * @Modified    : 
 * @Description : This is the general functions for FEATUREs
********************************************************/
             
        include("../includes/site_constants.php"); 
        
        function getFeatures($obj){
            
                $tblName =  " yb_features fea";                                            
                $disCol     = " * ";
                $where      = " fea.feature_is_active  = 1 AND fea.feature_is_delete = 0 ";                               
                
                $qry = "SELECT " . $disCol . " FROM " . $tblName;                
                if ($where != '')
                    $qry .= " WHERE " . $where;

                
                // --- EXECUTE PART ---
                $memLocation = array();
                $memResult = $obj->executeSql($qry);                
                if($memResult){
                    while($memResultData = mysql_fetch_object($memResult, 'Feature')){
                        
                        //--- Create & Fetch to Place object
                        $feature = new Feature();
                        $feature->setFeatureObjectCoreVariables($memResultData);
                                                                        
                        array_push($memLocation,$feature);
                    }
                }                
                                                             
                return $memLocation;                
        }
        
        
        
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
