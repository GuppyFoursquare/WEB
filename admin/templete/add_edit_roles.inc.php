<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
   
	$("#Save").click(function(){
		 
	   <?php if($iUserID > 0){ ?>
        $("#frmroles").validate({
            errorElement: "div",
            rules: {
				role_type : { required: true},
				role_description  : { required: true},
				'chkaccess[]' : { required: true},
			},
            messages: {
				
                role_type: { required: "Please enter role." },
				role_description  : { required: "Please enter role deescription." },
				'chkaccess[]' : { required: "Please select atleast one access." },       
            }
        });//End add worker form validation
        <?php }else{ ?>        
        $("#frmroles").validate({
           
			errorElement: "div",
            rules: {
				role_type : { required: true},
				role_description  : { required: true},
				'chkaccess[]' : { required: true},
            },
            messages: {
				role_type: { required: "Please enter role." },
				role_description  : { required: "Please enter role description." },
				'chkaccess[]' : { required: "Please select atleast one access." },
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
                                <form action="#" method="post" name="frmroles" id="frmroles" enctype="multipart/form-data">
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
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Role: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="role_type" id="role_type" maxlength="100"  value="<?php echo isset($sRoleType) ? htmlspecialchars($sRoleType) : htmlspecialchars($sRoleType); ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="role_type" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Role Description: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="role_description" id="role_description" value="<?php echo isset($sRoleDescription) ? htmlspecialchars($sRoleDescription) : htmlspecialchars($sRoleDescription); ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="role_description" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Access: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" style="font-size:13px" >
												<?php
                                                $options_query = "SELECT * FROM  yb_option WHERE opt_option_id!=8 AND opt_active = '1' ORDER BY opt_sequence_no ASC";
                                                $options_qry = mysql_query($options_query) or die("error".mysql_error());
                                                if($options==''){
                                                $options=$_POST['chkaccess'];
                                                }
                                                while($option = mysql_fetch_array($options_qry))
                                                {
                                                $checked = '';
                                                if(in_array($option['opt_option_id'], $options))
                                                $checked = 'checked=""';
                                                ?>
                                               <input type="checkbox" id="chkaccess_<?php echo $option['opt_option_id']; ?>" name="chkaccess[]" value="<?php echo $option['opt_option_id']; ?>" <?php echo $checked; ?> />
                                                   <?php echo $option['opt_option_name']; ?>        
                                                <br/>
                                                <?php
                                                }
                                                ?>
												<br/>
                                                <div for="chkaccess[]" generated="true" class="error" style="width:196px;"></div>		
                                            </td>
                                        </tr>
										
                                        <tr>
                                            <td></td>
                                            <td   align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($iRoleID == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='roles.php?isCancelButtonClicked=1'" />
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
