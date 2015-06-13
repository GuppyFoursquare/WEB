<?php

include_once("prepend.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$query = "SELECT cat_id, cat_color FROM yb_category WHERE cat_parent_id = 0 AND cat_is_active = 1 AND cat_is_delete = 0 ORDER BY cat_name ASC";
$cat_colors = mysql_query($query);
$cat_color_arr = array();
while($row = mysql_fetch_assoc($cat_colors)){
    $cat_color_arr[$row['cat_id']] = $row['cat_color'];
}

$categories = isset($_POST['chkCategories']) ? $_POST['chkCategories'] : '';
$features = isset($_POST['chkFeature']) ? $_POST['chkFeature'] : '';


echo getTagsHtml($categories, $features, $cat_color_arr);



function getTagsHtml($categories = '', $features = '',$cat_color_arr = '')
{
    //print_r($cat_color_arr);die;
    if(!empty($categories)){
        $query = "SELECT cat_id, cat_parent_id, cat_name FROM yb_category WHERE cat_id IN (" . implode(',',$categories) .")";
        $resultData = mysql_query($query);
        while($row = mysql_fetch_assoc($resultData)){ ?>
            <div class="tag-label-box" style="background: #<?php echo $cat_color_arr[$row['cat_parent_id']];?>">
                <label><?php echo $row['cat_name'];?></label>
                <div class="close-btn-tags" data-id="<?php echo $row['cat_id']?>" data-parent="<?php echo $row['cat_parent_id'];?>">
                    <img src="<?php echo SITE_PATH;?>images/close-red.png"/>
                </div>
            </div>
<?php 
            
        }
        
    }

	if(!empty($features)){
            $query = "SELECT feature_id, feature_title FROM yb_features WHERE feature_id IN (" . implode(',',$features) .")";
            $resultData = mysql_query($query);
            while($row = mysql_fetch_assoc($resultData)){ ?>
                    <div class="tag-label-box" style="background: #000">
                        <label><?php echo $row['feature_title'];?></label>
                        <div class="close-btn-tags-features" data-id="<?php echo $row['feature_id']?>">
                            <img src="<?php echo SITE_PATH;?>images/close-red.png"/>
                        </div>
                    </div>

    <?php        }
        }

}

?>
