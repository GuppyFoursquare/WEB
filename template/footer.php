<footer>
<div class="footer_top">
<div class="footer_in">
<div class="footer_in_box">
<div class="footer_top">
<div class="col_1">
<div class="fot_heading">menu</div>
<div class="text1">
<ul>
<li><a class="search_footer" href="javascript:void(0);">Search</a></li>
<li><a href="<?php echo SITE_PATH.'nearme';?>">Near me</a></li>
<li><a href="<?php echo SITE_PATH.'most-popular';?>">Most popular</a></li>
<?php if(isset($_SESSION['user_id'])):?>
<li><a class="my_profile_view" href="javascript:void(0);">My account</a></li>
<li><a href="<?php echo SITE_PATH.'my-comments';?>">My Comments</a></li>
<li><a href="<?php echo SITE_PATH.'password/change';?>">Change password</a></li>
<li><a href="<?php echo SITE_PATH.'logout.php';?>">Logout</a></li>
<?php else:?>
<li><a class="lnkLogin remove_background" href="javascript:scrollToTop();">Login</a></li>
<?php endif?>

</ul>
</div>
</div>
<div class="col_2">
<div class="fot_heading">Categories</div>
<div class="text1">
<ul>
    <?php 
        $fooCatArr = fetchCategory($obj);
        if($fooCatArr){
            foreach($fooCatArr as $cat){
                ?>
                    <li><a class="category_select" href="javascript:void(0);" data-cat-id="<?php echo $cat['cat_id'];?>"><?php echo $cat['cat_name'];?></a></li>
                <?php 
            }
        }
    ?>
</ul>

</div>
</div>
<div class="col_3">
<div class="fot_heading">follow us</div>
<div class="text1">
<ul>
<li><a href="https://www.facebook.com/YouBaku" target="_blank">Facebook</a></li>
<li><a href="javascript:void(0);">Twitter</a></li>
<li><a href="https://instagram.com/youbaku" target="_blank">Instagram</a></li>
<li><a href="javascript:void(0);">Flickr</a></li>
<li><a href="https://www.youtube.com/channel/UC126ZKxNcmvcCS5G_OwomYA" target="_blank">Youtube</a></li>
</ul>

</div>
</div>
<div class="col_4">
<div class="fot_heading">help</div>
<div class="text1">
<ul>
<!--li><a href="javascript:void(0);">Search</a></li-->
<li><a href="<?php echo SITE_PATH.'faq';?>">FAQ's</a></li>
<li><a href="<?php echo SITE_PATH.'content/'.$about_us['cnt_url_name'];?>">About Us</a></li>
<li><a href="<?php echo SITE_PATH.'contact-us';?>">Contact Us</a></li>
<li><a href="<?php echo SITE_PATH.'add-place';?>">Add Your Place</a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="footer2">
<div class="footer_in">
<div class="footer_in_box">
<div class="footer_top">
<div class="footer_left">© You Baku - <?php echo date('Y');?></div>
<a href="javascript:scrollToTop()" class="footer_right">back to top</a>
</div></div></div>
</div>
</footer>
   <script src="js/cbpHorizontalSlideOutMenu.min.js"></script>	
   <script>
		var menu = new cbpHorizontalSlideOutMenu( document.getElementById( 'cbp-hsmenu-wrapper' ) );
		var menu = new cbpHorizontalSlideOutMenu( document.getElementById( 'cbp-hsmenu-wrapper1' ) );
	</script>
    
    
<!--===================================bottom top=========================================-->

<script type="text/javascript" src="js/jquery1.8.js" ></script>
<script>
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
                    
            $j(".search_footer").click(function(){
                scrollToTop();
                $j("#txtSearch").focus();
            });
            
            $j(".category_select").click(function(){
                //alert($j(this).data("cat-id"));
                var url = window.location.href;
                if(url.toLowerCase().indexOf("home") >= 0)
                {
                    $('.chkCategories').prop('checked', false);
                    $('.pCatChk_'+$j(this).data("cat-id")).prop('checked', true);
                    $j("#btnShow").click();
                }
                else
                {
                    $.session.set("not_home_page",1);
                    $.session.set("cat_id",$j(this).data("cat-id"));
                    window.location.href = "<?php echo SITE_PATH.'home?sr='?>";
                }
                
                
            });
            
            

            });






    </script>
 
  <script type="text/javascript">
function scrollToBottom() {
$('html, body').animate({scrollTop:$(document).height()}, 'slow');
}
function scrollToTop() {
$('html, body').animate({scrollTop:0}, 'slow');
}
   </script>   
   <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59618544-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>