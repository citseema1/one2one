<?php
function dashboardDataFun($_POSTDATA){
    global $con,$prefix;
    
    $loginUserTableID = $_POSTDATA['loginUserTableID'];
    $get_meeting_location = $_POSTDATA['get_meeting_location'];
    
    $dateArray_get = userTimeSlotList($get_meeting_location);
    $RETURN_ARRAY = $meetingSummaryArray = array();
    $totalMeeting_all = $availableMeeting_all = $numBlockd_all = $numMeeting_all = 0;
    
    $meetingSummaryArray['All Day']['totalMeeting'] = $totalMeeting_all;
    $meetingSummaryArray['All Day']['availableMeeting'] = $availableMeeting_all;
    $meetingSummaryArray['All Day']['numBlockd'] = $numBlockd_all;
    $meetingSummaryArray['All Day']['numMeeting'] = $numMeeting_all;
    
    foreach ($dateArray_get as $conference_main_date => $d_value) {
        $totalMeeting = 0;
        $meetingIdsDayArray = array();
        if(is_array($d_value)){
            foreach ($d_value as $conference_main_date1 => $d_value1) {
                if(is_array($d_value1['one2one_new'])){
                    $totalMeeting = $totalMeeting + count($d_value1['one2one_new']);
                    foreach ($d_value1['one2one_new'] as $m_key => $m_value) {
                        $Meetingslots = $d_value1['one2one_new'][$m_key];
                        $meetingIdsDayArray[] = $Meetingslots['id'];
                    }
                }
            }
            $meetingIdsDay = implode(",",$meetingIdsDayArray);
            
            $where="where (meetingslots_id in($meetingIdsDay) AND blockd='1' AND (table_id='".$loginUserTableID."' or scheduled_with_table_id='".$loginUserTableID."'))";
            $sqlBlockd = mysqli_query($con,"select id FROM ".$prefix."O2O_Pre_Scheduledmeetings $where");
            $numBlockd = mysqli_num_rows($sqlBlockd);
            
            $sqlMeeting="where (meetingslots_id in($meetingIdsDay) AND blockd='1' AND (table_id='".$loginUserTableID."' or scheduled_with_table_id='".$loginUserTableID."'))";
            $sqlMeeting = mysqli_query($con,"select id FROM ".$prefix."O2O_Pre_Scheduledmeetings $sqlMeeting");
            $numMeeting = mysqli_num_rows($sqlMeeting);
            
            $availableMeeting = $totalMeeting-$numBlockd-$numMeeting;
            
            $totalMeeting_all = $totalMeeting_all+$totalMeeting;
            $numBlockd_all = $numBlockd_all+$numBlockd;
            $numMeeting_all = $numMeeting_all+$numMeeting;
            $availableMeeting_all = $availableMeeting_all+$availableMeeting;
            
            
            $meetingSummaryArray[$conference_main_date] = array(
                                                        "totalMeeting" => $totalMeeting,
                                                        "availableMeeting" => $availableMeeting,
                                                        "numBlockd" => $numBlockd,
                                                        "numMeeting" => $numMeeting,
                                                        "meetingIds" => $meetingIdsDay,
                                                        
                                                    );
        }
    }
    
    $meetingSummaryArray['All Day']['totalMeeting'] = $totalMeeting_all;
    $meetingSummaryArray['All Day']['availableMeeting'] = $availableMeeting_all;
    $meetingSummaryArray['All Day']['numBlockd'] = $numBlockd_all;
    $meetingSummaryArray['All Day']['numMeeting'] = $numMeeting_all;
    
    
    
    $country_dataArray = array();
    //,COUNT(*) as countryCount where country LIKE '%France%' GROUP BY country
    $sql_country = mysqli_query($con,"SELECT country FROM ".$prefix."O2O_Pre_Companies order by country");
    //$totalCountry = mysqli_num_rows($sql_country);
    while($fetchCountry = mysqli_fetch_assoc($sql_country)){ 
        $countryName = $fetchCountry['country'];
        $countryNameExp = explode(",",$countryName);
        for($c=0;$c<count($countryNameExp);$c++){
            $cc = trim($countryNameExp[$c]);
            //$country_dataArray[$cc] = 1;
            if (!array_key_exists($cc, $country_dataArray)) {
                $country_dataArray[$cc] = 1;
            }else{
                $getValCnt = 0;
                $getValCnt = $country_dataArray[$cc];
                $getValCnt = $getValCnt+1;
                $country_dataArray[$cc] = $getValCnt;
            }
        }
    }
    
    ksort($country_dataArray);
    $totalCountry = count($country_dataArray);
    
    
    
    $sql_totalCompany = mysqli_query($con,"SELECT id FROM ".$prefix."O2O_Pre_Companies");
    $totalCompany = mysqli_num_rows($sql_totalCompany);

    $sql_totalDelegates = mysqli_query($con,"SELECT id FROM ".$prefix."O2O_Pre_Participants");
    $totalDelegates = mysqli_num_rows($sql_totalDelegates);
    
    $RETURN_ARRAY['meetingSummaryArray'] = $meetingSummaryArray;
    $RETURN_ARRAY['country_dataArray'] = $country_dataArray;
    $RETURN_ARRAY['totalCountry'] = $totalCountry;
    $RETURN_ARRAY['totalCompany'] = $totalCompany;
    $RETURN_ARRAY['totalDelegates'] = $totalDelegates;
    
    return $RETURN_ARRAY;
}

function commonDelegateListFun($companyId){
    global $con,$prefix;
    
    $sqlGetCompanyMemberType = "select member_id FROM ".$prefix."O2O_Pre_Companies where id=$companyId";
    $sqlCompanyMemberType = mysqli_query($con,$sqlGetCompanyMemberType) or die(mysqli_error($con));
    $rowCompanyMemberType = mysqli_fetch_array($sqlCompanyMemberType);
    $company_member_id = $rowCompanyMemberType['member_id'];
    
    $sqlGetMemberType = mysqli_query($con,"select GROUP_CONCAT(utility) as memberIds from ".$prefix."O2O_Member_Types where id in ($company_member_id)");
    $fetchGetMemberType = mysqli_fetch_assoc($sqlGetMemberType);
    $memberIdsType = $fetchGetMemberType['memberIds'];
    $memberIdsTypeExp = explode(",", $memberIdsType);
    $memberIdsTypeExpUnique = array_unique($memberIdsTypeExp);
    $memberIdsTypeGAray = array();
    foreach($memberIdsTypeExpUnique as $memVal){
      $memberIdsTypeGAray[] = "c.member_id like '%$memVal%'";
    }
    $memberIdsTypeImplode = implode(" or ",$memberIdsTypeGAray);
    
    $COMPANY_DATA_ARRAY = array();
    
    $sql_delegate = mysqli_query($con,"select c.id as companyId, c.name as companyName,c.country as companyCountry, concat(p.id) as pId, concat(p.name) as participantName,p.photo as participantPhoto,p.meeting_location as meetingLocation,p.designation as designation FROM ".$prefix."O2O_Pre_Companies as c INNER JOIN ".$prefix."O2O_Pre_Participants as p on c.id=p.company_id where p.id in($t_participantId) and ($memberIdsTypeImplode) and c.id=$t_companyId");
    while($fetchDelegate = mysqli_fetch_assoc($sql_delegate)){
    }
    
}



function delegateListFun($companyId){
    global $con,$prefix;
    
    $sqlGetCompanyMemberType = "select member_id FROM ".$prefix."O2O_Pre_Companies where id=$companyId";
    $sqlCompanyMemberType = mysqli_query($con,$sqlGetCompanyMemberType) or die(mysqli_error($con));
    $rowCompanyMemberType = mysqli_fetch_array($sqlCompanyMemberType);
    $company_member_id = $rowCompanyMemberType['member_id'];
    
    $sqlGetMemberType = mysqli_query($con,"select GROUP_CONCAT(utility) as memberIds from ".$prefix."O2O_Member_Types where id in ($company_member_id)");
    $fetchGetMemberType = mysqli_fetch_assoc($sqlGetMemberType);
    $memberIdsType = $fetchGetMemberType['memberIds'];
    $memberIdsTypeExp = explode(",", $memberIdsType);
    $memberIdsTypeExpUnique = array_unique($memberIdsTypeExp);
    $memberIdsTypeGAray = array();
    foreach($memberIdsTypeExpUnique as $memVal){
      $memberIdsTypeGAray[] = "c.member_id like '%$memVal%'";
    }
    $memberIdsTypeImplode = implode(" or ",$memberIdsTypeGAray);
    
    // and ($memberIdsTypeImplode)
    
    $FILTER_ARRAY = $country_filter = $companyName_filter = $timezone_filter = $DELEGATE_LIST_ARRAY = array();
    
    $SQL = "SELECT *,t.id as t_id FROM ".$prefix."O2O_Pre_Table as t, ".$prefix."O2O_Pre_Participants as p where p.company_id!=$companyId and p.confirmTimezone=1 and p.confirmProfile=1 and p.confirmAvailablity=1";
    $sqlTable = mysqli_query($con,$SQL); //
    while($fetchTable = mysqli_fetch_assoc($sqlTable)){
        $t_participantId = $fetchTable['participant_id'];
        $t_companyId = $fetchTable['company_id'];
        $t_id = $fetchTable['t_id'];
    
        $sql_delegate = mysqli_query($con,"select c.name as cname,c.country as ccountry, concat(p.name) as pname,p.photo as delPhoto,concat(p.id) as pId,p.meeting_location as meetingLocation,p.designation as designation FROM ".$prefix."O2O_Pre_Companies as c INNER JOIN ".$prefix."O2O_Pre_Participants as p on c.id=p.company_id where p.id in($t_participantId) and ($memberIdsTypeImplode) and c.id=$t_companyId");
        while($fetchDelegate = mysqli_fetch_assoc($sql_delegate)){
            $exp_country = explode(",",$fetchDelegate['ccountry']);
            foreach($exp_country as $k => $v){
                $country_filter[] = $v;
            }
            $companyName_filter[] = $fetchDelegate['cname'];
            $timezone_filter[] = $fetchDelegate['meetingLocation'];
            
            $DELEGATE_LIST_ARRAY[$t_id] = array(
                                        "delPhoto" => $fetchDelegate['delPhoto'],
                                        "delCountry" => $fetchDelegate['ccountry'],
                                        "delCompanyId" => $t_companyId,
                                        "delCompanyName" => $fetchDelegate['cname'],
                                        "delegateId" => $fetchDelegate['pId'],
                                        "delgateName" => $fetchDelegate['pname'],
                                        "delFullName" => $fetchDelegate['ccountry'].": ".$fetchDelegate['cname']." - ".$fetchDelegate['pname'],
                                        "delTimezone" => $fetchDelegate['meetingLocation'],
                                        "designation" => $fetchDelegate['designation']
                                    );
        }
        
        $delCountry_unique = array_unique($country_filter);
        $delCompanyName_unique = array_unique($companyName_filter);
        $delTimezone_unique = array_unique($timezone_filter);
        
        asort($delCountry_unique);
        asort($delCompanyName_unique);
        asort($delTimezone_unique);
        
        $FILTER_ARRAY['delCountry'] = $delCountry_unique;
        $FILTER_ARRAY['delCompanyName'] = $delCompanyName_unique;
        $FILTER_ARRAY['delTimezone'] = $delTimezone_unique;
        
        $DELEGATE_ARRAY['filterOption'] = $FILTER_ARRAY;
    }
    
    asort($DELEGATE_LIST_ARRAY);
    $DELEGATE_ARRAY['DELEGATE_LIST_ARRAY'] = $DELEGATE_LIST_ARRAY;
    //echo "<pre>"; print_r($DELEGATE_ARRAY); echo "</pre>";
    return $DELEGATE_ARRAY;
}

function filterFun(){
    global $con,$prefix;
    
    $SQL = "SELECT *,t.id as t_id FROM ".$prefix."O2O_Pre_Table as t, ".$prefix."O2O_Pre_Participants as p where p.confirmTimezone=1 and p.confirmProfile=1 and p.confirmAvailablity=1";
    
    $FILTER_ARRAY = $country_filter = $companyName_filter = $timezone_filter = array();
    $sqlTable = mysqli_query($con,$SQL);
    while($fetchTable = mysqli_fetch_assoc($sqlTable)){
        $t_participantId = $fetchTable['participant_id'];
        $t_companyId = $fetchTable['company_id'];
        
        $sql_delegate = mysqli_query($con,"select c.name as cname,c.country as ccountry,p.meeting_location as meetingLocation FROM ".$prefix."O2O_Pre_Companies as c INNER JOIN ".$prefix."O2O_Pre_Participants as p on c.id=p.company_id where p.id in($t_participantId) and c.id=$t_companyId ");
        while($fetchDelegate = mysqli_fetch_assoc($sql_delegate)){
            $exp_country = explode(",",$fetchDelegate['ccountry']);
            foreach($exp_country as $k => $v){
                $country_filter[] = $v;
            }
            $companyName_filter[] = $fetchDelegate['cname'];
            $timezone_filter[] = $fetchDelegate['meetingLocation'];
        }
    }
    
    $delCountry_unique = array_unique($country_filter);
    $delCompanyName_unique = array_unique($companyName_filter);
    $delTimezone_unique = array_unique($timezone_filter);
    
    asort($delCountry_unique);
    asort($delCompanyName_unique);
    asort($delTimezone_unique);
    
    $FILTER_ARRAY['delCountry'] = $delCountry_unique;
    $FILTER_ARRAY['delCompanyName'] = $delCompanyName_unique;
    $FILTER_ARRAY['delTimezone'] = $delTimezone_unique;
    
    //echo "<pre>"; print_r($FILTER_ARRAY); echo "</pre>";
    return $FILTER_ARRAY;
}

function userScheduler($timezone,$get_date_scheduler,$LoginTableId){
    
    global $con,$prefix,$event_timezone,$concurrent_meeting;
    
    date_default_timezone_set($timezone);
    
    $where = "where (table_id='$LoginTableId' or scheduled_with_table_id='$LoginTableId') AND blockd='0' ";
    $SQL_alreadyMeetingData = mysqli_query($con,"SELECT GROUP_CONCAT(IF(table_id=$LoginTableId,scheduled_with_table_id,table_id)) as alreadyMeetingWith FROM ".$prefix."O2O_Pre_Scheduledmeetings $where"); //Select('O2O_Pre_Scheduledmeetings', '*', $where);
    $NUM_alreadyMeetingData = mysqli_num_rows($SQL_alreadyMeetingData);
    $FETCH_alreadyMeetingData = mysqli_fetch_assoc($SQL_alreadyMeetingData);
    $alreadyMeetingWith = $FETCH_alreadyMeetingData['alreadyMeetingWith'];
    
    if($get_date_scheduler=='all'){
        $ConferenceslotArray_new = mysqli_query($con,"Select * from ".$prefix."O2O_Pre_Conferenceslots order by date,`start_time` ASC");
    }else{
        $get_schedule_date = $get_date_scheduler." 00:00";
        $get_date_start_scheduler = strtotime($get_schedule_date);
        $get_date_end_scheduler = $get_date_start_scheduler+(3600*24);
        
        $conferenceslot_id_concat = array();
        $ConferenceslotArray_new = mysqli_query($con,"SELECT id FROM ".$prefix."O2O_Pre_Conferenceslots where purpose!='one to one meeting' AND start_time>='$get_date_start_scheduler' and end_time<'$get_date_end_scheduler' order by date,`start_time` ASC");
        while($Conferenceslot_new = mysqli_fetch_assoc($ConferenceslotArray_new)){
            $conferenceslot_id_concat[] = $Conferenceslot_new['id'];
        }
        
        $getConferenceIds = mysqli_query($con,"SELECT conferenceslot_id from ".$prefix."O2O_Pre_Meetingslots where start_time>='$get_date_start_scheduler' and end_time<'$get_date_end_scheduler' group by conferenceslot_id order by `start_time` ASC");
        while($getConferenceIds_fetch = mysqli_fetch_assoc($getConferenceIds)){
            $conferenceslot_id_concat[] = $getConferenceIds_fetch['conferenceslot_id'];
        }
        
        $conferenceslot_id_list = implode(",",$conferenceslot_id_concat);
        $dateArray = array();
        $ConferenceslotArray_new = mysqli_query($con,"SELECT * FROM ".$prefix."O2O_Pre_Conferenceslots where id in($conferenceslot_id_list)  order by date,`start_time` ASC");
    }
    while($Conferenceslot_new = mysqli_fetch_assoc($ConferenceslotArray_new)){
        $purpose = $Conferenceslot_new['purpose'];
        $confID = $Conferenceslot_new['id'];
        
        $start_time = $Conferenceslot_new['start_time'];
        $dateFormat = date("d F Y",$start_time);
        
        if($purpose=='one to one meeting'){
            
            $newOne2oneArray = array();
            
            $MeetingSlotArray_new = mysqli_query($con,"Select * from ".$prefix."O2O_Pre_Meetingslots where conferenceslot_id='$confID' and start_time>='$get_date_start_scheduler' and end_time<'$get_date_end_scheduler' order by `start_time` ASC");
            while($MeetingSlot_new = mysqli_fetch_assoc($MeetingSlotArray_new)){
                $start_time1 = $MeetingSlot_new['start_time'];
                $dateFormat1 = date("d F Y",$start_time1);
                
                $meetingSlotId = $MeetingSlot_new['id'];
                
                $SQL_CONCURRENT_COUNT = mysqli_query($con,"Select id from ".$prefix."O2O_Pre_Scheduledmeetings where blockd not like '1' and meetingslots_id='$meetingSlotId'");
                $NUM_CONCURRENT_COUNT = mysqli_num_rows($SQL_CONCURRENT_COUNT);
                
                $SQL_SCHEDULE_TABLE_IDS = mysqli_query($con,"Select GROUP_CONCAT(DISTINCT(table_id)) as table_ids, GROUP_CONCAT(DISTINCT(scheduled_with_table_id)) as sch_table_ids from ".$prefix."O2O_Pre_Scheduledmeetings where blockd not like '1' and meetingslots_id='$meetingSlotId'");
                $FETCH_TABLE_IDS = mysqli_fetch_assoc($SQL_SCHEDULE_TABLE_IDS);
                $table_ids = $FETCH_TABLE_IDS['table_ids'];
                $sch_table_ids = $FETCH_TABLE_IDS['sch_table_ids'];
                $table_ids_exp = explode(",",$table_ids);
                $sch_table_ids_exp = explode(",",$sch_table_ids);
                $alreadyMeetingWithExp = explode(",",$alreadyMeetingWith);
                
                $all_table_ids_array = array_unique (array_merge ($table_ids_exp, $sch_table_ids_exp,$alreadyMeetingWithExp));
                $all_table_id_list = implode(",",$all_table_ids_array);
                $MeetingSlot_new['unavailableTableIds'] = $all_table_id_list;
                $MeetingSlot_new['meetingCountSlot'] = $NUM_CONCURRENT_COUNT;
                
                if($dateFormat == $dateFormat1){
                    $newOne2oneArray['one2one_new'][] = $MeetingSlot_new;
                }else{
                    if(!empty($newOne2oneArray)){
                        $dateArray[$dateFormat][] = $newOne2oneArray;
                    }
                    $dateFormat = $dateFormat1;
                    $newOne2oneArray = array();
                    $newOne2oneArray['one2one_new'][] = $MeetingSlot_new;
                }
                        
            }
            
            $dateArray[$dateFormat][] = $newOne2oneArray;
        }else{
            $dateArray[$dateFormat][] = $Conferenceslot_new;
        }
    }
    return $dateArray;
}

function scheduleMeetingPageFun(){
    
}

function participantListFun($login_companyId){
    global $con,$prefix;
    
    $DELEGATE_ARRAY = delegateListFun($login_companyId);
}

?>