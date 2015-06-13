
<script type='text/javascript' src="js/jquery.validate.js"></script>

<script type="text/javascript">
    var login_validate;
    var forget_password_form;
    $(document).ready(function(){
        login_validate = $('#login_form').validate({
            rules:{
                username:{required:true},
                password:{required:true}
                
            },
            messages:{
                username:{required:"Please enter user name."},
                password:{required:"Please enter password."}
            }
        });
        
        forget_password_form = $('#reset_password_form').validate({
            rules:{
                recovery_email:{required:true,email:true}
                
            },
            messages:{
                recovery_email:{required:"Please enter an email.", email:"Please enter a valid email."}
            }
        });
        
        
        
    });
    $(".registernow").click(function(){
        window.location.href = $("#site_path").val()+"register";
    });
    
    $(".logout").click(function(){
        window.location.href = $("#site_path").val()+"logout.php";
    });
</script>


<div class="loginbox ">
    <div class="login_box_in">
    <div class="login_box_in2">
    <div class="login_box_in3">
    <div class="login_box_left">
        <a class="login_link login_link_act" href="javascript:void(0);" >Not a member yet?</a>
    <input type="button" value="create account" id="create_account" class="login_button" style="display:none;">
    <a class="login_link recover_password" href="javascript:void(0);">Forgot your password?</a>
    </div>
    <div class="login_box_right">
    <div class="login_account_heading">Log in to your account</div>
    <form action="login_action.php" method="POST" id="login_form">
        <input type="hidden" value="<?php echo urlencode(base64_encode($_SERVER['REQUEST_URI']));?>" name="redirect_link" id="redirect_link"/>
        <input type="text" placeholder="Username" class="username" id="username" name="username">
        <input type="password" placeholder="Password" class="password" id="password" name="password">
        <input type="submit" id="login_button" value="Login" class="login_button">
    </form>
    
    <form action="login_action.php" method="POST" id="reset_password_form">
        <input type="text" id="recovery_email" name="recovery_email" placeholder="Please enter your email..." class="recovery_email" style="display: none"/>
        <input type="submit" value="Reset password" id="send_email" class="login_button" style="display: none"/>
    </form>
    
    <a class="forgot_password recover_password" href="javascript:void(0);">Forgot your password?</a>
    <a class="registernow" href="javascript:void(0);">Register new account</a>
    </div>
    </div>
    </div>
    </div>
    <input type="hidden" id="site_path" name="site_path" value="<?php echo SITE_PATH;?>"/>
</div>