<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
$(function () {
    $('select').selectpicker();
});
</script>
<?php
//echo getMessage();

include('country_flag.php');

if(isset($_SESSION[$unique_user]) && $_SESSION[$unique_user]!=""){
   
   
//date_default_timezone_set($get_meeting_location);
$DELEGATE_ARRAY = delegateListFun($login_companyId);

$FILTER_ARRAY = $DELEGATE_ARRAY['filterOption']; //filterFun();
$new_country_list = $FILTER_ARRAY['delCountry'];
$new_company = $FILTER_ARRAY['delCompanyName'];
$DELEGATE_LIST_ARRAY = $DELEGATE_ARRAY['DELEGATE_LIST_ARRAY'];
//echo "<pre>"; print_r($DELEGATE_LIST_ARRAY); echo "</pre>";
?>
    
    <form method="POST" name="frmcontry"  action="" >
        <div class="col-md-offset-1 col-md-3">
            <input type="hidden" name="flag_val" id="flag_val" value="Y"/>
            <input type="hidden" name="viewGrid" id="viewGrid" value=""/>
            <select class="form-control selectpicker" multiple data-hide-disabled="true" data-live-search="true" name="search_country" id="search_country" style="width:300px;">
                <option value="">Select Country</option>
                <?php
                $new_country_list1=array_unique($new_country_list);
                foreach($new_country_list1 as $key=>$value){ ?>
                    <option value="<?php echo $value;?>"<?php if(isset($_POST['search_country']) && $_POST['search_country']==$value){?> selected <?php } ?> ><?php echo $value;?></option>
            <?php } ?>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" ><img src="../../images/find.png"></button>
            <!--onclick="srch_esc(this.value);" -->
        </div>
    </form>
    
    <div class="col-md-1">
        <p>OR</p>    
    </div>
        
    <!-- By Company Name -->
    <form method="POST" name="frm" action="">
        <div class="col-md-3">
        
            <input type="hidden" name="flag_valcon" id="flag_val" value="Z"/>
            <input type="hidden" name="viewGrid_con" id="viewGrid" value=""/>
            <select class="form-control selectpicker" multiple data-hide-disabled="true" data-live-search="true" name="search_company" id="search_company" style="width:300px;">
                <option value="">Select Company</option>
                <?php
                $new_company1=array_unique($new_company);
                foreach($new_company1 as $key=>$value1){ ?>
                    <option value="<?php echo $value1;?>"<?php if(isset($_POST['search_company']) && $_POST['search_company']==$value1){?> selected <?php } ?> ><?php echo $value1;?></option>
            <?php } ?>
            </select>
        </div>
        <div class="col-md-1">
             <!--onChange="srch_com(this.value);"-->
            <button type="submit" ><img src="../../images/find.png"></button>
        </div>
    </form>
        
    <div class="col-md-4 hidden">
        <div class="btn-group">
            <button type="button" id="tableIcon" class="btn btn-info" aria-label="Left Align"><i class="fa fa-bars" aria-hidden="true" style="font-size: 23px;"></i></button>
            <button type="button" id="gridIcon" class="btn btn-info" aria-label="Left Align"><i class="fa fa-th" aria-hidden="true" style="font-size: 23px;"></i></button>
        </div>
    </div>
    
    <div class="col-md-12">
        <?php
        //if(isset($_POST['flag_val']) && $_POST['flag_val']=='Y'){
        //    foreach ($CountryFlagArray as $key => $value) {
        //        if($key == $_POST['search_country']){
        ?>
            
        <?php /*}
            }
        }*/
        ?>
        <?php
        if(isset($_POST['flag_val']) && $_POST['flag_val']=='Y' && $_POST['search_country']!=''){ ?>
            <span style="font-size:12px;color:#3A9D3A; font-weight:bold;" class="filter_by_fl">
                Filtered by: Country= <span class="green"> <?php echo $_POST['search_country']; ?></span>
            </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="filter_by_fr" >
                <a href="?page=clear" style="text-decoration:none; cursor:pointer;">
                    <input class="report_page" type="button" name="Clear_Filter" value="Clear Filter" style="cursor:pointer;margin-top: 20px;margin-bottom: 25px;" />
                </a>
            </span>
        <?php } ?>
    
    
    
        <?php
        if(isset($_POST['flag_valcon']) && $_POST['flag_valcon']=='Z' && $_POST['search_company']!=''){ ?>
            <span style="font-size:12px;color:#3A9D3A; font-weight:bold;" class="filter_by_fl">
                Filtered by: Company= <span class="green"> <?php echo $_POST['search_company']; ?></span>
            </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="filter_by_fr">
                <a href="?page=clear" style="text-decoration:none; cursor:pointer; ">
                    <input class="report_page" type="button" name="Clear_Filter" value="Clear Filter" style="cursor:pointer;margin-top: 20px;margin-bottom: 25px;" />
                </a>
            </span>
        <?php } ?>
   </div>
    
    
   <?php
   if(isset($_POST['flag_val']) && $_POST['flag_val']=='Y' && $_POST['search_country']!=''){
       $where = "where FIND_IN_SET('".$_POST['search_country']."', country) AND ($memberIdsTypeImplode) and o2oStatus in(1,2) and pc.access_code>0 order by country";
   }
   else{
       $where = "where o2oStatus in(1,2) AND ($memberIdsTypeImplode) and pc.access_code>0 order by country";
   }
   // company filter
   if(isset($_POST['flag_valcon']) && $_POST['flag_valcon']=='Z' && $_POST['search_company']!=''){
       $where = "where pc.name='".$_POST['search_company']."' AND ($memberIdsTypeImplode) and o2oStatus in(1,2) and pc.access_code>0 order by country"; 
   }
    
   $mainQuery = "SELECT pp.id as partID, pc.id as cid, pp.name as pname,pc.name as cname,designation,country,member_id, pp.email as pemail, photo, profile,meeting_location FROM ".$prefix."O2O_Pre_Companies pc inner join ".$prefix."O2O_Pre_Participants pp on pc.id=pp.company_id ".$where;
   
   //echo $mainQuery;
    ?>
    
    <br/><br><br>
    
    <?php if (true) { ?>
    <div id="tableLayout">
        <?php include "listView.php"; ?>
    </div>
    <?php } ?>
    
    <div id="gridLayout" style="display: none;">
        <?php //include "gridView.php"; ?>
    </div>


    
<?php
}
?>

<script>

function meetingFun(loginTabId,mtSlotIdPara,mtStatus){
	
	mtSlotIdParaSplit = mtSlotIdPara.split("/");
	mttID = mtSlotIdParaSplit[0];
	
	//aa = add_datetime_ajax('user/model/duplicate_meeting_participant.php','',mttID,'',mtSlotIdPara);
		
	if(mtStatus==''){
		window.location.href="user/ajax_file/schedule_new_meeting.php?msg=1&flgsh=2&_table_id="+loginTabId+"&val3="+mtSlotIdPara+"&val4=book&pageVia=participant";
	}else{
		
		dataparameter = "val1="+mttID+"val2=&val3="+mtSlotIdPara;
		$.ajax({
				type: "GET",
				url: "user/model/duplicate_meeting_participant.php",
				data: dataparameter,
				cache: false,
				success: function(data){
					
					var_send1 = "<span class='alertCls'>"+data+"</span>";
					jConfirm(var_send1, 'Confirmation', function(r) {
						if(r==true){
							window.location.href="user/ajax_file/schedule_new_meeting.php?msg=1&flgsh=2&_table_id="+loginTabId+"&val3="+mtSlotIdPara+"&val4=book&pageVia=participant";
						}
					});
					
					
				}
		});
		
		//var_send1 = "<span class='alertCls'>Meeting already schedule with other participant of same company. <br/> Do you still want to schedule?</span>";
		//jConfirm(var_send1, 'Confirmation', function(r) {
		//	if(r==true){
		//		window.location.href="user/ajax_file/schedule_new_meeting.php?msg=1&flgsh=2&_table_id="+loginTabId+"&val3="+mtSlotIdPara+"&val4=book&pageVia=participant";
		//	}
		//});
	}

}

$(document).ready(function(){
	$("#tableIcon").addClass("typActive");
	//$("#gridLayout").hide();
    $("#gridIcon").click(function(){    	
		$("#tableLayout").hide();
    	$("#gridLayout").show();

    	$("#tableLayout").removeClass("dispType");
        $("#gridLayout").addClass("dispType");

    	$("#tableIcon").removeClass("typActive");
        $("#gridIcon").addClass("typActive");
    });
    $("#tableIcon").click(function(){
    	$("#gridLayout").hide();
    	$("#tableLayout").show();

    	$("#gridLayout").removeClass("dispType");
        $("#tableLayout").addClass("dispType");

    	$("#gridIcon").removeClass("typActive");
        $("#tableIcon").addClass("typActive");
    });
});

function srch_esc(val){
    testElement = document.getElementById('gridLayout');
    getDispType = testElement.classList.contains('dispType');
    document.frmcontry.viewGrid.value="tableLayout";
    if(getDispType==true){
        document.frmcontry.viewGrid.value="gridLayout";
    }
    // alert(val);
    document.frmcontry.flag_val.value="Y";
    document.frmcontry.submit();
}

function srch_com(val){
    testElement = document.getElementById('gridLayout');
    getDispType = testElement.classList.contains('dispType');
    document.frm.viewGrid_con.value="tableLayout";
    if(getDispType==true){
        document.frm.viewGrid_con.value="gridLayout";
    }
    document.frm.flag_valcon.value="Z";
    document.frm.submit();
}

</script>


<link href="templates/css/toastr.css" rel="stylesheet" type="text/css" />
<script src="templates/js/toastr.js"></script>
<script type="text/javascript">
function showToast(message,type='info'){
 // alert(message);
  toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "8000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
  };
toastr[type](message);
}
//showToast(getMessage());
</script>

<style>
.redColor{background-color: #F17C7C; color: black;}
.greenColor{background-color: lightgreen; color: black;}
.yellowColor{background-color: lightyellow; color: black;}

.lbb { border-left: 1px solid #AEAEAE; }
.bbb { border-bottom: 1px solid #AEAEAE; }
.dat{
	font-weight:700;
	color: #fff;
	background: #2a9ed9;
	padding: 3px 0;
}
.lastDiv {
    font-size: 12px;
    font-weight: bold;
    padding-top: 5px;
}
.availableCLS td{border-bottom: 1px solid #a1a1a1; padding: 3px;}

.wrapper {
   margin-left: auto;
   margin-right: auto;
}
.btn-info.disabled.focus, .btn-info.disabled:focus, .btn-info.disabled:hover, .btn-info.focus, .btn-info:focus, .btn-info:hover, .btn-info.typActive {
    background: #0075aa;
    opacity: .8;
    border: 1px solid #0075aa;
}
.table-bg{
	background: #888;
	height: 50px;
}
.table-bg th{
	color: #fff;
	text-align: center;
	font-weight: bold;a
}
.table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
    border: 1px solid #868686;
}

.alertCls{
	color: #fff;
	background-color: red;
	font-size: 13px;
	font-weight: bold;
	line-height: 22px;
}
</style>