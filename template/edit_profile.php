<?php include('header_start.php');?>
<!--===================================menu=========================================--> 
<link rel="stylesheet" type="text/css" href="css/component.css" />
<script type='text/javascript' src="js/modernizr.custom.js"></script>

<!-- MENU END -->
<!-- script type='text/javascript' src='js/youblur.min.js'></script -->

<!--===================================top-slider=========================================-->
    <script src="js/foggy.min.js"></script>
    <link rel="stylesheet" href="css/demo.css">
    <link rel="stylesheet" href="css/slippry.css">
    <script type='text/javascript' src="js/slippry.js"></script>
    <script type='text/javascript' src="js/jquery.validate.js"></script>
    <script type='text/javascript' src="js/jquery.additional-methods.min.js"></script>
    
    <script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>		
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
    
    <script type='text/javascript'>
        $(function() {
            
            $('#mem_dob').datepicker();
            $('#mem_dob').datepicker("option", "dateFormat", "M d, yy");
            $('#mem_dob').datepicker("option", "showAnim", "slide");
            $('#mem_dob').datepicker("option","changeYear",true);
            $('#mem_dob').datepicker("option","changeMonth",true);
            $("#mem_dob").datepicker( "option", "yearRange", "-60:+0" );
            $('#mem_dob').datepicker("option","showMonthAfterYear",true);
            $('#mem_dob').datepicker("option","showButtonPanel",true);
            $( "#mem_dob" ).datepicker("option", "maxDate", new Date('<?php echo date('M d, Y',time());?>') );
            $('#mem_dob').datepicker('setDate',new Date('<?php echo $_SESSION['usr_dob'];?>'));
            
            
            var demo1 = $("#demo1").slippry({
                        // transition: 'fade',
                        // useCSS: true,
                        // speed: 1000,
                        // pause: 3000,
                        // auto: true,
                        // preload: 'visible',
                        // autoHover: false
                });
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
                
                $("#ddlCountrySelect").val("<?php echo $_SESSION['usr_country'];?>");
                $("#ddlStateSelect").val("<?php echo $_SESSION['usr_state'];?>");
                
                $('#frmRegister').validate({
                    rules:{
                        mem_first_name:{required:true},
                        mem_last_name:{required:true},
                        mem_email:{required:true, email:true},
                        mem_user_name:{required:true},
                        mem_mob:{required:true,minlength:10,maxlength:10},
                        ddlCountrySelect:{required:true},
                        ddlStateSelect:{required:true},
                        txtCity:{required:true},
                        txtAddress:{required:true}
                    },
                    messages:{
                        mem_first_name:{required:"Please enter first name."},
                        mem_last_name:{required:"Please enter last name."},
                        mem_email:{required:"Please enter email.", email:"Please enter valid email."},
                        mem_user_name:{required:"Please enter user name."},
                        mem_mob:{required:"Please enter your contact number.",minlength:"Please enter valid contact.",maxlength:"Please enter valid contact."},
                        ddlCountrySelect:{required:"Please select your country."},
                        ddlStateSelect:{required:"Please select your state."},
                        txtCity:{required:"Please enter your city name."},
                        txtAddress:{required:"Please enter your address."}
                    }
                });
                
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
               
               $("#ddlCountrySelect").val("<?php echo $_SESSION['usr_country'];?>");
               $("#ddlCountrySelect").change();

               setTimeout(function(){
                   $("#ddlStateSelect").val("<?php echo $_SESSION['usr_state'];?>");
               }, 1000);
               
                
                
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
                                    <div class="heading">Edit Profile</div>
                                    <div id="inner-login_in">
                                     <div id="inner-login">
                                      <form method="post" action="" enctype="multipart/form-data" name="frmRegister" id="frmRegister">
                                          <table class="table-right-border" style="border:none;">
                                                  <tbody>
                                                      
                                                  
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;height: 20px;" class="cell_left">&nbsp;</td>
                                                      <td style="text-align: left;vertical-align:top;height:25px;color: #fff;font-size: 14px;font-weight: bold;">
                                                      <span style="color:#ff0000">*</span> indicates required field.</td>
                                                  </tr>
                                                  <tr>
                                                      <td style="vertical-align:top;text-align: left;" class="cell_left">First Name: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" maxlength="100" class="display_text" value="<?php echo stripslashes($_SESSION['usr_first_name']);?>" id="mem_first_name" name="mem_first_name">&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:" class="cell_left">Last Name: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" class="display_text" value="<?php echo stripslashes($_SESSION['usr_last_name']);?>" maxlength="100" id="mem_last_name" name="mem_last_name">&nbsp;
                                                      </td>
                                                  </tr>
                                                  
                                                   <tr>
                                                      <td style="text-align: left;vertical-align:" class="cell_left">Date of birth: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input readonly type="text" class="display_text" value="" maxlength="100" id="mem_dob" name="mem_dob">&nbsp;
                                                      </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Email ID: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input disabled type="text" class="display_text" value="<?php echo stripslashes($_SESSION['usr_email']);?>" maxlength="30" id="mem_email" name="mem_email">&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Username: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input disabled type="text" maxlength="20" class="display_text" value="<?php echo stripslashes($_SESSION['usr_username']);?>" id="mem_user_name" name="mem_user_name">&nbsp;
                                                      </td>
                                                  </tr>
                                                  
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Contact: <span style="color:#ff0000">*</span> </td>
                                                      <td class="cell_right" style="text-align: left;">
                                                          <input type="text" maxlength="10" onkeypress="return keyRestrict(event,'1234567890 -()+');" class="display_text" value="<?php echo stripslashes($_SESSION['usr_contact']);?>" id="mem_mob" name="mem_mob">
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Country: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;">
                                                          <select id="ddlCountrySelect" name="ddlCountrySelect" class="drop_down_list display_text" style="line-height: 25px;">
                                                              <option value="">Select Country</option>
                                                              <?php 
                                                                    while($rowQuery1=mysql_fetch_assoc($countries)){?>
                                                                        <option value="<?php echo $rowQuery1['country_id']; ?>" ><?php echo $rowQuery1['country_name']; ?></option>
                                                              <?php }?>
                                                              
                                                          </select>
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">State: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;">
                                                          <select id="ddlStateSelect" name="ddlStateSelect" class="drop_down_list display_text" style="line-height: 25px;">
                                                              <option value="">Select State</option>
                                                              <?php 
                                                                    while($rowQuery1=mysql_fetch_assoc($states)){?>
                                                                    <option value="<?php echo $rowQuery1['state_id']; ?>" ><?php echo htmlentities($rowQuery1['state_name']); ?></option>
                                                              <?php }?>
                                                              
                                                          </select>
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">City: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" class="display_text" value="<?php echo stripslashes($_SESSION['usr_city']);?>" maxlength="50" id="txtCity" name="txtCity" />&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Address: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="text" class="display_text" value="<?php echo stripslashes($_SESSION['usr_address']);?>" maxlength="50" id="txtAddress" name="txtAddress" />&nbsp;
                                                      </td>
                                                  </tr>
                                                  
                                                  
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;margin-top: -8px;" class="cell_left">Profile Picture: <span style="color:#ff0000">*</span>
                                                      &nbsp;&nbsp;&nbsp;</td>
                                                      <td class="cell_right" style="text-align: left;">
                                                      <input type="file" style="width:200px;color: #fff;" class="display_text1" id="image1" name="image1">
                                                      <input type="hidden" value="<?php echo $_SESSION['usr_profile_picture'];?>" id="oldphoto" name="oldphoto">
                                                      <br/>
                                                      <label style="color: #fff;font-size: 13px;">Please upload image in jpg or png format.</label>
                                                      <br/><br/>
                                                      <img id="previous_image" name="previous_image" src="<?php echo $_SESSION['usr_profile_picture'] != '' ? PROFILE_IMAGE.$_SESSION['usr_profile_picture'] : PROFILE_IMAGE.'default.png';?>" style="width:100px;"/>
                                                      <!--div style="float:left;font-size:12px"> Please upload 500px x 500px image.</div-->
                                                      </td>
                                                  </tr>
                                                  
                                                  
                                                  <tr>
                                                      <td colspan="2">&nbsp;</td>
                                                      </tr>
                                                      <tr>
                                                      <td class="cell_left">&nbsp;</td>
                                                      <td class="cell_right" style="text-align: left; padding-bottom:10px;">
                                                          <input type="hidden" value="add_member" name="step" id="step">
                                                      <input type="submit" style="margin-right:10px;" class="button left_menu_option" value="Submit" id="Save" name="Save">
                                                      <input type="button" class="button left_menu_option" id="Back" value="Cancel" name="back" onclick="window.location.href='<?php echo SITE_PATH.'index.php';?>'">
                                                      </td>
                                                  </tr>
                                                  </tbody>
                                          </table>

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
