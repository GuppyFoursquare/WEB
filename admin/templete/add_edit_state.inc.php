<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
   
        $("#state_country_id").val("<?php echo $iState_country_id;?>");
        
	$("#Save").click(function(){
       $("#frmstate").validate({
			ignore: ":hidden:not(#content_ans)",
			errorElement: "div",
            rules: {
                state_abbr      : { required: true},
                state_name      : { required: true},
                state_country_id      : { required: true}
            },
            messages: {
                state_abbr  : { required: "Please enter state abbreviation ." },
                state_name : { required: "Please enter state name." },
                 state_country_id : { required: "Please select a country." }
			 }
			
        });//End add state form validation
		
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
                                <form action="#" method="post" name="frmstate" id="frmstate" enctype="multipart/form-data">
									<input type="hidden" name="country_id" value="<?php echo $_REQUEST['country_id']; ?>"/>
                                    <input type="hidden" name="n_id" id="n_id" value="<?php echo $id != '' ? $id : ''; ?>"/>
                                    <input type="hidden" name="step" id="step" value="<?php
                                    if ($id == '') {
                                        echo 'add_country';
                                    } else {
                                        echo 'edit_country';
										
										
                                    }
                                    ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style=" padding: 30px;">
                                        <tr id="msg_dis">
                                            
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 150px;">&nbsp; </td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size:13px"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>
										
										<!--Question Start-->   
									<tr id="conent">
										<td colspan="2"></td>
									</tr>

									
								
                                                                <tr>
                                                                    <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 150px;"><p>Country:<font color='red' size='2px'>*</font></p> </td>
                                                                    <td colspan="2" height="" valign="top" align="left">
										
                                                                            <select id="state_country_id" name="state_country_id" style="margin-bottom: 5px!important;">
                                                                                <option value=""> Select country</option>
                                                                                <?php while($row_country = mysql_fetch_array( $result_country )){ ?>
                                                                                
                                                                                    <option value="<?php echo $row_country['country_id']?>"><?php echo $row_country['country_name']?></option>
                                                                                
                                                                                <?php }?>
                                                                            </select>
                                                                                
										
											<div for="content1" generated="true" class="error" style="width:196px;"></div>		
									</td>
									</tr>
                                                                
                                                                        
                                                                        
                                                                        
                                                                        
                                                                
								<tr>
                                                                    <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 150px;"><p>State Abbreviation:<font color='red' size='2px'>*</font></p> </td>
									<td colspan="2" height="" valign="top" align="left">
										
                                                                                <input type="text" name="state_abbr" id='state_abbr'  value="<?php echo $sState_abbr?>" style="margin: 0px!important;"/>
										
											<div for="content1" generated="true" class="error" style="width:196px;"></div>		
									</td>
									</tr>
                                                     <!--Question End-->
													 
										<!--Answer Start-->   
									<tr>
										<td colspan="2"></td>
									</tr>

									

								<tr id="conentdesc2">
                                                                    <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 150px;"><p>State Name:<font color='red' size='2px'>*</font></p> </td>
									<td colspan="2" valign="top" align="left"><div id="main" >
											 <div for="content_ans" generated="true" class="error" style="width:196px;"></div>
											
                                                                                         <input type="text" name='state_name' id='state_name' value="<?php echo $sState_name;?>" style="margin: 0px!important;"/>
                                                                                        
										</div>
										
                                               
									</td>
									</tr>
                                                     <!--Answer End-->			 

										
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 150px;">&nbsp; </td>
                                            <td colspan="2"  align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($id == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='state_management.php?isCancelButtonClicked=1'" />
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
