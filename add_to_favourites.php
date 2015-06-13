<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the index page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
include("prepend.php");

if(!empty($_POST))
{
    if(isset($_SESSION['user_id']))
    {
        $plc_id = $_POST['plc_id'];
        $user_id = $_SESSION['user_id'];
        
        $sQuery="SELECT favo_id FROM yb_places_favourites WHERE favo_plc_id=".$plc_id." AND favo_usr_id = ".$user_id;
        $aDetails = mysql_query($sQuery);
        $row=mysql_num_rows($aDetails);
        
        if($row==1)
        {
            $query = "DELETE FROM yb_places_favourites WHERE favo_plc_id = ".$plc_id." AND favo_usr_id = ".$user_id;
            $aDetails = mysql_query($query);
            $deleterow=mysql_affected_rows();
            if($deleterow == 1)
                echo 2;
            else
                echo 4;
        }
        else if($row==0)
        {
            $query = "INSERT INTO yb_places_favourites SET
                favo_plc_id = ".$plc_id.",
                favo_usr_id = ".$user_id."
            ";

            $rUser = mysql_query($query) or die("Error:in user selection".mysql_error());
            $iLastInsertID = mysql_insert_id();
            if($iLastInsertID)
                echo 1;
            else
                echo 3;
        }
    }
    else
    {
        echo 0;
    }
}

?>
