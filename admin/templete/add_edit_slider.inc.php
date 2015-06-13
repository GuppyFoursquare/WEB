<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
    $("#Save").click(function(){
        <?php if($iSlideID > 0){ ?>
        $("#frmslider").validate({
            errorElement: "div",
            rules: {
                slide_title : { required: true},
				txtSlideImage : { accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG" },
				slide_link : { url: true},
                //txtCatImage      : { accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG" },
                //txtCatIcon      : { accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG" },
            },
            messages: {
                slide_title: { required: "Please enter category name." }
				txtSlideImage : { accept: "Extension should be jpg,jpeg,png or gif." },
				slide_link : { required: "Please enter valid link." },
                //txtCatImage: { accept: "Extension should be jpg,jpeg,png or gif."},
                //txtCatIcon: { accept: "Extension should be jpg,jpeg,png or gif."}           
            }
        });//End add worker form validation
        <?php }else{ ?>        
        $("#frmslider").validate({
            errorElement: "div",
            rules: {
                slide_title : { required: true},
				txtSlideImage : { required: true,accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG" },
				slide_link : { url: true},
				
                //txtCatImage      : { required: true,accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG" },
               // txtCatIcon      : { required: true,accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG" },
            },
            messages: {
                slide_title: { required: "Please enter slide title." },
				txtSlideImage : { required: "Please upload slide image." , accept: "Extension should be jpg,jpeg,png or gif." },
				slide_link : { required: "Please enter valid url." },
               // txtCatImage: { required:"Please upload category image", 
               //                accept: "Extension should be jpg,jpeg,png or gif."},
               // txtCatIcon: { required:"Please upload category icon", 
               //                accept: "Extension should be jpg,jpeg,png or gif."}           
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
                                <form action="#" method="post" name="frmslider" id="frmslider" enctype="multipart/form-data">
                                    <input type="hidden" name="slide_id" value="<?php echo $_REQUEST['slide_id']; ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style=" margin-left:17px">
                                        <tr id="msg_dis">
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td width="145" valign="top">&nbsp;</td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size:13px"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>

                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Title: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="slide_title" id="slide_title" maxlength="100"  value="<?php echo isset($sSliderTitle) ? htmlspecialchars($sSliderTitle) : htmlspecialchars($sSliderTitle); ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="slide_title" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Slide Image: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="FILE" name="txtSlideImage" class="display_text" />&nbsp;
											<br/>
                                                <div for="txtSlideImage" generated="true" class="error" style="width:196px;"></div>
											</td>
                                        </tr>
                                        <?php if($sSlideImage){ ?>
                                            <tr>
                                                <td align="left"  class="white12" valign="top" style="padding-top:5px">&nbsp;</td>
                                                <td align="left" >
                                                    <img width="216px" src="<?php echo "../".SLIDER_IMAGE.$sSlideImage; ?>" border="0" /></td>
                                            </tr>
                                        <?php } ?>
                                        <!--tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Slide Link: <font color='red' size='2px'></font></p></td>
                                            <td align="left" ><input type="text" name="slide_link" id="slide_link" maxlength="100"  value="<?php //echo isset($sSliderLink) ? $sSliderLink : $sSliderLink; ?>" class="display_text" />&nbsp;
												<br/>
												<p>(e.g http://www.google.co.in)</p>
                                                <br/>
                                                <div for="slide_link " generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr -->

                                        <tr>
                                            <td></td>
                                            <td   align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($iSlideID == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='slider.php?isCancelButtonClicked=1'" />
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
