<?php
/* * ************** Page Details ***************************************************** */
// Created By 	: K.U.
// Created Date : 16 April, 2013.
// Page Name 	: manage_photo.php
/* * ************** END ************************************************************** */

#SETUP -------------------------------------------------------------------------
include("check_session.php");
include("prepend.php");
$obj = new db();
$sPageTitle  = "Gallery";
$sPageClass  = "places";
$iPageSelect = 6;
$_SESSION['parent_breadcum'] = "Places";
$_SESSION['parent_breadcum_url'] = 'places.php';
$_SESSION['mid_breadcum'] = "";
$_SESSION['mid_breadcum_url'] = "";
$_SESSION['breadcum'] = 'Gallery';
include("check_menu_session.php");
$msg = '';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$_SESSION['id'] = $id;
//echo "ss".$_SESSION['id'];
if (isset($_GET['curr_id'])) {
    $_SESSION['id'] = $_GET['curr_id'];
}



$plc_is_cover_image = isset($_POST['plc_is_cover_image']) ? mysql_real_escape_string(trim($_POST['plc_is_cover_image'])) : 0;
$plc_is_video = 0;
if (isset($_REQUEST['step']) && $_REQUEST['step'] != '') {

    switch ($_REQUEST['step']) {
        case 'add_photo':
            if ($_REQUEST['txtmatcount'] != '') {
                for ($i = 0; $i < $_REQUEST['txtmatcount']; $i++) {
                    if (isset($_FILES['OnmatInput' . $i]['name']) && $_FILES['OnmatInput' . $i]['name'] != '') {
                        $file_name = $_FILES['OnmatInput' . $i]['name'];
                        $ext = "." . pathinfo($file_name, PATHINFO_EXTENSION);
                        /*
                            .3g2 	3GPP2 Multimedia File
                            .3gp 	3GPP Multimedia File
                            .asf 	Advanced Systems Format File
                            .asx 	Microsoft ASF Redirector File
                            .avi 	Audio Video Interleave File
                            .flv 	Flash Video File
                            .mov 	Apple QuickTime Movie
                            .mp4 	MPEG-4 Video File
                            .mpg 	MPEG Video File
                            .rm 	Real Media File
                            .swf 	Shockwave Flash Movie
                            .vob 	DVD Video Object File
                            .wmv 	Windows Media Video File
                         */
                    $videoType = array('.3g2', '.3gp', '.asf', '.asx', '.avi', '.flv', '.mov', '.mp4', '.mpg', '.rm','.swf','.vob','.wmv');
                    $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $file_name);
                    if (!in_array($ext, $videoType)) 
                    {
                    
                        $type = array('.bmp', '.gif', '.jpg', '.jpeg', '.BMP', '.GIF', '.JPG', '.JPEG', '.PNG', '.png');
                        //echo $ext = substr($file_name, strpos($file_name, '.'), strlen($file_name) - 1);

                        if ($_FILES['OnmatInput' . $i]["size"] > 20971520 || $_FILES['OnmatInput' . $i]["size"] == 0) { //2 mb
                            $_SESSION['error_message'] = "Image size should be less than 2MB.";
                            @header("Location:manage_photo.php?id=" . $_SESSION['id']);
                            die;
                        } elseif (!in_array($ext, $type)) {
                            $_SESSION['error_message'] = "Only jpg,gif,bmp,png file is allowed.";
                            @header("Location:manage_photo.php?id=" . $_SESSION['id']);
                            die;
                        } elseif ($_FILES['OnmatInput' . $i]["error"] > 0) {
                            $_SESSION['error_message'] = " File contain error.";
                            @header("Location:manage_photo.php?id=" . $_SESSION['id']);
                            die;
                        } else {
                            $file_name = time() .$file_name;


                            //save file in three location
                            if (!file_exists(SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH)) {
                                mkdir(SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH, 0777, true);
                            }
                            if (!file_exists(SET_UPLOAD_PATH.PLACES_MEDIUM_IMAGE_PATH)) {
                                mkdir(SET_UPLOAD_PATH.PLACES_MEDIUM_IMAGE_PATH, 0777, true);
                            }
                            if (!file_exists(SET_UPLOAD_PATH.PLACES_SMALL_IMAGE_PATH)) {
                                mkdir(SET_UPLOAD_PATH.PLACES_SMALL_IMAGE_PATH, 0777, true);
                            }
                            if (!file_exists(SET_UPLOAD_PATH.PLACES_ORIGINAL_IMAGE_PATH)) {
                                mkdir(SET_UPLOAD_PATH.PLACES_ORIGINAL_IMAGE_PATH, 0777, true);
                            }
                            // $bannerImage = time() . $bannerImage;
                            move_uploaded_file($_FILES['OnmatInput' . $i]["tmp_name"], SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH. $file_name);    
                            //move_uploaded_file($_FILES['OnmatInput' . $i]["tmp_name"], SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH . $file_name);
                          
                           if (!copy(SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH . $file_name, SET_UPLOAD_PATH.PLACES_ORIGINAL_IMAGE_PATH. $file_name)) {
                                $_SESSION['error_message'] = "failed to copy ...\n";
                            }
                            
                            $file_for_dimention = SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH . $file_name;
                            
                            list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                            if ($dwidth == PLACES_LARGE_IMAGE_WIDTH || $dheight == PLACES_LARGE_IMAGE_HEIGHT) {
                                    $w = PLACES_LARGE_IMAGE_WIDTH;
                                    $h = PLACES_LARGE_IMAGE_HEIGHT;
                                    resizeImageProperSave($file_for_dimention, $w, $h,SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH);

                                } 
                                elseif($dwidth > PLACES_LARGE_IMAGE_WIDTH){
                                    /* $newDimensions = getThumbnailDimensions(PLACES_LARGE_IMAGE_WIDTH, PLACES_LARGE_IMAGE_HEIGHT, $file_for_dimention);
                                    $w = $newDimensions[0];
                                    $h = $newDimensions[1];*/
                                    $w = PLACES_LARGE_IMAGE_WIDTH;
                                    $h = PLACES_LARGE_IMAGE_HEIGHT;
                                    $newDimensions = getThumbnailDimensions(PLACES_LARGE_IMAGE_WIDTH,PLACES_LARGE_IMAGE_HEIGHT, $file_for_dimention);
                                    $w = $newDimensions[0];
                                    $h = $newDimensions[1];    
                                    resizeImageProperSave($file_for_dimention, $w, $h,"maxheight",SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH);
                                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                                    if($dheight > PLACES_LARGE_IMAGE_HEIGHT){
                                        $w = PLACES_LARGE_IMAGE_WIDTH;
                                        $h = PLACES_LARGE_IMAGE_HEIGHT;
                                        $newDimensions = getThumbnailDimensions(PLACES_LARGE_IMAGE_WIDTH,PLACES_LARGE_IMAGE_HEIGHT, $file_for_dimention);
                                        $w = $newDimensions[0];
                                        $h = $newDimensions[1];    
                                        resizeImageProperSave($file_for_dimention, $w, $h,"maxwidth",SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH);
                                    }
                                  
                                }
                                elseif($dheight > PLACES_LARGE_IMAGE_HEIGHT){

                                    $w = PLACES_LARGE_IMAGE_WIDTH;
                                    $h = PLACES_LARGE_IMAGE_HEIGHT;
                                    $newDimensions = getThumbnailDimensions(PLACES_LARGE_IMAGE_WIDTH,PLACES_LARGE_IMAGE_HEIGHT, $file_for_dimention);
                                    $w = $newDimensions[0];
                                    $h = $newDimensions[1];    
                                    resizeImageProperSave($file_for_dimention, $w, $h,"maxwidth",SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH);
                                    list($dwidth, $dheight, $type, $attr) = getimagesize($file_for_dimention);

                                    if($dwidth > PLACES_LARGE_IMAGE_WIDTH){
                                        $w = PLACES_LARGE_IMAGE_WIDTH;
                                        $h = PLACES_LARGE_IMAGE_HEIGHT;
                                        $newDimensions = getThumbnailDimensions(PLACES_LARGE_IMAGE_WIDTH,PLACES_LARGE_IMAGE_HEIGHT, $file_for_dimention);
                                        $w = $newDimensions[0];
                                        $h = $newDimensions[1];    
                                        resizeImageProperSave($file_for_dimention, $w, $h,"maxheight",SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH);
                                    }
                                   
                                }
                                else {

                                    $w = PLACES_LARGE_IMAGE_WIDTH;
                                    $h = PLACES_LARGE_IMAGE_HEIGHT;
                                    resizeImageProperSave($file_for_dimention, $w, $h,"maxheight",SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH);
                                }
                            
                             //RESIZE IMAGE TO GET THUMBNAIL, MEDIUM, LARGE SIZE IMAGES
                            $sCropImgName =  $file_name;
                            resizeImageCrop($sCropImgName,"maxheight");
                           
                        }
                    }
                    else
                    {
                        // this is for video....
                        if(!file_exists(SET_UPLOAD_PATH.PLACES_VIDEO_PATH)) {
                            mkdir(SET_UPLOAD_PATH.PLACES_VIDEO_PATH, 0777, true);
                        }
                        
                        if ($_FILES['OnmatInput' . $i]["size"] > 20971520 || $_FILES['OnmatInput' . $i]["size"] == 0) { //20 mb limit
                            $_SESSION['error_message'] = "Video size should be less than or equal to 20MB.";
                            @header("Location:manage_photo.php?id=" . $_SESSION['id']);
                            die;
                        }
                        $file_name = time() .$file_name;
                        
                        move_uploaded_file($_FILES['OnmatInput' . $i]["tmp_name"], SET_UPLOAD_PATH.PLACES_VIDEO_PATH. $file_name);    
                        $plc_is_video = 1;
                        $plc_is_cover_image = 0;
                    }
                      
                        if(!$plc_is_cover_image && !$plc_is_video){
                            $tblName = "  yb_place_gallery";
                            $where = " 	plc_id  = " . $_REQUEST['n_id'];
                            $disCol = " * ";
                            $resultQ = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
                            if(!count($resultQ)){
                                $plc_is_cover_image = 1;
                            }
                        }
                        if ($plc_is_cover_image) {
                            $tblName = "  yb_place_gallery";
                            //This case will update active inactive status
                            $updateWhere = " 	plc_id  = " . $_REQUEST['n_id'];
                            $updateCol = "  	plc_is_cover_image = '0' ";
                            //update record
                            $returnResource = $obj->updateQuery($tblName, $updateCol, $updateWhere, $disQuery = '');
                            $insertData = array(
                                'plc_gallery_media' => $file_name,
                                'plc_id' => $_REQUEST['n_id'],
                                'plc_is_cover_image' => $plc_is_cover_image,
                                'plc_gallery_is_video' => 0,
                                'plc_gallery_is_active' => 1
                            );
                        } 
                        elseif($plc_is_video){
                            $insertData = array(
                                'plc_gallery_media' => $file_name,
                                'plc_id' => $_REQUEST['n_id'],
                                'plc_gallery_is_video' => 1
                            );
                        }
                        else {
                            $insertData = array(
                                'plc_gallery_media' => $file_name,
                                'plc_id' => $_REQUEST['n_id'],
                                'plc_gallery_is_video' => 0,
                                'plc_gallery_is_active' => 1
                            );
                        }
                        $tblName = ' yb_place_gallery';

                        //insert menu
                        $returnResource = $obj->insertQuery($tblName, $insertData, $disQuery = '');
                        $gal_id = mysql_insert_id();
                    }
                }

                if(!$plc_is_video)
                {
                    $_SESSION['sucess_message'] = "Photos added successfully.";
                    $_SESSION['admin_insert_image'] =$gal_id;
                    $_SESSION['crop_image'] = $file_name;
                    @header("Location:image_crop.php?redirect_to=manage_photo");
                }
                else
                {
                    $_SESSION['sucess_message'] = "Video added successfully.";
                    @header("Location:manage_photo.php?id=" . $_SESSION['id']);
                }

//                @header("Location:manage_photo.php?id=" . $_SESSION['id']);
                die;
            } else {
                $_SESSION['error_message'] = "Please add photos.";
                @header("Location:manage_photo.php?id=" . $_SESSION['id']);
                die;
            }
            break;

        case 'delete_opr' :
            $file_path_to_remove = '';
            $page_title = 'Gallery ';
            $tblName = 'yb_place_gallery';
            $where = ' plc_gallery_id = "' . $_REQUEST['id'] . '"';
            $disCol = "*";
            $order_col = '';
            $returnResource = $obj->selectQueryResource($tblName, $disCol, $where, $order_col, $order_by = '', $group_by = '', $disQuery = '');
            $noofrecords = @mysql_num_rows($returnResource);
            if($noofrecords){
                $row = mysql_fetch_assoc($returnResource);
                if($row['plc_gallery_is_video'] == 1)
                {
                    $file_path_to_remove = SET_UPLOAD_PATH.PLACES_VIDEO_PATH . $row['plc_gallery_media'];
                    @unlink($file_path_to_remove);
                }else{
                    $file_path_to_remove = SET_UPLOAD_PATH.PLACES_SMALL_IMAGE_PATH . $row['plc_gallery_media'];
                    @unlink($file_path_to_remove);
                    $file_path_to_remove = SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH . $row['plc_gallery_media'];
                    @unlink($file_path_to_remove);
                    $file_path_to_remove = SET_UPLOAD_PATH.PLACES_MEDIUM_IMAGE_PATH . $row['plc_gallery_media'];
                    @unlink($file_path_to_remove);
                    $file_path_to_remove = SET_UPLOAD_PATH.PLACES_ORIGINAL_IMAGE_PATH . $row['plc_gallery_media'];
                    @unlink($file_path_to_remove);
                }
             
            }
           
            
            
            $tblName = " yb_place_gallery ";
            //This case will delete all level menu
            $deleteWhere = " plc_gallery_id  = " . $_REQUEST['id'];

            $returnResource = $obj->deleteQuery($tblName, $deleteWhere, $disQuery = '');


            $_SESSION['sucess_message'] = "Photo deleted successfully.";
            ?>
            <script type="text/javascript">
                window.location.href="manage_photo.php?id=<?= $_SESSION['id'] ?>";
            </script><?php
//                        @header("Location:manage_photo.php?id=".$_SESSION['id']);

            die;
            break;

        case 'status' :

            $tblName = "  yb_place_gallery";
            //This case will update active inactive status

            $updateWhere = " 	plc_gallery_id  = " . $_REQUEST['id'];
            if ($_REQUEST['act'] == 'deactivate')
                $updateCol = " plc_gallery_is_active = '0' ";
            else
                $updateCol = " plc_gallery_is_active = '1' ";

            //update record
            $returnResource = $obj->updateQuery($tblName, $updateCol, $updateWhere, $disQuery = '');
            if ($_REQUEST['act'] == 'activate')
                $_SESSION['sucess_message'] = 'Photo activated successfully.';
            else
                $_SESSION['sucess_message'] = 'Photo deactivated successfully.';
            ?>
            <script type="text/javascript">
                window.location.href="manage_photo.php?id=<?= $_SESSION['id'] ?>";
            </script><?php
            die;
            break;

            case 'set_cover_pic' :

            $tblName = "  yb_place_gallery";
            $updateWhere = " plc_id  = " .$_SESSION['id'];
            $updateCol = " plc_is_cover_image = '0' , plc_gallery_is_active = '1'";

            //update all records
            $returnResource = $obj->updateQuery($tblName, $updateCol, $updateWhere, $disQuery = '');

            $updateWhere = " 	plc_gallery_id  = " . $_REQUEST['id'];

            $updateCol = " plc_is_cover_image = '1' ";



            //update record
            $returnResource = $obj->updateQuery($tblName, $updateCol, $updateWhere, $disQuery = '');

            $_SESSION['sucess_message'] = "Cover pic updated successfully";
            ?>
            <script type="text/javascript">
                window.location.href="manage_photo.php?id=<?= $_SESSION['id'] ?>";
            </script><?php
//                        @header("Location:manage_photo.php?id=".$_SESSION['id']);

            die;
            break;
    }
}



// Save Sequence OPrder

$noofrecords = 100;
$pagingpagename = "manage_photo.php";
$pagesize = 5;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
if($page != 0)
    $offset = $page - 1;


$extra_parameters = "&id=".$id;
$offset = $offset * $pagesize;
//$offset = $offset - 1;

$page_title = 'Gallery ';
$tblName = 'yb_place_gallery';
$where = ' plc_id = "' . $id . '"';
$disCol = "*";
$order_col = '';

$returnResourceCount = $obj->selectQueryResource($tblName, $disCol, $where, $order_col, $order_by = '', $group_by = '', $disQuery = '');

if($offset > 0)
    $where .= " LIMIT ".$offset.",".$pagesize;
else
    $where .= " LIMIT ".$pagesize;


$returnResource = $obj->selectQueryResource($tblName, $disCol, $where, $order_col, $order_by = '', $group_by = '', $disQuery = '');
$noofrecords = @mysql_num_rows($returnResourceCount);

if (!empty($returnResource)) {
    $allPhoto = array();
    $i = '0';
    while ($opt = mysql_fetch_array($returnResource)) {
        $allPhoto[$i]['plc_gallery_id'] = $opt['plc_gallery_id'];
        $allPhoto[$i]['plc_gallery_media'] = $opt['plc_gallery_media'];
        $allPhoto[$i]['plc_gallery_is_active'] = $opt['plc_gallery_is_active'];
        $allPhoto[$i]['plc_id'] = $opt['plc_id'];
        $allPhoto[$i]['plc_is_cover_image'] = $opt['plc_is_cover_image'];
        $allPhoto[$i]['plc_gallery_is_video'] = $opt['plc_gallery_is_video'];
        $i++;
    }
}



$tblName = 'yb_places';
$where = ' plc_id 	 = "' . $id . '"';
$disCol = "plc_name";
$list_name = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '',1);
$title = ucwords($list_name['plc_name']);



include("templete/manage_photo.php");
