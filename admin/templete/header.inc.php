<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php if(isset($isContentIE)){?>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<?php }?>
<link rel="shortcut icon" href="images/favicon.ico" />
<title><?php echo $sPageTitle.ADMIN_SITENAME ?></title>
<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->
<link rel="shortcut icon" type="image/png" href="images/favicon.ico"/>
<link href="<?php echo SITEPATH; ?>css/css.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITEPATH; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITEPATH; ?>css/toastmessage.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITEPATH; ?>css/datatable/demo_page.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITEPATH; ?>css/datatable/demo_table.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css' />

<script src="<?php echo SITEPATH; ?>js/jquery-1.10.1.min.js"></script>
<script src="<?php echo SITEPATH; ?>js/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITEPATH; ?>js/datatable/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITEPATH; ?>js/datatable/jquery.dataTables-Search.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo SITEPATH; ?>js/jquery.validation.js" ></script>
<script language="javascript" type="text/javascript" src="<?php echo SITEPATH; ?>js/toastmessage.js" ></script>
<script language="javascript" type="text/javascript" src="<?php echo SITEPATH; ?>js/comman.js" ></script>
<script language="javascript" type="text/javascript" src="<?php echo SITEPATH; ?>js/validation_functions.js" ></script>
<?php 
    //----- INCLUDE TINY EDITOR FILE -----//
    require_once("include/tinymice.php");
?>

<script type="text/javascript">
$(document).ready(function() {
    
    if($.trim($('#sucess_msg').val())!=''){
        $().toastmessage('showSuccessToast', $('#sucess_msg').val());
    }

    if($.trim($('#notice_msg').val())!=''){
        $().toastmessage('showNoticeToast', $('#notice_msg').val());
    }

    if($.trim($('#warning_msg').val())!=''){
        $().toastmessage('showWarningToast', $('#warning_msg').val());
    }

    if($.trim($('#error_msg').val())!=''){
        $().toastmessage('showErrorToast', $('#error_msg').val());
    }

    if($.trim($('#error_message_invalidfile').val())!=''){
        $().toastmessage('showToast', {
            text     : $('#error_message_invalidfile').val(),
            sticky   : true,
            type     : 'error'
        });
    }
});

function toggleProfileOptions()
{
    //  alert('kk');
    jQuery("#profile_options_dd").slideToggle(300);
    jQuery("#profile_options_dd").css({ display: "block" });
}
</script>
</head>
<?php if($_SESSION['yb_admin_user'] !="" ){ ?>
<?php }else{ ?>
<body class="login_bg">
    <div class="login_logo">
        <a class="" href="index.php"><img src="images/admin_logo.png" alt="Youbaku" border="0"></a>
    </div>
<?php } ?>    
