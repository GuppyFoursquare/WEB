<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K.
 * @Maintainer  : T.K.
 * @Created     : 29 dec 2014
 * @Modified    :
 * @Description : separated out header for showing top portion of admin panel
********************************************************/
?>
<body class="<?php echo (isset($sPageClass) ? $sPageClass : '');?>">
<input name="hdnSitePath" id="hdnSitePath" type="hidden" value="<?php echo SITEPATH;?>"/>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
<tr>
  <td class="header_bg"><a class="" href="<?php echo ADMINHOMEPAGE;?>">
          <div class="innerlogo"><img src="images/admin_logo.png" border="0" title="Youbaku" /></div>
    </a>
    <table border="0" width="600" cellspacing="0" cellpadding="0" height="51" align="right">
      <tr>
        <td align="right" class="comman_heading">
            <ul class="menu_admin">
            <li><a href="<?php echo SITEPATH.ADMINHOMEPAGE;?>">Home</a></li>
            <!-- li><a href="#">Inbox</a><div class="notification_number">12</div></li -->
            <li><a href="javascript:void(0);" class="user_menu">
            <div  class="wrap_leftuser">
            <span class="welcom" onclick="toggleProfileOptions()">Welcome </span>
            <span class="user_name_menu" onclick="toggleProfileOptions()">Admin</span>
            </div>
            <div class="right_proimg" onclick="toggleProfileOptions()">
            <?php $sQuery="SELECT * FROM yb_users WHERE usr_id=".$_SESSION['yb_admin_user'];
				  $rQuery=mysql_query($sQuery);	
				  $rowqQuery=mysql_fetch_assoc($rQuery);	
				  if($rowqQuery['usr_profile_picture']==""){?>
					<img src="images/pro_pic.jpg" alt="profile pic"><?php }else{ ?>
					<img src="<?php echo "../".PROFILE_IMAGE.$rowqQuery['usr_profile_picture'];?>" alt="profile pic"><?php } ?>
			</div>
            </a></li>
            </ul>
            <div id="profile_options_dd" class="profile_options_dd">
                <ul class="logout_menu">
                    <li class="change_password"><a href="change_password.php">Change Password</a></li>
                    <li class="logout" style="border:none;"><a href="logout.php">Log Out </a></li>
                </ul>
            </div>
          </td>
        <td width="10">&nbsp;</td>
      </tr>
    </table>
    </td>
</tr>
<tr>
  <td align="left" valign="top" class="comman_heading"><div class="admintitalbox">
    <div class="admintitalboxleft"></div>
    <div class="admintitalboxright">
    <div style="float:left; width:100%;">
      <div class="admintital">
        <?php if(isset($_SESSION['yb_admin_user'])) { echo $sPageTitle; }else { echo "Administration Control Panel"; } ?>
      </div>
      <div class="breadcrumbs"><a href="<?= SITEPATH.ADMINHOMEPAGE; ?>" class="home">Home</a>
        <?php $_SESSION['parent_breadcum']; if(isset($_SESSION['parent_breadcum']) && $_SESSION['parent_breadcum']!='') { ?>
           <?php 
           if($_SESSION['parent_breadcum_url']=='') { ?>
                <div class="arrow"></div>
                    <span class="breadcrumblink">
                    <?= $_SESSION['parent_breadcum'] ?>
                    </span>
            <?php }else{?>
                <div class="arrow"></div>
                    <a href="<?= $_SESSION['parent_breadcum_url'] ?>" class="breadcrumblink" >
                    <?= $_SESSION['parent_breadcum'] ?>
                    </a>
                <?php } ?>
        <?php } ?>
                
        <?php if(isset($_SESSION['mid_breadcum']) && $_SESSION['mid_breadcum']!='') { ?>
        <div class="arrow"></div>
        <?php if(isset($_SESSION['breadcum'])){
            if($_SESSION['breadcum'] == ''){
                ?>
                    <span class="breadcrumblink">
                    <?= $_SESSION['mid_breadcum'] ?>
                    </span>
                <?php
            }else{
                ?>
                    <a href="<?= $_SESSION['mid_breadcum_url'] ?>" class="breadcrumblink">
                    <?= $_SESSION['mid_breadcum'] ?>
                    </a>    
                <?php
            }
        }
        else{
                ?>
                    <a href="<?= $_SESSION['mid_breadcum_url'] ?>" class="breadcrumblink">
                    <?= $_SESSION['mid_breadcum'] ?>
                    </a>    
                <?php
            }
        ?>
        
        <?php } ?>
        <?php if(isset($_SESSION['breadcum']) && $_SESSION['breadcum']!='') { ?>
        <div class="arrow"></div>
        <span class="breadcrumblink">
        <?= $_SESSION['breadcum'] ?>
        </span> </div>
      <?php } ?>
    </div></td>
</tr>

<?php
//set the message to show activity of page operations
if (isset($_SESSION['error_message'])) {
    $error = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['error_message_invalidfile'])) {
    $error_message_invalidfile = $_SESSION['error_message_invalidfile'];
    unset($_SESSION['error_message_invalidfile']);
}

if (isset($_SESSION['sucess_message'])) {
    $sucess = $_SESSION['sucess_message'];
    unset($_SESSION['sucess_message']);
}

if (isset($_SESSION['notice_message'])) {
    $notice = $_SESSION['notice_message'];
    unset($_SESSION['notice_message']);
}
if (isset($_SESSION['warning_message'])) {
    $warning = $_SESSION['warning_message'];
    unset($_SESSION['warning_message']);
}
?>
<input type="hidden" name="sucess_msg" id="sucess_msg" value="<?= isset( $sucess) ?  $sucess : ''; ?>" style="display:none"/>
<input type="hidden" name="error_msg" id="error_msg" value="<?= isset( $error) ?  $error : ''; ?>" style="display:none"/>
<input type="hidden" name="error_message_invalidfile" id="error_message_invalidfile" value="<?= isset( $error_message_invalidfile) ?  $error_message_invalidfile : ''; ?>" style="display:none"/>
<input type="hidden" name="warning_msg" id="warning_msg" value="<?= isset( $warning) ?  $warning : ''; ?>" style="display:none"/>
<input type="hidden" name="notice_msg" id="notice_msg" value="<?= isset( $notice) ?  $notice : ''; ?>" style="display:none"/>
<script type="text/javascript">
$(document).ready(function()
{
    $(".profile_tab").click(function(){
        $(".viewsubmenulink").slideToggle();
    });

    $("#upper_link").click(function(){

        $(".viewsubmenulink").slideToggle(function(){

            if($("#arrow_img").attr('src') == 'images/icon_up.GIF'){
                $("#arrow_img").attr('src','images/icon_down.GIF');
            }else{
                $("#arrow_img").attr('src','images/icon_up.GIF');
            }
        });

    });
});

function toggleProfileOptions()
{
    jQuery("#profile_options_dd").slideToggle(300);
    jQuery("#profile_options_dd").css({ display: "block" });
}
</script>