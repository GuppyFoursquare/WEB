<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
   
	$("#Save").click(function(){
       $("#frmfaq").validate({
			ignore: ":hidden:not(#content_ans)",
			errorElement: "div",
            rules: {
                content1      : { required: true},
                content_ans      : { required: true},
            },
            messages: {
                content1  : { required: "Please enter Question ." },
                content_ans : { required: "Please enter Answer ." }
			 }
			
        });//End add faq form validation
		
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
                                <form action="#" method="post" name="frmfaq" id="frmfaq" enctype="multipart/form-data">
									<input type="hidden" name="faq_id" value="<?php echo $_REQUEST['faq_id']; ?>"/>
                                    <input type="hidden" name="n_id" id="n_id" value="<?php echo $id != '' ? $id : ''; ?>"/>
                                    <input type="hidden" name="step" id="step" value="<?php
                                    if ($id == '') {
                                        echo 'add_faq';
                                    } else {
                                        echo 'edit_faq';
										
										
                                    }
                                    ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style=" margin-left:17px">
                                        <tr id="msg_dis">
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td width="145" valign="top">&nbsp;</td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size:13px"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>
										
										<!--Question Start-->   
									<tr id="conent">
										<td colspan="2"></td>
									</tr>

									<tr id="conentdesc1">
									<td colspan="2">
										<table width="700" height="19" border="0" cellpadding="0" cellspacing="0" id="content_radiobutton">
											<tr>
												<?php 
												$sQuery="SELECT faq_question,faq_answer FROM yb_faq WHERE faq_id=".base64_decode($_GET['faq_id']);
												$rQuery=mysql_query($sQuery);
												$rowQuery=mysql_fetch_assoc($rQuery);
												$content=  stripslashes($rowQuery['faq_question']);
												$content_ans=stripslashes($rowQuery['faq_answer']);
												?>	
												<td class="module2" width="20%" align="left"><p>Question:
													<font color='red' size='2px'>*</font></p></td>
												<td width="3%">&nbsp;&nbsp;</td>
												<td >&nbsp;&nbsp;</td>
											</tr>
										</table>
									   </td>
								</tr>
												
								<tr>
									<td colspan="2" height="" valign="top" align="left">
											<textarea name='content1' id='content1' style="width: 720px !important;" ><?php echo $content?></textarea>
										
										<br/>
											<div for="content1" generated="true" class="error" style="width:196px;"></div>		
									</td>
									</tr>
                                                     <!--Question End-->
													 
										<!--Answer Start-->   
									<tr>
										<td colspan="2"></td>
									</tr>

									<tr id="conentdesc1">
									<td colspan="2">
										<table width="700" height="19" border="0" cellpadding="0" cellspacing="0" id="content_radiobutton">
											<tr>

												<td class="module2" width="20%" align="left"><p>Answer:
													<font color='red' size='2px'>*</font></p></td>
												<td width="3%">&nbsp;&nbsp;</td>
												<td >&nbsp;&nbsp;</td>
											</tr>
										</table>
									   </td>
								</tr>

								<tr id="conentdesc2">
									<td colspan="2" height="150" valign="top" align="left"><div id="main" >
											 <div for="content_ans" generated="true" class="error" style="width:196px;"></div>
											<?php
											$content_menu1 = isset($_POST['content'.$i]) ? mysql_real_escape_string(trim($_POST['content'.$i])) : trim(stripslashes($sch_administration));
											echo "<textarea name='content_ans' id='content_ans' >".$content_ans."</textarea>";
											?>
										</div>
										<br/>
                                               
									</td>
									</tr>
                                                     <!--Answer End-->			 

										
                                        <tr>
                                            
                                            <td colspan="2"  align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($id == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='faq.php?isCancelButtonClicked=1'" />
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
