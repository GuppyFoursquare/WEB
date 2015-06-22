<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : A.D.
 * @Maintainer  : A.D.
 * @Created     : 02 feb 2015
 * @Modified    : Guppy Org.
 * @ModifiedBy  : Kemal Sami KARACA 
 * @ModifiedDate: 16/06/2015
 * @Description : This is the reset password page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
    include("prepend.php");
    include("./functions/placeOperations.php");
    
    $latitude1 = (isset($_GET['lat']) ? $_GET['lat'] : '');
    $longitude1 = (isset($_GET['long']) ? $_GET['long'] : '');    
    
    echo json_encode(getPlacesFromLocationArray($obj,$latitude1 , $longitude1));
                        
?>
