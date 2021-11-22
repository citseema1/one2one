<div class="portlet-title">
    <div class="caption">
    <?php  if($page == 'schedule_your_meetings0' || $page == 'search_new'){
            echo 'Schedule Your Meetings';
        }else if($page == 'participant'){
            echo 'Delegates List';  
        }else if($page == 'report'){
            echo 'Meeting(s) Report';
        }else if($page == 'my_profile'){
            echo 'My Profile';  
        }else if($page == 'my_profile_edit_com'){
            echo 'Update Company Details';  
        }else if($page == 'my_profie_edit_part'){
            echo 'Upate Participant Details';   
        }else if($page == 'version4_help'){
            echo 'One2One Meeting Scheduler V5.0 &ndash; Help in FAQ format';
        }else if($page == 'set_meetings'){
            $part_id_chk = array();
            $pre_table_chk=mysqli_query($con,"select * from ".$prefix."O2O_Pre_Table where company_id='".$_SESSION['com_id']."'    order by id") or die(mysqli_fetch());
            $num_pre_table = mysqli_num_rows($pre_table_chk);
            while($fetch_pre_table=mysqli_fetch_array($pre_table_chk)) {
                $part_id_chk[]=$fetch_pre_table['participant_id'];
            }

            $participant_id_list1=array();
            $se_1 = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Participants where company_id='".$_SESSION['com_id']."'") or die(mysqli_error($con));
            while($fet_pre_participant = mysqli_fetch_array($se_1)){
                $participant_id_list1[] = $fet_pre_participant['id'];
            }

            $participant_id_list = implode(',',$participant_id_list1);
            $num_pre_part = mysqli_num_rows($se_1);

            $se_pre_company = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Companies where id='".$_SESSION['com_id']."'") or die(mysqli_error($con));
            $fetch_pre_company = mysqli_fetch_array($se_pre_company);
            $table_required12 = $fetch_pre_company['table_required'];
            $set_group = $fetch_pre_company['set_group'];
            if($num_pre_part>$num_pre_table && $set_group==0){
                echo 'Participant(s) <br><br> <span style="font-size:13px;">Your company has '.$num_pre_part.' participants and '.$table_required12.' meeting scheduler allocated. Please group up the participants by selecting the "Participant name" and "Group" and press "Submit" for each participant.<br><br> THIS IS ONE TIME PROCESS AND GETS COMPLETE ONCE YOU PRESS ON "FINISH GROUPING PARTICIPANTS" BUTTON.</span>';
            }else{
                echo 'Participant(s)';
            }
        } ?>
    </div>
    <div class="cl"></div>
</div>