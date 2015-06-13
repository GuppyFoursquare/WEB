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
                        mem_password:{required:true},
                        cmem_password:{required:true,equalTo: "#mem_password"}                        
                    },
                    messages:{
                        mem_password:{required:"Please enter new password."},
                        cmem_password:{required:"Please enter confirm password.",equalTo: "Password and confirm password should match."}
                    }
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
                                    <div class="heading">Change Password</div>
                                    <div id="inner-login_in">
                                     <div id="inner-login">
                                      <form method="post" action="" enctype="multipart/form-data" name="frmRegister" id="frmRegister" novalidate>
                                          <table class="table-right-border" style="border:none;">
                                                  <tbody>
                                                     
                                                  
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">&nbsp;</td>
                                                      <td style="text-align: left;vertical-align:top;height:25px;color:#fff;font-size: 14px;font-weight: bold;">
                                                      <span style="color:#ff0000">*</span> indicates required field.</td>
                                                  </tr>
                                                  
                                                  
                                                 
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Username: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;">
                                                          <input style="background: #bbb;" readonly type="text" maxlength="20" class="display_text" value="<?php echo isset($_SESSION['usr_username']) ? stripslashes($_SESSION['usr_username']) : ''; ?>" id="mem_user_name" name="mem_user_name"/>&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">New Password: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="password" class="display_text" value="" maxlength="50" id="mem_password" name="mem_password" autocomplete="off">&nbsp;
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="text-align: left;vertical-align:top;" class="cell_left">Confirm Password: <span style="color:#ff0000">*</span></td>
                                                      <td class="cell_right" style="text-align: left;"><input type="password" class="display_text" value="" maxlength="50" id="cmem_password" name="cmem_password" autocomplete="off">&nbsp;
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
