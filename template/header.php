<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : S.K.
 * @Maintainer  : S.K.
 * @Created     : 05 jan 2015
 * @Modified    : 
 * @Description : This is the heder page of project
********************************************************/
?>
<script language="javascript" type="text/javascript" src="js/jquery.session.js" ></script>

<script  type="text/javascript" src="js/jquery.ezmark.js" ></script>
<link rel="stylesheet" href="css/ezmark.css" media="all">

<script type="text/javascript">
    function toggleProfileOptions()
    {
        //  alert('kk');
        jQuery("#profile_options_dd").slideToggle(100);
        var caret_index = $(".caret_arrow_image").attr("src").indexOf("bottom-arrow.png");
        //alert($("#caret_arrow_image").attr("src"));
        if(caret_index != -1)
        {
            $(".caret_arrow_image").attr("src","images/top-arrow.png");
        }
        else
        { 
            $(".caret_arrow_image").attr("src","images/bottom-arrow.png");
        }
        //jQuery("#profile_options_dd").css({ display: "block" });
    }
    
    $(document).ready(function(){
        $(this).mouseup(function(login) {
            
            if(!($(login.target).parent('.welcome_text').length > 0) || !($(login.target).parent('.caret_arrow_image').length > 0)) {
                $("#profile_options_dd").hide();
                $(".caret_arrow_image").attr("src","images/bottom-arrow.png");
                
            }
            
        });
        
        
        //alert($("#login_fail").val());
        if($("#login_fail").val() == 1)
        {
            var link_class = $(".lnkLogin").attr("class");
            if(link_class.indexOf("link_act")==-1)
                $(".lnkLogin").addClass("link_act");
            else
                $(".lnkLogin").removeClass("link_act");
            
            $(".loginbox").show();
        }
        
        if($("#no_account_exists").val() == 1)
        {
            var link_class = $(".lnkLogin").attr("class");
            if(link_class.indexOf("link_act")==-1)
                $(".lnkLogin").addClass("link_act");
            else
                $(".lnkLogin").removeClass("link_act");
            $(".lnkLogin").addClass("link_act");
            $(".loginbox").show();
            $(".recover_password").click();
        }
        
        $("#map_btn_mob").click(function(){
            $(".a2 a").removeClass("act");
            $("#map_btn_mob a").addClass("act");
        });
        
         $(".search_btn_mob").on("click",function(){
            $(".a2").addClass("a4");
            $(".a3").removeClass("a4");
            $(".a5").removeClass("a4"); 
         });
         
         $(".search_btn").click(function(){
             //alert($(".search_input").val());
             window.location.href = $("#site_path").val()+"home_page.php?sr="+$(".search_input").val();
         });
         
         $(".btn_close").on("click",function(){
            $(".a2").removeClass("a4");
            $(".a3").addClass("a4");
            $(".a5").addClass("a4"); 
         });
         
         $(".login_btn_mob").click(function(){
            login_validate.resetForm();
            forget_password_form.resetForm();
            var link_class = $(".lnkLogin").attr("class");
            if(link_class.indexOf("link_act")==-1)
                $(".lnkLogin").addClass("link_act");
            else
                $(".lnkLogin").removeClass("link_act");
            $(".loginbox").toggle();
            
            $("#username").show();
            $("#password").show();
            $("#login_button").show();
            
            $("#recovery_email").hide();
            $("#send_email").hide();
         });
         
         $('#chbexactsearch12').ezMark();
         $('.exactsearch').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'});
         
         $(".registernow").click(function(){
            window.location.href = $("#site_path").val()+"register";
        });
    });
    
</script>
<?php 
      $query = "SELECT * FROM yb_content
            WHERE cnt_is_offfmenu = 0 AND 
            cnt_id = 1
            LIMIT 1";
      $about_us = mysql_query($query);
      $about_us = mysql_fetch_array($about_us);
		

?>


<div id="header-top_outer">
    <input type="hidden" id="login_fail" name="login_fail" value="<?php echo isset($_SESSION['login_fail']) ? $_SESSION['login_fail'] : 0; $_SESSION['login_fail'] = 0;?>"/>
<input type="hidden" id="no_account_exists" name="no_account_exists" value="<?php echo isset($_SESSION['no_account_exists']) ? $_SESSION['no_account_exists'] : 0; $_SESSION['no_account_exists'] = 0;?>"/>

<div id="header-top">
    <div class="headermid">
    <div class="headermid1">
            <h1 class="logo">
                <a href="<?php echo SITE_PATH.'index.php';?>">
                    <img src="images/baku_logo.png" border="0" alt="Logo"/>
                </a>
            </h1>
            <div class="headermid_right">
            <nav id="menu">
                <ul>
                    <li class="a1 search">
                    <form id="frmSearch" action="home" method="get">
                        <label for="chbexactsearch" style="display: none;" class="exact_search_lbl">Exact search</label>
                        <input type="checkbox" style="display: none;" id="chbexactsearch" name="chbexactsearch"/>
                        <input id="txtSearch" name="sr" type="text" value="" placeholder="Search for ..." class="searchfield" />
                        <input value="" type="submit" class="searchbutton" />
                    </form>
                    </li>
                    <li class="a1 home_link"><a href="javascript:void(0);" >HOME</a></li>
                    <li class="a1"><a href="<?php echo SITE_PATH.'nearme';?>"> <!--class="act"-->near me</a></li>
                    <li class="a1"><a href="<?php echo SITE_PATH.'most-popular';?>">most popular</a>
                    </li>
                    <li class="a1"><a href="<?php echo SITE_PATH.'content/'.$about_us['cnt_url_name'];?>" >About us</a></li>
                    <?php if(!isset($_SESSION['user_id'])) { ?><li class="a1 b1"><a href="javascript:void(0);" class="search lnkLogin">login</a></li> 
                    <?php } else {?>
                    <li class="a1 welcome_text" onclick="toggleProfileOptions()" style="margin: 0 0 0 10px;"><a href="javascript:void(0);" style="padding: 3px 5px;min-width: 175px;"><?php echo strlen($_SESSION['usr_first_name'])>18 ? substr($_SESSION['usr_first_name'], 0, 18).'..' : $_SESSION['usr_first_name'];?> <img src="<?php echo $_SESSION['usr_profile_picture'] != '' ? PROFILE_IMAGE.$_SESSION['usr_profile_picture'] : PROFILE_IMAGE.'default.png';?>" style="width:20px;margin:0px 5px;height: 20px;vertical-align: middle;"/><img class="caret_arrow_image" src="images/bottom-arrow.png" style="width: 10px;vertical-align: middle;"/></a></li>
                        <div id="profile_options_dd" class="profile_options_dd" style="display: none;">
                            <div>
                                <!--span><img src="<?php echo IMAGE_PATH.'caret_image.png';?>"/></span-->
                                <ul class="logout_menu">
                                    <li class="a1"><a href="javascript:void(0);" class="my_profile_view width_change" >My Profile</a></li>
                                    <!--li class="a1"><a href="javascript:void(0);" class="edit_profile width_change" >Edit Profile</a></li-->
                                    <li class="a1"><a href="javascript:void(0);" class="search my_comments width_change" >My Comments</a></li>
                                    <li class="a1"><a href="javascript:void(0);" class="search change_password  width_change" >Change Password</a></li>
                                    <li class="a1"><a href="javascript:void(0);" class="search logout width_change" >Logout</a></li>
                                </ul>
                            </div>
                        </div>
                        
                    <input id="user_name" name="user_name" type="hidden" value="<?php echo $_SESSION['usr_username'];?>"/>
                        
                        
                    <?php }?>
                    
                    <li  class="a2 search_btn1_mob"><a href="<?php echo SITE_PATH.'home_page.php';?>" class="search2"></a></li>
                    <li class="a2 search_btn_mob"><a href="javascript:void(0);" class="searchact"></a></li>
                    <li  class="a5 a4 search_btn" style="float: right;"><a href="javascript:void(0);" class="act searchact"></a></li>
                    <li class="a3 a4">
                        <div style="float: left; display: none; height: 100%; width: 10%;">
                            <input type="checkbox" id="exactsearch" class="exactsearch" name="chbexactsearch" style="width: 100%; vertical-align: middle; height: 100%;">
                        </div>
                        <input placeholder="Search for Bar, Restaurant, Club, ..." class="search_input" id="search_input" name="search_input" type="text"/> <a class="btn_close" href="javascript:void(0);"></a>
                    </li>
                    <li class="a2 popular_btn_mob"><a href="<?php echo SITE_PATH.'most-popular';?>" class="popular"></a>	
                    </li>
                    
                    <li class="a2 map_btn_mob"><a href="<?php echo SITE_PATH.'nearme';?>" class="map"></a></li>
                    <?php if(!isset($_SESSION['user_id'])):?>
                        <li class="a2 login_btn_mob"><a href="javascript:void(0);" class="login"></a></li>
                    <?php else:?>
                        <li class="a2"><a href="<?php echo SITE_PATH.'view/profile/'.$_SESSION['usr_username'];?>" class="login"></a></li>
                    <?php endif?>
                    
                    
                    <!--li id="search_btn_mob" class="a2"><a href="javascript:void(0);" class="act searchact"></a></li>
                    <li id="popular_btn_mob" class="a2"><a href="javascript:void(0);" class="popular"></a>
                    </li>
                    <li id="search_btn1_mob" class="a2"><a href="javascript:void(0);" class="search2"></a></li>
                    <li id="map_btn_mob" class="a2"><a href="<?php echo SITE_PATH.'nearme'?>" class="map"></a></li>
                    <li id="login_btn_mob" class="a2"><a href="javascript:void(0);" class="login"></a></li-->	
                </ul>
            </nav>
        </div>

    </div>
</div>
</div>
<div class="header_bot_bg"></div>
</div>