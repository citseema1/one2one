<style>
.timeTd {
    color: black;
}
.blockdTd{
    color:red;
}
.meetingTd{
    color:black;
    font-weight:bold;
}
/*@media only screen and (orientation:portrait){
    body {  
        height: 100%;
        width: 100%;
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        transform: rotate(90deg);
    }
}
@media only screen and (orientation:landscape) {
    body {  
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
        width: 100%;
        height: 100%;
    }
}*/
</style>

<script>
function  duplicate_meeting_schedule(val1,val2,val3){
    $("#FormName").attr("action", "user/model/duplicate_meeting_schedule.php?status="+val1+"&id="+val2+"&mid="+val3);
    $('#FormName').submit();
}

function check_selected5(val,action,FormAction,DivID,val1,ElementType,val2,val3){
    //alert(action+' '+FormAction+' '+DivID+' '+val1+' '+ElementType+' '+val2+' '+val3);
    var flag ='yes';
    var element_type='checkbox';
    var j=1; var p_id=new Array();
    document.FormName.action = 'index.php?page=delete'; 
    if(FormAction){
        document.FormName.action = FormAction;  
    }
    if(ElementType!='checkbox' && ElementType!='select-one'){
        var flag='yes';
        p_id[j]=(ElementType) ;
    }else{   
        var flag='no';
        element_type=ElementType;   
    }
    for (var i = 0; i < document.FormName.elements.length; i++){
        var e = document.FormName.elements[i];
        if ((e.type == element_type)){
            if (e.checked && element_type=='checkbox'){
                var flag='yes';
                p_id[j]=e.value;
                j++;
            }else if(element_type=='select-one' && e.value!='' && e.value!=0){
                var flag='yes';
                p_id[j]=e.value;
                j++;
            }
        }
    }
    if(flag=='no'){
        jAlert("Please Select at least one company with whom you would like to "+val,'Alert');
        return false;
    }else{
        if(action=='ScheduledMeetings'){
            Ajax5(FormAction,DivID,val1,val2,p_id,val3,action);
        }
    }
} 

function Ajax5(url,DivID,val1,val2,val3,val4,val5,val6) {
    //alert(url+' '+DivID+' '+val1+' '+val2+' '+val3+' '+val4+' '+val5+' '+val6);
    if(val4=='book'){
        window.location.href="user/ajax_file/schedule_new_meeting.php?msg=1&flgsh=2&_table_id="+val1+"&val3="+val3+"&val4="+val4;    
    }else{

        if(val4=='cancel' || val4=='cancel_a' ||  val4=='cancel_block_a' || val4=='cancel_block1' || val4=='cancel_block' || val4=='accept' || val4=='blocked' || val5=='searchnschedule' || val4=='cancel_workshop' || val5=='cancel_workshop_a' || val4=='attend_workshop_a' || val4=='attend_workshop' ){
            if(val1=='m'){
                window.location.href="user/ajax_file/schedule_sim.php?msg=1&flgsh=2&val1="+val1+"&val3="+val3+"&val4="+val4;
            }
            else{
                window.location.href="user/ajax_file/schedule_sim.php?msg=1&flgsh=2&_table_id="+val1+"&val3="+val3+"&val4="+val4;
            }
        }
        if(val4!='dontload' ){
            //document.getElementById(DivID).innerHTML="<img class='img_center' src='https://www.one2onescheduler.com/images/Loading.gif'/><br><b><font color=green size=2>If page does not loads in 2 minutes, then please reclick on link and try again !</font></b>";
        }else{
            document.getElementById(DivID).innerHTML="<img class='img_center' src='https://www.one2onescheduler.com/images/load.jpg'/>";
        }
        
        $.post(url, {
            val1:val1,
            val2:val2,
            val3:val3,
            val4:val4,
            val5:val5,
            val6:val6,
            ajax_active:'set'
        },function(data) {
            // alert(DivID+" "+data);
            if( val4=='cancel' || val4=='cancel_block' || val4=='accept'){      
                window.location.href="?page=schedule_your_meetings0&msg=1&_table_id="+val1;
            }else if(val5=='searchnschedule'){             //val5=='ScheduledMeetings' || 
                //window.location.href="user/ajax_file/schedule_sim.php?msg=1&flgsh=2&_table_id="+val1+"&val3="+val3+"&val4="+val4;
                
                window.location.href="user/ajax_file/schedule_new_meeting.php?msg=1&flgsh=2&_table_id="+val1+"&val3="+val3+"&val4="+val4;
            }
            else{
                $("#"+DivID).html(data);
            }
        });
    }
}


function toggle() {
    var ele = document.getElementById("toggleText");
    var text = document.getElementById("displayText");
    if(ele.style.display == "block"){
        ele.style.display = "none";
        text.innerHTML = '<div align="right"  style="background:url(../images/search.png); background-repeat:no-repeat;width:250px;height:30px;float:right;position:relative; z-index:10;"  >  </div>';
    }else{
        ele.style.display = "block";
        text.innerHTML = '<div align="right"  style="background:url(../images/hide.png); background-repeat:no-repeat;width:250px;height:30px;float:right;position:relative; z-index:10;"  >    </div>';
    }
}  
</script>
<?php

$TableID = $_SESSION['loginTableId']; //_TaBlE_ID

$DELEGATE_LIST_ARRAY = delegateListFun($login_companyId);
$DELEGATE_ARRAY = $DELEGATE_LIST_ARRAY['DELEGATE_LIST_ARRAY'];

// $unavailableTableIds_byTimeslotId = "4"; //$Meetingslots['unavailableTableIds'];
// $remove = explode(",",$unavailableTableIds_byTimeslotId);

// $result = array_diff_key($DELEGATE_ARRAY, array_flip($remove));
                                        
//echo "<pre>"; print_r($DELEGATE_ARRAY); echo "</pre>"; die;

//$login_meeting_location = "Asia/Kolkata";
//$get_meeting_location = "Europe/London";
$get_date_scheduler = "26 June 2021";

$dateArray_get = userScheduler($login_meeting_location,$get_date_scheduler,$TableID);
$dateArray = $dateArray_get;
//date_default_timezone_set($login_meeting_location);

echo "<pre>"; print_r($dateArray); echo "</pre>";
?>

<form name="FormName" id="FormName" method="POST" action="">
    <table width="100%" class="table table-hover" border="0" cellpadding="4" cellspacing="0" style="font-size: 12px; margin-top: 5px;" align="center" >
        <tr class="b">
            <th width="4%" style="height:30px;line-height:30px;" align="center" class="tbb bbb lbb">&nbsp;&nbsp;</th>
            <th width="12%" style="height:30px;line-height:30px;  padding-left: 5px;" align="left" class="tbb lbb  bbb">Time</th>
            <th width="50%" style="height:30px;line-height:30px;" align="left" class="tbb  lbb bbb">&nbsp;&nbsp;Select Company<?=$star?></th>
            <?php if($EVENT_TYPE=='physical'){ ?>
            <th width="20%" style="height:30px;line-height:30px; text-align:center;" align="center"  class="tbb rbb bbb lbb">Location</th>
            <?php } ?>
            <th width="14%" style="height:30px;line-height:30px; text-align:center;" align="center" class="tbb lbb rbb bbb  ">Status</th>
            <?php if($EVENT_TYPE=='virtual'){ ?>
            <th width="20%" style="height:30px;line-height:30px; text-align:center;" align="center" class="tbb rbb  bbb">Action<?=$star?></th>
            <?php } ?>
        </tr>

        <?php
        
        $colspan = 3;
        $colspan_main = 5;
        if($EVENT_TYPE=='physical'){
            $colspan_main = 5;
            $colspan = 3;
        }
        $o="";
        foreach ($dateArray as $conference_main_date => $d_value) {
        ?>
            <tr>
                <td colspan="<?php echo $colspan_main; ?>" align="left" style="padding-left:5px; font-weight:bold;" class=" rbb bbb tbb lbb b"><? echo $conference_main_date;?></td>
            </tr>
            
            <?php
            if(is_array($d_value)){
                foreach ($d_value as $conference_main_date1 => $d_value1) {
                    if(is_array($d_value1['one2one_new'])){
                        foreach ($d_value1['one2one_new'] as $m_key => $m_value) {
                            $Meetingslots = $d_value1['one2one_new'][$m_key];
                            if($date_format==12){ 
                                $MeetingTime=date('h:i A',$Meetingslots['start_time']).' -- '.date('h:i A',$Meetingslots['end_time']);
                            }else{
                                $MeetingTime=date('H:i',$Meetingslots['start_time']).' -- '.date('H:i',$Meetingslots['end_time']);
                            }
                            $chk_hour = date('H',$Meetingslots['start_time']);
                            $chk_min = date('i',$Meetingslots['start_time']);
                            
                            $S_TIME = $Meetingslots['start_time'];
                            $videoStartTime = $Meetingslots['start_time']."|".$Meetingslots['end_time'];
                            
                            $meetingSlotId = $Meetingslots['id'];
                            
                            $where = "where meetingslots_id='$meetingSlotId'  AND (table_id='$TableID' or scheduled_with_table_id='$TableID') limit 1";
                            $SQL_meetingData = mysqli_query($con,"SELECT *, IF(table_id=$TableID,scheduled_with_table_id,table_id) as meetingWith FROM ".$prefix."O2O_Pre_Scheduledmeetings $where"); //Select('O2O_Pre_Scheduledmeetings', '*', $where);
                            $NUM_meetingData = mysqli_num_rows($SQL_meetingData);
                            
                            
                            if($NUM_meetingData>0){
                                $FETCH_meetingData = mysqli_fetch_assoc($SQL_meetingData);
                                $blockd = $FETCH_meetingData['blockd'];
                                
                                if($blockd=='0'){
                                    $meetingWith = $FETCH_meetingData['meetingWith'];
                                    $delegateDetail = $DELEGATE_ARRAY[$meetingWith];
                                    $CCP = $delegateDetail['delFullName'];
                                ?>
                                    <tr class="trRow">
                                        <td class="lbb rbb bbb"></td>
                                        <td class="rbb bbb timeTd"><?php echo $MeetingTime; ?></td>
                                        <td class="rbb bbb meetingTd"><?php echo $CCP; ?></td>
                                        <?php if($EVENT_TYPE=='physical'){ ?>
                                            <td class="rbb bbb"></td>
                                        <?php } ?>
                                        <td class="rbb bbb"></td>
                                        <td class="rbb bbb"></td>
                                    </tr>
                                <?php 
                                }else{
                                ?>
                                    <tr class="trRow">
                                        <td class="lbb rbb bbb">
                                            <?php //echo $Meetingslots['id'];?><?php //echo $meetingSlot_cnt_row; ?>
                                            <input type="checkbox" name="check[]" value="<?=$Meetingslots['id']; ?>" />
                                        </td>
                                        <td class="rbb bbb timeTd"><?php echo $MeetingTime; ?></td>   <!--." ".$meetingSlotId-->
                                        <td class="rbb bbb blockdTd">Blocked</td>
                                        <?php if($EVENT_TYPE=='physical'){ ?>
                                            <td class="rbb bbb"></td>
                                        <?php } ?>
                                        <td class="rbb bbb"></td>
                                        <td class="rbb bbb"></td>
                                    </tr>
                                <?php 
                                }
                            }else{
                                $meetingCountSlot = $Meetingslots['meetingCountSlot'];
                                $unavailableTableIds_byTimeslotId = $Meetingslots['unavailableTableIds'];
                                //echo "<pre>"; print_r($unavailableTableIds_byTimeslotId); echo "</pre>";
                                ?>
                
                                <tr class="trRow optionList">
                                    <td class="lbb rbb bbb">
                                        <?php //echo $Meetingslots['id'];?><?php //echo $meetingSlot_cnt_row; ?>
                                        <input type="checkbox" name="check[]" value="<?=$Meetingslots['id']; ?>" />
                                    </td>
                                    <td class="rbb bbb timeTd"><?php echo $MeetingTime; ?></td>   <!--." ".$meetingSlotId-->
                                    <td class="rbb bbb">
                                        <?php //echo $meetingCountSlot."  -  ".$concurrent_meeting; ?>
                                        <select name="schedule_with_table"  id="schedule_with_table_<?php echo $Meetingslots['id'];?>" class="form-control"  onchange="return add_datetime_ajax('user/model/duplicate_meeting.php','succ_<?php echo $Meetingslots['id'];?>','<?php echo $Meetingslots['id'];?>','',this.value);">
                                            <option value="">Select company to schedule with meetings </option>
                                            <?php
                                            if($meetingCountSlot>=$EVENT_CONCURRENT_MEETING){
                                                $RESULT_DELEGATE_ARRAY_UNAVAILABLE = $DELEGATE_ARRAY;
                                            }else{
                                                $unavailableTableIds_byTimeslotId = $Meetingslots['unavailableTableIds'];
                                                $removeTableId = explode(",",$unavailableTableIds_byTimeslotId);
                                                
                                                $RESULT_DELEGATE_ARRAY_AVAILABLE = array_diff_key($DELEGATE_ARRAY, array_flip($removeTableId));
                                                $RESULT_DELEGATE_ARRAY_UNAVAILABLE = array_intersect_key($DELEGATE_ARRAY, array_flip($removeTableId));
                                            }
                                            $msid=$Meetingslots['id'];
                                            foreach($RESULT_DELEGATE_ARRAY_AVAILABLE as $kd=>$kv){
                                                $CCP = $kv['delFullName'];
                                                $delTimezone = $kv['delTimezone'];
                                                date_default_timezone_set($delTimezone);
                                                $select_user_time = date('d M H:i',$Meetingslots['start_time'])." - ".date('H:i',$Meetingslots['end_time']);
                                                
                                            ?>
                                                <option value="<?php echo $msid.'/'.$kd;?>"><?php echo $CCP." - ".$select_user_time;?></option>
                                            <?php
                                            }
                                            foreach($RESULT_DELEGATE_ARRAY_UNAVAILABLE as $kd=>$kv){
                                                $CCP = $kv['delFullName'];
                                                $delTimezone = $kv['delTimezone'];
                                                date_default_timezone_set($delTimezone);
                                                $select_user_time = date('d M H:i',$Meetingslots['start_time'])." - ".date('H:i',$Meetingslots['end_time']);
                                            ?>
                                                <option disabled="disabled"><?php echo $CCP." - ".$select_user_time;?></option>
                                            <?php
                                            }
                                            ?>
                                            <!--style="color:yellow;"-->
                                        </select>
                                    </td>
                                    <td class="rbb bbb">Avaliable</td>
                                    <td class="rbb bbb"></td>
                                </tr>
                        <?php 
                                date_default_timezone_set($login_meeting_location);
                            }
                        }
                    }else{
                        if($date_format==12){ 
                            $MeetingTime = date('h:i A',$d_value1['start_time']).' -- '.date('h:i A',$d_value1['end_time']);
                        }else{
                            $MeetingTime = date('H:i',$d_value1['start_time']).' -- '.date('H:i',$d_value1['end_time']);
                        }
                    ?>
                        <tr class="trRow otherAgenda">
                            <td class="lbb rbb bbb"></td>
                            <td class="rbb bbb timeTd"><?php echo $MeetingTime; ?></td>
                            <td class="rbb bbb" style="color:#3D3D3D; font-weight:bold;text-align: center;"><?php echo $d_value1['purpose'];?></td>
                            <?php if($EVENT_TYPE=='physical'){ ?>
                                <td class="rbb bbb"></td>
                            <?php } ?>
                            <td class="rbb bbb"></td>
                            <td class="rbb bbb"></td>
                        </tr>

                    <?php
                    }
                }
            }
        }
        ?>
    </table>
    
    <div class="col-1-3">
        <input id="button" class="report_page" type="button" name="save" value="Schedule Your Meetings" onClick="check_selected5(this.value,'ScheduledMeetings','schedule_your_meetings0.php','AjaxDiv',<?=$TableID?>,'select-one','<?=str_replace( "'", "", $GroupName)?>','book')"  > <?php //} ?>            
    </div>
    <div class="col-1-3">
        <input id="button" class="report_page" type="button" name="save" value="Block Time Slot(s)" onClick="check_selected5(this.value,'ScheduledMeetings','schedule_your_meetings0.php','AjaxDiv',<?=$TableID?>,'checkbox','<?=str_replace( "'", "", $GroupName)?>','blocked')">
    </div>
    <div class="col-1-3">
        <input class="report_page" id="button" type="button" name="save" value="Unblock Your Time Slot(s)" onClick="check_selected5(this.value,'ScheduledMeetings','schedule_your_meetings0.php','AjaxDiv',<?=$TableID?>,'checkbox','<?=str_replace( "'", "", $GroupName)?>','cancel_block1')"> 
    </div>
</form>
    
<style>
.trRow{
    height: 40px;
}
.trRow td {
    vertical-align: middle !important;
}
</style>



