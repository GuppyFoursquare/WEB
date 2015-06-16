<?php

include_once("prepend.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$step = isset($_POST['step']) ? $_POST['step'] : '';
switch($step){
    case 'search':
        $searchText = isset($_POST['searchText']) ? $_POST['searchText'] : '';
        $categories = isset($_POST['chkCategories']) ? $_POST['chkCategories'] : '';
        $features = isset($_POST['chkFeature']) ? $_POST['chkFeature'] : '';
        $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
        $exactsearchchb = isset($_POST['exactsearch']) ? $_POST['exactsearch'] : 0;
        if($offset)
            echo getResultHtml($obj,$searchText,$exactsearchchb,$categories,$features,$offset);
        else
            echo getResultHtml($obj,$searchText,$exactsearchchb,$categories,$features);
        break;
    case 'searchFilters':
        $searchText = isset($_POST['searchText']) ? $_POST['searchText'] : '';
        $categories = isset($_POST['chkCategories']) ? $_POST['chkCategories'] : '';
        $features = isset($_POST['chkFeature']) ? $_POST['chkFeature'] : '';
        $exactsearchchb = isset($_POST['exactsearch']) ? $_POST['exactsearch'] : 0;
        echo getResultHighlightsHtml($obj,$searchText,$exactsearchchb,$categories,$features);
        break;
    
    default:
        break;
}


function fetchPlaces($obj,$searchText = '',$exactSearch = 0,$categories = '',$features = '',$page = 0,$allRec = 0){    
    $limit = 6;
    
    $tblName = " yb_places plc 
             LEFT JOIN yb_place_gallery gal ON (plc.plc_id = gal.plc_id AND plc_is_cover_image = 1) 
             JOIN yb_places_category plc_cat ON (plc.plc_id = plc_cat.plc_id) 
             LEFT JOIN yb_places_features plc_fet ON (plc.plc_id = plc_fet.plc_id) 
             LEFT JOIN yb_category subCat ON (plc_cat.plc_sub_cat_id = subCat.cat_id) 
             LEFT JOIN yb_category pCat ON (subCat.cat_parent_id = pCat.cat_id) 
             LEFT JOIN yb_features f ON (plc_fet.feature_id = f.feature_id) 
            ";    
    if(isset($_SESSION['is_most_popular']))
    {
        if($_SESSION['is_most_popular'] == 1)
            $tblName = $tblName." JOIN yb_places_rating plc_r ON (plc_r.plc_id = plc.plc_id) ";
    }
    
    $disCol = " plc.plc_id,f.feature_id,f.feature_title,subCat.cat_parent_id,pCat.cat_name as pcat_name,plc.plc_name,plc.plc_header_image,plc_gallery_media,plc.plc_email,plc.plc_contact,plc.plc_website,plc.plc_country_id,plc.plc_state_id,plc.plc_city,plc.plc_address,plc.plc_zip,plc.plc_latitude,plc.plc_longitude,plc.plc_menu,plc.plc_info_title,plc.plc_info,plc.plc_is_active,plc.plc_is_delete ";
    
    if(isset($_SESSION['is_most_popular']))
    {
        if($_SESSION['is_most_popular'] == 1) 
        $disCol = " AVG(plc_r.place_rating_rating) as avg_rate,plc.plc_id,f.feature_id,f.feature_title,subCat.cat_parent_id,pCat.cat_name as pcat_name,plc.plc_name,plc.plc_header_image,plc_gallery_media,plc.plc_email,plc.plc_contact,plc.plc_website,plc.plc_country_id,plc.plc_state_id,plc.plc_city,plc.plc_address,plc.plc_zip,plc.plc_latitude,plc.plc_longitude,plc.plc_menu,plc.plc_info_title,plc.plc_info,plc.plc_is_active,plc.plc_is_delete ";
         
    }
    $where = " plc.plc_is_active  = 1 AND plc.plc_is_delete = 0 ";
    $order_col = '';
    $order_by = '';
    if(isset($_SESSION['is_most_popular']))
    {
        if($_SESSION['is_most_popular'] == 1) {
            $order_col = 'avg_rate';
         $order_by = ' DESC';
        }
        
         
    }
    $searchText = trim($searchText);
    if(!empty($searchText)){
        if($exactSearch)
        {
            $where .= " AND plc.plc_name LIKE '".$searchText."' ";
        }
        else
        {
            //$where .= " AND plc.plc_name LIKE '%".$searchText."%' ";
			$where .= " AND (plc.plc_name LIKE '%".$searchText."%' OR pCat.cat_name LIKE '%".$searchText."' OR subCat.cat_name LIKE '%".$searchText."')";
        }
    }
    //echo (!empty($categories));die;
    if(!empty($categories)){
        $where .= " AND plc_cat.plc_sub_cat_id IN (". implode(',',$categories).") ";
    }
    if(!empty($features)){
        $where .= " AND plc_fet.feature_id IN (". implode(',',$features).") ";
    }
    if($page>0 && $page != "All")
        $page = $page * $limit;
    
    if($allRec)
        $where .= "GROUP BY plc.plc_id ";
    else
    {
        $cmp = strcmp($order_by, '');
        if($cmp == 0)
        {
            $where .= "GROUP BY plc.plc_id LIMIT ".$page.",".$limit." ";
        }
        else
        {
            $where .= "GROUP BY plc.plc_id";
            $order_by .=" LIMIT ".$page.",".$limit." ";
        }
        
    }
        
    
    $plcArr = $obj->selectQuery($tblName, $disCol, $where, $order_col, $order_by , $group_by='', $disQuery = '');    
    $flag = 0;
    $final_array = array();
    if($exactSearch)
    {
        if($categories)
        {
            foreach($plcArr as $rec)
            {
                //$i = 0;
                $flag = true;
                foreach($categories as $cat)
                {
                    $query = "SELECT plc_id FROM yb_places_category WHERE plc_id = ".$rec['plc_id']." AND plc_sub_cat_id = ".$cat;
                    $res = mysql_query($query);
                    
                    if(mysql_num_rows($res) > '0')
                        $flag = $flag && true;
                    else
                        $flag = $flag && false;
                }
                //echo $flag."<br/>";
                if($flag)
                {
                    //print_r($flag);die;
                    array_push($final_array, $rec);
                }
            }
        }
        
        if($features)
        {
            if($final_array)
            {
                $final_array1 = array();
                foreach($final_array as $rec)
                {
                    //$i = 0;
                    $flag = true;
                    foreach($features as $cat)
                    {
                        $query = "SELECT plc_id FROM yb_places_features WHERE plc_id = ".$rec['plc_id']." AND feature_id = ".$cat;
                        $res = mysql_query($query);

                        if(mysql_num_rows($res) > '0')
                            $flag = $flag && true;
                        else
                            $flag = $flag && false;
                    }
                    //echo $flag."<br/>";
                    if($flag)
                    {
                        //print_r($flag);die;
                        array_push($final_array1, $rec);
                    }
                }
                return $final_array1;
            }
            else
            {
                foreach($plcArr as $rec)
                {
                    //$i = 0;
                    $flag = true;
                    foreach($features as $cat)
                    {
                        $query = "SELECT plc_id FROM yb_places_features WHERE plc_id = ".$rec['plc_id']." AND feature_id = ".$cat;
                        $res = mysql_query($query);

                        if(mysql_num_rows($res) > '0')
                            $flag = $flag && true;
                        else
                            $flag = $flag && false;
                    }
                    //echo $flag."<br/>";
                    if($flag)
                    {
                        //print_r($flag);die;
                        array_push($final_array, $rec);
                    }
                }
                return $final_array;   
            }
        }
        //die;
        return $final_array;
    }
        
    return $plcArr;
}

function fetchPlacesFive($obj,$searchText = '',$exactSearch = 0,$categories = '',$features = '',$page = 0,$allRec = 0){
    $limit = 5;
    $tblName = " yb_places plc 
                 LEFT JOIN yb_place_gallery gal ON (plc.plc_id = gal.plc_id AND plc_is_cover_image = 1) 
                 JOIN yb_places_category plc_cat ON (plc.plc_id = plc_cat.plc_id) 
                 LEFT JOIN yb_places_features plc_fet ON (plc.plc_id = plc_fet.plc_id) 
                 LEFT JOIN yb_category subCat ON (plc_cat.plc_sub_cat_id = subCat.cat_id) 
                 LEFT JOIN yb_category pCat ON (subCat.cat_parent_id = pCat.cat_id) 
                 LEFT JOIN yb_features f ON (plc_fet.feature_id = f.feature_id) 
                ";
    $disCol = " plc.plc_id,f.feature_id,f.feature_title,subCat.cat_parent_id,pCat.cat_name as pcat_name,plc.plc_name,plc.plc_header_image,plc_gallery_media,plc.plc_email,plc.plc_contact,plc.plc_website,plc.plc_country_id,plc.plc_state_id,plc.plc_city,plc.plc_address,plc.plc_zip,plc.plc_latitude,plc.plc_longitude,plc.plc_menu,plc.plc_info_title,plc.plc_info,plc.plc_is_active,plc.plc_is_delete ";
    $where = " plc.plc_is_active  = 1 AND plc.plc_is_delete = 0 ";
    $order_col = '';
    $order_by = '';
    $searchText = trim($searchText);
    if(!empty($searchText)){
        if($exactSearch)
        {
            $where .= " AND plc.plc_name LIKE '".$searchText."' ";
        }
        else
        {
            //$where .= " AND plc.plc_name LIKE '%".$searchText."%' ";
			$where .= " AND (plc.plc_name LIKE '%".$searchText."%' OR pCat.cat_name LIKE '%".$searchText."' OR subCat.cat_name LIKE '%".$searchText."')";
        }
        
    }
    
    if(!empty($categories)){
        $where .= " AND plc_cat.plc_sub_cat_id IN (". implode(',',$categories).") ";
    }
    
    if(!empty($features)){
        $where .= " AND plc_fet.feature_id IN (". implode(',',$features).") ";
    }
    if($page>0 && $page != "All")
        $page = $page * $limit;
    
    if($allRec)
        $where .= "GROUP BY plc.plc_id  ORDER BY plc.plc_id DESC ";
    else
        $where .= "GROUP BY plc.plc_id  ORDER BY plc.plc_id DESC  LIMIT ".$page.",".$limit." ";
    
    
    $plcArr = $obj->selectQuery($tblName, $disCol, $where, $order_col = '', $order_by = '', $group_by='', $disQuery = '');
    return $plcArr;
}


function getSliderDetails($obj){
    $sQuery = 'SELECT * FROM yb_home_slider  WHERE home_slider_is_delete = 0 AND home_slider_is_active = 1 ORDER BY home_slider_sequence ASC ';
    $aDetails = mysql_query($sQuery);
    return $aDetails;    
}


function getResultHtml($obj,$searchText = '',$exactsearch = 0,$categories = '',$features = '',$page = 0){
           
    $fetchPlaces = array();
    if($page)
        $fetchPlaces = fetchPlaces($obj,$searchText,$exactsearch,$categories,$features,$page);
    else
        $fetchPlaces = fetchPlaces($obj,$searchText,$exactsearch,$categories,$features);
                  
    $row_inc = 0;    
    if($page > 0)
        $row_inc = $page * 6;
    foreach($fetchPlaces as $place){ $row_inc++ ?>
    <div class="list_tiles <?php echo ($row_inc % 3 == 0 ? 'col_2' : 'col_1')?> <?php echo ($row_inc % 2 == 0 ? 'float_right' : '')?>">
        <div class="col_img">            
            <div class="col_img_over">
                <div class="over" data-link="<?php  echo SITE_PATH.'places/'. base64_encode($place['plc_id']);?>">
                    <a href="<?php  echo SITE_PATH.'places/'. base64_encode($place['plc_id']);?>">MORE INFORMATION</a>
            </div>
                <div class="foggyimg" style="margin-bottom: -3px;">
                    <img src="<?php echo (!empty($place['plc_gallery_media']) ? PLACES_MEDIUM_IMAGE_PATH.$place['plc_gallery_media'] : DEFAULT_IMAGE_PATH);?>" alt="<?php echo htmlentities(stripslashes($place['plc_name']));?>"/>
                </div>
            </div>
            <div class="col-text">

                    <!--div class="cap_text">
                        <img src="images/favourites.png" alt=""/>
                    </div-->

                <div title="<?php echo htmlentities(stripslashes($place['plc_name']));?>" class="cap_text1"><?php echo htmlentities(strlen($place['plc_name']) > 15 ? substr(stripslashes($place['plc_name']),0,15).'...' : stripslashes($place['plc_name']));?></div>
            </div>
        </div>
    </div>
    <?php }?>
    <?php 
    foreach($fetchPlaces as $place){ ?>
    <div class="list_box">
        <div class="list_left col_img_over">
                    <div class="over">
            <a href="<?php echo SITE_PATH.'places/'. base64_encode($place['plc_id']);//'javascript:void();';?>">MORE INFORMATION</a>
        </div>
                <div class="col_img foggyimg">
                    <img src="<?php echo (!empty($place['plc_gallery_media']) ? PLACES_MEDIUM_IMAGE_PATH.$place['plc_gallery_media'] : DEFAULT_IMAGE_PATH);?>" alt="<?php echo htmlentities(stripslashes($place['plc_name']));?>"/>
                </div>
        </div>
        <div class="list_right">
                <div class="list_right_in">
                <div class="col_head"><?php echo htmlentities(stripslashes($place['plc_name']));?></div>
                <div class="col-text"><span><?php echo strlen($place['plc_info']) > 150 ? substr(stripslashes($place['plc_info']),0,180).'...' : stripslashes($place['plc_info']);?></span></div>
                <div class="read_more">
                    <a class="wlink" href="<?php echo SITE_PATH.'places/'. base64_encode($place['plc_id']);//'javascript:void();';?>">More Information</a>
                </div>
            </div>
        </div>
    </div>
    <?php }
    
   /* ?><input type="hidden" id="hidd_cat" value="<?php echo !empty($categories) ? implode(',',$categories) : 0;?>" /><?php*/
}

function getResultHighlightsHtml($obj,$searchText = '',$exactsearchchb = 0,$categories = '',$features = ''){
    
    $fetchPlaces = array();
    $resultArr = array();
    $fetchPlaces = fetchPlaces($obj,$searchText,$exactsearchchb,$categories,$features,0,1);
    foreach($fetchPlaces as $place){ 
        if(!empty($place['cat_parent_id']))
            $resultArr['c_'.$place['cat_parent_id']] = $place['pcat_name'];
        if(!empty($place['feature_id']))
            $resultArr['f_'.$place['feature_id']] = $place['feature_title'];
    }
    
    foreach($resultArr as $key=>$value){ 
        if(!empty($value)){
            $type = $key[0];
            if($type == 'c'){
                ?>
                    <div class="tags_left">
                        <div class="tags_left_in">
                        <div class="bt_close">
                            <span>
                                <img class="res_category_close" data-tag="<?php echo $key;?>" src="images/close-bt.png"  alt=""/>
                            </span>
                            <a class="res_category" data-tag="<?php echo $key;?>" href="javascript:void(0);">
                                <?php echo $value;?>
                            </a>
                        </div>
                        </div>
                    </div>
                <?php 
                }
                else{
                    ?>
                    <div class="tags_left">
                        <div class="tags_left_in">
                        <div class="bt_close">
                            <span>
                                <img class="res_feature_close" data-tag="<?php echo $key;?>" src="images/close-bt.png"  alt=""/>
                            </span>
                            <a class="res_feature" data-tag="<?php echo $key;?>" href="javascript:void(0);">
                                <?php echo $value;?>
                            </a>
                        </div>
                        </div>
                    </div>
                <?php 
                }
            }
        }
   }

?>
