<?php
$login_companyId = $_SESSION['loginCompanyId'];

$LOGIN_USER_SESSION = $_SESSION['LOGIN_USER_SESSION'];
if(isset($LOGIN_USER_SESSION['loginTableId'])){
    $_SESSION['loginTableId'] = $LOGIN_USER_SESSION['loginTableId']; 
}

if(isset($_SESSION['loginCompanyId'])){
    $login_companyId = $_SESSION['loginCompanyId'];
    $sql_comp_exe = "SELECT * FROM ".$prefix."O2O_Pre_Companies WHERE id=$login_companyId";
    $sql_comp_return = getResultDataFun($sql_comp_exe);
    $SUCCESS_ACTIVE_COMP = $sql_comp_return['success'];
    $ACTIVE_COMPANY_RESULT = $sql_comp_return['result'][0];
    
    $login_company_logo = $_SESSION['login_company_logo'] = $ACTIVE_COMPANY_RESULT['logo'];
    $login_company_name = $_SESSION['login_company_name'] = $ACTIVE_COMPANY_RESULT['name'];
    $login_company_country = $_SESSION['login_company_name'] = $ACTIVE_COMPANY_RESULT['country'];
    
    $sql_comp_part_exe = "SELECT * FROM ".$prefix."O2O_Pre_Participants WHERE company_id=$login_companyId";
    $sql_comp_part_return = getResultDataFun($sql_comp_part_exe);
    $NUM_RECORD_ACTIVE_PART = $sql_comp_part_return['numRecord'];
    if($NUM_RECORD_ACTIVE_PART==1){
        $ACTIVE_PARTICIPANT_RESULT = $sql_comp_part_return['result'][0];
        $_SESSION['activeParticipantId'] = $ACTIVE_PARTICIPANT_RESULT['id'];
    }
    
    
    if(isset($_SESSION['activeParticipantId'])){
        $login_activeParticipantId = $_SESSION['activeParticipantId'];
        $sql_part_exe = "SELECT * FROM ".$prefix."O2O_Pre_Participants WHERE id=$login_activeParticipantId";
        $sql_part_return = getResultDataFun($sql_part_exe);
        $SUCCESS_ACTIVE_PART = $sql_part_return['success'];
        if($SUCCESS_ACTIVE_PART==1){
            //$NUM_RECORD_ACTIVE_PART = $_SESSION['NUM_RECORD_ACTIVE_PART'] = $sql_part_return['numRecord'];
            
            $ACTIVE_PARTICIPANT_RESULT = $sql_part_return['result'][0];
            
            $_SESSION['activeParticipantId'] = $ACTIVE_PARTICIPANT_RESULT['id'];
            $_SESSION['loginParticipantName'] = $ACTIVE_PARTICIPANT_RESULT['name'];
            $login_meeting_location = $_SESSION['activeMeetingLocation'] = $ACTIVE_PARTICIPANT_RESULT['meeting_location'];
            $login_confirmTimezone = $_SESSION['login_confirmTimezone'] = $ACTIVE_PARTICIPANT_RESULT['confirmTimezone'];
            $login_confirmProfile = $_SESSION['login_confirmProfile'] = $ACTIVE_PARTICIPANT_RESULT['confirmProfile'];
            $login_confirmAvailablity = $_SESSION['login_confirmAvailablity'] = $ACTIVE_PARTICIPANT_RESULT['confirmAvailablity'];
        }
    }
    else{
        $include = "view/proceed_with_delegate.php";
    }
    
    
        
       /* $_SESSION['activeParticipantId'] = $ACTIVE_PARTICIPANT_RESULT['id'];
        $_SESSION['loginParticipantName'] = $ACTIVE_PARTICIPANT_RESULT['name'];
        $login_meeting_location = $_SESSION['activeMeetingLocation'] = $ACTIVE_PARTICIPANT_RESULT['meeting_location'];
        $login_confirmTimezone = $_SESSION['login_confirmTimezone'] = $ACTIVE_PARTICIPANT_RESULT['confirmTimezone'];
        $login_confirmProfile = $_SESSION['login_confirmProfile'] = $ACTIVE_PARTICIPANT_RESULT['confirmProfile'];
        $login_confirmAvailablity = $_SESSION['login_confirmAvailablity'] = $ACTIVE_PARTICIPANT_RESULT['confirmAvailablity'];*/
        
        //$NUM_RECORD_ACTIVE_PART = $_SESSION['NUM_RECORD_ACTIVE_PART'];
        
        /*$login_meeting_location = $_SESSION['activeMeetingLocation'];
        $login_confirmTimezone = $_SESSION['login_confirmTimezone'];
        $login_confirmProfile = $_SESSION['login_confirmProfile'];
        $login_confirmAvailablity = $_SESSION['login_confirmAvailablity'];*/
        
    /*}else{
        $sql_part_exe = "SELECT * FROM ".$prefix."O2O_Pre_Participants WHERE company_id=$login_companyId";
        $sql_part_return = getResultDataFun($sql_part_exe);
        $SUCCESS_ACTIVE_PART = $sql_part_return['success'];
        if($SUCCESS_ACTIVE_PART==1){
            $NUM_RECORD_ACTIVE_PART = $_SESSION['NUM_RECORD_ACTIVE_PART'] = $sql_part_return['numRecord'];
            if($NUM_RECORD_ACTIVE_PART==1){
                $ACTIVE_PARTICIPANT_RESULT = $sql_part_return['result'][0];
                
                $_SESSION['activeParticipantId'] = $ACTIVE_PARTICIPANT_RESULT['id'];
                $_SESSION['loginParticipantName'] = $ACTIVE_PARTICIPANT_RESULT['name'];
                $login_meeting_location = $_SESSION['activeMeetingLocation'] = $ACTIVE_PARTICIPANT_RESULT['meeting_location'];
                $login_confirmTimezone = $_SESSION['login_confirmTimezone'] = $ACTIVE_PARTICIPANT_RESULT['confirmTimezone'];
                $login_confirmProfile = $_SESSION['login_confirmProfile'] = $ACTIVE_PARTICIPANT_RESULT['confirmProfile'];
                $login_confirmAvailablity = $_SESSION['login_confirmAvailablity'] = $ACTIVE_PARTICIPANT_RESULT['confirmAvailablity'];
                
            }else{
                $include = "view/set_meetings.php";
                $include = "view/proceed_with_delegate.php";
            }
        } 
    }*/
}

//echo $login_meeting_location;
date_default_timezone_set($login_meeting_location);
$login_country_utc = "UTC ".date('P');
$login_country_utcExplode = explode("UTC",$login_country_utc);

$login_time_info = getdate();
$login_currentTimeStr = $login_time_info[0];

$js_utc = 0;
$login_country_utcTime = $login_country_utcExplode[1];
if($login_country_utcTime!=""){
	$login_country_utcTimeExplode = explode(":",$login_country_utcTime);
	$login_country_utcTime_Hour = $login_country_utcTimeExplode[0];
	$login_country_utcTime_Min = $login_country_utcTimeExplode[1];
	$login_country_utcTime_Min_new = 0;
	if($login_country_utcTime_Min==30){
	    $login_country_utcTime_Min_new = 0.5;
	}
	if($login_country_utcTime_Min==45){
		$login_country_utcTime_Min_new = 0.75;
	}
	$js_utc = $login_country_utcTime_Hour+$login_country_utcTime_Min_new;
}

//echo $js_utc;

//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//echo $login_confirmTimezone." >> ".$login_confirmProfile." >> ".$login_confirmAvailablity;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta name=viewport content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <title>One2One Meeting Scheduler - <?php echo $short_company_name; ?> <?php echo date('Y'); ?></title>
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet"  href="user/templates/css/simpleGrid.css" />
        <link rel="stylesheet"  href="user/templates/css/boot.css" />
        <link rel="stylesheet"  href="user/templates/css/custom.css" />
        <link rel="stylesheet" type="text/css" href="user/templates/css/menu.css">
        <link rel="stylesheet" type="text/css" href="user/templates/css/style-new.css">

        <link rel="stylesheet" type="text/css" href="user/templates/calibri-font/font.css">
        <link rel="stylesheet" type="text/css" href="user/templates/font-awesome-4.7.0/css/font-awesome.min.css">

        <!-- menu css js -->     
        <link rel="stylesheet" href="user/templates/css/jquery.alerts.css">
        <link href="user/templates/css/toastr.css" rel="stylesheet" type="text/css" /> 
        <link rel="stylesheet" href="user/templates/css/jquery.loadingModal.css"> 
        <script src="user/templates/js/jquery-3.3.1.min.js" ></script>   
        <script src="user/templates/js/jquery.alerts.js" ></script>
        <!--<script type="text/javascript" src="admin/templates/js1/script.js"></script>-->
        
        <script type="text/javascript" src="user/templates/js/ajax.js"></script>
        <script type="text/javascript" src="user/templates/js/function.js"></script>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="user/templates/bootstrap-select/dist/css/bootstrap-select.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="user/templates/bootstrap-select/dist/js/bootstrap-select.js"></script>
        
        <script type="text/javascript" src="user/templates/highslide/highslide-with-html.js"></script>
        <link rel="stylesheet" type="text/css" href="user/templates/highslide/highslide.css" />
        <script type="text/javascript">
        hs.graphicsDir = 'user/templates/highslide/graphics/';
        hs.outlineType = 'rounded-white';
        hs.wrapperClassName = 'draggable-header';
        </script>

        <style type="text/css">
        /*.myTimer {
            right: 20px;
            margin-top: -20px;
            background-color: #fff;
            position: absolute;
            padding: 0px 15px;
        }*/
        
        
        .timezoneTag_MenuHide, .profileTag_MenuHide, .availabilityTag_MenuHide{
            display: none;
        }
        .second_third_stepHide, .first_third_stepHide, .first_second_stepHide{
            display:none;
        }
        
        .allSteps {
            text-align: center;
            padding: 10px 0px;
        }
        .stepSpan{
            display:block;
            font-size: 25px;
            color: black;
            text-transform: uppercase;
        }
        .stepText {
            font-size: 18px;
        }
        .allSteps .editImg img {
            width: 20px !important;
            vertical-align: sub;
        }
        
        .editImg img{
            font-size: 12px;
            vertical-align: baseline;
        }
        
        .actionText{
            vertical-align: text-bottom;
            color: #43B7E8;
            font-size: 11px;
            font-weight: 700;
            cursor:pointer;
        }

        </style>
    </head>
    <body>
        <div class="wrapper">
            <?php
            if($_SESSION['table_admin']!="admin_flag"){
                include "heading.php";
            }
            ?>
            
            <?php if(isset($_SESSION['activeParticipantId'])){ ?>
                <div class="menuMainCls <?php echo $timezoneCSS.' '.$profileCSS.' '.$availabilityCSS; ?>">
                    <?php include "view/include_menu.php"; ?>
                </div>
            <?php } ?>
            
            <?php if(!isset($_SESSION['loginCompanyId'])){ ?>
                <?php include "view/login.php"; ?>
            <?php } else{ ?>

                <div id="page-wrapper">
                <?php if($close_ind==1){ ?>
                    <div style="color:#FF0000;font-size:14px; padding:10px;" align="center"><strong>"<?php echo $short_company_name;?>"</strong> one2one meeting scheduler is now closed for <strong >&quot;<?=$title?>&quot;</strong> meetings. However, you can still log-in into the system and download your Final meeting report.</div><br />
                <?php  } ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12  mt body_con">
                                <?php //include "view/include_heading.php"; ?>
                                <?php if(isset($_SESSION['activeParticipantId'])){ ?>
                                    <?php include("view/include_loginInfo.php"); ?>
                                <?php } ?>
                                <div class="portlet-body">
                                    <div class="table-scrollable1">
                                        <?php //include("view/include_loginInfo.php"); ?>
                                        <!--<div id="mainDivData">-->
                                        <?php include($include); ?>
                                        <!--</div>-->
                                    </div>
                                </div>
                                
    
                                <?php
                                $select23  = mysqli_query($con,'select * from '.$prefix.'O2O_Sponsors_Details');
                                $fet23 =  mysqli_fetch_array($select23);
                                if($fet23['logo']==""){
                                    //echo '<br><br><br><br>';
                                }
                                if($session_id!=""){ 
                                    if($fet23['logo']!=""){  
                                ?> 
                                        <div class="cl"></div>
                                <?php   if(isset($_SESSION[$unique_user]) && !empty($_SESSION[$unique_user])) {
                                            //include "view/include_sponsor.php";
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        
    <?php if(isset($_SESSION['activeParticipantId'])){ ?>

        <script type="text/javascript">
            function showCurrentTime(incr){
                js_utc = <?php echo $js_utc; ?>;
                if(incr==0){
                    s_t = <?php echo $login_currentTimeStr ?>;
                }else{
                    s_t = s_t + incr;
                }
                //console.log(s_t);
				
				var d = new Date(s_t * 1000);
				var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
				var date = new Date(utc + (3600000*js_utc));

				//$('.digital-clock').css({'float': 'right', 'color': '#000', 'text-shadow': '0 0 6px #ff0'});

				var day = date.getDate();
				var mon = date.toLocaleString('default', { month: 'short' }); //date.getMonth();
				var weekday = date.toLocaleString('default', { weekday: 'short' });
				var year = date.getFullYear();
				var h = date.getHours(); //addZero(twelveHour(date.getHours()));
				var m = date.getMinutes(); //addZero(date.getMinutes());
				var s = date.getSeconds(); //addZero(date.getSeconds());

				day = ("0" + day).slice(-2);
				h = ("0" + h).slice(-2);
				m = ("0" + m).slice(-2);
				s = ("0" + s).slice(-2);

				show_running_time = "Local Time: "+weekday+", "+day + " " + mon +" " + year + " " + h + ":" + m + ":" + s;
				$('.digital-clock').text(show_running_time);
				//console.log(msg_start_time);
            }
            
            $(document).ready(function() {
                showCurrentTime(0);
                setInterval( function() { showCurrentTime(1); }, 1000 );
            });
        </script>
    <?php } ?>
    </body>
    
</html>