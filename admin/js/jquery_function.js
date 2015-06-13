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

function confirmStatus(id,action,table_name){
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
				//$("#"+divStatusId).html('');//to clear the div content
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

function confirmDelete(id,table_name,ajax_table_name,no_prod){

 var msg = "Are you sure to delete this record?"
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
							search(ajax_table_name);
							$().toastmessage('showSuccessToast', 'Record deleted successfully.');
						}
					}
				});
 }
}