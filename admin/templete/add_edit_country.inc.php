<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
   
	$("#Save").click(function(){
       $("#frmcountry").validate({
			ignore: ":hidden:not(#content_ans)",
			errorElement: "div",
            rules: {
                country_abbr      : { required: true},
                country_name      : { required: true}
            },
            messages: {
                country_abbr  : { required: "Please enter country abbreviation ." },
                country_name : { required: "Please enter country name." }
			 }
			
        });//End add Country form validation
		
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
                                <form action="#" method="post" name="frmcountry" id="frmcountry" enctype="multipart/form-data">
									<input type="hidden" name="country_id" value="<?php echo $_REQUEST['country_id']; ?>"/>
                                    <input type="hidden" name="n_id" id="n_id" value="<?php echo $id != '' ? $id : ''; ?>"/>
                                    <input type="hidden" name="step" id="step" value="<?php
                                    if ($id == '') {
                                        echo 'add_country';
                                    } else {
                                        echo 'edit_country';
										
										
                                    }
                                    ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style="padding: 30px;">
                                        <tr id="msg_dis">
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 150px;">&nbsp; </td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size:13px"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>
										
                                                        <!--Question Start-->   

                                                

                                        <tr>
                                                <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 150px;"><p>Country Abbreviation:<font color='red' size='2px'>*</font></p> </td>
                                                <td colspan="2" height="" valign="top" align="left">

                                                        <input type="text" name="country_abbr" id='country_abbr'  value="<?php echo $sCountry_abbr?>" style="margin: 0px!important;"/>
                                                        
                                                                <div for="content1" generated="true" class="error" style="width:196px;"></div>		
                                                </td>
                                                </tr>
                             <!--Question End-->

                                                        <!--Answer Start-->   
                                                <tr>
                                                        <td colspan="2"></td>
                                                </tr>

                                                

                                        <tr id="conentdesc2">
                                                
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px;width: 150px;"><p>Country Name:<font color='red' size='2px'>*</font></p> </td>
                                            <td colspan="2" valign="top" align="left"><div id="main" >
                                                                 <div for="content_ans" generated="true" class="error" style="width:196px;"></div>

                                                                 <input type="text" name='country_name' id='country_name' value="<?php echo $sCountry_name;?>" style="margin: 0px!important;" />

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
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='country_management.php?isCancelButtonClicked=1'" />
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
