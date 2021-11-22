<table align="center"  width="98%" border="0" cellspacing="0" cellpadding="0" >
    <tr>
        <td align="center">
            <?php
            $s_1 = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Participants where company_id='$login_companyId'") or die(mysqli_error($con));
            $num_1 = mysqli_num_rows($s_1);
            
            while($f_1 = mysqli_fetch_assoc($s_1)){
            ?>
                <form action="" method="post">
                    <input type="hidden" value="<?php echo $f_1['meeting_location']."###".$f_1['id']."###".$f_1['loginAttempt'];?>" name="meeting_location">
                    <input type="submit" name="set_location" class="report_page" value='Proceed with <?php echo '"'.$f_1['name'].'"';?> ' />
                </form>
                <br/><br/>
            <?php  
            }
            ?>
        </td>
    </tr>
</table>

<?php
if(isset($_POST['set_location'])){
    $m_location_Exp = explode("###",$_POST['meeting_location']);
    $m_location = $m_location_Exp[0];
    $m_delegate_id = $m_location_Exp[1];
    $m_login_attempt = $m_location_Exp[1];
    $_SESSION['delegate_location'] = $m_location;
    $_SESSION['delegate_active_user_id'] = $m_delegate_id;
    $_SESSION['temp_loginAttempt'] = $m_login_attempt;
    
    $location="?page=schedule_your_meetings0";
    redirect($location);
    
    //header("Location: ../?page=schedule_your_meetings0"); exit();
}
?>