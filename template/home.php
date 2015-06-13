<?php include('header_start.php');?>
<!--===================================menu=========================================--> 
<link rel="stylesheet" type="text/css" href="css/component.css" />
<script type='text/javascript' src="js/modernizr.custom.js"></script>
  <script type="text/javascript" src="source_fexi/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="source_fexi/jquery.fancybox.css?v=2.1.5" media="screen" />
<!-- MENU END -->
<!-- script type='text/javascript' src='js/youblur.min.js'></script -->

<!--===================================top-slider=========================================-->
<style>
    .cbp-hsmenubg {
        height: 1px!important;
        width: 50% !important;
    }
    
    .bt_close {
        position: relative;
        float: left;
    }
    .bt_close > span {
        position: absolute;
        right: -10px;
        top: 0;
    }
    .feat_box ul li .mob_feature{
        width: 24%;
    }
    .feat_box{
        text-align: left;
    }
</style>
    <link rel="stylesheet" href="css/demo.css">
    <link rel="stylesheet" href="css/slippry.css">
    <script type='text/javascript' src="js/slippry.js"></script>
    <script src="js/foggy.min.js"></script>
    
    <!-- jquery-mCustomScrollbar -->
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css" />
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="js/Base64.js"></script>
<script type="text/javascript" src="js/jquery.session.js"></script>
    <script type='text/javascript'>
        /*if (navigator.geolocation) {
            console.log('Geolocation is supported!');
        }
        else {
            console.log('Geolocation is not supported for this Browser/OS version yet.');
        }
        
        window.onload = function() {
            var startPos;
            var geoSuccess = function(position) {
                startPos = position;
                document.getElementById('startLat').value = startPos.coords.latitude;
                document.getElementById('startLon').value = startPos.coords.longitude;
            };
            var geoError = function(position) {
                console.log('Error occurred. Error code: ' + error.code);
                // error.code can be:
                //   0: unknown error
                //   1: permission denied
                //   2: position unavailable (error response from location provider)
                //   3: timed out
            };
            navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
        };
        */
       
      
       
        $(function() {
            
            var temp = 0;
            //$("#mainScroll").mCustomScrollbar({axis:"xy"});
            
            $(".over").click(function(){
                window.location.href  = $(this).data("link");
            });
            
            $('input:checkbox').removeAttr('checked');
             
           $(window).load(function(){
               //alert();
               $("#demo1").show();
               var demo1 = $("#demo1").slippry({
                           // transition: 'fade',
                           // useCSS: true,
                           // speed: 1000,
                           // pause: 3000,
                            //auto: false,
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
                   
                  <?php if($searchText != ''):?> 
                   
                   	$('.sy-caption').css('letter-spacing',4);		
                $(".sy-controls, .sy-caption").mouseenter(function(){
                    var oldTitle = $('.sy-caption').html();
                   
                    $('.sy-caption').css('font-size',30);
                    $('.sy-caption').css('letter-spacing',4);				
                    $('.sy-caption').css('font','futura_heavyregular,Arail');
                    
                    str = "<span class='clickinfo'><br /><a style='font-size:13px; z-index:9999999; color:#fff;' href='<?php echo SITE_PATH.'places/'?>"+Base64.encode($("#place_id1").val())+"'>Click here for more information</a></span>";
                    var str1 = $(this).attr("class");
                    var compare_result = str1.localeCompare("sy-caption");
                    if(compare_result == 0)
                    {
                        if(temp == 0)
                            $(".sy-caption").html(oldTitle+str);
                        
                        temp = 1;
                    }
                    else
                    {
                        if(temp == 1)
                        {
                            temp = 0;
                        }
                        else
                        {
                            $(".sy-caption").html(oldTitle+str);
                            
                        }
                        
                         
                    }
                    
                    
              });
               $(".sy-controls").mouseout(function(){
                    $(".clickinfo").remove();
                    $('.sy-caption').css('font-size',20);
                    $('.sy-caption').css('letter-spacing',null);				
              });
              
              $(".clickinfo").bind("mouseover",function(){
                  
                  var oldTitle = $('.sy-caption').html();
                    $('.sy-caption').css('font-size',30);
                    $('.sy-caption').css('letter-spacing',4);				
                    $('.sy-caption').css('font','futura_heavyregular,Arail');
                    
                    $(".sy-caption").html(oldTitle);
                   
              });
              
              <?php else:?>
                  
                    $('.sy-caption').css('letter-spacing',4);		
                    $(".sy-controls, .sy-caption").mouseenter(function(){
                        var oldTitle = $('.sy-caption').html();

                        $('.sy-caption').css('font-size',30);
                        $('.sy-caption').css('letter-spacing',4);				
                        $('.sy-caption').css('font','futura_heavyregular,Arail');
                        //alert($("#place_id1").val());
                        str = "<span class='clickinfo'><br /><a target='_blank' style='font-size:13px; z-index:9999999; color:#fff;' href='"+$("#place_id1").val()+"'>Click here for more information</a></span>";
                        var str1 = $(this).attr("class");
                        var compare_result = str1.localeCompare("sy-caption");
                        if(compare_result == 0)
                        {
                            if(temp == 0)
                                $(".sy-caption").html(oldTitle+str);
                            temp = 1;
                        }
                        else
                        {
                            if(temp == 1)
                            {
                                temp = 0;
                            }
                            else
                            {
                                $(".sy-caption").html(oldTitle+str);

                            }
                        }
                  });
                   $(".sy-controls").mouseout(function(){
                        $(".clickinfo").remove();
                        $('.sy-caption').css('font-size',20);
                        $('.sy-caption').css('letter-spacing',null);				
                  });

                  $(".clickinfo").bind("mouseover",function(){
                      var oldTitle = $('.sy-caption').html();
                        $('.sy-caption').css('font-size',30);
                        $('.sy-caption').css('letter-spacing',4);				
                        $('.sy-caption').css('font','futura_heavyregular,Arail');

                        $(".sy-caption").html(oldTitle);
                  });
              
              <?php endif?>
              
           });
                
                
                /* $( ".resultDiv" ).on( "hover", ".foggyimg", function() {//col_img
                //$(".resultDiv").on(".col_img_over",'mouseenter')(function(){
                    $(this).foggy({
                        blurRadius: 3.5,            // In pixels.
                        opacity: 0.8,
                        quality:20,// Falls back to a filter for IE.
                        cssFilterSupport: true      // Use "-webkit-filter" where available.
                    });
                });
                 $( ".resultDiv" ).on( "mouseleave", ".over", function() {//col_img
                    $(".foggyimg").foggy(false);
                });
                */
               
                  
                  
                  
             
            
            
                $(".featureSymb").click(function(){
                    var chkFeat = $(this).find( "input:hidden" );
                    var isNewChecked = chkFeat.val();
                    if(isNewChecked == '' || isNewChecked == '0'){
                        chkFeat.val('1'); 
                        $(this).attr('style','opacity:1');
                    }
                    else{
                        chkFeat.val('0'); 
                        $(this).attr('style','opacity:0.4');
                    }
                });
            
                $(".pAll").change(function(){
                    var fun_class = $(this).attr('data-chk');
                    var thisCheck = $(this).prop("checked");
                    if(thisCheck == false){
                        $("."+fun_class).prop('checked', false); 
                    }
                    else{
                        $("."+fun_class).prop('checked', true); 
                    }
                    
                    var pcid = $(this).attr('data-pcid');
                    var chkCategories = $('.pCatChk_'+pcid+':checkbox:checked').map(function() {
                            //var pcid = $(this).attr('data-pcid');
                            //$("pCate_"+pcid).css('opacity:1!important;');
                            $(".pCate_"+pcid).attr('style','opacity: 1;');
                            return this.value;
                        }).get();
                        
                        if(chkCategories == ''){
                           $(".pCate_"+pcid).attr('style','opacity: 0.4;');
                        }
					$("#btnShow").click();	
                    
                });
                
                $(".chkCategories").change(function(){
                    var pcid = $(this).attr('data-pcid');
                    var chkCategories = $('.pCatChk_'+pcid+':checkbox:checked').map(function() {
                            //var pcid = $(this).attr('data-pcid');
                            //$("pCate_"+pcid).css('opacity:1!important;');
                            $(".pCate_"+pcid).attr('style','opacity: 1;');
                            return this.value;
                        }).get();
                        
                        if(chkCategories == ''){
                           $(".pCate_"+pcid).attr('style','opacity: 0.4;');
                        }
						$("#btnShow").click();
                });
                
                $(".chkFeature").change(function(){
                    var chkFeature = $('.chkFeature:checkbox:checked').map(function() {
                            //var pcid = $(this).attr('data-pcid');
                            //$("pCate_"+pcid).css('opacity:1!important;');
                            $(".featImg").attr('style','opacity: 1;');
                            return this.value;
                        }).get();
                        
                        if(chkFeature == ''){
                           $(".featImg").attr('style','opacity: 0.4;');
                        }
						$("#btnShow").click();
                });
                $("#fet_selectAll").change(function(){
                    var chkFeature = $('.chkFeature:checkbox:checked').map(function() {
                            //var pcid = $(this).attr('data-pcid');
                            //$("pCate_"+pcid).css('opacity:1!important;');
                            $(".featImg").attr('style','opacity: 1;');
                            return this.value;
                        }).get();
                        
                        if(chkFeature == ''){
                           $(".featImg").attr('style','opacity: 0.4;');
                        }
						$("#btnShow").click();
                });
                
                
                $(".chkCategories").keypress(function(event){
                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if(keycode == '13'){
                            $("#btnShow").click();
                        }
                });
                
                
                $( "#continer" ).on( "click", "#btnShow",function(){
                //$("#btnShow").click(function(){
               // alert('call');
               //$('.fancybox').showloading("<div>fdsfdsfdsf</div>");
               $.fancybox.showLoading();
                    $("#lnkShowMore").html('Show more');
                    $("#hidd_cat").remove();
                    pageOffset = 0;
                    var chkFeature = $('.chkFeature:checkbox:checked').map(function() {
                        return this.value;
                    }).get();
                    var chkCategories = $('.chkCategories:checkbox:checked').map(function() {
                        return this.value;
                    }).get();
                    
                    
                       
                    //chkCategories = $.unique(chkCategories.sort());
//                    chkCategories = chkCategories.filter(
//                                        function(a){if (!this[a]) {this[a] = 1; return a;}},
//                                    {}
//                                   );
//                    chkCategories.splice( $.inArray(8,chkCategories) ,1 );
//                    alert(chkCategories);
                    
                    var exact_search = $("#chbexactsearch12").prop('checked');
                    var exact = 0;
                    if(exact_search)
                        exact = 1;
                    var searchText = $("#txtSearch").val();
                    
                    var win_w = $(window).width();
                    if(win_w <= 650)
                    {
                        var mob_exact_search = $("#exactsearch").prop("checked");
                        if(mob_exact_search)
                        {
                            exact = 1;
                        }
                    }
                    
                    /* var chkFeatureHidd = $('.hiddFeature').map(function() {
                        if(this.value > 0)
                            return this.attr('data-fet');
                        
                    }).get();*/
                    var responsiveFeatures = [];                    
                    var i = 0;
                    $('.feat_box').find('input[type=hidden]').each(function(index){
                        if($(this).val() == 1){
                            responsiveFeatures[i++] = $(this).attr('data-fet');
                        }
                    });
                   if($('.desk-feat:visible').length == 0)
                        chkFeature = responsiveFeatures;
                    $.post( "<?echo SITE_PATH;?>ajax.places.php",{'step':'search','searchText':searchText,'chkCategories':chkCategories,'chkFeature':chkFeature,'offset':pageOffset,'exactsearch':exact}, function( data ) {
                            $(".resultDiv").html(data);
                            $("."+currStyleClass).trigger('click');
                    });
                    
                    $.post( "<? echo SITE_PATH;?>ajax.places.php",{'step':'searchFilters','searchText':searchText,'chkCategories':chkCategories,'chkFeature':chkFeature,'exactsearch':exact}, function( data ) {
                            $(".tags_box").html(data);
                            $.fancybox.hideLoading();
                    });
                    
                    
                    $.post( "<? echo SITE_PATH;?>getTags.php",{'chkCategories':chkCategories,'chkFeature':chkFeature}, function( data ) {
                            $(".mini-category-icons").html(data);
                            $.fancybox.hideLoading();
                    });
                    
                    $(".cbp-hsmenu li").attr("data-open","");
                    $(".cbp-hsmenu li").removeClass("cbp-hsitem-open");
                    setTimeout(function(){
                        var styles = $(".cbp-hsmenubg").attr("style");
                        $(".cbp-hsmenubg").attr("style",styles+" width:50%!important;height:1px!important;");
                    }, 1000);
                    
                    
                      //$(".cbp-hsitem-open").removeClass("cbp-hsitem-open");

                });
                
                $(".mini-category-icons").on("click",".close-btn-tags", function(){
                    var cat_id = $(this).data("id");
                    var cat_parent_id = $(this).data("parent");
                    $("#lbl_cat_"+cat_id).prop("checked",false);
                    $("#m_lbl_"+cat_id).prop("checked",false);
                    $("#p_"+cat_parent_id).prop("checked",false);
                    $("#btnShow").trigger('click');
                });
                $(".mini-category-icons").on("click",".close-btn-tags-features", function(){
                    var fet_id = $(this).data("id");
                    $("#fet_selectAll").prop("checked",false);
                    $("#lbl_"+fet_id).prop("checked",false);
                    $("#btnShow").trigger('click');
                });
                
                $(this).mouseup(function(login) {
                    
                    if(!($(login.target).parent('#warper .cbp-hsitem-open').length > 0) && !($(login.target).parent('#warper .cbp-hssubmenu').length > 0) && !($(login.target).parent('#warper .cbp-hsitem-open ul li').length > 0) && !($(login.target).parent('#warper .cbp-hsitem-open ul li a').length > 0) && !($(login.target).parent('#warper .cbp-hsitem-open ul li a span').length > 0) && !($(login.target).parent('#warper .cbp-hsitem-open ul li .cat_name_embedded').length > 0) && !($(login.target).parent('#warper .cbp-hsitem-open ul li .cat_name_embedded span').length > 0)) {
                        $(".cbp-hsmenu li").attr("data-open","");
                        $(".cbp-hsmenu li").removeClass("cbp-hsitem-open");
                        $(".mini-category-icons").css("opacity","1");
                        setTimeout(function(){
                            var styles = $(".cbp-hsmenubg").attr("style");
                            $(".cbp-hsmenubg").attr("style",styles+" width:50%!important;");
                        }, 1000);
                    }
                });
                
                setInterval(function(){ $( window ).resize(); }, 1000);
                
                $.post( "<? echo SITE_PATH;?>ajax.places.php",{'step':'searchFilters','searchText':'','chkCategories':'','chkFeature':''}, function( data ) {
                            $(".tags_box").html(data);
                });
                
                var pageOffset = 0;
                $("#lnkShowMore").click(function(){
                    $.fancybox.showLoading();
                    $("#hidd_cat").remove();
                    pageOffset++;
                    var chkFeature = $('.chkFeature:checkbox:checked').map(function() {
                        return this.value;
                    }).get();
                    var chkCategories = $('.chkCategories:checkbox:checked').map(function() {
                        return this.value;
                    }).get();
                    
                    var exact_search = $("#chbexactsearch12").prop('checked');
                    var exact = 0;
                    if(exact_search)
                        exact = 1;
                    
                    var searchText = $("#txtSearch").val();
                    
                    var win_w = $(window).width();
                    if(win_w <= 650)
                    {
                        var mob_exact_search = $("#exactsearch").prop("checked");
                        if(mob_exact_search)
                        {
                            exact = 1;
                        }
                    }
                    
                    var responsiveFeatures = [];                    
                    var i = 0;
                    $('.feat_box').find('input[type=hidden]').each(function(index){
                        if($(this).val() == 1){
                            responsiveFeatures[i++] = $(this).attr('data-fet');
                        }
                    });
                    if($('.desk-feat:visible').length == 0)
                        chkFeature = responsiveFeatures;
                    
                    $.post( "<?echo SITE_PATH;?>ajax.places.php",{'step':'search','searchText':searchText,'chkCategories':chkCategories,'chkFeature':chkFeature,'offset':pageOffset,'exactsearch':exact}, function( data ) {
                        if(data.length > 4)
                        {
                            $(".resultDiv").append(data);
                            $("."+currStyleClass).trigger('click');
                        }
                        else{
                            pageOffset--;
                            $("#lnkShowMore").html('No record(s) found');
                        }
                        $.fancybox.hideLoading();
                    });
                });
                
                // default setting
                    $(".list_tiles").show();
                    $(".list_box").hide();
                    var currStyleClass = "grid_iocn";
                    
                $(".grid_iocn").click(function(){
                    $(".list_tiles").show();
                    $(".list_box").hide();
                    currStyleClass = "grid_iocn";
                    $(this).addClass('actView');
                    $(".grid_iocn1").removeClass('actView1');
                });
                $(".grid_iocn1").click(function(){
                    $(".list_tiles").hide();
                    $(".list_box").show();
                    currStyleClass = "grid_iocn1";
                    $(this).addClass('actView1');
                    $(".grid_iocn").removeClass('actView');
                }); 
                
                $('.mob .cbp-hsmenu li').on('touchstart click', function(){
                    var ind = $(this).index();
                    var ul = $(this).find('ul');
                    var constfac = 15;
                    var constfac2 = 17;
                     
                    var rowelecount = parseInt($("#rowCount").val());
                    if(rowelecount > 6){
                        constfac = 0;
                        constfac2 = 0;
                    }
                    
                    var percent = 0;
                    if(parseInt(ind) == 0 || parseInt(ind) == 1 || parseInt(ind) == 2)
                        percent = 30 + constfac;
                    else if(parseInt(ind) == 3 || parseInt(ind) == 4 || parseInt(ind) == 5)
                        percent = 63 + constfac + constfac2;
                    else if(parseInt(ind) == 6 || parseInt(ind) == 7 || parseInt(ind) == 8)
                        percent = 96 + constfac;					
                    else
                        percent = 129 + constfac;
                    
                    if(rowelecount < 4)
                        percent = 90;
                    ul.css('top',percent+'%');
                    
                    if ( navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1 ) 
                     {
                        
                        var window_width = $( window ).width();                        
                        if(window_width <=650 && window_width>=450)
                        {
                            if(rowelecount < 4)
                                percent = window_width * 0.4;
                            ul.css('top',percent+'px');
                            
                        }
                        else
                        {
                            if(rowelecount < 4)
                                percent = window_width * 0.45;
                            ul.css('top',percent+'px');
                        }
                       
                        
//                        if(window_width <=650 && window_width>=570)
//                        {
//                            if(rowelecount < 4)
//                                percent = 250;
//                            ul.css('top',percent+'px');
//                        }
//                        else if(window_width <570 && window_width>=520)
//                        {
//                            if(rowelecount < 4)
//                                percent = 225;
//                            ul.css('top',percent+'px');
//                        }
//                        else if(window_width <520 && window_width>=440)
//                        {
//                            if(rowelecount < 4)
//                                percent = 200;
//                            ul.css('top',percent+'px');
//                        }
//                        else if(window_width <440 && window_width>=390)
//                        {
//                            if(rowelecount < 4)
//                                percent = 190;
//                            ul.css('top',percent+'px');
//                        }
//                        else if(window_width <390 && window_width>=350)
//                        {
//                            if(rowelecount < 4)
//                                percent = 170;
//                            ul.css('top',percent+'px');
//                        }
//                        else if(window_width <350)
//                        {
//                            if(rowelecount < 4)
//                                percent = 150;
//                            ul.css('top',percent+'px');
//                        }
//                        if(rowelecount < 4)
//                            percent = 150;
//                        ul.css('top',percent+'px');
                        
                     }
                    
                    //ul.attr('stype','top:40%');
                    //alert('call');
                     
//                   var topleft = $(this).offset();
//                   var myheight = $(this).height();
//                   var calTop = topleft.top - 923.5666656494141;
//                   var setTop = myheight + calTop + 25;
//                    ul.offset.top = setTop;
                });
                
                $(".tag-opacity-control").on("click",function(){
                    if($(this).parent().hasClass("cbp-hsitem-open"))
                    {
                        $(".mini-category-icons").css("opacity","0.2");
                    }
                    else
                    {
                        $(".mini-category-icons").css("opacity","1");
                    }
                });
                
                // RESULT FILTER ACTIONS
                $( ".tags_box" ).on( "click", ".res_category",function(){
                    var action_id = $(this).attr('data-tag');
                    action_id = action_id.replace('c_', '');
                    $("input:checkbox").prop('checked',false);
                    //$(".cbp-hsmenu > li").css('opacity','0.4');
                    $("#mobCatAll"+action_id).trigger('click');
                    $("#btnShow").trigger('click');
                });
                
                $( ".tags_box" ).on( "click", ".res_feature",function(){
                    var action_id = $(this).attr('data-tag');
                    action_id = action_id.replace('f_', '');
                    $(".hiddFeature").val(0);
                    $("#lnk_f_"+action_id).trigger('click');
                    $("#btnShow").trigger('click');
                });
                
                $( ".tags_box" ).on( "click", ".res_category_close",function(){
                    var action_id = $(this).attr('data-tag');
                    action_id = action_id.replace('c_', '');
                    $("#mobCatAll"+action_id).prop('checked',true);
                    $("#mobCatAll"+action_id).trigger('click');
                    $("#btnShow").trigger('click');
                    $(this).remove();
                });
                
                $( ".tags_box" ).on( "click", ".res_feature_close",function(){
                    var action_id = $(this).attr('data-tag');
                    action_id = action_id.replace('f_', '');
                    $("#lnk_f_"+action_id).css('opacity','0.4');
                    $("#chk_fet_"+action_id).val(0);
                    $("#btnShow").trigger('click');
                    $(this).remove();
                });
                // RESULT FILTER ACTION END
                
                if($.session.get("not_home_page")==1)
                {
                    var cate_id = $.session.get("cat_id");
                    $.session.remove("not_home_page");
                    $.session.remove("cat_id");
                    
                    $('.chkCategories').prop('checked', false);
                    $('.pCatChk_'+cate_id).prop('checked', true);
                    $j("#btnShow").click();
                    
                }
                
                $(".main1").click(function(){
                    $(".mob > .feat_box").toggle("display");
                    $(".exact_search_class_div_mob").toggle("display");
                });
//                $(".main1").click();
                
        });
    </script>
    <style>
        .actView{
                background: url("images/grid-icon-over.png") no-repeat scroll left top rgba(0, 0, 0, 0)!important;
        }
        .actView1{
            background: url("images/list-icon-over.png") no-repeat scroll left top rgba(0, 0, 0, 0)!important;
        }
		.main1{
            cursor: pointer;
        }
		.mob > .feat_box, .exact_search_class_div_mob{
            display: none;
        }
        .tags_box{
            display: none!important;
        }
        
    </style>
</head>
<body>
    <!--input type="text" id="startLat" value="" >
    <input type="text" id="startLon" value="" -->
<div id="warper">
	<div id="warper-inner">
		<?php include('header_in.php');
                $fetchPlaces = fetchPlaces($obj,$searchText);
                ?>
        <div class="home_slider">
       		 <div class="home_slider_in">
                     
                <?php  $noRec = 1;?>
                <?php if($searchText != ''):?>
                         
                <?php 
               
                $fetchPlacesTopFive = fetchPlacesFive($obj,$searchText,$chbExactSearch);
                if($fetchPlacesTopFive){
                    ?>
                     <input type="hidden" value="" id="place_id1"/>
                     <ul id="demo1" style="display: none;">
                        <?php 
                        
                foreach($fetchPlacesTopFive as $place){ $noRec = 0;
                    ?>
                    <li>
                    <div class="hover_bg_slide">
                        <div class="sy-controls_left"></div>
                        <div class="sy-controls_right"></div>
                    </div>
                    <div class="slide_caption " data-temp="12" >
                        <?php echo htmlentities($place['plc_name']);?>
                        <!-- span class="caption_star12">*****</span --></div>
                        <a class="foggyimg2" href="#slide1">
                            <input type='hidden' id='hidden_place_id<?php echo $place['plc_id']?>' value='<?php echo $place['plc_id'];?>'/>
                            <img src="<?php echo $place['plc_header_image'] ? PLACES_HEADER_IMAGE.$place['plc_header_image'] : 'images/big_logo_no_image.jpg';?>" alt="<?php echo htmlentities($place['plc_name']).'---@---'.$place['plc_id'];?>">
                        </a>
                    <div class="slide_description">
                        <p><?php echo strlen($place['plc_info']) > 115 ? substr($place['plc_info'],0,115).'...' : html_entity_decode(htmlentities($place['plc_info']));?></p>
                        <div class="slide_read_more"><a href="<?php echo SITE_PATH.'places/'.base64_encode($place['plc_id'])?>">read more</a></div>
                    </div>
                    </li>
                <?php
                    }?></ul><?php 
                    }else{
                        echo "<div class='norecords'>No record(s) found</div>";
                    }
                    ?>
                     
               <?php else:?>
                     <?php $slider_details = getSliderDetails($obj);
                           if($slider_details){ $noRec = 0;?>
                           <input type="hidden" value="" id="place_id1"/>
                           <ul id="demo1" style="display: none;">
                                <?php while($slider_individual = mysql_fetch_array($slider_details)){ ?>
                                    <li>
                                        <div class="hover_bg_slide">
                                            <div class="sy-controls_left"></div>
                                            <div class="sy-controls_right"></div>
                                        </div>
                                        
                                        <div class="slide_caption " data-temp="12" >
                                            <?php echo html_entity_decode($slider_individual['home_slider_title']);?>
                                        </div>
                                        <a class="foggyimg2" href="#slide1">
                                            <input type='hidden' id='hidden_place_id<?php echo $slider_individual['home_slider_id']?>' value='<?php echo $slider_individual['home_slider_link'];?>'/>
                                            <img src="<?php echo $slider_individual['home_slider_image'] ? SLIDER_IMAGE.$slider_individual['home_slider_image'] : 'images/big_logo_no_image.jpg';?>" alt="<?php echo htmlentities($slider_individual['home_slider_title']).'---@---'.$slider_individual['home_slider_link'];?>">
                                        </a>
                                        <div class="slide_description">
                                            <div class="slide_read_more"><a href="<?php echo $slider_individual['home_slider_link'];?>">read more</a></div>
                                        </div>
                                        
                                        
                                    </li>
                               <?php } ?>
                           </ul>    
                      <?php }?>
                     
               <?php endif?>
                
            </div>
        </div>
        <div id="continer_outer">
        	<div id="continer_in">
            	<div id="continer">
                	<div class="col_left">
                    	<div class="category_box">
                        	<div class="category_box_in">
                            	<div class="head"><span>search by&nbsp;</span>category</div>
                                <div class="head1">features</div>
                                <div id="mainScroll" class="main"></div>
                                <div class="menu">
                                <div class="desk">
                                    <nav class="cbp-hsmenu-wrapper" id="cbp-hsmenu-wrapper">
                                    <div class="cbp-hsinner">
                                        <ul class="cbp-hsmenu">
                                            <?php if($formData['pCat']){
                                                foreach($formData['pCat'] as $pCat){
                                                    $catIcon = CATEGORY_IMAGE.$pCat['cat_image'];
                                                    if(empty($pCat['cat_image']))
                                                        $catIcon = CATEGORY_IMAGE.$pCat['cat_image'];
                                                    if(!file_exists($catIcon))
                                                        $catIcon = CATEGORY_DEFAULT_ICON;
                                                    
                                                    $rcount = getplacessCount($obj,$pCat['cat_id']);
                                                    ?>
                                                        <li>
                                                            <a class="tag-opacity-control" href="javascript:void(0);">
                                                                <img style="<?php echo ($rcount ? 'opacity:1' : '')?>" class="pCate_<?php echo $pCat['cat_id'];?>" title="<?php echo htmlentities($pCat['cat_name']);?>" src="<?php echo $catIcon;?>" alt="" />
                                                            </a>
                                                            <div class="bottom-icon" style="opacity:1;border-bottom: 20px solid <?php echo '#'.$pCat['cat_color'];?>"></div>
                                                            <ul style="opacity:1;background-color:<?php echo '#'.$pCat['cat_color'];?>" class="cbp-hssubmenu">
                                                                <li style="width: 100%;">
                                                                    <div class="head">
                                                                        <?php echo ucwords($pCat['cat_name']);?>
                                                                    </div>
                                                                </li>
                                                                <?php 
                                                                // sub category
                                                                
                                                                $subCatArr = fetchCategory($obj,$pCat['cat_id']);
                                                                if($subCatArr){
                                                                    $perCol = count($subCatArr);
                                                                    $perCol = ceil($perCol / 3);
                                                                    $catColCount = 0;
                                                                    $catCount = 0;
                                                                    foreach ($subCatArr as $subCat){
                                                                        $catColCount++;
                                                                        $catCount++;
                                                                        if($catColCount <=  $perCol){
                                                                            if($catColCount == 1)
                                                                            {
                                                                                echo "<li ><div class='cat_name_embedded'>";
                                                                            }
                                                                            ?>
                                                                                    <span>
                                                                                        <input data-pcid="<?php echo $pCat['cat_id'];?>" class="chkCategories pCatChk_<?php echo $pCat['cat_id'];?>" value="<?php echo $subCat['cat_id'];?>" id="<?php echo 'lbl_cat_'.$subCat['cat_id'];?>" type="checkbox" />
                                                                                        <label for="<?php echo 'lbl_cat_'.$subCat['cat_id'];?>" style="font: 14px/20px futura_heavyregular,Arail;">
                                                                                            <?php echo htmlentities($subCat['cat_name']);?>
                                                                                        </label>
                                                                                    </span>
                                                                            <?php
                                                                            if($catColCount == $perCol || $catCount == count($subCatArr))
                                                                            {
                                                                                echo "</div></li>";
                                                                                $catColCount = 0;
                                                                            }
                                                                            
                                                                            
                                                                        }
                                                                    }
                                                                }
                                                                // end of sub category
                                                                ?>
                                                                <li><div class='cat_name_embedded'>
                                                                        <span>
                                                                            <input class="pAll" data-pcid="<?php echo $pCat['cat_id'];?>" data-chk="pCatChk_<?php echo $pCat['cat_id'];?>" type="checkbox" id="p_<?php echo $pCat['cat_id'];?>" />
                                                                            <label for="p_<?php echo $pCat['cat_id'];?>" style="font: 14px/20px futura_heavyregular,Arail;  ">Select All</label>
                                                                        </span>
                                                                <!-- span><input type="checkbox" /> Deselect All</span -->  
                                                                </div></li>
                                                            </ul>
                                                        </li>
                                                        
                                                        
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                                        
                                                        
                                            <li><a class="desk-feat" href="javascript:void(0);"><img class="featImg" src="images/fau-icon.jpg" alt=""/></a>
                                                <ul class="cbp-hssubmenu black">
                                                    <li style="width: 100%;">
                                                        <div class="head">Features</div>
                                                    </li>
                                                    <?php 
                                                                // sub category
                                                                $fetArr = fetchFeature($obj);
                                                                if($fetArr){
                                                                    $perCol = count($fetArr);
                                                                    $perCol = ceil($perCol / 3);
                                                                    $catColCount = 0;
                                                                    $catCount  = 0;
                                                                    foreach ($fetArr as $feature){
                                                                        $catColCount++;
                                                                        $catCount++;
                                                                        if($catColCount <=  $perCol){
                                                                            if($catColCount == 1)
                                                                            {
                                                                                echo "<li><div class='cat_name_embedded'>";
                                                                            }
                                                                            ?>
                                                                                    <span>
                                                                                        <input class="chkFeature" value="<?php echo $feature['feature_id'];?>" id="<?php echo 'lbl_'.$feature['feature_id'];?>" type="checkbox" />
                                                                                        <label for="<?php echo 'lbl_'.$feature['feature_id'];?>" style="font: 14px/20px futura_heavyregular,Arail;">
                                                                                            <?php echo htmlentities($feature['feature_title']);?>
                                                                                        </label>
                                                                                    </span>
                                                                            <?php
                                                                            if($catColCount == $perCol || $catCount == count($fetArr))
                                                                            {
                                                                                echo "</div></li>";
                                                                                $catColCount = 0;
                                                                            }
                                                                            
                                                                            
                                                                        }
                                                                    }
                                                                }
                                                                // end of sub category
                                                                ?>
                                                    <li><div class='cat_name_embedded'>
                                                    <span>
                                                        <input id="fet_selectAll" class="pAll" data-chk="chkFeature" type="checkbox" />
                                                        <label for="fet_selectAll" style="font: 14px/20px futura_heavyregular,Arail;"> Select All</label>
                                                    </span>
                                                    <!-- span><input type="checkbox" /> Deselect All</span -->  
                                                    </div></li>
                                                    
                                                </ul>
                                                 
                                             </li>
                                             
                                            </ul>
                                            <div style="position: absolute;right: 110px;top: 15px;">
                                                <label for="chbexactsearch" class="exact_search_lbl">Exact search</label>
                                                <input type="checkbox" id="chbexactsearch12" name="chbexactsearch12"/>
                                            </div>
                
                                    </div>
                                </nav>
                                </div>
                                
                                <!--div class="desk">
                                <nav class="cbp-hsmenu-wrapper1" id="cbp-hsmenu-wrapper1">
                                <ul class="cbp-hsmenu">
                                            
                                        </ul>
                                </nav>
                                </div -->
                                <input type="hidden" id="rowCount" value="<?php echo count($formData['pCat']);?>" >
                             	    <div class="mob">
                                    <nav class="cbp-hsmenu-wrapper" id="cbp-hsmenu-wrapper1">
                                    <div class="cbp-hsinner">
                                        <ul class="inner_class cbp-hsmenu">
                                            <?php if($formData['pCat']){
                                                foreach($formData['pCat'] as $pCat){
                                                    $catIcon = CATEGORY_IMAGE.$pCat['cat_image'];
                                                    if(empty($pCat['cat_image']))
                                                        $catIcon = CATEGORY_IMAGE.$pCat['cat_image'];
                                                    if(!file_exists($catIcon))
                                                        $catIcon = CATEGORY_DEFAULT_ICON;
                                                    
                                                    $rcount = getplacessCount($obj,$pCat['cat_id']);
                                                    ?>
                                                        <li >
                                                            <a href="javascript:void(0);">
                                                                <img style="<?php echo ($rcount ? 'opacity:1' : '')?>" title="<?php echo htmlentities($pCat['cat_name']);?>" class="pCate_<?php echo $pCat['cat_id'];?>" src="<?php echo $catIcon;?>" alt="" />
                                                            </a>
                                                            <ul style="opacity:1;background-color:<?php echo '#'.$pCat['cat_color'];?>" class="cbp-hssubmenu">
                                                                <?php 
                                                                // sub category
                                                                $subCatArr = fetchCategory($obj,$pCat['cat_id']);
                                                                if($subCatArr){
                                                                    $perCol = count($subCatArr);
                                                                    $perCol = ceil($perCol / 3);
                                                                    $catColCount = 0;
                                                                    $catCount = 0;
                                                                    foreach ($subCatArr as $subCat){
                                                                        $catColCount++;
                                                                        $catCount++;
                                                                        if($catColCount <=  $perCol){
                                                                            if($catColCount == 1)
                                                                            {
                                                                                echo "<li><div class='cat_name_embedded'>";
                                                                            }
                                                                            ?>
                                                                                    <span>
                                                                                        <input data-pcid="<?php echo $pCat['cat_id'];?>" class="chkCategories pCatChk_<?php echo $pCat['cat_id'];?>" value="<?php echo $subCat['cat_id'];?>"  id="m_<?php echo 'lbl_'.$subCat['cat_id'];?>" type="checkbox" />
                                                                                        <label for="m_<?php echo 'lbl_'.$subCat['cat_id'];?>">
                                                                                            <?php echo htmlentities($subCat['cat_name']);?>
                                                                                        </label>
                                                                                    </span>
                                                                            <?php
                                                                            if($catColCount == $perCol || $catCount == count($subCatArr))
                                                                            {
                                                                                echo "</div></li>";
                                                                                $catColCount = 0;
                                                                            }
                                                                            
                                                                            
                                                                        }
                                                                    }
                                                                }
                                                                // end of sub category
                                                                ?>
                                                                <li><div class='cat_name_embedded'>
                                                                <span>
                                                                    <input id="mobCatAll<?php echo $pCat['cat_id'];?>" class="pAll"  data-pcid="<?php echo $pCat['cat_id'];?>" data-chk="pCatChk_<?php echo $pCat['cat_id'];?>" type="checkbox" />
                                                                    <label for="mobCatAll<?php echo $pCat['cat_id'];?>">Select All</label>
                                                                </span>
                                                                </div></li>
                                                            </ul>
                                                        </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </ul>
                
                                    </div>
                                </nav>
                                </div>
                                </div>
                                
                                <div class="main1"><div class="head2"><span>Filter by&nbsp;</span>features</div></div>
                                <form id="test_form" action="#" method="POST">
                                    <div class="mob">
                                    	<div class="feat_box">
                                            <ul>
                                                <?php if($fetArr){
                                                    foreach ($fetArr as $feature){
                                                    ?>
                                                        <li><div id="lnk_f_<?php echo $feature['feature_id'];?>" class="featureSymb mob_feature" data-ele="chk_fet_<?php echo $feature['feature_id'];?>">
                                                                <img src="<?php echo FEATURE_ICON.$feature['feature_icon'];?>"  alt=""/>
                                                                <span>
                                                                    <label ><?php echo htmlentities($feature['feature_title']);?></label>
                                                                </span>
                                                                <input value="0" data-fet="<?php echo $feature['feature_id'];?>" class="hiddFeature" id="chk_fet_<?php echo $feature['feature_id'];?>" type="hidden" />
                                                            </div>
                                                        </li>
                                                    <?php
                                                    }
                                                }?>
                                            	
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                                    <div class="exact_search_class_div_mob">
                                        <label class="search_text_class">Exact Search</label>
                                        <input type="checkbox" id="exactsearch" class="exactsearch" name="chbexactsearch" style="width: auto; vertical-align: middle; height: 100%;">
                                    </div>
                                    <div class="button">
                                        <input type="button" id="btnShow" name="btnShow" value="Search" >   
                                    </div>
                                <div class="main2">
                              	  <div class="head3">search results</div>
                                </div>
                                <div class="tags_box">
                                	
                                	<!-- div class="tags_right">
                                    	<div class="bt_close"><a href="javascript:void(0);"><span><img src="images/add-bt.png"  alt=""/></span>add tags</a></div>
                                        </div -->
                                </div>
                            </div>
                        </div>
                        
                            
                            <div class="mini-category-icons">
                                
                            </div>
                            
                            
                            
                    <div class="hotel-grid">
                        <div class="hotel-grid_in">
                            <div class="view_box">
                                <div class="view_left">
                                <div class="view_left_in">
                                <div class="view_text">view results</div>
                                </div>
                                </div>
                                <div class="view_right">
                                    <div class="grid_iocn1 margin_0"><img src="images/list-icon.png" alt=""/></div>
                                    <div class="grid_iocn"><img src="images/grid-icon.png" alt=""/></div>
                                </div>
                            </div>
                             <div class="resultDiv">
                                <!-- print result output here.... -->
                                <?php echo getResultHtml($obj,$searchText,$chbExactSearch);?>                            
                             </div>
                        </div>
                    </div>
                    	<a href="javascript:void(0);">
                            <div id="lnkShowMore" class="more"><?php echo ($noRec ? 'No record(s) found' : 'show more');?></div>
                        </a>
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