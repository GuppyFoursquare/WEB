<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<?php  include_once("tinymice.php");?>
<script type="text/javascript">
$(document).ready(function(){
   
	$("#Save").click(function(){
		<?php if($iNewsID > 0){ ?>
        $("#frmnews").validate({
			 ignore: [],
            errorElement: "div",
            rules: {
                cnt_page_heading : { required: true},
				cnt_browser_title	: { required: true},
				cnt_keywords : { required: true},
				cnt_meta_description : { required: true},
				content_ans : { required: true},
				cnt_url_name : { required: true},
			},
            messages: {
				cnt_page_heading: { required: "Please enter page heading."},
				cnt_browser_title	: { required: "Please enter browser title." },
				cnt_keywords : { required: "Please enter meta keyword ." },
				cnt_meta_description : { required: "Please enter meta description ." },
				content_ans1 : { required: "Please enter  description ." },
				cnt_url_name : { required: "Please enter url." },       
            }
        });//End add worker form validation
        <?php }else{ ?>  
		
        $("#frmnews").validate({
			ignore: ":hidden:not(#content_ans)",
			errorElement: "div",
            rules: {
                cnt_page_heading : { required: true},
				cnt_browser_title	: { required: true},
				cnt_keywords : { required: true},
				cnt_meta_description : { required: true},
				content_ans : { required: true},
				cnt_url_name : { required: true},
				
            },
            messages: {
                cnt_page_heading: { required: "Please enter page heading."},
				cnt_browser_title	: { required: "Please enter browser title." },
				cnt_keywords : { required: "Please enter meta keyword ." },
				cnt_meta_description : { required: "Please enter meta description ." },
				content_ans1 : { required: "Please enter  description ." },
				cnt_url_name : { required: "Please enter url." },  
				
            }
		});//End add worker form validation
        <?php } ?>
    });//End save click
	
	
});
</script>
<script>
function urlconvert(val)
	{
		var res = val.replace(/["~!@#$%^&*\(\)_+=`{}\[\]\|\\:;'<>,.\/?"\- \t\r\n]+/g, '-');
		//var res = val.replace(/ /g, "_");
		var res1 = res.toLowerCase(); 
		//alert(res1);
		document.getElementById("cnt_url_name").value=res1;
	}
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
                                <form action="" method="post" name="frmnews" id="frmnews" enctype="multipart/form-data">
                                    <input type="hidden" name="usr_id" value="<?php echo $_REQUEST['usr_id']; ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style=" margin-left:17px">
                                        <tr id="msg_dis">
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td width="145" valign="top">&nbsp;</td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size:13px;"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Page Heading:<font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="cnt_page_heading" id="cnt_page_heading" maxlength="100"  value="<?php echo isset($sPageHeading) ? stripslashes($sPageHeading) : stripslashes($sPageHeading); ?>" class="display_text" onkeyup="urlconvert(this.value);"  style="width:570px!important" />&nbsp;
                                                <br/>
                                                <div for="cnt_page_heading" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Page URL: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" style="font-size:13px" ><?php echo SERVER_FRONT_PATH;?><input type="text" name="cnt_url_name" id="cnt_url_name" maxlength="100"  value="<?php echo isset($sPageUrl) ? stripslashes($sPageUrl) : stripslashes($sPageUrl); ?>" class="display_text" onkeypress="return keyRestrict(event,'abcedfghijklmnopqrstuvwxyz1234567890-_')" style="width:416px!important" />&nbsp;
                                                <br/>
                                                <div for="cnt_url_name" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Browser Title: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="cnt_browser_title" id="cnt_browser_title" maxlength="100"  value="<?php echo isset($sBrowserTitle) ? stripslashes($sBrowserTitle) : stripslashes($sBrowserTitle); ?>" class="display_text" style="width:570px!important" />&nbsp;
                                                <br/>
                                                <div for="cnt_browser_title" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Meta Keywords: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><textarea name="cnt_keywords" id="cnt_keywords" maxlength="100"  class="display_text" style="width:570px!important" ><?php echo isset($sPageMetaKeyword) ? stripslashes($sPageMetaKeyword) : ''; ?></textarea> &nbsp;
                                                <br/>
                                                <div for="cnt_keywords" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Meta Description: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><textarea name="cnt_meta_description" id="cnt_meta_description" maxlength="100"  class="display_text" style="width:570px!important" ><?php echo isset($sPageMetaDescription) ? stripslashes($sPageMetaDescription) : ''; ?></textarea> &nbsp;
                                                <br/>
                                                <div for="cnt_meta_description" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
										
										<!--Description Start-->   
									<tr id="conentdesc">
										<td colspan="2"></td>
									</tr>

									<tr >
									<td colspan="2">
										<table width="700" height="19" border="0" cellpadding="0" cellspacing="0" id="content_radiobutton">
											<tr>

												<td class="module2" width="20%" align="left"><p>Page Content:
													<font color='red' size='2px'>*</font></p></td>
												<td width="3%">&nbsp;&nbsp;</td>
												<td >&nbsp;&nbsp;</td>
											</tr>
										</table>
									   </td>
								</tr>

								<tr>
									
									<td colspan="2" height="150" valign="top" align="left"><div id="main" >
                                                                            <div for="content_ans1" generated="true" class="error" style="width:196px;"></div> 
                                                                            <?php
                                                                            echo "<textarea name='content_ans' id='content_ans' >".stripslashes($content_ans)."</textarea>";
                                                                            ?>
                                                                        </div>
                                                                        <br/>
                                               
									</td>
                                                                </tr>
                                          <!--Description End-->		
										
										<tr>
                                            
                                            <td colspan="2"  align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($iCntID == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='off_menu.php?isCancelButtonClicked=1'" />
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
