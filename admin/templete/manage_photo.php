<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script language="javascript" type="text/javascript">

    <!--image validation function starts here-->
    function chkvalidation()
    {

        var flag2 = 1;

        var imgtype = false;
        var cnt=document.getElementById('txtmatcount').value;

        if(cnt>0)
        {
            var count=cnt;
            for(i=0;i<count;i++)
            {
                if(document.getElementById('OnmatInput0').value!="")
                {

                    if (/(\.(jpg|jpeg|JPG|JPEG|mp4))$/i.test(document.getElementById('OnmatInput0').value))
                    {
                        imgtype = true;
                        imgblanck = true;
                        flag2 =1;
                    }
                    else
                    {
                        imgtype = false;
                        imgblanck = true;
                    }
                }
                else
                {
                    imgblanck = false;
                    flag2 =1;
                }
                if(i!="0" && document.getElementById('OnmatInput'+i).value!="")
                {

                    if (/(\.(jpg|jpeg|JPG|JPEG|mp4))$/i.test(document.getElementById('OnmatInput'+i).value))
                    {
                        imgtype = true;
                        flag2 =1;
                    }
                    else
                    {
                        imgtype = false;

                    }
                }

            }
        }
        else
        {
            alert("Please upload image.");
            flag2 = 0;
        }

        if (imgblanck == false)
        {
            alert("Please upload image.");
            flag2 = 0;
        }
        else if (imgtype == false)
        {

            alert("Load only jpg, jpeg");
            flag2 = 0;
        }
        if(flag2 ==1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function editchkvalidation()
    {
        var flag1 = 1;
        var flag2 = 1;

        if( document.getElementById('txtupload').value != "" )
        {
            var ext_array=document.getElementById('txtupload').value.split('.');
            var ln=ext_array.length ;
            var ext=ext_array[ln-1].toLowerCase();
            if(ext=='jpg' || ext=='JPG' || ext=='JPEG' || ext=='jpeg')
            {
                document.getElementById('errphoto').innerHTML='';
            }
            else
            {
                document.getElementById('errphoto').innerHTML='Load only jpg, jpeg.';
                flag2 = 0;
            }
        }
        if(flag2)
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    <!--image validation function ends here-->

    <!--image delete function starts here-->

    <!--image delete function ends here-->
</script>
<script language="javascript" type="text/javascript">
    <!--add dynamic table rows -->
    function addMatRow(tableID)
    {
        var table = document.getElementById(tableID);

        var rowCount = table.rows.length;

        var row = table.insertRow(rowCount);
        rowCount = rowCount +1;

        var cell2 = row.insertCell(0);
        var element2 = document.createElement("input");
        element2.id="OnmatInput"+rowCount;
        element2.name="OnmatInput"+rowCount;
        element2.maxlength=25;
        element2.size=20;
        element2.type = "file";
        element2.style.color="#999999";



        //cell2.style.backgroundColor="#000000";
        //cell2.style.color="#999999";

        cell2.appendChild(element2);

        //document.getElementById('txtmatcount').value=rowCount + 1;

        document.getElementById('txtmatcount').value=rowCount+1 ;

    }

</script>
<style>
    .warning {
color: #333333;
background-color: #FFE6E6;
background-image: url('images/error.png');
border: 1px solid #F58A89;
margin: 10px 0px;
padding:15px 10px 15px 50px;
background-repeat: no-repeat;
background-position: 10px center;
width:200px;
}

tr, td {
    color: #333;
    font-family: "Open Sans",sans-serif;
    font-size: 13px;
    font-weight: 400;
    margin: 0;
}
</style>

<!--container start-->
<tr>
    <td height="400" align="center" valign="top" class="adminleft">
        <div class="admintitalbox">
            <div class="admintitalboxleft">
                <?php include("left_menu.inc.php"); ?>
            </div>
            <div class="admintitalboxright">
                <div class="mid_contain">
                    <table width="734px" border="0" align="center" cellpadding="4" cellspacing="0" >
                        <tr>
                            <td>


                                <form action="#" method="post" name="frmgaller" id="frmgaller" enctype="multipart/form-data">
                                    <input type="hidden" name="n_id" id="n_id" value="<?php echo $id != '' ? $id : ''; ?>"/>
                                    <input type="hidden" name="step" id="step" value="add_photo"/>
                                    <table width="700" border="0" align="center" cellpadding="4" cellspacing="0" >

                                        <tr id="sts_msg" style="display:none">
                                            <td colspan="2" align="center"><div class="msg_dis" >Status updated successfully.</div></td>
                                        </tr>
                                        <tr>
                                            <td style="">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >

                                                    <tr id="msg_dis">
                                                        <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" width="20%" style="padding-top:10px;" class="comman_text2">Product Title:&nbsp;&nbsp;</td>
                                                        <td width="80%" align="left" class="comman_text2" style="padding-top:10px; padding-left:5px;"><?= stripslashes($title); ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td align="left" valign="top" class="comman_text2">Photos:</td>
                                                        <td align="left" width="700px" style="padding-left:5px;" >
                                                            <input name="OnmatInput0" type="file" id="OnmatInput0" onkeypress="false" style="color:#999999;"  /><div>Image size should be 600px x 350px</div>
                                                            <br/>
                                                            <div id="errphoto" class="err_div"></div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Make Cover Image:</td>
                                                        <td><input name="plc_is_cover_image" type="checkbox" value="1" <?php if ($plc_is_cover_image == "1") echo "checked=checked"; ?> >
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td height="15"><br />
                                                            <br />  <input type="hidden" name="txtmatcount" id="txtmatcount" value="1"/>                  </td>
                                                        <td height="15" align="left">
                                                            <?php if (count($allPhoto) < 20) { ?>
                                                                <input type="submit" name="btnsubmit" value="Save"  class="button" onclick="return chkvalidation();">&nbsp;
                                                            <?php } ?></td>
                                                        <td height="15">&nbsp;</td>
                                                    </tr>
                                                    <?php if (count($allPhoto) >= 20) { ?>
                                                        <tr>
                                                            <td height="15"></td>
                                                            <td height="15" align="left"><div class="warning">Note:You can add only 20 photos</div></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </form>
                                                    <br/>

                                                    <form action="#" method="post" name="frmsequenceorder" id="frmsequenceorder" enctype="multipart/form-data">
                                                        <input type="hidden" id="list_id" name="list_id" value="<?= $id ?>">
                                                        <tr>
                                                            <td colspan="3" align="left">
                                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" id="gridtable" style="margin-left:0px" class="display">
                                                                   <thead>
                                                                    <tr>
                                                                        <th width="10%"  align="center"  >SEQ.No.</th>
                                                                        <th width="20%"  align="center" style="">PHOTO</th>
                                                                        <th width="20%"  align="center" class="align_image_center" style="">COVER PIC</th>
                                                                        <th width="20%"  align="center" class="align_image_center" >STATUS</th>
                                                                        <th width="20%" align="center" class="align_image_center" >DELETE</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <?
                                                                    $i = 0;
                                                                    //print_r($allPhoto);
                                                                    if (!empty($allPhoto)) {

                                                                        foreach ($allPhoto as $row_mat) {
                                                                            $i++;
                                                                            $strTrClass = "grid_row2";
                                                                            $w = '';
                                                                            $h = '';
                                                                            if($row_mat['plc_gallery_is_video'] == 1)
                                                                            {
                                                                                $photopath = SET_UPLOAD_PATH.PLACES_VIDEO_PATH . $row_mat['plc_gallery_media'];
                                                                                $w = '160';
                                                                                $h = '65';
                                                                            }else{
                                                                                $photopath = SET_UPLOAD_PATH.PLACES_SMALL_IMAGE_PATH . $row_mat['plc_gallery_media'];
                                                                                $newDimensions = resizeImage(100, 100, $photopath);
                                                                                $w = $newDimensions[0];
                                                                                $h = $newDimensions[1];
                                                                            }
                                                                            
                                                                            ?>
                                                                            <tr <?php if ($i % 2 == '0') { ?> class='even' <?php } else { ?> class='odd' <?php } ?>>
                                                                                <td   align="center" style="text-align:center">
                                                                                    <p><div class="numberCircle" style=""><?= $i; ?></div></p>

                                                                                </td>
                                                                                <td align="center"  class="name_link" style="padding:10px;text-align: center;">
                                                                                    <?php if($row_mat['plc_gallery_is_video'] == 1){?>
                                                                                    <video width="<?php echo $w; ?>" height="<?php echo $h; ?>" controls id="video">
                                                                                        <source src="<?= $photopath; ?>" >
                                                                                    </video>
                                                                                    <?php }else{?>
                                                                                    <img src="<?= $photopath; ?>" width="<?php echo $w; ?>" height="<?php echo $h; ?>"/>
                                                                                    <?php }?>
                                                                                </td>
                                                                                <td   align="center" class="align_image_center">
                                                                                    <?php if($row_mat['plc_gallery_is_video'] != 1){?>
                                                                                    <a href="#" id="actdect<?php echo $row_mat['plc_is_cover_image']; ?>">
                                                                                        <?php if ($row_mat['plc_is_cover_image'] == '1') { ?>
                                                                                            <img src="images/active.png" style="cursor:pointer"  border="0" title="Set cover pic" onclick="alert('You need to set atleast one cover picture.');"/>
                                                                                        <?php } else { ?>
                                                                                            <img title="Unset Cover Pic" style="cursor:pointer"  border="0" src="images/deactive.png" onclick="SetImage('set','cover photo ','<?php echo $row_mat["plc_gallery_id"] ?>','manage_photo.php','<?= $_SESSION['id'] ?>')">
                                                                                        <?php } ?>
                                                                                    </a>
                                                                                     <?php }else{ echo "--";} ?>
                                                                                </td>
                                                                                <td  align="center" class="align_image_center">
                                                                                    <?php if ($row_mat['plc_is_cover_image'] != '1') { ?>
                                                                                    <a href="#" id="actdect<?php echo $row_mat['plc_id']; ?>">
                                                                                        <?php if ($row_mat['plc_gallery_is_active'] == '1') { ?>
                                                                                            <img src="images/active.png" style="cursor:pointer"  border="0" title="Active" onclick="statusOprGallery('deactivate','Photo ','<?php echo $row_mat["plc_gallery_id"] ?>','manage_photo.php','<?= $_SESSION['id'] ?>')"/>
                                                                                        <?php } else { ?>
                                                                                            <img title="Inactive" style="cursor:pointer"  border="0" src="images/deactive.png" onclick="statusOprGallery('activate','Photo ','<?php echo $row_mat["plc_gallery_id"] ?>','manage_photo.php','<?= $_SESSION['id'] ?>')">
                                                                                        <?php } ?></a>
                                                                                    <? }else{ echo "--";} ?>
                                                                                </td>
                                                                                <td align="center"  class="align_image_center" >
                                                                                    <?php if ($row_mat['plc_is_cover_image'] != '1') { ?>
                                                                                    <div name="divDeleteRecord" id="divDeleteRecord11"><a href="#" onclick="deleteOprGallery('delete','photo','<?php echo $row_mat["plc_gallery_id"] ?>','manage_photo.php','<?= $_SESSION['id'] ?>')"><img src="images/delete.png" border="0" alt="delete"  title="Delete"/></a></div>
                                                                                     <? }else{ echo "--";} ?>
                                                                                </td>
                                                                            </tr>

                                                                        <? } ?>


                                                        </form>
                                                        <?
                                                    } else {
                                                        ?>
                                                        <tr class="<?= $strTrClass; ?>">
                                                            <td colspan="5"  class="name_link" style="text-align: center;padding: 10px;
                                                                background-color: #fff;">No record(s) found.</td>
                                                        </tr>
                                                    <?php }
                                                    if($noofrecords > $pagesize ) 
                                                    {?>					

                                                    <tr>
                                                        <td height="6" colspan="9" align="center" class="grid_footer pagination" bgcolor="#CCCCCC">
                                                            <?php echo $data = pagination(1,$pagingpagename,$noofrecords,$pagesize,$page,$extra_parameters);  ?>
                                                        </td>
                                                    </tr> <?php } ?>
                                                    <tr>
                                                        <td colspan="2" align="center"  class="name_link" style="padding-top:5px; padding-left:10px;">                          </td>
                                                    </tr>
                                                </table>
                                                <span style="padding-left:180px;">

                                                </span>
                                                <input type="hidden" name="txttotalproducts_on_the_mat" id="txttotalproducts_on_the_mat" value="" />                  </td>
                                        </tr>
                                    </table>

                            </td>
                        </tr>
                    </table>
                    </td>
                    </tr>
                    <tr><td>
                            <table width="100%" border="0" align="center" cellspacing="0" cellpadding="5">
                                <tr>
                                    <td align="center"><input type="button" name="Back" value="Back" id="Back"  onclick="location.href='places.php?isCancelButtonClicked=1'" class="button"/></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </td>
</tr>
<?php include("footer.inc.php"); ?>
<style>
    .pagination{
        border-top: 1px solid #e6e6e6;
        background-color: #fff!important;
        height: 20px!important;
        text-align: right!important;
        line-height: 20px!important;
    }
    .pagination a {
    border: 1px solid #c9c9c9;
    border-radius: 3px;
    color: #585858 !important;
    cursor: pointer;
    font-size: 12px;
    font-weight: 400;
    margin: 0 3px;
    padding: 2px 5px;
    text-align: center;
    text-shadow: 1px 1px 0 #f1f0f0;  
    background: linear-gradient(to bottom, #e6e6e6 0%, #dbd6d6 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    }
    .pagination .current {
        background: linear-gradient(to bottom, #dd6665 0%, #E41D3C 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
        border: 1px solid #b94241;
        border-radius: 3px;
        color: #8c2221 !important;
        cursor: pointer;
        font-size: 12px;
        font-weight: 400;
        text-align: center;
        text-shadow: 1px 1px 0 #e48584;
    }
    .pagination .pagingbox a:first-child:after { 
        content: " Prev ";
    }
    .pagination .pagingbox a:last-child:after { 
        content: " Next ";
    }
</style>   
