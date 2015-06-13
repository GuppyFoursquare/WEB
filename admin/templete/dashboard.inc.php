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
                aoData.push( { "name": "usr_username", "value": $('#usr_username').val() } );	//to search paramatert
            },
            "aoColumnDefs" : [ {
                    "bSortable" : false,
                    "aTargets" : [ "no-sort" ]
                } ],//aoColumnDefs to apply no sorting for coloumn where class is "no-sort"
            "aoColumns": [
                null,
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
        
        
    });//End document ready
    
function searchTable(){
    search("usersMasterTable");
}    

function clearFilter(){
    $('#usr_username').val('');
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
            
            <div style="margin-left: 220px;padding: 30px 0;font-size: 16px;">
                You have <a style="text-decoration: underline;" href="<?php echo $pending_reviews ? SITE_PATH.'admin/review_ratings.php?pending=1' : 'javascript:void(0);';?>"><?php echo $pending_reviews;?></a> reviews and ratings pending to be approved.
            </div>
            
            <div style="margin-left: 220px;">
                <!--<img src="images/admin-user.png"/>-->
                <img src="member_dashboard.php?type=Members&total=<?= $total_member; ?>&active=<?= $member_active; ?>&inactive=<?= $member_inactive; ?>" />
            </div>
            
            
            <div style="margin-left: 220px;">
                <!--<img src="images/admin-user.png"/>-->
                <img src="places_dashboard.php?type=Places&total=<?= $total_plc; ?>&active=<?= $plc_active; ?>&inactive=<?= $plc_inactive; ?>" />
            </div>
            
        </div>
    </td>
</tr>
<?php include("footer.inc.php"); ?>
