<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript" language="javascript" src="js/jquery_function.js"></script>
<script type="text/javascript" language="javascript" src="js/datatable/jquery.dataTables-Search.js"></script>
<script type="text/javascript" >
    $(document).ready(function() {
        var set_value=$('#is_set_order').val();
        
        if(set_value==1){
            set_value=false;
            $('#btn_save_order').show();
            $('#btn_change_order').hide();
        }else{
            $('#btn_save_order').hide();
            set_value=true;
        }
        
        $('#stateMasterTable').dataTable( {
            "bPaginate": set_value,
            "bFilter": false,//to show search filter
            "bInfo": true,//to show number of record info
            "aLengthMenu": [[15,25, 50, 100, -1], [15,25, 50, 100 , "All"]],//Page size dropdown

            "bAutoWidth": false,
            "bSortable" : false,
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": true, //to save page state
            "iDisplayLength": 15 ,//to show number of page size
            "bLengthChange": true,//to show page size dropdown
            "aaSorting": [[3,'asc']],//default coloumn for sort and sort type
            "sPaginationType": "full_numbers",
            "bSort":true,
            "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "question", "value": $('#question').val() } );	//to search paramatert
            },
            "aoColumnDefs" : [ {
                    "bSortable" : false,
                    "aTargets" : [ "no-sort" ]
                } ],//aoColumnDefs to apply no sorting for coloumn where class is "no-sort"
            "aoColumns": [
                
               { "sWidth": "2%", "sClass": "align_image_center" },
                { "sWidth": "5%" },
                { "sWidth": "5%" },
                { "sWidth": "3%", "sClass": "align_image_center" },
                { "sWidth": "3%", "sClass": "align_image_center" },
                { "sWidth": "3%", "sClass": "align_image_center" }
            ],
            "sAjaxSource": "./ajax/state_management.php"
        });
        
        //CHECK ORDER IS UNIQUE OR NOT
        $('body').delegate('.orderValue', 'focus', function(){
          $("#btn_save_order").fadeOut();
        });
        
        $("#btn_save_order_btn").hide();
        
        //CHECK ORDER IS UNIQUE OR NOT
        $('body').delegate('.orderValue', 'blur', function(){
            var iCategoryID  = $(this).attr("data-CatID");
            var iCurrentOrder= $(this).attr("data-currentorder");
            var iCategorySeq = $(this).val();
            var aOrderList = [];
            var aCategoryArray = [];
            
            $(".categoryOrder").each(function(){
                aCategoryArray.push($(this).val());
            });
            
            $(".orderValue").each(function(){
                aOrderList.push($(this).val());
            });
            var uniques = $.unique( aOrderList )
			var iCatOrderCount  = parseInt(aCategoryArray.length);
            var iOrderCount     = parseInt(uniques.length);
            
            
            if(iCatOrderCount == iOrderCount){
				$("#btn_save_order_btn").hide();
                $("#btn_save_order").fadeIn();
            }else{
                $("#btn_save_order_btn").fadeIn();
			}
        });
        
         $("#btn_save_order_btn").click(function(){
			alert("Duplicate order not allowed");
			return false;
        });
		
		if($("#order_id").val()==1)
		{
			clearFilter();
		}
        $("input").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                $("#btnshow").trigger('click');
            }
        });        
    });//End document ready
    
function searchTable(){
   
	search("stateMasterTable");
	
}    

function clearFilter(){
    $('#question').val('');
	$('#stateMasterTable').dataTable({ "bRetrieve": true }).fnSort([]);
    search("stateMasterTable");
}

function set_order(){
    window.location.href='faq.php?isCancelButtonClicked=1&set_order=1';
}

function save_order(){
	var chks = document.getElementsByName('chorder[]');
			var flag1=1;
          for (var i = 0; i < chks.length; i++){
			//alert(chks[i].value);
          if (chks[i].value==""){
				flag1=0;
				break;
			}
         }
			if(flag1){
			$('#change_order').submit();
			return false;
			}
			else{
			alert("Please fill up all the text boxes");
			chks[i].focus();
			return false;}
	
}
</script>
<tr>
	<input type="hidden" name="order_id" id="order_id" value="<?php if(isset($_REQUEST["set_order"]))echo $_REQUEST["set_order"];  ?>">
    <td height="400" align="center" valign="top" class="adminleft">
        <div class="admintitalbox">
            <div class="admintitalboxleft">
                <?php include("left_menu.inc.php"); ?>
            </div>
            <div class="admintitalboxright">
                <div class="mid_contain">
                    <table width="95%" border="0" align="center" cellpadding="4" cellspacing="0" >
                        <tr id="msg_dis">
                            <td colspan="2" align="center" id="message_div" style="margin:0 50px"></td>
                        </tr>
                        <tr>
                            <td style="">
                                <form name="frmSearch" id="frmSearch" method="post" action="">
                                    <input type="hidden" name="isCancelButtonClicked" id="isCancelButtonClicked" value="<?php echo $isCancelButtonClicked; ?>"/>
                                    <input type="hidden" name="serach_opr" id="serach_opr" value="search"/>
                                     <input type="hidden" name="is_set_order" id="is_set_order" value="<?=$_SESSION['set_session']?>"/>
                                    <div style=" float:left; position:absolute;" class="formtopbox">
                                        <div style="left:0px; float:right; z-index:1; float:left; position:relative;">
                                            <div class="white12" style="vertical-align:middle;float:left;padding: 8px 5px;font-size: 13px !important;">State: </div>
                                            <div style="float:left;margin-right: 10px;">
                                                <input type="text" name="question" id="question" style="width:90px;" value="<?php echo isset($_SESSION['Question']) ? stripslashes($_SESSION['Question']) : ''; ?>"/>
                                            </div>
                                        </div>
                                        <input type="button" name="btnshow" value="Show" id="btnshow" class="button serach_opr" onclick="searchTable();"/>
                                        <input type="button" name="btnshow" value="Clear" id="back" class="button left_menu_option" onclick="clearFilter();"/>
                                    </div>
                                    <div style="right:0px; float:right; z-index:1; position:relative;">
                                        <!--input type="button" id="btn_change_order" value="Change Order" onclick="set_order()" class="button" -->
                                        <input type="button" id="btn_save_order" value="Save Order" onclick="save_order()" class="button" style="display: none;">
                                        <input type="button" id="btn_save_order_btn" value="Save Order" class="button" style="display: none;">
                                        <input type="button" name="add_edit" value="Add State" id="add_edit" style="width:auto" onclick="location.href='add_edit_state.php'" class="button add_edit_member"/>
                                    </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form id="change_order" name="change_order" method="post">
                                    <input type="hidden" name="command" id="step" value="save_order" />
                                    <div class="grid_content">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="stateMasterTable" width="100%">
                                            <thead>
                                                <tr>
                                                    																												<th class="blue_bg_header no-sort">SEQ. NO.</th>
                                                    <th class="blue_bg_header">STATE NAME</th>
                                                    <th class="blue_bg_header">COUNTRY NAME</th>
                                                    <th class="blue_bg_header no-sort">STATUS</th>
                                                    <th class="blue_bg_header no-sort">EDIT</th>
                                                    <th class="blue_bg_header no-sort">DELETE</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td colspan="6" class="dataTables_empty">Please wait.. fetching records.</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                </form>
                                <table width="100%" border="0" align="center" cellspacing="0" cellpadding="5">
                                    <tr>
                                        <td align="center"><input type="button" name="Back" value="Back" id="Back"  onclick="location.href='<?php echo ADMINHOMEPAGE; ?>'" class="button"/></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </td>
</tr>
<?php include("footer.inc.php"); ?>
