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
$_SESSION['is_most_popular'] = 0;
if(!empty($_POST))
{
    if(isset($_SESSION['user_id']))
    {
        $place_id = isset($_POST['current_place_id']) ? $_POST['current_place_id'] : 0;
        $user_id = $_SESSION['user_id'];
        $message = isset($_POST['rate_message']) ? $_POST['rate_message'] : '';
        $score = isset($_POST['score']) ? $_POST['score'] : 3;
        
        $query = "SELECT place_rating_id from yb_places_rating WHERE plc_id = ".$place_id." AND places_rating_by = ".$user_id;
        $aDetails = mysql_query($query);
        $row=mysql_num_rows($aDetails);
        
        if($row > 0)
        {
            $_SESSION['error_message'] = "Review already added.";
            header('location:'.SITE_PATH.'places/'.  base64_encode($place_id));
        }
        else
        {
            $time = date('Y/m/d G:i:s ', time());
            $query = "INSERT INTO yb_places_rating SET
                plc_id = '".($place_id)."',
                places_rating_by = '".($user_id)."',
                place_rating_rating = '".($score)."',
                place_rating_comment = '".mysql_real_escape_string($message)."',
                places_rating_created_date = '".$time."',
                places_rating_is_active = 0
            ";

            $rUser = mysql_query($query) or die("Error:in review insertion".mysql_error());
            $iLastInsertID = mysql_insert_id();
            
            if($iLastInsertID)
            {
                $_SESSION['sucess_message'] = "Review added successfully.";
            }
            else
            {
                $_SESSION['error_message'] = "Failed to add review.";
            }
            header('location:'.SITE_PATH.'places/'.base64_encode($place_id));
        }
        
    }
    else
    {
        $place_id = isset($_POST['current_place_id']) ? base64_encode($_POST['current_place_id']) : 0;
        $_SESSION['error_message'] = "Please login to add rating.";
        header('location:'.SITE_PATH.'places/'.$place_id);
    }
}
else
{
    header('location:'.SITE_PATH.'index.php');
}

?>
