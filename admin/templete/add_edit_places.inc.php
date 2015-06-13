<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>

<link rel="stylesheet" type="text/css" href="<?php echo SITEPATH; ?>js/multiselect/jquery.multiselect.css" />
<!-- link rel="stylesheet" type="text/css" href="<?php //echo SITEPATH; ?>js/multiselect/style.css" / -->
<link rel="stylesheet" type="text/css" href="<?php echo SITEPATH; ?>js/multiselect/prettify.css" />
<link rel="stylesheet" type="text/css" href="<?php echo SITEPATH; ?>css/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="<?php echo SITEPATH; ?>js/multiselect/prettify.js"></script>
<script type="text/javascript" src="<?php echo SITEPATH; ?>js/multiselect/src/jquery.multiselect.js"></script>
<script type="text/javascript" src="<?php echo SITEPATH; ?>js/jquery-ui-timepicker-addon.js"></script>
<style>
.ui-widget {
    font-family: "Open Sans",sans-serif;
    font-size: 13px;
}
.cat_class .ui-widget {
    width: 216px !important;
}
.add_edit_section textarea {
    width: 200px !important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
    $("#selSubCat").multiselect();
    $("#selFeatures").multiselect();
    
    $("#txtinTime").timepicker({timeFormat: "HH:mm"});
    $("#txtoutTime").timepicker({timeFormat: "HH:mm"});
    
    $("#Save").click(function(){
        <?php 
        if($iPlaceId > 0){ ?>
        $("#frmPlaces").validate({
            errorElement: "div",
            ignore:"hidden",
            rules: {
                txtname:{
                        required:true
                },
                'selSubCat[]':{
                        required:true
                },
                /*'selFeatures[]':{
                        required:true
                },*/
                txtheader_image:{
                        accept: "gif|jpg|jpeg|GIF|JPG|JPEG"
                },
                txtemail:{
//                        required:true,
                        email:true
                },
//                txtcontact:{
//                        required:true
//                },
                txtwebsite:{
//                        required:true,
                        url:true
                },
//                selCountry:{
//                        required:true
//                },
//                selState:{
//                        required:true
//                },
//                txtcity:{
//                        required:true
//                },
//                txtaddress:{
//                        required:true
//                },
//                txtzip:{
//                        required:true
//                },
                txtlatitude:{
                        required:true
                },
                txtlongitude:{
                        required:true
                },
                txtmenu:{
                        accept: "pdf"
                }
//                txtinfo_title:{
//                        required:true
//                },
//                txtinfo:{
//                        required:true
//                }
            },
            messages: {
                txtname:{
                        required:"Please enter Name."
                },
                selSubCat:{
                        required:"Please select Categories."
                },
                /*selFeatures:{
                        required:"Please select Features."
                },*/
                txtheader_image:{
                        accept: "Extension should be jpg,jpeg or gif."
                },
                txtemail:{
//                        required:"Please enter Email.",
                        email:"Please enter a valid email"
                },
//                txtcontact:{
//                        required:"Please enter Contact."
//                },
                txtwebsite:{
//                        required:"Please enter Website.",
                          url:"Please enter a valid url."
                },
//                selCountry:{
//                        required:"Please enter Country."
//                },
//                selState:{
//                        required:"Please enter State."
//                },
//                txtcity:{
//                        required:"Please enter City."
//                },
//                txtaddress:{
//                        required:"Please enter Address."
//                },
//                txtzip:{
//                        required:"Please enter Zip."
//                },
                txtlatitude:{
                        required:"Please enter Latitude."
                },
                txtlongitude:{
                        required:"Please enter Longitude."
                },
                txtmenu:{
                        accept: "Extension should be pdf."
                }
//                txtinfo_title:{
//                        required:"Please enter Info Title."
//                },
//                txtinfo:{
//                        required:"Please enter Info."
//                }
            }
        });//End add worker form validation
        <?php }else{ ?>        
        $("#frmPlaces").validate({
            errorElement: "div",
            ignore:"hidden",
            rules: {
                txtname:{
                        required:true
                },
                'selSubCat[]':{
                        required:true
                },
                /*'selFeatures[]':{
                        required:true
                },*/
                txtheader_image:{
                        //required:true,                    
                        accept: "gif|jpg|jpeg|GIF|JPG|JPEG"
                },
                txtemail:{
                        //required:true,
                        email:true
                },
//                txtcontact:{
//                        required:true
//                },
                txtwebsite:{
                        //required:true,
                        url:true
                },
//                selCountry:{
//                        required:true
//                },
//                selState:{
//                        required:true
//                },
//                txtcity:{
//                        required:true
//                },
//                txtaddress:{
//                        required:true
//                },
//                txtzip:{
//                        required:true
//                },
                txtlatitude:{
                        required:true
                },
                txtlongitude:{
                        required:true
                },
                txtmenu:{
                        //required:true,                    
                        accept: "pdf"
                }
//                txtinfo_title:{
//                        required:true
//                },
//                txtinfo:{
//                        required:true
//                }
            },
            messages: {
               txtname:{
                        required:"Please enter Name."
                },
                selSubCat:{
                        required:"Please select Categories."
                },
                /*selFeatures:{
                        required:"Please select Features."
                },*/
                txtheader_image:{
                        //required:"Please select Header Image.",
                        accept: "Extension should be jpg,jpeg or gif."
                },
                txtemail:{
                        //required:"Please enter Email.",
                        email:"Please enter a valid email."
                },
//                txtcontact:{
//                        required:"Please enter Contact."
//                },
                txtwebsite:{
                        //required:"Please enter Website.",
                        url:"Please enter a valid url."
                },
//                selCountry:{
//                        required:"Please enter Country."
//                },
//                selState:{
//                        required:"Please enter State."
//                },
//                txtcity:{
//                        required:"Please enter City."
//                },
//                txtaddress:{
//                        required:"Please enter Address."
//                },
//                txtzip:{
//                        required:"Please enter Zip."
//                },
                txtlatitude:{
                        required:"Please enter Latitude."
                },
                txtlongitude:{
                        required:"Please enter Longitude."
                },
                txtmenu:{
                        //required:"Please select Menu Pdf.",
                        accept: "Extension should be pdf."
                }
//                txtinfo_title:{
//                        required:"Please enter Info Title."
//                },
//                txtinfo:{
//                        required:"Please enter Info."
//                }      
            }
        });//End add worker form validation
        <?php } ?>
    });//End save click
    
    
    // lat long buttons
        $("#diplay_lat").click(function()
        {
            if($('#txtaddress').val()!='' && $('#selState').val()!='' )
            {
                var city = $("#txtcity").val();
                //address = $('#txtaddress').val()+" "+ city +" "+ $("#selState option:selected" ).text()+" "+ $("#selCountry option:selected" ).text()+" "+$('#txtzip').val()+ " ";
                address = $("#txtname").val()+" "+$('#txtaddress').val()+" "+ city +" "+ $("#selState option:selected" ).text()+" "+ $("#selCountry option:selected" ).text()+" "+" ";
                $.ajax({
                    type: "POST",
                    url: "action.php",
                    async: false,
                    data: "address="+address+"&step=get_lat_lng",
                    success: function(data){
                        if(data){
                            var result =$.parseJSON(data);
                            
                            $("#txtlatitude").val(result['lat']);
                            $("#txtlongitude").val(result['long']);
                                    
                            $("#link_map").attr('href','https://maps.google.com/maps?q='+$("#txtname").val()+","+$('#txtaddress').val()+","+$("#selCountry option:selected" ).text()+","+
                            $("#selState option:selected" ).text()+","+city+"&hl=en&sll="+result['lat']+","+result['long']);
                            $("#link_map").show();
                            $("#display_status").val('1');
                            $("#diplay_lat").attr('disabled','disabled');
                            $("#diplay_lat").next('input').next('div').html('');
                        }
                        else
                            alert("Please enter correct address.");
                    }
                });
            }
            else
            {
                alert("Please enter address, city & state.");
            }
        });
    
        $("#link_map").click(function()
        {
            var city = $("#txtcity").val();
            $("#link_map").attr('href','https://maps.google.com/maps?q='+$("#txtname").val()+","+$('#txtaddress').val()+","+
            $("#selCountry option:selected" ).text()+","+$("#selState option:selected" ).text()+","+city+"&hl=en&sll="+$('#txtlatitude').val()+","+$('#txtlongitude').val());
            $("#link_map").show();
            $("#display_status").val('1');

        });
    
    
     $( ".mid_contain" ).on( "focus", "#selCountry", function() {
                show_button();
            });
            $( ".mid_contain" ).on( "focus", "#selState", function() {
                show_button();
            });
            $( ".mid_contain" ).on( "focus", "#txtcity", function() {
                show_button();
            });
            $( ".mid_contain" ).on( "focus", "#txtaddress", function() {
                show_button();
            });
            $( ".mid_contain" ).on( "focus", "#txtzip", function() {
                show_button();
            });
            
            $("#selCountry").change(function(){
            var country=$("#selCountry").val();
            $.ajax({
               type:"post",
               url:"<?php echo SITE_PATH;?>getStates.php",
               data:"country="+country,
               success:function(data){
                     $("#selState").html(data);
               }
            });
      });
      
       $("#selCountry").val("<?php echo $selCountry?>");
        $("#selCountry").change();

        setTimeout(function(){
            $("#selState").val("<?php echo $selState?>");
        }, 1500);
});



    function show_button()
    {
        $("#txtlatitude").val('');
        $("#txtlongitude").val('');
        $("#diplay_lat").removeAttr('disabled');
        $("#Save").attr('disabled');
        $("#display_status").val(0);

    }
    function hide_button()
    {
        $("#display_status").val(1);
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
                                <form action="#" method="post" name="frmPlaces" id="frmPlaces" enctype="multipart/form-data">
                                    <input type="hidden" name="plc_id" value="<?php echo $_REQUEST['plc_id']; ?>"/>
                                    <table  border="0" cellspacing="0" align="left" cellpadding="2" class="formtopbox add_edit_section" style=" margin-left:17px">
                                        <tr id="msg_dis">
                                            <td colspan="2" align="center"><div class="msg_dis"><?php echo isset($msg) ? $msg : '' ?></div></td>
                                        </tr>
                                        <tr>
                                            <td width="145" valign="top">&nbsp;</td>
                                            <td width=""  class="err_div" align="left" valign="top" style="color:red;font-size: 13px;"><font color='red' size='2px'>*</font> indicates required field.</td>
                                        </tr>

                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Name: <font size="2px" color="red">*</font></p></td>
                                            <td align="left"><input type="text" class="display_text" value="<?php echo isset($txtname) ? $txtname : ''; ?>" maxlength="100" id="txtname" name="txtname"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtname"></div>
                                            </td>
                                        </tr>
                                        <tr class="cat_class">
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p> Categories: <font size="2px" color="red">*</font></p></td>
                                            <td align="left">
                                                <select id="selSubCat" name="selSubCat[]" multiple="multiple" size="5">
                                                    <?php 
                                                        if(count($catMaster)){
                                                            $iCat = 0;
                                                            foreach($catMaster as $cat){ $iCat++;
                                                                if($cat['cat_parent_id'] == 0)
                                                                {
                                                                    if($iCat != 1)
                                                                    echo "</optgroup>";
                                                                    echo "<optgroup label='".$cat['cat_name']."'>";
                                                                }
                                                                else    
                                                                    echo "<option ".(in_array($cat['cat_id'],$placeCatArr) ? "selected='selected'" : "")." value='".$cat['cat_id']."'>".$cat['cat_name']."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <br>
                                                <div   class="error" generated="true" for="selSubCat"></div>
                                            </td>
                                        </tr>
                                        <tr class="cat_class">
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p> Features: <font size="2px" color="red"></font></p></td>
                                            <td align="left">
                                                <select id="selFeatures" name="selFeatures[]" multiple="multiple" size="5">
                                                    <?php if(count($featureArr)){
                                                        foreach($featureArr as $feature){
                                                            echo "<option ".(in_array($feature['feature_id'],$placeFeatArr) ? "selected='selected'" : "")." value='".$feature['feature_id']."'>".$feature['feature_title']."</option>"; 
                                                        }
                                                    }?>
                                                </select>
                                                <br>
                                                <div   class="error" generated="true" for="selFeatures"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Header Image: <font size="2px" color="red"></font></p></td>
                                            <td align="left"><input type="FILE" class="display_text" id="txtheader_image" name="txtheader_image"> 
                                                <br/>
                                                <label>Please enter an image of size 1920px x 1000px</label>
                                                <br>
                                                <div   class="error" generated="true" for="txtheader_image"></div>
                                            </td>
                                        </tr>
                                        <?php if($txtheader_image){ ?>
                                            <tr>
                                                <td align="left"  class="white12" valign="top" style="padding-top:5px">&nbsp;</td>
                                                <td align="left" >
                                                <img style="max-width:200px;" src="<?php echo "../".PLACES_HEADER_IMAGE.$txtheader_image; ?>" border="0" /></td>
                                            </tr>
                                        <?php } ?>
                                            
                                        
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Opening time: <font size="2px" color="red"></font></p></td>
                                            <td align="left"><input readonly type="text" class="display_text" value="<?php echo isset($txtinTime) ? $txtinTime : ''; ?>" maxlength="100" id="txtinTime" name="txtinTime"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtinTime"></div>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Closing time: <font size="2px" color="red"></font></p></td>
                                            <td align="left"><input readonly type="text" class="display_text" value="<?php echo isset($txtoutTime) ? $txtoutTime : ''; ?>" maxlength="100" id="txtoutTime" name="txtoutTime"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtoutTime"></div>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Open 24 hours: <font size="2px" color="red"></font></p></td>
                                            <td align="left"><input type="checkbox" class="display_text" <?php echo (isset($chbHours) && $chbHours == 1) ? 'checked' : ''; ?> id="chbHours" name="chbHours"> 
                                                <br>
                                                <div   class="error" generated="true" for="chbHours"></div>
                                            </td>
                                        </tr>
                                        
                                        
                                            
                                            
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Email: <font size="2px" color="red"></font></p></td>
                                            <td align="left"><input type="text" class="display_text" value="<?php echo isset($txtemail) ? $txtemail : ''; ?>" maxlength="100" id="txtemail" name="txtemail"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtemail"></div>
                                            </td>
                                        </tr><tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Contact: <font size="2px" color="red"></font></p></td>
                                            <td align="left"><input type="text" class="display_text" value="<?php echo isset($txtcontact) ? $txtcontact : ''; ?>" maxlength="10" id="txtcontact" name="txtcontact"  onkeypress="return keyRestrict(event,'1234567890')"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtcontact"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Web site: <font size="2px" color="red"></font></p></td>
                                            <td align="left"><input type="text" class="display_text" value="<?php echo isset($txtwebsite) ? $txtwebsite : ''; ?>" maxlength="100" id="txtwebsite" name="txtwebsite"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtwebsite"></div>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Meta Description: <font size="2px" color="red"></font></p></td>
                                            <td align="left">
                                                <textarea class="display_text" id="txtmetadescription" name="txtmetadescription"><?php echo isset($txtmetadescription) ? $txtmetadescription : ''; ?></textarea>
                                                <br>
                                                <div   class="error" generated="true" for="txtmetadescription"></div>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Meta Keywords: <font size="2px" color="red"></font></p></td>
                                            <td align="left">
                                                <textarea class="display_text" maxlength="100" id="txtmetakeywords" name="txtmetakeywords"><?php echo isset($txtmetakeywords) ? $txtmetakeywords : ''; ?></textarea>
                                                <br>
                                                <div   class="error" generated="true" for="txtmetakeywords"></div>
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>Country: <font color='red' size='2px'></font></p></td>
                                            <td align="left" >
                                                <select name="selCountry" id="selCountry">
                                                            <option value="">Select Country</option>
                                                            <?php $sQuery1="SELECT * FROM yb_countrymst ORDER BY country_name ASC";
							$rQuery1=mysql_query($sQuery1);
							while($rowQuery1=mysql_fetch_assoc($rQuery1)){
								if($rowQuery1['country_id']==$selCountry)
									$select_value="Selected";
									else $select_value="";	
							?>
							<option value="<?php echo $rowQuery1['country_id']; ?>"  <?php echo $select_value; ?> ><?php echo $rowQuery1['country_name']; ?></option>
							<?php } ?>
                                                </select>&nbsp;
                                                <br/>
                                                <div style="width: 30%;" for="selCountry" generated="true" class="error"  ></div>
                                            </td>
                                        </tr>
					<tr>
                                            <td align="left"  class="white12" valign="top" style="padding-top:5px"><p>State: <font color='red' size='2px'></font></p></td>
                                            <td align="left" >
                                                <select name="selState" id="selState">
						<option value="">Select State</option> 
							
                                                    </select>&nbsp;
                                                <br/>
                                                <div style="width: 30%;" for="selState" generated="true" class="error"  ></div>
                                            </td>
                                        </tr>					
                                        
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>City: <font size="2px" color="red"></font></p></td>
                                            <td align="left"><input type="text" class="display_text" value="<?php echo isset($txtcity) ? $txtcity : ''; ?>" maxlength="100" id="txtcity" name="txtcity"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtcity"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Address: <font size="2px" color="red"></font></p></td>
                                            <td align="left">
                                                <input type="text" class="display_text" value="<?php echo isset($txtaddress) ? $txtaddress : ''; ?>" maxlength="300" id="txtaddress" name="txtaddress"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtaddress"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Zip: <font size="2px" color="red"></font></p></td>
                                            <td align="left"><input type="text" class="display_text" value="<?php echo isset($txtzip) ? $txtzip : ''; ?>" maxlength="6" id="txtzip" name="txtzip"  onkeypress="return keyRestrict(event,'0123456789')"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtzip"></div>
                                            </td>
                                        </tr>
                                        
                                        
                                         <tr>
                                             <td></td>
                                             <td valign="middle">
                                            <input type="button" value="Get Latitude & Longitude" name="diplay_lat" id="diplay_lat" class="diplay_lat"  style="width:216px" <?php if($id!='') { ?> disabled="disabled" <?php } ?>/>
                                                <input type="text" name="display_status" id="display_status"
                                                <?php if($iPlaceId=='') { ?>value="0" <?php } else { ?> value="1"  <?php } ?> style="visibility:hidden; width:33px"/>
                                            <br/><div class="error" generated="true" for="display_status"></div>
                                            <div style="width:216px;" >
                                                <?php if($iPlaceId=='') { ?>
                                                <a href="" id="link_map" style="display:none;" target="_blank"><p>Check Map in google map</p></a>
                                                <?php }else { ?>
                                                <a href="https://maps.google.com/maps?q=<?= $txtaddress ?>&hl=en&sll=<?=  $txtlatitude ?>+<?= $txtlongitude ?>" id="link_map" target="_blank"><p>Check Map in google map</p></a>
                                                <?php } ?>
                                            </div>
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Latitude: <font size="2px" color="red">*</font></p></td>
                                            <td align="left"><input type="text" class="display_text" value="<?php echo isset($txtlatitude) ? $txtlatitude : ''; ?>" maxlength="100" id="txtlatitude" name="txtlatitude"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtlatitude"></div>
                                            </td>
                                        </tr><tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Longitude: <font size="2px" color="red">*</font></p></td>
                                            <td align="left"><input type="text" class="display_text" value="<?php echo isset($txtlongitude) ? $txtlongitude : ''; ?>" maxlength="100" id="txtlongitude" name="txtlongitude"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtlongitude"></div>
                                            </td>
                                        </tr><tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Menu Pdf: <font size="2px" color="red"></font></p></td>
                                            <td align="left">
                                                <input type="FILE" class="display_text" id="txtmenu" name="txtmenu"> 
                                                <br /><span>(Please upload Pdf file.)</span>
                                                <br />
                                                <div   class="error" generated="true" for="txtmenu"></div>
                                            </td>
                                        </tr>
                                        <?php if($txtmenu){ ?>
                                            <tr>
                                                <td align="left"  class="white12" valign="top" style="padding-top:5px">&nbsp;</td>
                                                <td align="left" >
                                                    <a href="<?php echo "../".PLACES_MENU_PDF.$txtmenu; ?>" target="_blank" /><p style="width:200px;"><?php echo $txtmenu;?></p></a></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Info Title: <font size="2px" color="red"></font></p></td>
                                            <td align="left">
                                                <input style="width:98%;" type="text" class="display_text" value="<?php echo isset($txtinfo_title) ? $txtinfo_title : ''; ?>" maxlength="100" id="txtinfo_title" name="txtinfo_title"> 
                                                <br>
                                                <div   class="error" generated="true" for="txtinfo_title"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" align="left" style="padding-top:5px" class="white12"><p>Info: <font size="2px" color="red"></font></p></td>
                                            <td align="left">
                                                <?php
                                                    echo "<textarea name='txtinfo' id='txtinfo' >".(isset($txtinfo) ? $txtinfo : '')."</textarea>";
                                                ?>
                                                <div class="error" generated="true" for="txtinfo"></div>
                                            </td>
                                        </tr>
                                        					
                                        <tr>
                                            <td></td>
                                            <td   align="left" style="margin-left:2px; padding-bottom:10px;"><input type="submit" name="btnSave" id="Save"  value="<?php
                                           if ($iPlaceId == '') {
                                               echo 'Save';
                                           } else {
                                               echo 'Update';
                                           }
                                                ?>" class="button left_menu_option" style="margin-right:5px;" />
                                                <input name="back" value="Cancel" id="Back" type="button" class="button left_menu_option" onclick="location.href='places.php?isCancelButtonClicked=1'" />
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
