<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : A.D.
 * @Maintainer  : A.D.
 * @Created     : 02 feb 2015
 * @Modified    : 
 * @Description : This is the reset password page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
    include("prepend.php");
    //error_reporting(E_ALL);
    $country=$_POST["country"];
    $result=mysql_query("SELECT * FROM yb_statemst where state_country_id='$country' AND state_is_active = 1 AND state_is_delete = 0 ORDER BY state_name ASC ");
    echo"<option value=\"\">Select state</option>";
    while($city=mysql_fetch_array($result)){
      echo"<option value=$city[state_id]>$city[state_name]</option>";

    }
    
?>
