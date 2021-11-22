<link rel="stylesheet" type="text/css" href="user/templates/css/dashboard.css">

<style>
.innerRow{
	background-color: #838791;
}
.statisticsLabel{
    margin-bottom:10px;
}
.loopItem {
    max-height: 290px;
    overflow-x: hidden;
}
</style>

<?php 

$DASHBOARD_DATA_POST = array();
$DASHBOARD_DATA_POST['get_meeting_location'] = $get_meeting_location;
$DASHBOARD_DATA_POST['loginUserTableID'] = $loginUserTableID;

$GET_DASHBOARD_DATA = dashboardDataFun($DASHBOARD_DATA_POST);
$meetingSummaryArray = $GET_DASHBOARD_DATA['meetingSummaryArray'];
$country_dataArray = $GET_DASHBOARD_DATA['country_dataArray'];
$totalCountry = $GET_DASHBOARD_DATA['totalCountry'];
$totalCompany = $GET_DASHBOARD_DATA['totalCompany'];
$totalDelegates = $GET_DASHBOARD_DATA['totalDelegates'];
// $ = $GET_DASHBOARD_DATA[''];

$timezoneStatusCls = "uncheckCls";
$timezoneStatusImg = "../../images/incomplete.png";

$completeStatusImage = "../../images/complete.jpg";

$profileStatusCls = $availablityStatusCls = "uncheckCls";
$profileStatusImg = $availablityStatusImg = "../../images/incomplete.png";

if($login_confirmTimezone==1){ 
	$timezoneStatusCls = "checkCls";
	$timezoneStatusImg = $completeStatusImage; //"../../images/complete.jpg";
} 

if($login_confirmProfile==1){ 
	$profileStatusCls = "checkCls";
	$profileStatusImg = $completeStatusImage; //"../../images/complete.jpg";
} 

if($login_confirmAvailablity==1){ 
	$availablityStatusCls = "checkCls";
	$availablityStatusImg = $completeStatusImage; //"../../images/complete.jpg";
}
?>

<?php if($login_confirmTimezone==0 || $login_confirmProfile==0 || $login_confirmAvailablity==0){ ?>
<div class="row allStepsDiv">
    <div class="col-md-offset-3 col-md-6 col-sm-12">
		<div class="mainBox summaryRow">
		    <p class="myLabel">Priority List</p>
		    <div class="divBox">
			    <div class="">
    			    <div class="allSteps firstStep <?php echo $stepHide_1_3.' '.$stepHide_1_2; ?>">
    			        <span class="stepSpan"><b>Step 1/3</b></span>
        			    <p class="stepText">Selected Timezone <span style="color: cornflowerblue;text-decoration: underline black;"><?php echo $login_meeting_location; ?> <?php echo $login_utc; ?></span>
        				    <span class="editImg" >
        				        <span class="actionText" onclick="openTimezoneBoxFun()">[Change It]</span>
        				        <!--<img onclick="openTimezoneBoxFun()" src="../../images/edit_wrong.gif" alt="">-->
        				        <img onclick="viewDashFun('timezoneTag','secondStep',<?php echo $login_participant_id;?>);" class="" src="<?php echo $completeStatusImage; ?>">
        				    </span>
        				</p>
    			    </div>
    			    <div class="allSteps secondStep <?php echo $stepHide_2_3.' '.$stepHide_1_2; ?>">
    			        <span class="stepSpan"><b>Step 2/3</b></span>
        			    <p class="stepText">Confirm My Availability
    					    <span class="editImg">
    					        <a href="user/view/ajax_user_profile.php?id=<?php echo $login_companyId; ?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax',width: 750,height: 650})">
    					            <span class="actionText">[Review]</span>
    					            <!--<img src="admin/templates/images/eye_wrong.gif" alt="">-->
    					        </a>
    					        <img onclick="viewDashFun('availabilityTag','thirdStep',<?php echo $login_participant_id;?>)" class="" src="<?php echo $completeStatusImage; ?>">
    					    </span>
    					</p>
    					<p>Block the time-slots during which you will not be available for the meeting.</p>
    			    </div>
    			    <div class="allSteps thirdStep <?php echo $stepHide_2_3.' '.$stepHide_1_3; ?>">
    			        <span class="stepSpan"><b>Step 3/3</b></span>
        			    <p class="stepText">My Profile Review
        					<span class="eyeImg editImg">
        						<a href="user/view/ajax_user_profile.php?id=<?php echo $login_companyId; ?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax',width: 750,height: 650})">
        							<span class="actionText">[Review]</span>
        							<!--<img src="admin/templates/images/eye_wrong.gif" alt="">-->
        						</a>
        						<img onclick="viewDashFun('profileTag','showAllSteps',<?php echo $login_participant_id;?>)" class="" src="<?php echo $completeStatusImage; ?>">
        					</span>
    					</p>
    					<p>Review and update your personal and company information and also record a short video introduction.</p>
    			    </div>
			    </div>
		    </div>
		</div>
	</div>
</div>

<?php } ?>

<div class="row menuMainCls <?php echo $timezoneCSS.' '.$profileCSS.' '.$availabilityCSS; ?>">
	<div class="col-md-6 col-sm-12">
		<div class="mainBox summaryRow">
			<p class="myLabel">Priority List</p>
			<div class="divBox">
			
			<div>
			<?php //if($login_confirmTimezone==1 && $login_confirmProfile==1 && $login_confirmAvailablity==1){ ?>
				<p>
					<img class="timezoneTag taskStatusImg <?php echo $timezoneStatusCls; ?>" src="<?php echo $timezoneStatusImg; ?>">
					Selected Timezone <?php echo $login_meeting_location; ?> <?php echo $login_utc; ?> 
					<span class="editImg" onclick="openTimezoneBoxFun()">
					    <span class="actionText">[Change It]</span>
					    <!--<img src="../../images/edit_wrong.gif" alt="">-->
					</span>
				</p>
				<p>
					<img class="availabilityTag taskStatusImg <?php echo $availablityStatusCls; ?>" src="<?php echo $availablityStatusImg; ?>">
					Confirm My Availability
					<span class="editImg" onclick="viewDashFun('availabilityTag',<?php echo $login_participant_id;?>)">
					    <span class="actionText">[Review]</span>
					    <!--<img  src="admin/templates/images/eye_wrong.gif" alt="">-->
					</span>
				</p>
				<p>
					<img class="profileTag taskStatusImg <?php echo $profileStatusCls; ?>" src="<?php echo $profileStatusImg; ?>">
						My Profile Review
					<span class="eyeImg">
						<a href="user/view/ajax_user_profile.php?id=<?php echo $login_companyId; ?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax',width: 750,height: 650})">
							<span class="actionText">[Review]</span>
							<!--<img src="admin/templates/images/eye_wrong.gif" alt="">-->
						</a>
					</span>
				</p>
			</div>
			<?php //} else{ ?>
			
			</div>
		</div>

		<div class="mainBox summaryRow">
			<p class="myLabel">My Agenda</p>
			<div class="divBox">
				<?php
				// $totalMeeting_all = 120;
				// $numMeeting_all = 60;
				// $availableMeeting_all = 40;
				// $numBlockd_all = 20;

				$utilizedChart = 10/($totalMeeting_all/$numMeeting_all);
				$availableChart = 10/($totalMeeting_all/$availableMeeting_all);
				$blockChart = 10/($totalMeeting_all/$numBlockd_all);

				?>
				
				<div class="row innerRow">
				    <div class="col-md-4 col-sm-4 col-xs-4 statisticsLabel">
				        <span class="schSummaryText_1">Inviter</span> = <img src="../images/system/i.png">
				    </div>
				    <div class="col-md-4 col-sm-4 col-xs-4 statisticsLabel">
				        <span class="schSummaryText_1">Invitee</span> = <img src="../images/system/e.png">
				    </div>
				    
				    <div class="col-md-4 col-sm-4 col-xs-4 statisticsLabel">
				        <span class="schSummaryText_1">Blocked</span> = <img src="../images/system/b.png">
				    </div>
				</div>
				
				<div class="row innerRow">
				    <div class="col-md-4 col-sm-4 col-xs-4 statisticsLabel">
				        <span class="schSummaryText">Total Slots</span> <img src="../images/system/t.png"> <?php //echo $totalMeeting_all; ?>
				    </div>
				    <div class="col-md-4 col-sm-4 col-xs-4 statisticsLabel">
				        <span class="schSummaryText">Utilized</span> <img src="../images/system/u.png"> = <img src="../images/system/i.png"> + <img src="../images/system/e.png"> + <img src="../images/system/b.png">
				    </div>
				    
				    <div class="col-md-4 col-sm-4 col-xs-4 statisticsLabel">
				        <span class="schSummaryText">Available</span> <img src="../images/system/a.png"> = <img src="../images/system/t.png"> - <img src="../images/system/u.png">
				    </div>
				</div>
				<br/>
				<!--<br/>-->
				
				<!--<div class="dateLoopItem">
    				<div class="row">
    				    <div class="col-md-12 col-sm-12 col-xs-12 dateLabelDiv">
    						<p class="dateLabel">All Day</p>
    					</div>
    					<div class="col-md-4 col-sm-4 col-xs-4">
    						<img src="../images/system/t.png"> = <?php echo $totalMeeting_all; ?>
    					</div>
    					<div class="col-md-4 col-sm-4 col-xs-4">
    						<img src="../images/system/u.png"> = <?php echo $numMeeting_all; ?>
    					</div>

    					<div class="col-md-4 col-sm-4 col-xs-4">
    						<img src="../images/system/a.png"> = <?php echo $availableMeeting_all; ?>
    					</div>
    					
    				</div>
    			</div>-->
				
				
    
                <!--schSummary-->
                
				

				<div class="row">
					<div id="piechart"></div>
				</div>
                
                <?php foreach($meetingSummaryArray as $mskey => $msValue){ ?>
                
    				<div class="dateLoopItem">
    					<div class="row">
    						<div class="col-md-12 col-sm-12 col-xs-12 dateLabelDiv">
    							<p class="dateLabel"><?php echo $mskey; ?></p>
    						</div>
    						<div class="col-md-4 col-sm-4 col-xs-4">
    							<img src="../images/system/t.png"> = <?php echo $msValue['totalMeeting']; ?>
    						</div>
    						<div class="col-md-4 col-sm-4 col-xs-4">
    							<img src="../images/system/u.png"> = <?php echo $msValue['numMeeting']+$msValue['numBlockd']; ?>
    						</div>
    						<div class="col-md-4 col-sm-4 col-xs-4">
    							<img src="../images/system/a.png"> = <?php echo $msValue['availableMeeting']; ?>
    						</div>
    					</div>
    				</div>
				<?php } ?>

			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-12 menuMainCls <?php echo $timezoneCSS.' '.$profileCSS.' '.$availabilityCSS; ?>">
		<div class="mainBox summaryRow">
			<p class="myLabel">Announcement <img class="announcementIcon" src="../../images/announcement.png">
			</p>
			<div class="divBox">
				<ul>
					<li><p>Scheduler will open on 25-Mar-2021 <span class="dateCls">Dt. 20-Mar-2021</span></p></li>
					<li><p>Block only mode <span class="dateCls">Dt. 15-Mar-2021</span></p></li>
					
				</ul>
			</div>
		</div>
		<div class="mainBox summaryRow">
			<p class="myLabel">Delegates Summary</p>
			<div class="divBox">
				<div class="row">
					<div class="col-md-12 textCss">

						<b><?php echo $totalDelegates; ?></b> delegates from <b><?php echo $totalCompany; ?></b> of companies are representing <b><?php echo $totalCountry; ?></b> countries.
					</div>
				</div>
				<div class="row innerRow">
					<div class="col-md-7 col-sm-6 col-xs-6">
						<p class="statisticsLabel">Country (<?php echo $totalCountry; ?>)</p>
					</div>
					<div class="col-md-offset-2 col-md-3 col-sm-6 col-xs-6">
						<p class="statisticsLabel">Company #</p>
					</div>
				</div>

				<div class="loopItem">
				<?php foreach($country_dataArray as $k_name => $v_count){ ?>
					<div class="row">
						<div class="col-md-7 col-sm-6 col-xs-6">
							<p><?php echo $k_name; ?></p>
						</div>
						<div class="col-md-offset-2 col-md-3 col-sm-6 col-xs-6">
							<p><?php echo $v_count; ?></p>
						</div>
					</div>
				<?php } ?>
					<!--<div class="row">-->
					<!--	<div class="col-md-6 col-sm-6 col-xs-6">-->
					<!--		<p>China</p>-->
					<!--	</div>-->
					<!--	<div class="col-md-6 col-sm-6 col-xs-6">-->
					<!--		<p>05</p>-->
					<!--	</div>-->
					<!--</div>-->
					<!--<div class="row">-->
					<!--	<div class="col-md-6 col-sm-6 col-xs-6">-->
					<!--		<p>India</p>-->
					<!--	</div>-->
					<!--	<div class="col-md-6 col-sm-6 col-xs-6">-->
					<!--		<p>10</p>-->
					<!--	</div>-->
					<!--</div>-->
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row summaryRow" style="display: none;">
	<div class="col-md-6 col-sm-12">
		<p class="myLabel">My Scheduler Statistics</p>
		<div class="divBox">
			<p>Total Meeting Time Slots
				<img src="../../images/system/t.png"> 120
			</p>
			<p>Available Time Slots
				<img src="../../images/system/a.png"> 80
			</p>
		</div>
	</div>
	<div class="col-md-6 col-sm-12">
		<p class="myLabel">Delegate Statistics 11</p>
		<div class="divBox">
			<div class="row">
				<div class="col-md-12">
					<b>150</b> of delegates from <b>100</b> of companies are representing <b>60</b> countries.
				</div>
			</div>
			<div class="row innerRow">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p class="statisticsLabel">Country (10)</p>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p class="statisticsLabel">#</p>
				</div>
			</div>

			<div class="loopItem">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<p>Afghanistan </p>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<p>10</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<p>China</p>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<p>05</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<p>India</p>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<p>10</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Rating'],
  ['U', <?php echo $utilizedChart;?>],
  ['B', <?php echo $availableChart;?>],
  ['A', <?php echo $blockChart;?>]

]);

  // Optional; add a title and set the width and height of the chart
  var options = {
  					'title':'', 
  					'width':400, 'height':250,
  					pieHole: 0.4,
  					pieSliceText: 'label',
  					// pieStartAngle: 100,
  					legend: 'none'

  				};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script> -->


<style type="text/css">
.openChangeUTCBOX{
    position: absolute;
    top: 0%;
    background-color: rgb(0,0,0,0.8);
    padding: 200px 50px 50px 50px;
    width: 100%;
    height: 100%;
}
.timezoneBox{
    border: 1px solid #ccc;
    padding: 20px 60px 20px 60px;
    background-color: #fff;
}

.mainTimezoneDivHide{
	display: none;
}
</style>

<script type="text/javascript">
    function confirmTimezoneFun(){
    	formData = $("form#formTimezone").serialize();
    	$.ajax({
	      	type: 'POST',
	      	url: 'user/model/changeTimezone.php',
	      	data: formData,//+"&type=photo", //+id+'&second_com='+second_com+'&month='+month+'&year='+year,
		   	success: function(data) {
		   	    viewDashFun('timezoneTag','secondStep',<?php echo $login_participant_id;?>);
		   		//changePriorityStatus('timezoneTag','secondStep');
		   		$(".mainTimezoneDiv").addClass("mainTimezoneDivHide");
		   		//$(".mainTimezoneDiv").hide();
		   	}
		});

    }

    function viewDashFun(tagName,nextStep,participantId){
    	$.ajax({
	      	type: 'POST',
	      	url: 'user/model/updateDashboard.php',
	      	data: 'update=dashboard&tagName='+tagName+'&loginParticipantId='+participantId, //+id+'&second_com='+second_com+'&month='+month+'&year='+year,
		   	success: function(data) {
		   		changePriorityStatus(tagName,nextStep);
		   	}
		});
    }

    function changePriorityStatus(tagName,nextStep){
        if(nextStep=='showAllSteps'){
   		 $(".allStepsDiv").html('');   
   		}
        $(".allSteps").hide();
        $("."+nextStep).show();
        $("."+tagName).removeClass("uncheckCls");
        $("."+tagName).addClass("checkCls");
        $("."+tagName).attr("src","../../images/complete.jpg");
   		$(".menuMainCls").removeClass(tagName+"_MenuHide");
   		
    }
    
    function openTimezoneBoxFun(){
        $('.mainTimezoneDiv').removeClass('mainTimezoneDivHide');
    }
</script>

<div class="mainTimezoneDiv <?php //if($login_confirmTimezone==1){ ?> mainTimezoneDivHide <?php // } ?>">
	<div class="openChangeUTCBOX">
		<div class="container timezoneBox">
			<p style="color: black; text-transform: uppercase; text-align: center;"><b>Change your timezone</b></p>
			<?php $timezoneArray_new_set = getTimezoneList(); ?>
	        <form id="formTimezone" action="user/model/changeTimezone.php" method="post">
	            <div class="row">
	                <div class="col-md-offset-2 col-md-8 col-xs-12 col-xs-12">
	                    <select name="newTimezoneSet" class="form-control" style="margin-bottom: 10px;">
	                        <option value="">Select Timezone</option>
	                        <?php foreach ($timezoneArray_new_set as $key_ss => $value_ss) { ?>
	                            <option <?php if($login_meeting_location==$value_ss['country_timezone']){ ?> selected="selected" <?php } ?> value="<?php echo $value_ss['country_timezone']; ?>"><?php echo $value_ss['country_name']." - (".$value_ss['country_timezone'].") ".$value_ss['country_utc']; ?></option>
	                        <?php } ?>
	                    </select>
	                    <input type="hidden" name="loginParticipantId" value="<?php echo $login_participant_id;?>" >
	                </div>
	            </div>
	            <div class="row">
	                <div class="col-md-offset-2 col-md-4 col-sm-6 col-xs-6">
	                    <input type="submit" name="changeTimezone" value="Change" class="form-control btn btn-success submitBTN">
	                </div>
	                <div class="col-md-4 col-sm-6 col-xs-6">
	                    <!--<input type="button" value="Cancel" class="hideTimezoneBox form-control btn btn-warning">-->			                    
	                    <input onclick="confirmTimezoneFun()" type="button" value="Confirm" class="form-control btn btn-warning">
	                </div>
	            </div>
	        </form>
    	</div>
	</div>
</div>
