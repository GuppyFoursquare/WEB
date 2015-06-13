<?php
/**************************
 *FUNCTION TO RESIZE IMAGE
 *PARAMETERS :  FILE_NAME,FILE_PATH,RESIZE_WIDTH,RESIZE_HEIGHT
 *****/
function resizeImages($sFILENAME,$sFILEPATH,$sIMAGEWIDTH,$sIMAGEHEIGHT) {
    
    $sOrignalFilePath = $sFILEPATH.$sFILENAME;
    
    $resize = new ResizeImage($sFILEPATH.$sFILENAME);
    
    list($width, $height, $type, $attr) = getimagesize($sOrignalFilePath);
   
    //RESIZE TO LARGE
    if($width > $sIMAGEWIDTH){
        $resize->resizeTo($sIMAGEWIDTH,$sIMAGEHEIGHT);
        $resize->saveImage($sFILEPATH.$sFILENAME);
    }else{
        copy($sOrignalFilePath,$sFILEPATH.$sFILENAME);
    }
    return "1";
}

function resizeImageProperSave($file_name, $w, $h,$type='exact',$dest_path = "") {
    //echo $file_name;die;

    $resize = new ResizeImage($file_name);
    $path_parts = pathinfo($file_name);
    $file_name = $path_parts['filename'].".".$path_parts['extension'];
    //RESIZE TO THUMBNAIL
    $resize->resizeTo($w, $h,$type);
    $resize->saveImage($dest_path . $file_name);
}

/*********************************************
 *FUNCTION USE TO GET FIELDS DETAILS FROM TABLE
 *PARAMETERS : 
 * $sFIELDS         => COMMA SEPERATED FIELDS
 * $sTABLE_NAME     => TABLE NAME
 * $sWHERE_FIELD    => WHERE CLAUSE FIELDS (e.g cat_id or usr_id etc).
 * $sWHERE_ID       => WHERE CLAUSE ID
 *****/
function singleRowDetail($sFIELDS,$sTABLE_NAME,$sWHERE_FIELD,$sWHERE_ID) {
    
    $rSql=mysql_query("SELECT $sFIELDS FROM $sTABLE_NAME WHERE $sWHERE_FIELD='".$sWHERE_ID."'") or die("Error:in singleRowDetail function".mysql_error());
    if(mysql_num_rows($rSql) > 0){
        $aSingleRow = mysql_fetch_assoc($rSql);
        $aRowDetails = $aSingleRow;
        return $aRowDetails;
    }else return 0;
}

// IMAGES
function getThumbnailDimensions($req_width, $req_height, $newpath) {
    if (file_exists($newpath)) {
        list($width_orig, $height_orig) = getimagesize($newpath);
        if ($width_orig <= $req_width && $height_orig <= $req_height) {
            $w = (int) $width_orig;
            $h = (int) $height_orig;
            $dimensions = array($w, $h);
            return $dimensions;
        } else {
            if ($height_orig > $width_orig) {
                $h = $req_height;
                $w = (($width_orig * $req_height) / $height_orig);
                if ($w > $req_width) {
                    $w = $req_width;
                    $h = (($height_orig * $req_width) / $width_orig);
                }
            } else if ($height_orig < $width_orig) {
                $w = $req_width;
                $h = (($height_orig * $req_width) / $width_orig);
                if ($h > $req_height) {
                    $h = $req_height;
                    $w = (($width_orig * $req_height) / $height_orig);
                }
            } else if ($height_orig == $width_orig && $height_orig > $req_height) {
                $h = $req_height;
                $w = (($width_orig * $req_height) / $height_orig);
                if ($w > $req_width) {
                    $w = $req_width;
                    $h = (($height_orig * $req_width) / $width_orig);
                }
            } else if ($height_orig == $width_orig && $height_orig < $req_height) {
                $w = $req_width;
                $h = (($height_orig * $req_width) / $width_orig);
            }
            $w = (int) $w;
            $h = (int) $h;
            $dimensions = array($w, $h);
            return $dimensions;
        }
    } else {
        return 0;
    }
}

//FUNCTION TO RESIZE IMAGE
function resizeImageCrop($file_name,$type="exact") {
       
    $sOrignalFilePath = SET_UPLOAD_PATH.PLACES_LARGE_IMAGE_PATH .$file_name;
    list($width, $height, $type, $attr) = getimagesize($sOrignalFilePath);
    
    $resize = new ResizeImage($sOrignalFilePath);
    
    //RESIZE TO THUMBNAIL
      
    //RESIZE TO MEDIUM
    if($width > PLACES_MEDIUM_IMAGE_WIDTH){
        $resize->resizeTo(PLACES_MEDIUM_IMAGE_WIDTH, PLACES_MEDIUM_IMAGE_HEIGHT);
        $resize->saveImage(SET_UPLOAD_PATH.PLACES_MEDIUM_IMAGE_PATH .$file_name);
        $file_for_dimention = SET_UPLOAD_PATH.PLACES_MEDIUM_IMAGE_PATH .$file_name;
        list($dwidth_in, $dheight_in, $type_in, $attr_in) = getimagesize($file_for_dimention);
        if($dheight_in > PLACES_MEDIUM_IMAGE_HEIGHT){
                $w = PLACES_MEDIUM_IMAGE_WIDTH;
                $h = PLACES_MEDIUM_IMAGE_HEIGHT;
                $resize = new ResizeImage($file_for_dimention);
                $resize->resizeTo(PLACES_MEDIUM_IMAGE_WIDTH, PLACES_MEDIUM_IMAGE_HEIGHT,"maxheight");
                $resize->saveImage(SET_UPLOAD_PATH.PLACES_MEDIUM_IMAGE_PATH .$file_name);
            }
    }else{
        $resize->resizeTo(PLACES_MEDIUM_IMAGE_WIDTH, PLACES_MEDIUM_IMAGE_HEIGHT);
         $resize->saveImage(SET_UPLOAD_PATH.PLACES_MEDIUM_IMAGE_PATH .$file_name);
        //copy($sOrignalFilePath,SET_UPLOAD_PATH.PLACES_MEDIUM_IMAGE_PATH .$file_name);
    }
        
    //RESIZE TO LARGE
    if($width > PLACES_SMALL_IMAGE_WIDTH){
        //die("We are in small size loop.");
        $resize->resizeTo(PLACES_SMALL_IMAGE_WIDTH, PLACES_SMALL_IMAGE_HEIGHT);
        $resize->saveImage(SET_UPLOAD_PATH.PLACES_SMALL_IMAGE_PATH .$file_name);
        $file_for_dimention = SET_UPLOAD_PATH.PLACES_SMALL_IMAGE_PATH .$file_name;
        list($dwidth_in, $dheight_in, $type_in, $attr_in) = getimagesize($file_for_dimention);
        if($dheight_in > PLACES_SMALL_IMAGE_HEIGHT){
                $w = PLACES_SMALL_IMAGE_WIDTH;
                $h = PLACES_SMALL_IMAGE_HEIGHT;
                $resize = new ResizeImage($file_for_dimention);
                $resize->resizeTo(PLACES_SMALL_IMAGE_WIDTH, PLACES_SMALL_IMAGE_HEIGHT,"maxheight");
                $resize->saveImage(SET_UPLOAD_PATH.PLACES_SMALL_IMAGE_PATH .$file_name);
            }
    }else{
        $resize->resizeTo(PLACES_SMALL_IMAGE_WIDTH, PLACES_SMALL_IMAGE_HEIGHT);
        $resize->saveImage(SET_UPLOAD_PATH.PLACES_SMALL_IMAGE_PATH .$file_name);
        //copy($sOrignalFilePath,SET_UPLOAD_PATH.PLACES_SMALL_IMAGE_PATH .$file_name);
    }
    
    
}

//Image resize function
function resizeImage($req_width, $req_height, $path) {

    if (file_exists($path)) {

        list($width_orig, $height_orig) = getimagesize($path);
        if ($width_orig <= $req_width && $height_orig <= $req_height) {
            $w = (int) $width_orig;
            $h = (int) $height_orig;
            $dimensions = array($w, $h);
            return $dimensions;
        } else {
            if ($height_orig > $width_orig) {
                $h = $req_height;
                $w = (($width_orig * $req_height) / $height_orig);
                if ($w > $req_width) {
                    $w = $req_width;
                    $h = (($height_orig * $req_width) / $width_orig);
                }
            } elseif ($height_orig < $width_orig) {
                $w = $req_width;
                $h = (($height_orig * $req_width) / $width_orig);
                if ($h > $req_height) {
                    $h = $req_height;
                    $w = (($width_orig * $req_height) / $height_orig);
                }
            } elseif ($height_orig == $width_orig && $height_orig > $req_height) {
                $h = $req_height;
                $w = (($width_orig * $req_height) / $height_orig);
            } elseif ($height_orig == $width_orig && $height_orig < $req_height) {
                $w = $req_width;
                $h = (($height_orig * $req_width) / $width_orig);
            }
            $w = (int) $w;
            $h = (int) $h;
            $dimensions = array($w, $h);
            return $dimensions;
        }
    } else {
        return 0;
    }
}

function pagination($adjacents, $targetpage, $total_pages, $limit, $page, $extra_parameters) {

    if ($page)
        $start = ($page - 1) * $limit;    //first item to display on this page
    else
        $start = 0;

    if ($page == 0)
        $page = 1;     //if no page var is given, default to 1.
    $prev = $page - 1;       //previous page is page - 1
    $next = $page + 1;       //next page is page + 1
    $lastpage = ceil($total_pages / $limit);  //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;
    $pagination = "";

    if ($lastpage > 0) {
        $pagination.= '<div class="pagingbox">';
        //previous button
        if ($page > 1)
            $pagination.= '<a class="pre_next" href="' . $targetpage . '?page=' . $prev . $extra_parameters . '"></a>';//<img alt="" src="images/page-arrow.png">
        else
            $pagination.= '<a class="disabled"></a>';//<img src="images/page-arrow.png" alt="">

        //pages
        if ($lastpage < 7 + ($adjacents * 2)) { //not enough pages to bother breaking it up
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                //echo $counter;
                if ($counter == $page)
                    $pagination.= '<a class="current" href="javascript: void(0);">' . $counter . '</a>';
                else
                    $pagination.= '<a href="' . $targetpage . '?page=' . $counter . $extra_parameters . '"> ' . $counter . '  </a>';
            }
        }
        else
        if ($lastpage > 5 + ($adjacents * 2)) { //enough pages to hide some
            //close to beginning; only hide later pages
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination.= '<a class="current" href="javascript: void(0);">' . $counter . '</a>';
                    else
                        $pagination.= '<a href="' . $targetpage . '?page=' . $counter . $extra_parameters . '"> ' . $counter . '</a>';
                }
                //$pagination.= '...';
                $pagination.= '<a href="' . $targetpage . '?page=' . $lpm1 . $extra_parameters . '"> ' . $lpm1 . '</a>';
                $pagination.= '<a href="' . $targetpage . '?page=' . $lastpage . $extra_parameters . '"> ' . $lastpage . '</a>';
            }
            //in middle; hide some front and some back
            else
            if ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination.= '<a href="' . $targetpage . '?page=1' . $extra_parameters . '"> 1</a>';
                $pagination.= '<a href="' . $targetpage . '?page=2' . $extra_parameters . '"> 2</a>';
                //$pagination.= '...';
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= '<a class="current" href="javascript: void(0);">' . $counter . '</a>';
                    elseif ($counter != 2)
                        $pagination.= '<a href="' . $targetpage . '?page=' . $counter . $extra_parameters . '"> ' . $counter . '</a>';
                }
               // $pagination.= '...';
                $pagination.= '<a href="' . $targetpage . '?page=' . $lpm1 . $extra_parameters . '"> ' . $lpm1 . '</a>';
                $pagination.= '<a href="' . $targetpage . '?page=' . $lastpage . $extra_parameters . '"> ' . $lastpage . '</a>';
            } //close to end; only hide early pages
            else {
                $pagination.= '<a href="' . $targetpage . '?page=1' . $extra_parameters . '"> 1</a>';
                $pagination.= '<a href="' . $targetpage . '?page=2' . $extra_parameters . '"> 2</a>';
                //$pagination.= '...';
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= '<a class="current" href="javascript: void(0);">' . $counter . '</a>';
                    else
                        $pagination.= '<a href="' . $targetpage . '?page=' . $counter . $extra_parameters . '"> ' . $counter . '</a>';
                }
            }
        }
        //next button
        if ($page < $counter - 1)
            $pagination.= '<a class="pre_next" href="' . $targetpage . '?page=' . $next . $extra_parameters . '"></a>';//<img alt="" src="images/page-arrow1.png">
        else
            $pagination.= '<a class="disabled"></a>';//<img src="images/page-arrow1.png" alt="">
        $pagination.= "</div>\n";
    }
    return $pagination;
}

function fetchCategory($obj,$parentCatId = 0){
     $tblName = "  ";
        $disCol = " ";
        $where = " ";
    if($parentCatId){
        $tblName = " yb_category ";
        $disCol = " cat_id,cat_parent_id,cat_name,cat_image,cat_color,cat_is_active,cat_is_delete,cat_seq,cat_created_date,cat_modified_date ";
        $where = " cat_is_active  = 1 AND cat_parent_id = ".$parentCatId." AND cat_is_delete = 0";
    }
    else{
        $tblName = " yb_category pcat 
                    JOIN yb_category subCat on (pcat.cat_id = subCat.cat_parent_id) ";
        $disCol = " pcat.cat_id,pcat.cat_parent_id,pcat.cat_name,pcat.cat_image,pcat.cat_color,pcat.cat_is_active,pcat.cat_is_delete,pcat.cat_seq,pcat.cat_created_date,pcat.cat_modified_date ";
        $where = " pcat.cat_is_active  = 1 AND pcat.cat_parent_id = ".$parentCatId." AND pcat.cat_is_delete = 0";
        $where .= " GROUP BY pcat.cat_id ORDER BY pcat.cat_seq ASC ";
    }
    $order_col = '';
    $order_by = '';
    $catArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '');
    return $catArr;
}

    function getplacessCount($obj,$parentCatId = 0){
        $tblName = " yb_places_category pc
                    left join yb_category subc on (pc.plc_sub_cat_id = subc.cat_id) 
                    left join yb_category prntc on (subc.cat_parent_id = prntc.cat_id) 
                    left join yb_places plc on (pc.plc_id = plc.plc_id) 
                    ";
        $disCol = " count(pc.plc_id) as rcount,pc.*,subc.cat_id,prntc.cat_id ";
        $where = " prntc.cat_id = ".$parentCatId." AND plc.plc_is_active = 1 AND plc.plc_is_delete = 0 ";
        $order_col = '';
        $order_by = '';
        $catArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by = '', $disQuery = '',1);
        if(!empty($catArr)){
            return $catArr['rcount'];
        }
        else
            return 0;
    }
    
    

?>