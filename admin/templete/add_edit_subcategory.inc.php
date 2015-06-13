<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
    $("#Save").click(function(){
        <?php if($iCategoryID > 0){ ?>
        $("#frmcat").validate({
            errorElement: "div",
            rules: {
                cat_name : { required: true},
                txtCatImage      : { accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG" }
            },
            messages: {
                cat_name: { required: "Please enter sub category name." },
                txtCatImage: { accept: "Extension should be jpg,jpeg,png or gif."}
            }
        });//End add worker form validation
        <?php }else{ ?>        
        $("#frmcat").validate({
            errorElement: "div",
            rules: {
                cat_name : { required: true},
                txtCatImage      : { required: true,accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG" }
            },
            messages: {
                cat_name: { required: "Please enter sub category name." },
                txtCatImage: { required:"Please upload category image", 
                               accept: "Extension should be jpg,jpeg,png or gif."}
            }
        });//End add worker form validation
        <?php } ?>
    });//End save click
});
</script>
<tr>
    <td height="400" align="center" valign="top" class="adminleft">
        <div class="admintitalbox">
            <div class="admintitalboxleft">
                <?php include("left_menu.inc.php"); ?>
            </div>
            <div class="admintitalboxright">
                <div class="mid_contain">
                    <table width="95%" border="0" align="center" cellpadding="4" cellspacing="0" >
                        <tr id="msg_dis">
                            <td colspan="2" align="center" id="message_div" style="margin:0 50px"></td>
                        </tr>
                        <tr>
                            <td style="">
                                <form action="#" method="post" name="frmcat" id="frmcat" enctype="multipart/form-data">
                                    <input type="hidden" name="cat_id" value="<?php echo $_REQUEST['cat_id']; ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style=" margin-left:17px">
                                        <tr id="msg_dis">
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td width="145" valign="top">&nbsp;</td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size:13px"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Category: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" >
                                                <select name="selCategory" style="width: 200px;"><?php echo $sCategories; ?></select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Sub Category: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="cat_name" id="cat_name" maxlength="100"  value="<?php echo isset($sCatName) ? $sCatName : htmlspecialchars($sCategory_Title); ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="cat_name" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td   align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($iCategoryID == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='subcategory_management.php?isCancelButtonClicked=1'" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </td>
</tr>
<?php include("footer.inc.php"); ?>
