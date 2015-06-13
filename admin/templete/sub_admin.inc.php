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
        
        $('#usersMasterTable').dataTable( {
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
                aoData.push( { "name": "slide_title", "value": $('#slide_title').val() } );	//to search paramatert
            },
            "aoColumnDefs" : [ {
                    "bSortable" : false,
                    "aTargets" : [ "no-sort" ]
                } ],//aoColumnDefs to apply no sorting for coloumn where class is "no-sort"
            "aoColumns": [
                null,
				{ "sWidth": "100px", "sClass": "align_image_center" },
                { "sWidth": "100px", "sClass": "align_image_center" },
                { "sWidth": "160px", "sClass": "align_image_center" },
                { "sWidth": "50px", "sClass": "align_image_center" },
                { "sWidth": "50px", "sClass": "align_image_center" },
				{ "sWidth": "50px", "sClass": "align_image_center" },
                { "sWidth": "50px", "sClass": "align_image_center" }
            ],
            "sAjaxSource": "./ajax/users_management.php"
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
        
        $("input").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                $("#btnshow").trigger('click');
            }
        });
    });//End document ready
    
function searchTable(){
    search("usersMasterTable");
}    

function clearFilter(){
    $('#slide_title').val('');
	$('#usersMasterTable').dataTable({ "bRetrieve": true }).fnSort([]);
    search("usersMasterTable");
}

function set_order(){
    window.location.href='slider.php?isCancelButtonClicked=1&set_order=1';
}

function save_order(){
    $('#change_order').submit();
    return false;
}
</script>
<tr>
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
                                            <div class="white12" style="vertical-align:middle;float:left;padding: 8px 5px;">Title: </div>
                                            <div style="float:left;margin-right: 10px;">
                                                <input type="text" name="slide_title" id="slide_title" style="width:90px;" value="<?php echo isset($_SESSION['Sessinoslide_name']) ? stripslashes($_SESSION['Sessinoslide_name']) : ''; ?>"/>
                                            </div>
                                        </div>
                                        <input type="button" name="btnshow" value="Show" id="btnshow" class="button serach_opr" onclick="searchTable();"/>
                                        <input type="button" name="btnshow" value="Clear" id="back" class="button left_menu_option" onclick="clearFilter();"/>
                                    </div>
                                    <div style="right:0px; float:right; z-index:1; position:relative;">
                                        <input type="button" id="btn_change_order" value="Change Order" onclick="set_order()" class="button" >
                                        <input type="button" id="btn_save_order" value="Save Order" onclick="save_order()" class="button" style="display: none;">
                                        <input type="button" id="btn_save_order_btn" value="Save Order" class="button" style="display: none;">
                                        <input type="button" name="add_edit" value="Add User" id="add_edit" style="width:auto" onclick="location.href='add_edit_slider.php'" class="button add_edit_member"/>
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
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="usersMasterTable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="blue_bg_header">SEQ. NO.</th>
													<th class="blue_bg_header">FIRST NAME</th>
													<th class="blue_bg_header no-sort">LAST NAME</th>
													<th class="blue_bg_header no-sort">USERNAME</th>
													<th class="blue_bg_header">EMAIL</th>
                                                    <th class="blue_bg_header no-sort">STATUS</th>
                                                    <th class="blue_bg_header no-sort">EDIT</th>
                                                    <th class="blue_bg_header no-sort">DELETE</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td colspan="5" class="dataTables_empty">Please wait.. fetching records.</td>
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
