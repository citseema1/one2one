<style>
#tableLayout th{
    vertical-align: middle;
}
#tableLayout td, #tableLayout td a {
    color: black;
}
#tableLayout td a {
    text-decoration: underline;
}
</style>
<table id="tableLayout" width="100%" border="0" cellpadding="4" cellspacing="0" style="font-size: 12px; margin-top: 5px;" align="center" class="table table-hover" >
    <thead>
        <tr class="table-bg">
            <th width="15%" align="left" class="tbb bbb lbb black" >Delegate Image</th>
            <th width="15%" align="left" class="tbb bbb lbb black" >Delegate Name</th>
            <th width="20%" align="left" class="tbb bbb lbb black" >Company Name</th>
            <th width="13%" align="left" class="tbb bbb lbb black" >Designation</th>
            <th width="17%" align="left" class=" tbb bbb lbb black">Country</th>
            <!--<th width="17%" align="left" class=" tbb bbb lbb black">Member Type</th>-->
            <th width="10%" align="left" class="tbb  bbb lbb black" >Full Details</th>
            <th width="10%" align="left" class="tbb  bbb lbb black" >View Time Slots Status</th>
            <th width="10%" align="left" class="tbb  bbb lbb black" >is meeting with delegate possible?:</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query=mysqli_query($con,$mainQuery);
        $j=1;
        //while ($result=mysqli_fetch_array($query)){
        foreach($DELEGATE_LIST_ARRAY as $k_dList => $v_dList){
            
            $loopTableID = $k_dList;
            
            $result = $v_dList;
            
            $delCompanyId = $result['delCompanyId'];
            $delegateId = $result['delegateId'];
            
            $sql_comp_data = "SELECT * FROM ".$prefix."O2O_Pre_Companies WHERE id=$delCompanyId";
            $sql_comp_data_return = getResultDataFun($sql_comp_data);
            $SUCCESS_ACTIVE_COMP = $sql_comp_data_return['success'];
            $COMPANY_DATA_RESULT = $sql_comp_data_return['result'][0];
            
            $sql_part_data = "SELECT * FROM ".$prefix."O2O_Pre_Participants WHERE id=$delegateId";
            $sql_part_data_return = getResultDataFun($sql_part_data);
            $PARTICIPANT_DATA_RESULT = $sql_part_data_return['result'][0];
        
            //$queryC1 = mysqli_query($con,"SELECT id FROM ".$prefix."O2O_Pre_Table where participant_id in($g_partID)");
            
            
            
            
            if (isset($result['photo']) && !empty($result['photo'])) {
                $images = $result['photo'];
                $photo_srcExp = explode("assets",$images);
                if(!file_exists("assets/".$photo_srcExp[1])) {
                    $images="user/templates/images/profile.png";
                }
            }else{
                $images = "user/templates/images/profile.png";
            }
            
            $rowColor = "";
            $num_Meeting = 0;
            /*if($CMP_id!=$mw_companyId){
                $sql_checkMeetingStatus = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Scheduledmeetings where (table_id='".$TableID."' and scheduled_with_table_id='".$g_preTableID."') or (table_id='".$g_preTableID."' and scheduled_with_table_id='".$TableID."')");
                $num_Meeting = mysqli_num_rows($sql_checkMeetingStatus);
                
                $rowColor = "redColor";
                
                if($num_Meeting==0){
                    $availableTimeslot_Array = get_availaleTimeSlot($TableID,$get_meeting_location,$g_preTableID);
                    //echo "<pre>"; print_r($availableTimeslot_Array); echo "</pre>";
                    $available_cnt = count($availableTimeslot_Array);
                    $rowColor = "greenColor";
                    if($available_cnt==0){
                        $rowColor = "redColor";
                    }
                }
            }*/
            
        ?>
        <tr height="30px" class="<?php echo $rowColor." ".$moveToFirst;?>" >		
            <td class="lbb bbb" style="width: 5%">
                <img src="<?php echo $images;?>" class="img-responsive center-block" style="width: 60px;" />
            </td>

            <td class="lbb bbb" style="width: 10%"> 
                <b><?php echo ucfirst(mysqli_real_escape_string($con,$PARTICIPANT_DATA_RESULT['name']));?></b>
            </td>
            
            <td class="lbb bbb"> 
                <?php echo ucfirst(mysqli_real_escape_string($con,$COMPANY_DATA_RESULT['name']));?>
            </td>
            
            <td class="lbb bbb"><?php echo ucfirst($PARTICIPANT_DATA_RESULT['designation']);?></td>
            
            <td class="lbb bbb" style="position:relative;"> 
                <?php
                $country_arr = explode(',', $COMPANY_DATA_RESULT['country']);
                for($i=0; $i<count($country_arr); $i++){
                    echo ucfirst($country_arr[$i]);
                    if(isset($result['country']) && !empty($result['country'])){
                        //include('country_flag.php');
                        foreach ($CountryFlagArray as $key => $value) {
                            if ($key == $country_arr[$i]){
                                echo $flag = '<img src="user/'.$value.'" style="right:10px; margin-right: 10px; width: 25px; height: 15px; border-radius: 4px; position: absolute;"><br>';
                            }
                        }
                    }
                }
            ?>
            </td>
            <!--<td class="lbb bbb">
                <?php foreach($member_type_array as $vv){ ?>
                    <img src="<?php echo $vv['m_icon']; ?>" title="<?php echo $vv['m_name']; ?>" alt="<?php echo $vv['m_name']; ?>" style="width: 30px; float: left; margin: 5px;">
                <?php } ?>
            </td>-->
            <td class="bbb lbb black" >
                <a href="user/view/ajax_user_profile.php?id=<?php echo $sw_getCID; ?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax',width: 750,height: 650})">Full Details</a>
            </td>
            
            <td class="lbb bbb">
                <?php $timeSlotName = ucfirst(mysqli_real_escape_string($con,$name))." From ".ucfirst(mysqli_real_escape_string($con,$cname))." - ".ucfirst($country);?>
                <a href="user/view/ajax_user_timeslot.php?login_table_id=<?php echo $TableID; ?>&sch_with_table_id=<?php echo $g_preTableID; ?>&num_Meeting=<?php echo $num_Meeting; ?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax',width: 500,height: 550})">View Time Slots Status</a>
            </td>
            
            <td class="lbb bbb">
                <?php
                if($CMP_id!=$mw_companyId){
                    if($num_Meeting!=0){
                        echo "MEETING ALREADY SCHEDULED";
                    }else{
                        if($available_cnt==0){
                            echo "NO";
                        }else{
                            echo "YES";
                        }
                    }
                }
                ?>
            </td>
        </tr>

        
        <?php } ?>
    </tbody>
</table>