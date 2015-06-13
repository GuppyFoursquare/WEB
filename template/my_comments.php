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
    
    <link rel="stylesheet" type="text/css" href="css/jquery.raty.css" />
    <link rel="stylesheet" type="text/css" href="css/labs.css" />
    <script type="text/javascript" src="js/jquery.raty.js"></script>
    <script type="text/javascript" src="js/labs.js"></script>
    
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
                
                
                <?php while ($row1 = mysql_fetch_array($rating_query)) {?>
                    $('#rating<?php echo $row1['place_rating_id'];?>').raty({
                        path:'images/',
                        score: <?php echo $row1['place_rating_rating'];?>,
                        space:false,
                        readOnly: true
                    });

                <?php }?>
                
                
                /*var i,
                    tags = document.getElementById("whiteMark").getElementsByTagName("*"),
                    total = tags.length;
                for ( i = 0; i < total; i++ ) {
                    if(tags[i].nodeName != "BR" && tags[i].nodeName != "STRONG" && tags[i].nodeName != "EM" && tags[i].nodeName != "IMG")
                        tags[i].setAttribute('class','whiteMark');
                }*/
        });
    </script>
   
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
                            	
                                <div class="heading1">My Comments</div>
                                
                                <div id="my_comments">
                                <?php if($rows > 0):?>
                                    <?php while ($comment = mysql_fetch_array($my_comments)) {?>
                                    <div class="place_box">  
                                        <div class="place_box_in">
                                            <div class="place_name">
                                                <?php echo stripslashes($comment['plc_name']);?>
                                            </div>

                                            <div class="place_comment">
                                                <?php echo stripslashes($comment['place_rating_comment']);?>
                                            </div>

                                            <div class="place_ratings" id="rating<?php echo $comment['place_rating_id'];?>">

                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                <?php else:?>
                                    <div style="text-align: center;color: #fff;font-size: 16px;">No record(s) found.</div>
                                <?php endif?>
                                
                                </div>
                                
                                
                                <!--div class="news">
                                    <div class="heading">FAQ</div>
                                    <div class="sub_heading ">vcbvcb</div>
                                    
                                        <div id="whiteMark" class="white14">
                                            
                                        </div>
                                    <div class="border_bot"></div>
                                </div-->
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