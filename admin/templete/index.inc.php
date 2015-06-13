<?php include_once("header.inc.php"); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#btnSubmit").click(function(){
            $("#frmLogin").validate({
                errorElement: "div",
                rules: {
                    txtUsername : { required: true},
                    txtPassword : { required: true },
                },
                messages: {
                    txtUsername: { required: "Please enter username" },
                    txtPassword: { required: "Please enter pasword" }
                }
            });//End add worker form validation
        });//End save click
    });
</script>
<div class="login_wrapper">
    <div class="login_table">
        <form action="" method="post" name="frmLogin" id="frmLogin">
            <div class="title_big">Welcome to the <?php echo SITETITLE; ?></div>
            <div class="title_small"></div>
            <div class="error"> <?php echo isset($msg) ? $msg : ''; ?></div>
            <div class="login_feild">
                <input type="text" name="txtUsername" id="txtUsername" class="display_text" />
            </div><!-- login_field -->
            <div class="login_feild">
                <input type="password" name="txtPassword" id="txtPassword" class="display_text" />
            </div><!-- login_field -->
            <div class="login_btn">
                <label><input type="submit" name="btnSubmit" id="btnSubmit" class="loginbutton" value="Login" /></label>
            </div><!-- login_field -->
        </form><!-- form -->
    </div><!-- login_table -->
</div><!-- login_wrapper -->

<div class="footer_wrapper"><span class="footer_text">&copy; 2014 <?php echo SITETITLE; ?>. All rights reserved.</span></div>

