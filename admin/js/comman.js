function statusOpr(act,field_name,id,fileName)
{

	if(act == 'popular'){
	$res = confirm("Are you sure you want to add this category in popular list?");
	}else if(act == 'notpopular'){
	$res = confirm("Are you sure you want to remove this category from popular list?");
	}else if(act == 'activate'){
	$res = confirm("Are you sure to change the status of this record?");
	}else if(act == 'deactivate'){
	$res = confirm("Are you sure to change the status of this record?");
	}else if(act == 'approved'){
	$res = confirm("Are you sure you want to approved this "+field_name+"?");
	}else if(act == 'notapprove'){
	$res = confirm("Are you sure you want to not approved this "+field_name+"?");
	}

	/*if(act != 'Non favorite')
	$res = confirm("Are you sure you want to "+act+" this "+field_name+"?");
	else if(act == 'Non favorite')
	$res = confirm("Do you want to remove from favorite list?");
	//alert(act);
	*/

    if($res)
    {
		document.location.href = "./"+fileName+"?step=status&act="+act+"&id="+id;
	}
	else
	{
		return false;
	}
}
function statusOprGallery(act,field_name,id,fileName,curr_id)
{

	if(act == 'popular'){
	$res = confirm("Are you sure you want to add this category in popular list?");
	}else if(act == 'notpopular'){
	$res = confirm("Are you sure you want to remove this category from popular list?");
	}else if(act == 'activate'){
	$res = confirm("Are you sure to change the status of this record?");
	}else if(act == 'deactivate'){
	$res = confirm("Are you sure to change the status of this record?");
	}else if(act == 'approved'){
	$res = confirm("Are you sure you want to approved this "+field_name+"?");
	}else if(act == 'notapprove'){
	$res = confirm("Are you sure you want to not approved this "+field_name+"?");
	}

	/*if(act != 'Non favorite')
	$res = confirm("Are you sure you want to "+act+" this "+field_name+"?");
	else if(act == 'Non favorite')
	$res = confirm("Do you want to remove from favorite list?");
	//alert(act);
	*/

    if($res)
    {
		document.location.href = "./"+fileName+"?step=status&act="+act+"&id="+id+"&curr_id="+curr_id;
	}
	else
	{
		return false;
	}
}
function SetImage(act,field_name,id,fileName,curr_id)
{
	$res = confirm("Are you sure you want to "+act+" this "+field_name+"?");
    if($res)
    {
		document.location.href = "../admin/"+fileName+"?step=set_cover_pic&act="+act+"&id="+id+"&curr_id="+curr_id;
	}
	else
	{
		return false;
	}
}
function ConfOpr(act,field_name,id,fileName)
{
	$res = confirm("Are you sure you want to "+act+" this "+field_name+"?");
    if($res)
    {
		document.location.href = "../admin/"+fileName+"&step=confirm&act="+act+"&id="+id;
	}
	else
	{
		return false;
	}
}
function deleteOpr(act,field_name,id,fileName)
{
	$res = confirm("Are you sure to delete this record?");
    if($res)
    {
		document.location.href = "./"+fileName+"?step=delete_opr&id="+id;
	}
	else
	{
		return false;
	}
}
function deleteOprGallery(act,field_name,id,fileName,curr_id)
{
    $res = confirm("Are you sure to delete this record?");
    if($res)
    {
		document.location.href = "./"+fileName+"?step=delete_opr&id="+id+"&curr_id="+curr_id;
	}
	else
	{
		return false;
	}
}
function seqOpr(type,seq,id,fileName)
{
	if(type == 'edit')
	{
		$("#txt_"+id).val($("#display_"+id).html());
		$("#disk_"+id).show();
		$("#pencil_"+id).hide();
		$("#txt_"+id).show();
		$("#display_"+id).hide();
		$("#cancel_"+id).show();
	}
	else
	{

		if($.trim($("#txt_"+id).val()) != $.trim($("#display_"+id).html()))
		{
			if($.trim($("#txt_"+id).val()) != '')
			{
				seq = $.trim($("#txt_"+id).val());

				$("#display_"+id).html($("#txt_"+id).val());
				document.location.href = "../admin/"+fileName+"&step=chgOrder&id="+id+"&seq="+seq;return false;
			}
			else
			{
				alert("Please enter sequence number");
				return false;
			}
		}

		$("#disk_"+id).hide();
		$("#pencil_"+id).show();
		$("#txt_"+id).hide();
		$("#display_"+id).show();
		$("#cancel_"+id).hide();
	}

}
function updateNick(type,seq,id,fileName)
{

	if(type == 'edit')
	{


		//$("#txt_"+id).val($("#display_"+id).html());
		$("#disk_"+id).show();
		$("#pencil_"+id).hide();
		$("#txt_"+id).show();
		$("#display_"+id).hide();
		$("#cancel_"+id).show();

	}
	else
	{

		if($.trim($("#txt_"+id).val()) != $.trim($("#display_"+id).html()))
		{
			if($.trim($("#txt_"+id).val()) != '')
			{
				name = $.trim($("#txt_"+id).val());
				//document.location.href = "../admin/"+fileName+"&step=UpdateName&id="+id+"&name="+name;
				$.ajax({
                type: "GET",
                url: fileName,
                async: false,
                data: "&step=UpdateName&id="+id+"&name="+name,
                success: function(data){
					if(data == '1')
					{
                    $("#disk_"+id).hide();
					$("#pencil_"+id).show();
					$("#txt_"+id).hide();
					$("#display_"+id).show();$("#display_"+id).html($("#txt_"+id).val());$("#cancel_"+id).hide();
					$('.msg_dis').html('Nick name updated successfully.');
					}
					else
					{
						alert("Nick name already exist.");
					}
                }
            });
			}
			else
			{
				alert("Please enter nick name");
				return false;
			}
		}
		else
		{

			$("#disk_"+id).hide();
			$("#pencil_"+id).show();
			$("#txt_"+id).hide();
					$("#display_"+id).show();$("#cancel_"+id).hide();
		}
	}
}
function cancel_opr(curr_id)
{
		$("#disk_"+curr_id).hide();
		$("#pencil_"+curr_id).show();
		$("#txt_"+curr_id).hide();
		$("#display_"+curr_id).show();
		$("#cancel_"+curr_id).hide();
}
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
function sendvalidation()
{

	var flag1=1;
	var flag2=1;
	var flag4=1;
	var flag7=1;
	var flag3=1;
	//newsletter title

var1= mf_validation(document.getElementById('txtNewsletter'),"B","Please enter newsletter title.",document.getElementById('err_title'));
	if(var1==false)
	{
		flag1= 0;
	}

	 contents=tinyMCE.get('content_en').getContent();
            if(trim(contents)=='')
            {

                document.getElementById('err_content').innerHTML = "Please enter description.";
                flag2=0;
            }
            else
            {
                document.getElementById('err_content').innerHTML ="";


            }

	users=document.getElementById('checkId').value.split("-");

	var count1=0;
	for(j=0;j<(users.length-1);j++)
	{
		//alert(document.getElementById('user'+users[j]).checked);
		if(!document.getElementById('user'+users[j]).checked)
			//alert("yes");
		   count1=count1+1;


	}
	//alert(users.length);
	if(document.getElementById('send_all').checked=="" && document.getElementById('send_person').value=="" && count1==(users.length-1))
	{
		document.getElementById('err_person').innerHTML ="Send to all or to specific person.";
		flag3=0;
	}
	else
	{
		document.getElementById('err_person').innerHTML="";
	}
	//alert(document.getElementById('send_person').value);
	if(document.getElementById('send_person').value!="")
	{
		send_people=document.getElementById('send_person').value.split(",");


	for(i=0;i<send_people.length;i++)
	{
				 if(emailCheck(send_people[i])==false)
				 {

						flag4=0;
						break;
				 }

	}
	if(flag4==0)
	{
							document.getElementById('err_person').innerHTML = "Email address is not valid";
						document.getElementById('send_person').select();
						document.getElementById('send_person').focus();
	}
	else
	{
					 	document.getElementById('err_person').innerHTML="";
	}
	}

	if(flag1==1 && flag2==1 && flag3==1 && flag4==1)
	{
		//$("#step").val('send_newletter');$("#frmcategory").submit();
		return true;
	}
	else
	{
		return false;
	}
}
function validation_nl()
{
		var flag1=1;
	var flag2=1;
	var flag4=1;
	var flag7=1;
	var flag3=1;
	//newsletter title
	document.getElementById('err_person').innerHTML="";
var1= mf_validation(document.getElementById('txtNewsletter'),"B","Please enter newsletter title.",document.getElementById('err_title'));
	if(var1==false)
	{
		flag1= 0;
	}


          contents=tinyMCE.get('content_en').getContent();
            if(trim(contents)=='')
            {

                document.getElementById('err_content').innerHTML = "Please enter description.";
                flag2=0;
            }
            else
            {
                document.getElementById('err_content').innerHTML ="";
            }



	if(flag1==1 && flag2==1)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function checkStatus(total)
{
	users=document.getElementById('checkId').value.split("-");

	if(document.getElementById('send_all').checked!="")
	{
		for(j=0;j<users.length;j++)
		{
			document.getElementById('user'+users[j]).checked="true";
		}

	}
	else if(document.getElementById('send_all').checked=="")
	{
		for(j=0;j<users.length;j++)
		{
			document.getElementById('user'+users[j]).checked="";
		}

	}

}
function allchecked()
{

	document.getElementById('send_all').checked="";
}

function confirm_alert(msg)
{
    alert(msg);
}


function confirmDelete(id,table_name,ajax_table_name){
//	alert(id+'*'+table_name+'*'+ajax_table_name);
        var msg = "Are you sure to delete this record?";
        var r=confirm(msg);
	if (r==true){
            //document.frmDelete.id.value=id;
            //document.frmDelete.submit();
            var step='deleteRecord';

                var table_id = id;
                var HOSTPATH = $("#hdnSitePath").val();
                //alert(HOSTPATH);return false;
                //alert(action);	return false;
                    $.ajax({
                            url: HOSTPATH+"action.php",
                            type : "POST",
                            data : {"table_name":table_name,"table_id":id,
                                            "step":step},
                            success: function(data){ 
                                    if(data == 0){
                                            $().toastmessage('showErrorToast', 'Record not deleted.');//toastmessage declared in header.php
                                    }else{
                                            //$('#'+ajax_table_name).
                                            search_with_pagination(ajax_table_name);
                                            $().toastmessage('showSuccessToast', 'Record deleted successfully.');
                                    }
                            }
                    });
    }
}

function confirmDeleteCategory(id,table_name,ajax_table_name,rcount,sub){
//	alert(id+'*'+table_name+'*'+ajax_table_name);
        var msg = "Are you sure to delete this record?";
        if(rcount){msg = rcount + " Place(s) added under this"+ sub +" category \nAre you sure to delete this record?";}
        var r=confirm(msg);
	if (r==true){
            //document.frmDelete.id.value=id;
            //document.frmDelete.submit();
            var step='deleteRecord';

                var table_id = id;
                var HOSTPATH = $("#hdnSitePath").val();
                //alert(HOSTPATH);return false;
                //alert(action);	return false;
                    $.ajax({
                            url: HOSTPATH+"action.php",
                            type : "POST",
                            data : {"table_name":table_name,"table_id":id,
                                            "step":step},
                            success: function(data){ 
                                    if(data == 0){
                                            $().toastmessage('showErrorToast', 'Record not deleted.');//toastmessage declared in header.php
                                    }else{
                                            //$('#'+ajax_table_name).
                                            search_with_pagination(ajax_table_name);
                                            $().toastmessage('showSuccessToast', 'Record deleted successfully.');
                                    }
                            }
                    });
    }
}

function confirmStatus(id,action,table_name){
	 //alert(table_name);return false;
	 //alert(action);
 var r=confirm("Are you sure to change the status of this record?");
 if (r==true){

	  var step='changeRecordStatus';
	  var table_id = id;
	  var HOSTPATH = $("#hdnSitePath").val();
	  //alert(HOSTPATH);return false;
	  //alert(action);	return false;
		$.ajax({
			url: HOSTPATH+"action.php",
			type : "POST",
			data : {"table_name":table_name,"table_id":id,"action":action,
					"step":step},
			success: function(data){
				var divStatusId='divStatusChange'+id;
                                //alert(divStatusId);
				//$("#"+divStatusId).html('');//to clear the div content
				if(data == 0){
					//alert('Status not changed');
					$().toastmessage('showErrorToast', 'Status not changed.');
				}else{
                                        //alert(data);
					 $("#"+divStatusId).replaceWith(data);
                                        //  setTimeout(function () {
					 $().toastmessage('showSuccessToast', 'Status changed successfully.');
                                     //    }, 100);
				}
			}
		});
 }
}
function confirmEmergency(id,action,table_name){
 var r=confirm("Are you sure to change the status of this record?");
 if (r==true){

	  var step='setAsEmergency';
	  var table_id = id;
	  var HOSTPATH = $("#hdnSitePath").val();
		$.ajax({
			url: HOSTPATH+"action.php",
			type : "POST",
			data : {"table_name":table_name,"table_id":id,"action":action,
					"step":step},
			success: function(data){
				var divStatusId='divemerChange'+id;
                                if(data == 0){
					//alert('Status not changed');
					$().toastmessage('showErrorToast', 'Status not changed.');
				}else{
                                      $("#"+divStatusId).replaceWith(data);
                                      $().toastmessage('showSuccessToast', 'Status changed successfully.');
                                }
			}
		});
 }   
}
function confirmHome(id,action,table_name,num_of_home){ 
    if(num_of_home>1 && action==1){
        alert("You can set only two records to display on home page.");
    }else{
 var r=confirm("Are you sure to change the status of this record?");
 if (r==true){

	  var step='setAsHome';
	  var table_id = id;
	  var HOSTPATH = $("#hdnSitePath").val();
		$.ajax({
			url: HOSTPATH+"action.php",
			type : "POST",
			data : {"table_name":table_name,"table_id":id,"action":action,
					"step":step},
			success: function(data){ 
				var divStatusId='divhomeChange'+id;
                                if(data == 0){
					//alert('Status not changed');
					$().toastmessage('showErrorToast', 'Status not changed.');
				}else{
//                                      $("#"+divStatusId).replaceWith(data);
                                        search_with_pagination("newsmstTable");
                                      $().toastmessage('showSuccessToast', 'Status changed successfully.');
                                }
			}
		});
 }   
    }
}
function orderconfirmStatus(id,action,table_name){
	 //alert(table_name);return false;
	 //alert(action);
 var r=confirm("Do you want to confirm order?");
 if (r==true){

	  var step='changeorderstatus';
	  var table_id = id;
	  var HOSTPATH = $("#hdnSitePath").val();
	  //alert(HOSTPATH);return false;
	  //alert(action);	return false;
		$.ajax({
			url: HOSTPATH+"action.php",
			type : "POST",
			data : {"table_name":table_name,"table_id":id,"action":action,
					"step":step},
			success: function(data){
				var divStatusId='divStatusChange'+id;
				//$("#"+divStatusId).html('');//to clear the div content
				if(data == 0){
					//alert('Status not changed');
					$().toastmessage('showErrorToast', 'Error in order confirmation.');
				}else{
					 //$("#"+divStatusId).replaceWith(data);
                                         search_with_pagination("orderMasterTable");
					 $().toastmessage('showSuccessToast', 'Order confirmed.');
				}
			}
		});
 }
}
function orderrehectStatus(id,action,table_name){
	 //alert(table_name);return false;
	 //alert(action);
 var r=confirm("Do you want to reject order?");
 if (r==true){

	  var step='changeorderstatus';
	  var table_id = id;
	  var HOSTPATH = $("#hdnSitePath").val();
	  //alert(HOSTPATH);return false;
	  //alert(action);	return false;
		$.ajax({
			url: HOSTPATH+"action.php",
			type : "POST",
			data : {"table_name":table_name,"table_id":id,"action":action,
					"step":step},
			success: function(data){
				var divStatusId='divStatusChange'+id;
				//$("#"+divStatusId).html('');//to clear the div content
				if(data == 0){
					//alert('Status not changed');
					$().toastmessage('showErrorToast', 'Error in order rejection.');
				}else{
					// $("#"+divStatusId).replaceWith(data);
                                         search_with_pagination("orderMasterTable");
					 $().toastmessage('showSuccessToast', 'Order rejected.');
				}
			}
		});
 }
}
function isFeature(id,action,table_name,num_of_isfeature,ajax_table_name){
    //alert(num_of_isfeature+'+'+action);
	 //alert(table_name);return false;
	 //alert(action);
         if(num_of_isfeature>=1 &&action==1){
         alert("To activate this price please inactive the price which is already activated.");
	return false;
     }else{
 var r=confirm("Are you sure to change the status of this record?");
 if (r==true){

	  var step='setAsFeature';
	  var table_id = id;
	  var HOSTPATH = $("#hdnSitePath").val();
	  //alert(HOSTPATH);return false;
	  //alert(action);	return false;
		$.ajax({
			url: HOSTPATH+"action.php",
			type : "POST",
			data : {"table_name":table_name,"table_id":id,"action":action,
					"step":step},
			success: function(data){
				var divStatusId='divStatusChange'+id;
				//$("#"+divStatusId).html('');//to clear the div content
				if(data == 0){
					//alert('Status not changed');
					$().toastmessage('showErrorToast', 'Status not changed.');
				}else{
					 //$("#"+divStatusId).replaceWith(data);
                                         search_with_pagination(ajax_table_name);
					 $().toastmessage('showSuccessToast', 'Status changed successfully.');
				}
			}
		});
 }
         }
}
function showPackageOptions()
{
	$(".package_ul").slideToggle('slow');
}

function confirmDeletechampion(id,table_name,ajax_table_name){
//	 alert(id+'*'+table_name+'*'+ajax_table_name);
 var r=confirm("Are you sure to delete this record?");
	if (r==true){
			//document.frmDelete.id.value=id;
			//document.frmDelete.submit();
			var step='deleteRecord';

			  var table_id = id;
			  var HOSTPATH = $("#hdnSitePath").val();
			  //alert(HOSTPATH);return false;
			  //alert(action);	return false;
				$.ajax({
					url: HOSTPATH+"action.php",
					type : "POST",
					data : {"table_name":table_name,"table_id":id,
							"step":step},
					success: function(data){ 
                                            	if(data == 0){
							$().toastmessage('showErrorToast', 'Record not deleted.');//toastmessage declared in header.php
						}else{
							//$('#'+ajax_table_name).
							
                                                        //ajax.reload(null, true);
                                                        $('#ddlYear').html(data);
                                                        search_with_pagination(ajax_table_name);
							$().toastmessage('showSuccessToast', 'Record deleted successfully.');
						}
					}
				});
 }
}