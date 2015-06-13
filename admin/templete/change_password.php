<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
   
	$("#Save").click(function(){
		 
	   <?php if($iUserID > 0){ ?>
        $("#frmuser").validate({
            errorElement: "div",
            rules: {
                usr_old_password : { required: true},
				usr_new_password :	{ required: true},
				usr_password  : { required: true,equalTo: "#usr_new_password"},
			},
            messages: {
                usr_old_password: { required: "Please enter old Password." },
				usr_new_password :{ required: "Please enter new Password." },
				usr_password  : { required: "Please enter confirm Password."},
				       
            }
        });//End add worker form validation
        <?php }else{ ?>        
        $("#frmuser").validate({
           
			errorElement: "div",
            rules: {
                usr_old_password : { required: true},
				usr_password  : { required: true},
				
            },
            messages: {
                usr_old_password: { required: "Please enter Old Password." },
				usr_password  : { required: "Please enter New Password." },
				
            }
        });//End add worker form validation
        <?php } ?>
    });//End save click
	
	$("#usr_old_password").blur(function(){
		var user_type=$("#usr_old_password").val();
		var action="select_password";
		$.post( "ajax_functionality.php",{'user_type':user_type,'action':action}, function( data ) {
		//$( ".result" ).html( data );
                    var i=0;
                    //alert(data);
                    if(data=='1'){
                            alert("old password not valid");
                            $("#usr_old_password").val("");
                            //$("#usr_old_password").focus();
                    }
		});
	});
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
                                <form action="" method="post" name="frmuser" id="frmuser" enctype="multipart/form-data">
                                    <input type="hidden" name="usr_id" value="<?php echo $_REQUEST['usr_id']; ?>"/>
                                    <input type="hidden" name="step" value="<?php echo isset($_REQUEST['usr_id']) ? 'UserUpdate' : 'AdminUpdate'; ?>"/>
                                    <input type="hidden" name="p" value="<?php echo isset($_REQUEST['p']) ? $_REQUEST['p'] : ''; ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style=" margin-left:17px">
                                        <tr id="msg_dis">
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td width="145" valign="top">&nbsp;</td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size: 13px;"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>
										
					<?php if(!$userId){?>				
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 168px;font-size: 13px;" >Current Password: <font color='red' size='2px'>*</font></td>
                                            <td align="left" ><input type="password" name="usr_old_password" id="usr_old_password" maxlength="100"  value="<?php echo isset($sUserPassword) ? $sUserPassword : $sUserPassword; ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="usr_old_password" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
					<?php }else{?>	
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 168px;font-size: 13px;" >Username: <font color='red' size='2px'>*</font></td>
                                            <td align="left" ><input type="text" disabled="disabled" name="username" id="username" maxlength="100"  value="<?php echo isset($sUsername) ? $sUsername : $sUsername; ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="username" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
                                        <?php }?>
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 168px;font-size: 13px;" >New Password: <font color='red' size='2px'>*</font></td>
                                            <td align="left" >
                                                <input type="password" name="usr_new_password" id="usr_new_password" maxlength="100"  value="<?php echo isset($sUserPassword) ? $sUserPassword : $sUserPassword; ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="usr_new_password" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;font-size: 13px;">Confirm Password: <font color='red' size='2px'>*</font></td>
                                            <td align="left" >
                                                <input type="password" name="usr_password" id="usr_password" maxlength="100"  value="<?php echo isset($sUserName) ? $sUserName : $sUserName; ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="usr_password" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
                                        <tr>
                                            <td></td>
                                            <td   align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($iUserID == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='<?php echo $cancelUrl; ?>'" />
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
