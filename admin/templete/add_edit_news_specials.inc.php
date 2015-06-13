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
                txtNewsImage : { accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG" },
				news_title	: { required: true},
				news_meta_keyword : { required: true},
				news_meta_description : { required: true},
				news_page_url : { required: true}, 
			},
            messages: {
				txtNewsImage : { accept: "Extension should be jpg,jpeg,png or gif."},
				news_title	: { required: "Please enter news title." },
				news_meta_keyword : { required: "Please enter meta keyword ." },
				news_meta_description : { required: "Please enter meta description ." },
				news_page_url : { required: "Please enter page url ." },       
            }
        });//End add worker form validation
        <?php }else{ ?>  
		
        $("#frmnews").validate({
			ignore: ":hidden:not(#content_ans)",
			errorElement: "div",
            rules: {
                txtNewsImage : { required: true, accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG"},
				news_title	: { required: true},
				news_meta_keyword : { required: true},
				news_meta_description : { required: true},
				content_ans : { required: true},
				news_page_url : { required: true}, 
				
            },
            messages: {
                txtNewsImage: { required: "Please upload image ." ,accept: "Extension should be jpg,jpeg,png or gif."},
				news_title	: { required: "Please enter news title." },
				news_meta_keyword : { required: "Please enter meta keyword ." },
				news_meta_description : { required: "Please enter meta description ." },
				content_ans1 : { required: "Please enter meta description ." },
				news_page_url : { required: "Please enter page url ." },
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
		//var res = val.replace(/ /g, "-");
		var res1 = res.toLowerCase(); 
		//alert(res1);
                <?php if(!$iNewsID){ ?>
		document.getElementById("news_page_url").value=res1;
                <?php }?>
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
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>News Image: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="FILE" name="txtNewsImage" class="display_text" />&nbsp;</td>
                                        </tr>
                                        <?php if($sNewsImage){ ?>
                                            <tr>
                                                <td align="left"  class="white12" valign="top" style="padding-top:5px">&nbsp;</td>
                                                <td align="left" ><img src="<?php echo "../".NEWS_IMAGE.$sNewsImage; ?>" border="0" /></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>News Title: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="news_title" id="news_title" style="width: 570px;"   value="<?php echo isset($sNewsTitle) ? htmlspecialchars($sNewsTitle) : htmlspecialchars($sNewsTitle); ?>" class="display_text" onkeyup="urlconvert(this.value);"  />&nbsp;
                                                <br/>
                                                <div for="news_title" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>News URL: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" style="font-size:13px" ><?php echo SERVER_FRONT_PATH."news/";?><input type="text" name="news_page_url" id="news_page_url" style="width: 378px;"  value="<?php echo isset($sNewsPageUrl) ? htmlspecialchars($sNewsPageUrl) : htmlspecialchars($sNewsPageUrl); ?>" class="display_text" onkeypress="return keyRestrict(event,'abcedfghijklmnopqrstuvwxyz1234567890-_')" />&nbsp;
                                                <br/>
                                                <div for="news_page_url" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
										
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Meta Keywords: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><textarea name="news_meta_keyword" id="news_meta_keyword" maxlength="100"  class="display_text" style="width: 570px !important;" ><?php echo isset($sNewsMetaKeyword) ? $sNewsMetaKeyword : $sNewsMetaKeyword; ?></textarea> &nbsp;
                                                <br/>
                                                <div for="news_meta_keyword" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Meta Description: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><textarea name="news_meta_description" id="news_meta_description" maxlength="100"  class="display_text" style="width: 570px !important;" ><?php echo isset($sNewsMetaDescription) ? $sNewsMetaDescription : $sNewsMetaDescription; ?></textarea> &nbsp;
                                                <br/>
                                                <div for="news_meta_description" generated="true" class="error" style="width:196px;"></div>
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

												<td class="module2" width="20%" align="left"><p>News Description:
													<font color='red' size='2px'>*</font></p></td>
												<td width="3%">&nbsp;&nbsp;</td>
												<td >&nbsp;&nbsp;</td>
											</tr>
										</table>
									   </td>
								</tr>

								<tr>
									
									<td colspan="2" height="150" valign="top" align="left">
                                                                            <div id="main" >
                                                                            <div for="content_ans1" generated="true" class="error" ></div> 
                                                                            <?php
                                                                            echo "<textarea name='content_ans' id='content_ans' >".$content_ans."</textarea>";
                                                                            ?>
                                                                            </div>
                                                                        <br/>
                                               
									</td>
									</tr>
                                          <!--Description End-->		
										
										<tr>
                                            
                                            <td  colspan="2" align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($iNewsID == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='news_specials.php?isCancelButtonClicked=1'" />
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
