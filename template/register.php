<?php include('header_start.php');?>
<!--===================================menu=========================================--> 
<link rel="stylesheet" type="text/css" href="css/component.css" />
<script type='text/javascript' src="js/modernizr.custom.js"></script>

<!-- MENU END -->
<!-- script type='text/javascript' src='js/youblur.min.js'></script -->

<!--===================================top-slider=========================================-->

    <link rel="stylesheet" href="css/demo.css">
    <link rel="stylesheet" href="css/slippry.css">
    <script type='text/javascript' src="js/slippry.js"></script>
    <script type='text/javascript' src="js/jquery.validate.js"></script>
    <script type='text/javascript' src="js/jquery.additional-methods.min.js"></script>
    <script src="js/foggy.min.js"></script>
    
    <script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>		
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
    
    <script type='text/javascript'>
        $(function() {
            var demo1 = $("#demo1").slippry({
                        // transition: 'fade',
                        // useCSS: true,
                        // speed: 1000,
                        // pause: 3000,
                        // auto: true,
                        // preload: 'visible',
                        // autoHover: false
                });
                
                
                $('#mem_dob').datepicker();
                $('#mem_dob').datepicker("option", "dateFormat", "M d, yy");
                $('#mem_dob').datepicker("option", "showAnim", "slide");
                $('#mem_dob').datepicker("option","changeYear",true);
                $('#mem_dob').datepicker("option","changeMonth",true);
                $("#mem_dob").datepicker( "option", "yearRange", "-60:+0" );
                $('#mem_dob').datepicker("option","showMonthAfterYear",true);
                $('#mem_dob').datepicker("option","showButtonPanel",true);
                $('#mem_dob').datepicker("option", "maxDate", new Date('<?php echo date('M d, Y',time());?>') );
                $('#mem_dob').datepicker('setDate',new Date('<?php echo '';?>'));
               
                
                
                $('.stop').click(function () {
                        demo1.stopAuto();
                });

                $('.start').click(function () {
                        demo1.startAuto();
                });

                $('.prev').click(function () {
                        demo1.goToPrevSlide();
                        return false;
                });
                $('.next').click(function () {
                        demo1.goToNextSlide();
                        return false;
                });
                $('.reset').click(function () {
                        demo1.destroySlider();
                        return false;
                });
                $('.reload').click(function () {
                        demo1.reloadSlider();
                        return false;
                });
                $('.init').click(function () {
                        demo1 = $("#demo1").slippry();
                        return false;
                });
                
                $('#frmRegister').validate({
                    rules:{
                        mem_first_name:{required:true},
                        mem_last_name:{required:true},
                        mem_email:{required:true, email:true},
                        mem_user_name:{required:true},
                        mem_password:{required:true},
                        cmem_password:{required:true,equalTo: "#mem_password"},
                        mem_mob:{required:true,minlength:10,maxlength:10},
                        ddlCountrySelect:{required:true},
                        ddlStateSelect:{required:true},
                        txtCity:{required:true},
                        //txtAddress:{required:true},
                        chkTermsConditions: {required:true},
                        //image1:{required: true}
                    },
                    messages:{
                        mem_first_name:{required:"Please enter first name."},
                        mem_last_name:{required:"Please enter last name."},
                        mem_email:{required:"Please enter email.", email:"Please enter valid email."},
                        mem_user_name:{required:"Please enter user name."},
                        mem_password:{required:"Please enter password."},
                        cmem_password:{required:"Please enter password.",equalTo: "Password mismatch."},
                        mem_mob:{required:"Please enter your contact number.",minlength:"Please enter valid contact.",maxlength:"Please enter valid contact."},
                        ddlCountrySelect:{required:"Please select your country."},
                        ddlStateSelect:{required:"Please select your state."},
                        txtCity:{required:"Please enter your city name."},
                        //txtAddress:{required:"Please enter your address."},
                        chkTermsConditions: {required:"Please accept the terms and conditions."},
                        //image1:{required: "Please select an image to upload."}
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "chkTermsConditions" ) {
                            error.insertAfter("#terms_label");
                        } 
                        else {
                            error.insertAfter(element);
                        }
                    }
                });
                
                
                $("#ddlCountrySelect").val("<?php echo isset($sCountry) ? stripslashes($sCountry) : '';?>");
                $("#ddlStateSelect").val("<?php echo isset($sState) ? stripslashes($sState) : '';?>");
                
                
                
                $("#ddlCountrySelect").change(function(){
                     var country=$("#ddlCountrySelect").val();
                     $.ajax({
                        type:"post",
                        url:"getStates.php",
                        data:"country="+country,
                        success:function(data){
                              $("#ddlStateSelect").html(data);
                        }
                     });
               });
                
                
        });
    </script>
    <style>
        .whiteMark{
            color:#fff!important;
            background: none repeat scroll 0 0 transparent!important;
        }
       
    </style>
</head>
<body>
<div id="warper">
	<div id="warper-inner">
        <?php include('header_in.php');?>
            
        <!-- div class="home_slider">
       		 <div class="home_slider_in">
        	
                <ul id="demo1">
                    
                <?php //foreach($fetchPlaces as $place){
                    ?>
                    <li>
                    <div class="hover_bg_slide">
                        <div class="sy-controls_left"></div>
                        <div class="sy-controls_right"></div>
                    </div>
                    <div class="slide_caption">
                        <?php //echo $place['plc_name'];?><span class="caption_star">*****</span></div>
                        <a class="foggyimg2" href="#slide1">
                            <img style="width: 100%!important;" src="<?php //echo PLACES_HEADER_IMAGE.$place['plc_header_image']?>" alt="<?php echo $place['plc_name'];?>">
                        </a>
                    <div class="slide_description">
                        <p><?php //echo strlen($place['plc_info']) > 115 ? substr($place['plc_info'],0,115).'...' : $place['plc_info'];?></p>
                        <div class="slide_read_more"><a href="javascript:void(0);">read more</a></div>
                    </div>
                    </li>
                <?php
                    //}?>
                </ul>
            </div>
        </div -->
            
            <div id="continer_outer">
        	<div id="continer_in">
            	<div id="continer">
                    <div class="col_left" style="width: 100%;">
                    	<div class="category_box">
                            <div class="category_box_in">
                            	<div class="news">
                                    <div class="heading">Registration</div>
                                    <div id="inner-login_in">
                                     <div id="inner-login">
                                      <form method="post" action="<?php echo SITE_PATH.'register'?>" enctype="multipart/form-data" name="frmRegister" id="frmRegister" novalidate>
                                          <table class="table-right-border">
                                                  <tbody>
                                                      
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;height: 20px;" class="cell_left">&nbsp;</td>
                                                      <td style="text-align: left;vertical-align:top;height:25px;color:#fff;font-size: 14px;font-weight: bold;">
                                                      <span style="color:#ff0000">*</span> indicates required field.</td>
                                                  </tr>
                                                  <tr>
                                                      <td style="vertical-align:top;text-align: left;" class="cell_left">First Name: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" maxlength="100" class="display_text" value="<?php echo isset($sFirstName) ? stripslashes($sFirstName) : ''; ?>" id="mem_first_name" name="mem_first_name">&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:" class="cell_left">Last Name: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" class="display_text" value="<?php echo isset($sLastName) ? stripslashes($sLastName) : ''; ?>" maxlength="100" id="mem_last_name" name="mem_last_name">&nbsp;
                                                      </td>
                                                  </tr>
                                                  
                                                   <tr>
                                                      <td style="text-align: left;vertical-align:" class="cell_left">Date of birth: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input readonly type="text" class="display_text" value="" maxlength="100" id="mem_dob" name="mem_dob">&nbsp;
                                                      </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Email ID: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" class="display_text" value="<?php echo isset($semail) ? stripslashes($semail) : ''; ?>" maxlength="30" id="mem_email" name="mem_email">&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Username: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" maxlength="20" class="display_text" value="<?php echo isset($sUserName) ? stripslashes($sUserName) : ''; ?>" id="mem_user_name" name="mem_user_name">&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Password: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="password" class="display_text" value="" maxlength="50" id="mem_password" name="mem_password" autocomplete="off">&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Confirm Password: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="password" class="display_text" value="" maxlength="50" id="cmem_password" name="cmem_password" autocomplete="off">&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Contact: <span style="color:#ff0000">*</span> </td>
                                                      <td class="cell_right" style="text-align: left;">
                                                      <input type="text" maxlength="20" onkeypress="return keyRestrict(event,'1234567890 -()+');" class="display_text" value="<?php echo isset($sContact) ? stripslashes($sContact) : ''; ?>" id="mem_mob" name="mem_mob">
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Country: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;">
                                                          <select id="ddlCountrySelect" name="ddlCountrySelect" class="drop_down_list display_text" style="line-height: 25px;">
                                                              <option value="" style="padding: 0 5px;">Select country</option>
                                                              <?php 
                                                                    while($rowQuery1=mysql_fetch_assoc($countries)){?>
                                                                        <option value="<?php echo $rowQuery1['country_id']; ?>" style="padding: 0 5px;"><?php echo $rowQuery1['country_name']; ?></option>
                                                              <?php }?>
                                                              
                                                          </select>
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">State: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;">
                                                          <select id="ddlStateSelect" name="ddlStateSelect" class="drop_down_list display_text" style="line-height: 25px;">
                                                              <option value="">Select state</option>
                                                              <?php 
                                                                    //while($rowQuery1=mysql_fetch_assoc($states)){?>
                                                                    <!--option value="<?php //echo $rowQuery1['state_id']; ?>" ><?php //echo htmlentities($rowQuery1['state_name']); ?></option-->
                                                              <?php //}?>
                                                              
                                                          </select>
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">City: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" class="display_text" value="<?php echo isset($sCity) ? stripslashes($sCity) : ''; ?>" maxlength="50" id="txtCity" name="txtCity" />&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Address: <span style="color:#ff0000"></span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" class="display_text" value="<?php echo isset($sAddress) ? stripslashes($sAddress) : ''; ?>" maxlength="50" id="txtAddress" name="txtAddress" />&nbsp;
                                                      </td>
                                                  </tr>
                                                  
                                                  
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;padding-top: 5px;
                                                      " class="cell_left">Profile Picture: <span style="color:#ff0000"></span>
                                                      &nbsp;&nbsp;&nbsp;</td>
                                                      <td class="cell_right" style="text-align: left;">
                                                      <input type="file" style="padding-top: 10px;color: #fff;width: 97%;" class="display_text1" id="image1" name="image1">
                                                      <input type="hidden" value="" id="oldphoto" name="oldphoto">
                                                      <br/><br/>
                                                      <label style="color: #fff;font-size: 13px;">Please upload image in jpg or png format.</label>
                                                      <!--div style="float:left;font-size:12px"> Please upload 500px x 500px image.</div-->
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">
                                                      &nbsp;&nbsp;&nbsp; </td>
                                                      <td class="cell_right" style="text-align: left;padding-top: 15px;">
                                                          <input type="checkbox" checked value="" id="chkTermsConditions" name="chkTermsConditions" style=" float: left;">
                                                          <label id="terms_label" for="chkTermsConditions" style="color: #fff;font-size: 16px;">I agree with <a target="_blank" href="<?php echo SITE_PATH.'content/'.$content['cnt_url_name'];?>" style="text-decoration: none;">terms and conditions</a></label>
                                                      </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                      <td colspan="2">&nbsp;</td>
                                                      </tr>
                                                      <tr>
                                                      <td  class="cell_left">&nbsp;</td>
                                                      <td class="cell_right" style="text-align: left; padding-bottom:10px;">
                                                          <input type="hidden" value="add_member" name="step" id="step">
                                                        <input type="submit" style="margin-right:10px;" class="button left_menu_option" value="Submit" id="Save" name="Save">
                                                        <input type="button" class="button left_menu_option" id="Back" value="Cancel" name="back" onclick="window.location.href='<?php echo SITE_PATH.'index.php';?>'">
                                                      </td>
                                                  </tr>
                                                  </tbody>
                                          </table>

                                          <div id="inner-reg1"  class="signin">
                                                  <div class="inner-heading-log-reg"><h2>LOGIN</h2></div>											
                                                  <div class="black12"><p>Already registered then click below.</p></div>
                                                  <div class="registrationrow">
                                                      <input type="button" name="btnSignin" id="btnSignin" value="LOGIN" class="button lnkLogin">
                                                  </div>

                                          </div>
                                      </form>
                                          </div>
                                      </div>
                                    
                                </div>
                            </div>
                        </div>
                </div>
                
            </div>
        </div>
     </div>
        
	</div>
</div>
<?php include('footer.php');?>
