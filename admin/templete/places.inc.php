<?php include_once("header.inc.php"); ?>
<?php include_once("inner_header.inc.php"); ?>
<script type="text/javascript" language="javascript" src="js/jquery_function.js"></script>
<script type="text/javascript" language="javascript" src="js/datatable/jquery.dataTables-Search.js"></script>
<script type="text/javascript" >
    $(document).ready(function() {
        var set_value=$('#is_set_order').val();
        
        $('#placesMasterTable').dataTable( {
            //"bPaginate": set_value,
            "bFilter": false,//to show search filter
            "bInfo": true,//to show number of record info
            "aLengthMenu": [[15,25, 50, 100, -1], [15,25, 50, 100 , "All"]],//Page size dropdown

            "bAutoWidth": false,
            "bSortable" : false,
            "bProcessing": true,
            "bServerSide": true,
            "bStateSave": false, //to save page state
            "iDisplayLength": 15 ,//to show number of page size
            "bLengthChange": true,//to show page size dropdown
            "aaSorting": [[3,'asc']],//default coloumn for sort and sort type
            "sPaginationType": "full_numbers",
            "bSort":true,
            "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "plc_name", "value": $('#plc_name').val() } );	//to search paramatert
            },
            "aoColumnDefs" : [ {
                    "bSortable" : false,
                    "aTargets" : [ "no-sort" ]
                } ],//aoColumnDefs to apply no sorting for coloumn where class is "no-sort"
            "aoColumns": [
                null,
                { "sWidth": "250px", "sClass": "align_image_center" },
                { "sWidth": "200px", "sClass": "align_image_center" },
                { "sWidth": "200px", "sClass": "align_image_center" },
                { "sWidth": "80px", "sClass": "align_image_center" },
                { "sWidth": "80px", "sClass": "align_image_center" },                
                { "sWidth": "80px", "sClass": "align_image_center" }
            ],
            "sAjaxSource": "./ajax/places_management.php"
        });
                
                $("input").keypress(function(event) {
                    if (event.which == 13) {
                        event.preventDefault();
                        $("#btnshow").trigger('click');
                    }
                });
    });//End document ready
    
    

function searchTable(){
    search("placesMasterTable");
}    

function clearFilter(){
    $('#plc_name').val('');
	$('#placesMasterTable').dataTable({ "bRetrieve": true }).fnSort([]);
    search("placesMasterTable");
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
                                            <div class="white12" style="vertical-align:middle;float:left;padding: 8px 5px;"><p>Title:</p></div>
                                            <div style="float:left;margin-right: 10px;">
                                                <input type="text" name="plc_name" id="plc_name" style="width:90px;" value="<?php echo isset($_SESSION['Sessinoplc_name']) ? stripslashes($_SESSION['Sessinoplc_name']) : ''; ?>"/>
                                            </div>
                                        </div>
                                        <input type="button" name="btnshow" value="Show" id="btnshow" class="button serach_opr" onclick="searchTable();"/>
                                        <input type="button" name="btnshow" value="Clear" id="back" class="button left_menu_option" onclick="clearFilter();"/>
                                    </div>
                                    <div style="right:0px; float:right; z-index:1; position:relative;">
                                        <input type="button" name="add_edit" value="Add Place" id="add_edit" style="width:auto" onclick="location.href='add_edit_places.php'" class="button add_edit_member"/>
                                    </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                    <div class="grid_content">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="placesMasterTable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="blue_bg_header no-sort">#</th>
                                                    <th class="blue_bg_header">TITLE</th>
                                                    <th class="blue_bg_header no-sort">GALLERY</th>
                                                    <th class="blue_bg_header no-sort">REVIEW & RATINGS</th>
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
