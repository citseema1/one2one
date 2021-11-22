<script src="admin/templates/js1/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function() {
     jQuery("#validation").validate({});
});
    
function finish_grouping(val){
    window.location = 'user/model/group_check.php?finish_id='+val;    
}
</script>  

<style type="text/css">
.error{
   color:red;    
}
.succ_group{
    color: #006633;
    font-weight: bold;
    margin-left: 10px;    
}
</style>
<?php
session_start();

if (isset($_SESSION[$unique_user]) && $_SESSION[$unique_user] != "") {
    if ($num_pre_part > $num_pre_table && $set_group == 0) {
        for ($t1 = 1; $t1 <= $table_required12; $t1++) {
            mysqli_query($con, "CREATE TABLE IF NOT EXISTS  " . $prefix . "temp_group (ID INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(ID), name VARCHAR(255), comp_id VARCHAR(255))");
            $se_temp_group = mysqli_query($con, "select * from " . $prefix . "temp_group where name='group" . $t1 . "' and comp_id='" . $_SESSION['com_id'] . "'") or die(mysqli_error($con));
            
            if (mysqli_num_rows($se_temp_group) == 0) {
                mysqli_query($con, "insert into " . $prefix . "temp_group (name,comp_id)values('group" . $t1 . "','" . $_SESSION['com_id'] . "')") or die(mysqli_error($con));
            }
        }
        
        mysqli_query($con, "CREATE TABLE IF NOT EXISTS  " . $prefix . "O2O_Participants_Grouping (ID INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(ID), name VARCHAR(255), company_id INT(11), part_id INT(11))");
        
?>
       <form method="post" action="user/model/group_check.php" id="validation" name="validation">
            <?php
            if (isset($_SESSION['SetMessage'])) {
                echo GetMessage();
            }
            
            $se_14 = mysqli_query($con, "select * FROM ".$prefix."O2O_Participants_Grouping where  part_id in($participant_id_list) and company_id='$login_companyId'") or die(mysqli_error($con));
            $remaing_participant1 = mysqli_num_rows($se_14);
            
            if ($remaing_participant1 > 0) {
    ?>
               <table align="center"  width="98%" border="0" cellspacing="0" cellpadding="0" >
                <?php
                while ($fet_14 = mysqli_fetch_array($se_14)) {
                    $sel_part_15 = mysqli_query($con, "select * from " . $prefix . "O2O_Pre_Participants where id='" . $fet_14['part_id'] . "'");
                    $fet_part_15 = mysqli_fetch_array($sel_part_15);
    ?>
                   <tr>
                        <td align="center">
                            <input type="button" name="" class="report_page" value='Participant <?php echo '"' . $fet_part_15['name'] . '"'; ?> is assigned in <?php echo '"' . ucfirst($fet_14['name']) . '"'; ?>' /> 
                            <a href="user/model/group_check.php?del_group=<?php echo $fet_14['ID']; ?>" onclick="return confirm('Are you sure want to continue it?')">
                                <img src="admin/templates/images/delete1.gif" />
                            </a>
                        </td>
                    </tr>
            <?php } ?>
               </table>
    <?php
            }
            
            $se_140 = mysqli_query($con, "select * from ".$prefix."O2O_Participants_Grouping where company_id='$login_companyId'") or die(mysqli_error($con));
            $active_gruorp_set = mysqli_num_rows($se_140);
            $flag = 0;
            
            if ($num_pre_part == $active_gruorp_set) {
                $flag = 1;
            }
    
            //$s11 = mysqli_query($con,"select * from ".$prefix."temp_group where comp_id='".$_SESSION['com_id']."'");
            //$num_s11 = mysqli_num_rows($s11)-1;
    
            $s_1 = mysqli_query($con, "select * from ".$prefix."O2O_Pre_Participants where company_id='$login_companyId'") or die(mysqli_error($con));
            $num_1 = mysqli_num_rows($s_1);
            
            $num_2 = $table_required12;
            //, GROUP_CONCAT(part_id) as partId 
            $s_2 = mysqli_query($con, "select GROUP_CONCAT(DISTINCT(name)) as nameG from " . $prefix . "O2O_Participants_Grouping where company_id='$login_companyId'") or die(mysqli_error($con));
            //$s_2 = mysqli_query($con,"select name from ".$prefix."O2O_Participants_Grouping where company_id='".$_SESSION['com_id']."' gr ") or die(mysqli_error($con));
            $n_2            = mysqli_num_rows($s_2);
            $f_2            = mysqli_fetch_array($s_2);
            $grp_Name       = $f_2['nameG'];
            $grp_NameExp    = explode(",", $grp_Name);
            $grp_NameExpCnt = count($grp_NameExp);
            $rem_grp_cnt    = $num_2 - $grp_NameExpCnt;
            
    ?>
            <table align="center"  width="40%" border="0" cellspacing="0" cellpadding="0" >
            
            <?php if ($flag == 0) { ?>
                <tr>
                    <td>
                        <select name="part_sel_group" id="part_sel_group" style="height:25px; width:250px;" class="required">
                            <option value="">-- Please Select Participant Name --</option>
                            <?php
                            $new_cnt_part = 0;
                            for ($kl = 0; $kl < count($part_id_chk); $kl++) {
                                $part_1 = explode(',', $part_id_chk[$kl]);
                                for ($j = 0; $j < count($part_1); $j++) {
                                    
                                    $se_11 = mysqli_query($con, "select * from " . $prefix . "O2O_Participants_Grouping where  part_id='" . $part_1[$j] . "' and company_id='$login_companyId'") or die(mysqli_error($con));
                                    $num_rows = mysqli_num_rows($se_11);
                                    
                                    if ($num_rows == 0) {
                                        $new_cnt_part++;
                                        $se_2 = mysqli_query($con, "select * from " . $prefix . "O2O_Pre_Participants where id='" . $part_1[$j] . "'") or die(mysqli_error($con));
                                        $fet_2 = mysqli_fetch_array($se_2);
                                    ?>
                                        <option value="<?php echo $part_1[$j]; ?>" ><?php echo $fet_2['name']; ?> </option>
                                    <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td> 
                        <select name="sel_group_value" id="sel_group_value" style="height:25px; width:180px;" class="required">
                            <option value="">-- Please Select Group --</option> 
                            <?php
                            for ($t = 1; $t <= $num_pre_table; $t++) {
                                $se_13 = mysqli_query($con, "select * from " . $prefix . "O2O_Participants_Grouping where name in(select name from " . $prefix . "temp_group)  and  name='group" . $t . "' and company_id='$login_companyId'") or die(mysqli_error($con));
                                $num_rows_13 = mysqli_num_rows($se_13);
                                
                                //if($num_s11==$num_rows_13){continue;}
                                $remaing_participant = $num_pre_part - $remaing_participant1;
                                
                                $ggname = "group" . $t;
                                if ($remaing_participant == $rem_grp_cnt) {
                                    if (in_array($ggname, $grp_NameExp)) {
                                        continue;
                                    }
                                }
                                
                                if ($num_rows_13 <= $remaing_participant) { ?>
                                    <option value="group<?php echo $t; ?>" > Group <?php echo $t; ?> </option>  
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="submit" name="submit_groups"  value="Submit" class="report_page" /></td>
                </tr>
                
                <?php
            } else { ?> 
                <tr><td colspan="3"></td></tr>
                <tr>
                    <td colspan="3" align="center">
                        <input type="button" name="sub"  value="FINISH GROUPING PARTICIPANTS" class="report_page" onclick="return finish_grouping('<?php echo $_SESSION['com_id']; ?>');" />
                    </td>
                </tr>
            <?php } ?>
               
            </table>    
        </form>
<?php
    } else {
?>
        <p style="margin-left:150px;">
            <table align="center"  width="98%" border="0" cellspacing="0" cellpadding="0" >
                <tr>
                    <td class="blue b f14"  style="background: none repeat scroll 0 0 rgb(68, 182, 174); color: rgb(255, 255, 255); padding: 10px; font-weight:bold;"> Click on appropriate button below:
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>
                        <?php //print_r($_REQUEST);
                        error_reporting(0);
                        if (isset($_SESSION['SetMessage'])) { 
                            echo GetMessage();
                        }
                        ?>
                        <form name="redio_group_name" action="" method="post">
                            <table width="100%" border="0" cellspacing="0" cellpadding="4" class="text b">
                        <?php
                            $sql = mysqli_query($con, "SELECT * FROM ".$prefix. "O2O_Pre_Table WHERE company_id='$login_companyId' order by id") or die(mysqli_error($con));
                            while ($data_table = mysqli_fetch_array($sql)) {
                                $checked = '';
                
                                if ($_POST['TableID'] > 0) {
                                    if ($_POST['TableID'] == $data_table['id']) {
                                        $checked = 'checked';
                                        $TableID = $_POST['TableID'];
                                    }
                                } elseif ($a == 0) {
                                    $checked = 'checked';
                                    $TableID = $data_table['id'];
                                }
                                $part_id = $data_table['participant_id'];
                                $BoothName = '';
                                $BoothID   = '';
                                $sql_1 = mysqli_query($con, "SELECT * FROM ".$prefix."O2O_booth_details` where participant_id='$part_id'");
                                
                                $res_booth = mysqli_fetch_array($sql_1);
                                $BoothID = $res_booth['id'];
                                $BoothName = $res_booth['booth_name'];
                                
                                $new_part_id = explode(",", $part_id);
                
                                $part_name = '';
                                for ($k = 0; $k <= count($new_part_id); $k++) {
                                    $part_id = $new_part_id[$k];
                                    $qry_part1  = mysqli_query($con, "select name from " . $prefix . "O2O_Pre_Participants where id='$part_id'");
                                    $res_part1  = mysqli_fetch_array($qry_part1);
                                    $part_name2 = trim($res_part1['name']);
                                    
                                    if ($k != count($new_part_id)) {
                                        $part_name .= $part_name2 . ", " . " ";
                                    } else {
                                        $part_name .= $part_name2;
                                    }
                                }
                                $part_name = substr($part_name, 0, -3);
                                ?>
                                <tr>
                                    <td nowrap align="center">
                                        <?php
                                        $req_url = $_SERVER['REQUEST_URI'];
                                        $tempPos = strpos($req_url, 'set_meetings');
                                        $req_url = str_replace("set_meetings", 'schedule_your_meetings', $req_url);
                                        /*if ($tempPos == true) {
                                            //$req_url='schedule_your_meetings0';
                                            if ($_SESSION['table_required'] <= 1) {
                                                $req_url = str_replace("set_meetings", 'schedule_your_meetings', $req_url);
                                            } else {
                                                $req_url = str_replace("set_meetings", 'schedule_your_meetings', $req_url);
                                            }
                                        }*/
                                        ?>
                                        <input type="button" name="" class="report_page" value="Proceed to schedule meeting for <?php echo $part_name; ?>" onclick="window.location.href='<?php echo $req_url; ?>&_table_id1=<?= $data_table['id'] ?>'"/>&nbsp;
                                        <?php
                                            if ($BoothID > 0) {
                                                echo '&nbsp;[Booth: ' . $BoothName . ']&nbsp;';
                                            } elseif ($data_table['table_no'] > 0) {
                                                echo '&nbsp;[Table No: ' . $data_table['table_no'] . ']&nbsp;';
                                            }
                                        ?>
                                        <br/><br/><br/>
                                    </td>
                                </tr>
                            <?php } ?>
                            </table>
                        </form>
                    </td>
                </tr>
                <tr align="center">
                    <td id="AjaxDiv"></td>
                </tr>
          </table>
        </p>
<?php } 
} else {
    $location = "?page=login";
    redirect($location);
}
?>