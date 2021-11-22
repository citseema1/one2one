<p class="blue b f14" style="background: none repeat scroll 0 0 rgb(68, 182, 174); color: rgb(255, 255, 255); padding: 10px; font-weight:bold;"> Click on appropriate button below:
</p>
<br/><br/>

<?php
// $sql_part_exe = "SELECT * FROM ".$prefix."O2O_Pre_Participants WHERE company_id=$login_companyId order by id";
// $sql_part_return = getResultDataFun($sql_part_exe);

$sql = mysqli_query($con, "SELECT * FROM ".$prefix. "O2O_Pre_Participants WHERE company_id='$login_companyId' order by id") or die(mysqli_error($con));
while ($data_table = mysqli_fetch_array($sql)) {
    $checked = '';
    $participant_id = $data_table['id'];
    $participant_name = $data_table['name'];
    
    $SQL_TABLE = mysqli_query($con,"SELECT * FROM ".$prefix. "O2O_Pre_Table WHERE FIND_IN_SET($participant_id,participant_id) and company_id='$login_companyId'");
    $FETCH_TABLE = mysqli_fetch_assoc($SQL_TABLE);
    $active_table_id = $FETCH_TABLE['id'];
    $BoothName = '';
    $BoothID   = '';
    $sql_1 = mysqli_query($con, "SELECT * FROM ".$prefix."O2O_booth_details WHERE participant_id='$participant_id'");
    
    $res_booth = mysqli_fetch_array($sql_1);
    $BoothID = $res_booth['id'];
    $BoothName = $res_booth['booth_name'];
    
    $req_url = "user/model/change_delegate_model.php?active_participant_id=".$participant_id."&active_table_id=".$active_table_id;
?>
    <p class="select_procced_button">
        <input type="button" name="" class="report_page" value="Proceed to schedule meeting for <?php echo $participant_name; ?>" onclick="window.location.href='<?php echo $req_url; ?>'"/>&nbsp;
    </p>
    <br/><br/>
<?php } ?>

<style>
.select_procced_button{
    text-align:center;
}
</style>