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
				place_rating_rating : { required: true},
				place_rating_comment : { required: true},
			},
            messages: {
				place_rating_rating: { required: "Please enter rating." },
				place_rating_comment : { required: "Please enter review." },
            }
        });//End add worker form validation
        <?php }else{ ?>        
        $("#frmuser").validate({
           
			errorElement: "div",
            rules: {
				place_rating_rating : { required: true},
				place_rating_comment : { required: true},
			},
            messages: {
				place_rating_rating: { required: "Please enter rating." },
				place_rating_comment : { required: "Please enter review." },
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
                                    <input type="hidden" name="place_id" value="<?php echo isset($_REQUEST['plc_id']) ? $_REQUEST['plc_id'] : ''; ?>"/>
                                    <input type="hidden" name="pending" value="<?php echo isset($_REQUEST['pending']) ? $_REQUEST['pending'] : ''; ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style=" margin-left:17px">
                                        <tr id="msg_dis">
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td width="145" valign="top">&nbsp;</td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size:13px"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>
										
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Rating: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><input type="text" name="place_rating_rating" id="place_rating_rating" maxlength="1"  value="<?php echo isset($sPlaceRating) ? $sPlaceRating : $sPlaceRating; ?>" class="display_text" onkeypress="return keyRestrict(event,'12345')" />&nbsp;
												<p> Enter Rating between 1 to 5 only
                                                <br/>
                                                <div for="place_rating_rating" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Review: <font color='red' size='2px'>*</font></p></td>
                                            <td align="left" ><textarea name="place_rating_comment" id="place_rating_comment" maxlength="100"  value="" class="display_text" ><?php echo isset($sPlaceComment) ? $sPlaceComment : $sPlaceComment; ?></textarea>&nbsp;
                                                <br/>
                                                <div for="	place_rating_comment" generated="true" class="error" style="width:196px;"></div>
                                            </td>
                                        </tr>
										
										<tr>
                                            <td></td>
                                            <td   align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($iPlaceRatingID == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='review_ratings.php?isCancelButtonClicked=1<?php echo isset($_REQUEST['plc_id']) ? '&plc_id='.$_REQUEST['plc_id'] : (isset($_REQUEST['pending']) ? '&pending='.$_REQUEST['pending'] :'');?>'" />
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
