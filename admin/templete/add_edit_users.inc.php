<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
	
	
$("#usr_user_type").change(function(){
		var user_type = $(this).val();
		
		/*$.post( "ajax_functionality.php",{'user_type':user_type}, function( data ) {
		$( ".result" ).html( data );
		});*/
 });

	
	$("#Save").click(function(){
		 
	   <?php if($iUserID > 0){ ?>
        $("#frmuser").validate({
            errorElement: "div",
            rules: {
				txtProfileImage : { accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG"},
                usr_first_name : { required: true},
				usr_last_name  : { required: true},
				usr_username : { required: true},
				usr_email : { required: true, email: true},
				usr_user_type : { required: true},
				'chkaccess[]' :  { required: true},
			},
            messages: {
				txtProfileImage : { accept: "Extension should be jpg,jpeg,png or gif."},
                usr_first_name: { required: "Please enter first name." },
				usr_last_name  : { required: "Please enter last name." },
				usr_username: { required: "Please enter username." },
				usr_email: { required: "Please enter email.", email: "Enter Valid Email."},
				usr_user_type : { required: "Please select user role." },
				'chkaccess[]' :  { required: "Please select at least one access." },
				       
            }
        });//End add worker form validation
        <?php }else{ ?>        
        $("#frmuser").validate({
           
			errorElement: "div",
            rules: {
				txtProfileImage : {	required: true, accept: "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG"},
                usr_first_name : { required: true},
				usr_last_name  : { required: true},
				usr_username : { required: true},
				usr_password : { required: true},
				usr_conf_password : { equalTo: "#usr_password"},
				usr_email : { required: true, email: true},
				usr_user_type : { required: true},
				'chkaccess[]' :  { required: true},
			},
            messages: {
				txtProfileImage : {	required: "Please upload profile image.", accept: "Extension should be jpg,jpeg,png or gif."},
                usr_first_name: { required: "Please enter first name." },
				usr_last_name  : { required: "Please enter last name." },
				usr_username: { required: "Please enter username." },
				usr_password : { required: "Please enter password."},
				usr_conf_password : { required: "Please retype password."},
				usr_email: { required: "Please enter email.", email: "Enter Valid Email."},
				usr_user_type : { required: "Please select user role." },
				'chkaccess[]' :  { required: "Please select at least one access." },
            }
			
        });//End add worker form validation
		<?php } ?>
    });//End save click
		
		
	$("#usr_user_type").change(function(){
		var role= [];
		var user_type=$("#usr_user_type").val();
		//alert(user_type);
		var action="select_role";
		$.post( "ajax_functionality.php",{'user_type':user_type,'action':action}, function( data ) {
		//$( ".result" ).html( data );
			var i=0;
			//alert(data);
			//alert();
			while(i<data.length)
			{
			  var s=$("#chkaccess_"+data[i]).val();
			  if(s==data[i]){
			  //alert("check"+data[i]);
			  $("#chkaccess_"+data[i]).prop("checked", true);
			  }else{
			  //alert("uncheck"+data[i]);
			 $("#chkaccess_"+data[i]).prop("checked", false);
			 }
			 i++;
			}
		},'JSON');
	
	
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
                                <form action="#" method="post" name="frmuser" id="frmuser" enctype="multipart/form-data">
                                    <input type="hidden" name="usr_id" value="<?php echo $_REQUEST['usr_id']; ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style=" margin-left:17px">
                                        <tr id="msg_dis">
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td width="145" valign="top">&nbsp;</td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size:13px"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Profile Image: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="FILE" name="txtProfileImage" class="display_text" />&nbsp;</td>
                                        </tr>
                                        <?php if($sProfileImage){ ?>
                                            <tr>
                                                <td align="left"  class="white12" valign="top" style="padding-top:5px">&nbsp;</td>
                                                <td align="left" ><img src="<?php echo "../".PROFILE_IMAGE.$sProfileImage; ?>" border="0" /></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>First Name: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="usr_first_name" id="usr_first_name" maxlength="100"  value="<?php echo isset($sFirstName) ? htmlspecialchars($sFirstName) : htmlspecialchars($sFirstName); ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="usr_first_name" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Last Name: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="usr_last_name" id="usr_last_name" maxlength="100"  value="<?php echo isset($sLastName) ? htmlspecialchars($sLastName) : htmlspecialchars($sLastName); ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="usr_last_name" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Username: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="usr_username" id="usr_username" maxlength="100"  value="<?php echo isset($sUserName) ? htmlspecialchars($sUserName) : htmlspecialchars($sUserName); ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="usr_username" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										<?php if ($iUserID == '') { ?>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Password: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="password" name="usr_password" id="usr_password" maxlength="100"  value="<?php echo isset($sUserPassword) ? $sUserPassword : $sUserPassword; ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="usr_password" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Confirm Password: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="password" name="usr_conf_password" id="usr_conf_password" maxlength="100"  value="<?php echo isset($sUserName) ? $sUserName : $sUserName; ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="usr_conf_password" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										<?php } ?>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Email: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="usr_email" id="usr_email" maxlength="100"  value="<?php echo isset($sEmail) ? htmlspecialchars($sEmail) : htmlspecialchars($sEmail); ?>" class="display_text" />&nbsp;
                                                <br/>
                                                <div for="usr_email" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;font-size:13px"><p>User Role: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" >
											<select name="usr_user_type" id="usr_user_type" >
											<option value="">Select Role</option>
											<?php 
											$sQueryrole="SELECT * FROM yb_rolemst WHERE role_status=1 AND role_removed=0";
											$rQueryrole=mysql_query($sQueryrole);
											while($rowrole=mysql_fetch_assoc($rQueryrole)){?>
											
											<option value="<?php echo $rowrole['role_id']; ?>" <?php if ($sUserType==$rowrole['role_type']) echo "selected";
											?>><?php echo stripslashes($rowrole['role_type']); ?></option>
											<?php } ?>
											</select>
                                                <br/>
                                            <div for="usr_user_type" generated="true" class="error" style="width:196px;"></div>    
                                            </td>
											
                                        </tr>
										 
										 <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;font-size:13px"><p>Access: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" style="font-size:13px" >
												<?php
                                                $options_query = "SELECT * FROM  yb_option WHERE  	opt_active = '1' AND opt_option_id!=7 AND opt_option_id!=8 ORDER BY opt_sequence_no ASC";
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
												</div>    
                                            </td>
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
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='users.php?isCancelButtonClicked=1'" />
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
