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
    <script src="js/foggy.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
    <script type='text/javascript' src="js/jquery-ui.js"></script>
    
    <script type='text/javascript' src="js/jquery.validate.js"></script>
    <script type='text/javascript' src="js/jquery.additional-methods.min.js"></script>
    
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
                
                $( "#accordion" ).accordion({
                    collapsible: true,
                    heightStyle: "content",
                    active: true,
                    animate: 400
                });
                
                $('#accordion h3').bind('click',function(){
                    var self = this;
                    setTimeout(function() {
                            theOffset = $(self).offset();
                            $('body,html').animate({ scrollTop: theOffset.top - 3 });
                    }, 400); // ensure the collapse animation is done
                });
                
                
                $('#frmContactUs').validate({
                    ignore: "",
                    rules:{
                        member_name:{required:true},
                        member_email:{email:true, required:true},
                        member_phone:{required:true},
                        member_subject:{required:true},
                        member_message:{required:true}
                    },
                    messages:{
                        member_name:{required:"Please enter member name."},
                        member_email:{email:"Please enter a valid email. ",required:"Please enter an email address."},
                        member_phone:{required:"Please enter phone number."},
                        member_subject:{required:"Please enter subject."},
                        member_message:{required:"Please enter message."}
                    },
                     errorPlacement: function(error, element) {
                        error.insertAfter(element);                        
                    }
                });
        });
    </script>
   <style>
    .pagination{
        height: 24px !important;
        text-align: right!important;
        line-height: 20px!important;
        
    }
    .pagination a {
    border-radius: 3px;
    color: #585858 !important;
    cursor: pointer;
    font-size: 11px;
    font-weight: 400;
    margin: 0 2px;
/*    padding: 2px 5px;*/
    padding:1px 3px;
    text-align: center;
    text-shadow: 1px 1px 0 #f1f0f0;  
    background: linear-gradient(to bottom, #e6e6e6 0%, #dbd6d6 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    }
    .pagination .current {
        background: linear-gradient(to bottom, #dd6665 0%, #E41D3C 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
        border: 1px solid #b94241;
        border-radius: 2px;
        color: #8c2221 !important;
        cursor: pointer;
        font-size: 11px;
        font-weight: 400;
        text-align: center;
        text-shadow: 1px 1px 0 #e48584;
    }
    .pagination .pagingbox a:first-child:after { 
        content: " Prev ";
    }
    .pagination .pagingbox a:last-child:after { 
        content: " Next ";
    }
</style>  
</head>
<body>
<div id="warper">
	<div id="warper-inner">
        <?php include('header_in.php');  ?>
        
            
            <div id="continer_outer">
        	<div id="continer_in">
            	<div id="continer">
                <div class="col_left">
                    	<div class="category_box">
                            <div class="category_box_in">
                                <div class="heading1">Contact Us</div>
                                
                                <form id="frmContactUs" action="" method="POST">
                                        <div class="form_contact_us">
                                            <div class="form-control">
                                                <label class="form_label">Name: <span class="error">*</span></label>
                                                <div class="form-input-out">
                                                <input class="form-input" id="member_name_contact" name="member_name"/>
                                                </div>
                                            </div>
                                            <div class="form-control">
                                                <label class="form_label">Email: <span class="error">*</span></label>
                                                <div class="form-input-out">
                                                <input class="form-input" id="member_email_contact" name="member_email"/>
                                                </div>
                                            </div>
                                            <div class="form-control">
                                                <label class="form_label">Phone: <span class="error">*</span></label>
                                                <div class="form-input-out">
                                                <input class="form-input" id="member_phone" name="member_phone"/>
                                                </div>
                                            </div>
                                            <div class="form-control">
                                                <label class="form_label">Subject: <span class="error">*</span></label>
                                                <div class="form-input-out">
                                                <input class="form-input" id="member_subject" name="member_subject"/>
                                                </div>
                                            </div>
                                            <div class="form-control">
                                                <label class="form_label">Message: <span class="error">*</span></label>
                                                <div class="form-input-out">
                                                <textarea class="form-input" rows="4" id="member_message" name="member_message"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-control">
                                                <label class="form_label hide_respnsive">&nbsp;</label>
                                                <input type="submit" name="submit" class="contact_submit" value="Send"/>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>
                </div>
                <div class="col_right">
                     <div class="news_top">news & specials</div>
                    <?php 
                        $newsS = fetchNewsSpecials($obj);
                        $firstlink = "";
                        $rowCount = count($newsS);
                        $i = 0;
                        if($newsS)
                        {
                            foreach($newsS as $news){ $i++;
                                if(empty($firstlink))
                                    $firstlink = SITE_PATH.'news/'.  $news['news_page_url'];
                                ?>
                                    <div class="news_ban <?php echo ($i == $rowCount ? 'news_bot' : '');?>">
                                        <a href="<?php echo SITE_PATH.'news/'.  $news['news_page_url'];?>">
                                        <img src="<?php echo NEWS_IMAGE . $news['news_photo']?>" alt="<?php echo htmlspecialchars($news['news_title']);?>"/>
                                    </a>    
                                    </div>
                                <?php
                            }
                        }
                    ?>
                     <div class="news_top"><a style="color:white;" href="<?php echo (!empty($firstlink) ? $firstlink : 'javascript:void(0);');?>">view more...</a></div>
                </div>
            </div>
        </div>
     </div>
        
	</div>
</div>
<?php include('footer.php');?>
