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
                
                
                var i,
                    tags = document.getElementById("whiteMark").getElementsByTagName("*"),
                    total = tags.length;
                for ( i = 0; i < total; i++ ) {
                    if(tags[i].nodeName != "BR" && tags[i].nodeName != "STRONG" && tags[i].nodeName != "EM" && tags[i].nodeName != "IMG")
                        tags[i].setAttribute('class','whiteMark');
                }
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
        <?php include('header_in.php');
        $fetchPlaces = fetchPlaces($obj);
        ?>
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
                <div class="col_left">
                    	<div class="category_box">
                            <div class="category_box_in">
                            	<div class="news">
                                    <div class="heading">News</div>
                                    <div class="sub_heading "><?php echo stripslashes($pageNews['news_title']);?></div>
                                    <div class="date"><?php echo date('M d Y',  strtotime($pageNews['news_created_on']));?></div>
                                        <div id="whiteMark" class="white14">
                                            <?php echo stripslashes($pageNews['news_description']);?>
                                        </div>
                                    <div class="border_bot"></div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col_right">
                     <div class="news_top">news & specials</div>
                    <?php 
                        if($newsS)
                        {
                            $rowCount = count($newsS);
                            $i = 0;
                            foreach($newsS as $news){
                                $i++;
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
                <div class="news_top pagination">
                    <?php echo $data = pagination(1,$pagingpagename,$noofrecords,$pagesize,$page,$extra_parameters);  ?>
                </div>     
                </div>
            </div>
        </div>
     </div>
        
	</div>
</div>

<?php include('footer.php');?>
