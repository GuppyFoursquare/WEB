<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the index page of project
********************************************************/

#SETUP -----------------------------------------------------------------------
@session_start();
//$_SESSION['user_name'] = '';
//$_SESSION['user_id'] = '';

?>
<!DOCTYPE html>
<html>
<head>
<base href="<?php echo SERVER_FRONT_PATH;?>" />
<title>YOUBAKU</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport" />
<meta name="keywords" content="youbaku"/>
<meta name="description" content="youbaku"/>
<link rel="shortcut icon" type="image/png" href="images/favicon.ico"/>
<link href="css/wcss.css" rel="stylesheet" type="text/css" />
<link href="css/responsive.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />

<style type="text/css"> html, body{ overflow:hidden;}</style>
<!--===================================menu=========================================-->
		
<script type='text/javascript' src="js/jquery.min.js"></script>
<script type='text/javascript' src="js/jquery.slicknav.js"></script>
<script src="js/foggy.min.js" type='text/javascript'></script>
<script src="js/front_comman.js" type='text/javascript'></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#menu').slicknav();
});
</script>
<!--===================================top-slider=========================================-->

<link href="css/jquery.bxslider.css" rel="stylesheet" />
   <script type='text/javascript' src="js/jquery.bxslider.min.js"></script>
   <script language="javascript" type="text/javascript" src="js/toastmessage.js" ></script>
    <link rel="stylesheet" type="text/css" href="css/toastmessage.css"/>
   
            <script type="text/javascript">
                $(document).ready(function(){
                    $('.bxslider').bxSlider({
                        auto: true,
                        mode: 'fade'
                    });
                    $('.fancybox').fancybox();
                    
                })
   </script>
   
<!--===================================detial-slider=========================================--> 

   <script type='text/javascript' src="js/responsiveslides.min.js"></script>
  <script type='text/javascript'>
    // You can also use "$(window).load(function() {"
    $(function () {
      // Slideshow 3
      $("#slider3").responsiveSlides({
        manualControls: '#slider3-pager',
        maxwidth: 1100
      });
      
      
      <?php if(isset($_SESSION['sucess_message']))
                {
                      $success =   $_SESSION['sucess_message'];
                      $_SESSION['sucess_message']= '';
                }

                if(isset($_SESSION['error_message']))
                {
                      $error =   $_SESSION['error_message'];
                      $_SESSION['error_message'] = '';
                }
      ?>
        
        //alert($('#success_msg').val());
        if($.trim($('#success_msg').val())!='')
        {
          $().toastmessage('showSuccessToast', $('#success_msg').val());
        }
        if($.trim($('#error_msg').val())!='')
        {
          $().toastmessage('showErrorToast', $('#error_msg').val());
        }
      
    });
    
    
    
    
  </script>
  
    
  <script type="text/javascript" src="source_fexi/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="source_fexi/jquery.fancybox.css?v=2.1.5" media="screen" />

    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="source_fexi/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
    <script type="text/javascript" src="source_fexi/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

    <!-- Add Thumbnail helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="source_fexi/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <script type="text/javascript" src="source_fexi/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

    <!-- Add Media helper (this is optional) -->
    <script type="text/javascript" src="source_fexi/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
  
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59618544-1', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body id="start">
<div id="warper">
<input id="success_msg" type="hidden" value="<?php echo isset($success) ? $success : '';?>"/>
    <input id="error_msg" type="hidden" value="<?php echo isset($error) ? $error : '';?>"/>
    <div id="warper-inner">
        <?php include('header.php');?>
        <?php include 'template/loginbox.php';?>
        
        <div id="slider">
            <ul class="bxslider">
                <?php if($sliderArr){
                    foreach($sliderArr as $slide){
                        ?>
                            <li class="slide1" style="background:#ffffff url('<?php echo SLIDER_IMAGE.$slide['slide_image'];?>') no-repeat scroll left top;background-size: cover;  ">
                            </li>
                
                            <!--li class="slide1" style="background:#ffffff url('<?php echo SLIDER_IMAGE.$slide['slide_image'];?>') no-repeat scroll  center top ">
                            </li-->
                        <?php 
                    }
                }?>
            </ul>
            <a href="<?php echo SITE_PATH.'nearme';?>" class="home_baku_logo">
                <img src="images/home_baku_logo.png" alt=""/>
            </a>
        </div>
    </div>
</div><!-- warper -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type='text/javascript'>
    $j=jQuery.noConflict();
</script>
<script type="text/javascript">

        function DropDown(el) {
                this.dd = el;
                this.initEvents();
        }
        DropDown.prototype = {
                initEvents : function() {
                        var obj = this;

                        obj.dd.on('click', function(event){
                                $j(this).toggleClass('active');
                                event.stopPropagation();
                        });	
                }
        }

        $j(function() {

                var dd = new DropDown( $j('#dd') );
                var dd1 = new DropDown( $j('#dd1') );
                var dd2 = new DropDown( $j('#dd2') );
                var dd3 = new DropDown( $j('#dd3') );
                $j(document).click(function() {
                        // all dropdowns
                        $j('.wrapper-dropdown-2').removeClass('active');
                });
                
                $j(".loginbox").addClass("loginbox2");
        });

</script>
</body>
</html>