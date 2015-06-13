<?php
# SETUP -----------------------------------------------------------------------
include("check_session.php");
include("prepend.php");
# ------- -----------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     if($_POST['dataW'] > 0 && $_POST['dataH'] > 0) {

            //------------------------CROP LARGE SIZE IMAGE---------------------------------------------//
            if($_SESSION['redirect_to'] == 'add_edit_places' ){
                $image_path = SET_UPLOAD_PATH.PLACES_HEADER_IMAGE_ORG .$_POST['imagePath'];
                $image_targ_path = SET_UPLOAD_PATH.PLACES_HEADER_IMAGE .$_POST['imagePath'];
                $targ_w = PLACES_HEADER_IMAGE_WIDTH;
                $targ_h = PLACES_HEADER_IMAGE_HEIGHT;
                cropimage($image_path,$image_targ_path,$targ_w,$targ_h);
            }
            if($_SESSION['redirect_to'] == 'manage_photo' ){
                $image_path = SET_UPLOAD_PATH.PLACES_ORIGINAL_IMAGE_PATH .$_POST['imagePath'];
                $image_targ_path = SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH .$_POST['imagePath'];
                $targ_w = PLACES_LARGE_IMAGE_WIDTH;
                $targ_h = PLACES_LARGE_IMAGE_HEIGHT;
                cropimage($image_path,$image_targ_path,$targ_w,$targ_h);
                //RESIZE IMAGE TO GET THUMBNAIL, MEDIUM, LARGE SIZE IMAGES
                $sCropImgName =  $_POST['imagePath'];
                resizeImageCrop($sCropImgName);
            }
     }
}
//$_SESSION['admin_insert_image'] ="";
$plcId = isset($_SESSION['admin_insert_image']) ? $_SESSION['admin_insert_image'] : array();
if($_SESSION['redirect_to'] == 'add_edit_places' ){
    //@header("location:places.php?isCancelButtonClicked=1");
    $_SESSION['sucess_message'] = "Place added successfully. <br />Please add gallery images for place";
    @header("location:manage_photo.php?id=".$_SESSION['id']);
}
if($_SESSION['redirect_to'] == 'manage_photo' ){
    @header("location:manage_photo.php?id=".$_SESSION['id']);
}

function cropimage($image_path,$image_targ_path,$targ_w,$targ_h)
{   
    $jpeg_quality = 90;
    $img_r = imagecreatefromjpeg($image_path);
    $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
    $x =  $_POST['dataX'];
    $y = $_POST['dataY'];
    $w = $_POST['dataW'];
    $h = $_POST['dataH'];
    $ext = pathinfo($dst_r, PATHINFO_EXTENSION);
    imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y , $targ_w, $targ_h, $w, $h );
    imagejpeg($dst_r, $image_targ_path,$jpeg_quality);
    // Remove from memory
    imagedestroy($dst_r);
}
?>
