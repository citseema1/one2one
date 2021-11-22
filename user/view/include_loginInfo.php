<?php if($login_total_parti_of_company>1){ ?>
    <div align="center">
        <span class="blue b f14 f16" >Multiple delegates from your company can schedule their own meetings during this event. <a href="?page=set_meetings" style="color:#42B7E7; text-decoration:none; ">CLICK HERE TO CHANGE DELEGATE</a></span>
    </div>
<?php } 

$show_part_name_exp = explode(" ",$_SESSION['loginParticipantName']);
?>

<div class="row" >
    <div class="col-md-offset-3 col-sm-offset-2 col-md-3 col-sm-4 col-xs-12">
        <div class="loggedInfo">
            <span>Logged-in as <?php echo $show_part_name_exp[0]; ?> 
                <?php if($NUM_RECORD_ACTIVE_PART>1){ ?>
                    <a href="?page=proceed_with_delegate"><span class="changeDelegateCls">(Change Delegate)</span></a>
                <?php } ?>
            </span>
            <p class="loginInfoOther">Country: <?php echo $login_company_country; ?></p>
        </div>
    </div>
    
    <div class="col-md-4 col-sm-5 col-xs-12">
        <div class="myTimer">
            <span class="loginInfoOther">Timezone: <?php echo $login_meeting_location." (".$login_country_utc; ?>)</span>
            <span class="digital-clock"><?php echo "Local Time: ".date('D, d M Y H:i:s'); ?></span>
        </div>
    </div>
</div>
<div align="center" style="padding:10px;display:none;">
    <span class="blue b f14 f16" >Logged in as:</span>
    <font color="#178DAA" style="font-weight:bold;font-size:16px;"> <i><?php echo $login_participant_name;?></i></font>
    <font color="#178DAA" style="font-size:16px;"> <i><?php echo ' From '.$login_company_name." - ".$login_country?>&nbsp; &nbsp;</i>
    <?php
        if($main_table_no1>0){
            echo '(Assigned Table#: '.$main_table_no1.')';
        }
    ?>
    </font>
</div>
<!--<br/>-->
<style>
/*.loggedInfo{
    left: 20px;
    margin-top: -20px;
    background-color: #fff;
    position: absolute;
    padding: 8px 9px;
    box-shadow: 0px 0px 0px 0px;
}*/

.digital-clock{
    /*color: #EA4642;
    font-size: 15px;
    font-weight: bold;*/
    background-color: lightgoldenrodyellow;
    display: inline !important;
    padding: 5px 3px;
    margin-top: 40px !important;
}

.loggedInfo span {
    display: block;
    font-size: 14px;
    color: black;
    font-weight: bold;
    line-height: 25px;
}

/*, .myTimer span*/
.loginInfoOther, .myTimer span{
    display: block;
    color: black;
    margin-bottom: 6px;
}

.changeDelegateCls{
    color: #4b77be !important;
    font-size: 10px !important;
    display: inline !important;
    cursor:pointer;
}
</style>