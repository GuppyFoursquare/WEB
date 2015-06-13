/**
 * jQuery.browser.mobile (http://detectmobilebrowser.com/)
 * jQuery.browser.mobile will be true if the browser is a mobile device
 **/


$(document).ready(function(){
	$(".lnkLogin").click(function(){
            
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
        
	$(".login_link_act").click(function(){
            //$("#create_account").attr("style","display:block;");
             $("#create_account").toggle();
        });
        
        $("#create_account").click(function(){
            window.location.href = $("#site_path").val()+"register";
            //alert($("#site_path").val()+"register.php");
        });
        $(".home_link").click(function(){
            window.location.href = $("#site_path").val()+"home_page.php";
            //alert($("#site_path").val()+"register.php");
        });
        
        $(".my_profile_view").click(function(){
            window.location.href = $("#site_path").val()+"view/profile/"+$("#user_name").val();
        });
        
        $(".edit_profile").click(function(){
            window.location.href = $("#site_path").val()+"edit/profile/"+$("#user_name").val();
        });
        
        $(".change_password").click(function(){
            window.location.href = $("#site_path").val()+"password/change";
        });
        
        $(".recover_password").click(function(){
            
            $("#username").hide();
            $("#password").hide();
            $("#login_button").hide();
            
            $("#recovery_email").show();
            $("#send_email").show();
            //login_validate = $('#login_form');
            login_validate.resetForm();
        });
        
         $(".my_comments").click(function(){
            window.location.href = $("#site_path").val()+"my-comments";
        });
        
        /*$("#continer").on("click",".cap_text",function(){
            var place_id = $(this).data("id");
            //alert($("#continer .favourites_img"+place_id).attr("src","images/favourites-yellow.png"));
            $.ajax({
                    url:$("#site_path").val()+'add_to_favourites.php?place_id='+place_id,
                    type:"POST",
                    data:{"plc_id": place_id },
                            success:function(data){
                                if(data == 0)
                                {
                                    $().toastmessage('showErrorToast', "Please login to mark as favourite");
                                }   
                                else if(data == 1)
                                {
                                    $().toastmessage('showSuccessToast', "Place added to favourites.");
                                    $("#continer .favourites_img"+place_id).attr("src","images/favourites-yellow.png");
                                }
                                else if(data == 2)
                                {
                                    $().toastmessage('showSuccessToast', "Place removed from favourites.");
                                    $("#continer .favourites_img"+place_id).attr("src","images/favourites.png")
                                }
                                else if(data == 3)
                                {
                                    $().toastmessage('showErrorToast', "Falied to mark the place as favourite.");
                                }
                                else if(data == 4)
                                {
                                    $().toastmessage('showErrorToast', "Falied to unmark the place as favourite.");
                                }
                            }
            });
        });
        
        
        
        
        $(".favourite_rating").on("click",function(){
            var place_id = $("#place_id").val();
            //alert($("#continer .favourites_img"+place_id).attr("src","images/favourites-yellow.png"));
            $.ajax({
                    url:$("#site_path").val()+'add_to_favourites.php?place_id='+place_id,
                    type:"POST",
                    data:{"plc_id": place_id },
                            success:function(data){
                                if(data == 0)
                                {
                                    $().toastmessage('showErrorToast', "Please login to mark as favourite");
                                }   
                                else if(data == 1)
                                {
                                    $().toastmessage('showSuccessToast', "Place added to favourites.");
                                    $(".favourite_rating img").attr("src","images/favourites-yellow.png");
                                }
                                else if(data == 2)
                                {
                                    $().toastmessage('showSuccessToast', "Place removed from favourites.");
                                    $(".favourite_rating img").attr("src","images/favourites.png")
                                }
                                else if(data == 3)
                                {
                                    $().toastmessage('showErrorToast', "Falied to mark the place as favourite.");
                                }
                                else if(data == 4)
                                {
                                    $().toastmessage('showErrorToast', "Falied to unmark the place as favourite.");
                                }
                                
                                
                                
                            }

            });
        });*/
        
        
        if(!isMobile.any()) {
            // It is mobile
                   /* $(".foggyimg2").foggy({
                                blurRadius: 3.5,            // In pixels.
                                opacity: 0.8,   
                                quality:20,// Falls back to a filter for IE.
                                cssFilterSupport: true   
                    });

                $(".foggyimg2").foggy(false);
*/

                $(".home_slider").mouseleave(function() {//col_img
                    $(".foggyimg2").foggy(false);
                });

                $(".home_slider").mouseenter(function() {//col_img
                        $(".foggyimg2").foggy({
                        blurRadius: 3.5,            // In pixels.
                        opacity: 0.8,   
                        quality:20,// Falls back to a filter for IE.
                        cssFilterSupport: true      // Use "-webkit-filter" where available.
                    });
                });
        }
        
});

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};


function keyRestrict(e, validchars)
{
    var key='', keychar='';
    key = getKeyCode(e);
    if (key == null) return true;
    keychar = String.fromCharCode(key);
    keychar = keychar.toLowerCase();
    validchars = validchars.toLowerCase();
    if (validchars.indexOf(keychar) != -1)
            return true;
    if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
            return true;
    return false;
}

function getKeyCode(e)
{
if (window.event)
	return window.event.keyCode;
else if (e)
	return e.which;
else
	return null;
}