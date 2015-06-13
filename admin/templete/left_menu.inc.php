<?php
/******************** PAGE DETAILS ********************/
/* @Programmer  : T.K./K.S.
 * @Maintainer  : T.K.
 * @Created     : 29 Dec 2014
 * @Modified    : 2 Jan 2015
 * @Description : Page is used to show left menu navigation of admin panel.
 * ****************************************************** */

#SETUP -------------------------------------------------------------------------
$iPageSelect = isset($iPageSelect) ? $iPageSelect : '0';
#PROCESS -----------------------------------------------------------------------
if($_SESSION['yb_admin_user']=='1' || $_SESSION['yb_admin_user']=='39'){
$sOption = "SELECT * FROM {$prefix}option WHERE opt_active=1 ORDER BY opt_sequence_no ASC";
$rOption = mysql_query($sOption) or die("Error:in option selection".mysql_error());
}else{
$sOption = "SELECT * FROM {$prefix}option WHERE opt_option_id IN (SELECT opt_option_id FROM yb_user_access WHERE usr_id=".$_SESSION['yb_admin_user'].") AND opt_active=1 ORDER BY opt_sequence_no ASC";
$rOption = mysql_query($sOption) or die("Error:in option selection".mysql_error());
}
$isPageFirstTimeLoad = 0;
?>
<div id="lefsec" style="padding-bottom:0;">
    <ul>
        <?php
        if (mysql_num_rows($rOption) > 0) {
            $i = 1;
            while ($opt = mysql_fetch_array($rOption)) {
           
            $isPageFirstTimeLoad = 1;
            $sDisplayStatus = 'style="display:none;"';
            $tempClass = "";
            if($iPageSelect == $opt['opt_sequence_no'])
            {
                $sMainLink = 'selected';
                $sDisplayStatus = '';
				/*
                if($_SESSION['pack_type']=='2'){
                    $sLinkClass2 = "active";
                }elseif($_SESSION['pack_type']=='3'){
                    $sLinkClass3 = "active";
                }else{
                    $sLinkClass1= "active";
                }*/
            }else  $sMainLink = '';
        ?>
        <li class="a<?php echo $opt['opt_sequence_no']; ?>">
            <a href="<?php echo SITEPATH.$opt['opt_page_name']; ?>" onclick="showPackageOptions();" class="<?php echo $sMainLink; ?>">
                <?php echo $opt['opt_option_name']; ?>
            </a>
        </li>
        <?php 
			$i++;
		}
        
        }
    ?>
    </ul>
    <input type="hidden" name="isPageFirstTimeLoad" id="isPageFirstTimeLoad" value="<?php echo $isPageFirstTimeLoad; ?>" />
</div>
