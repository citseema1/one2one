<?php		
$session_id = $_SESSION[$unique_user];
$setting =  mysqli_query($con,'select logo from '.$prefix.'EMS_Settings');
$setting_fetch = mysqli_fetch_array($setting);
$logo_setting=$setting_fetch['logo'];



$fect1 =  mysqli_query($con,'select * from '.$prefix.'O2O_Event_Info');
$row_fet = mysqli_fetch_array($fect1);
$short_company_name = $row_fet['short_company_name']; 
//date_default_timezone_set('Asia/Kolkata');
$qry_comp=mysqli_query($con,"select * from ".$prefix."O2O_Pre_Companies where email='$session_id' ");
$res_comp=mysqli_fetch_array($qry_comp);
$mem_id=$res_comp['member_id'];
if($mem_id==1){
$mem_type='Seller';
}else{
$mem_type='Buyer';  
}
///////////////////////////////////////////check for close event///////////////////////////////////////////////
$select_2=mysqli_query($con,"select * from ".$prefix."O2O_Event_Info");
$row_2=mysqli_num_rows($select_2);
$get_time_zone=date_default_timezone_get();
$row_for_closing=mysqli_fetch_array($select_2);
$time_zone=$row_for_closing["time_zone"];
date_default_timezone_set($time_zone);
$close_date=$row_for_closing["close_date"];
$current_date_time=strtotime(date("Y-m-d H:i")); 
date_default_timezone_set($get_time_zone);
$close_ind=$row_for_closing["close_ind"];
 
///////////////////////////////////////////check for close event///////////////////////////////////////////////
$res= strpos($_SERVER['REQUEST_URI'],'set_meetings');		       
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8"/>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta name=viewport content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title><?php echo  strtoupper($folder)." One2One Meeting Scheduler"; ?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<!------------------old index css and js---------------------->
<link rel="stylesheet"  href="templates/css/simpleGrid.css" />
<link rel="stylesheet"  href="templates/css/boot.css" />
<link rel="stylesheet"  href="templates/css/custom.css" />
<link rel="stylesheet" type="text/css" href="templates/css/menu.css">
<link rel="stylesheet" type="text/css" href="templates/css/style-new.css">

<link rel="stylesheet" type="text/css" href="templates/calibri-font/font.css">
<link rel="stylesheet" type="text/css" href="templates/font-awesome-4.7.0/css/font-awesome.min.css">

<!-- menu css js -->	 
<link rel="stylesheet" href="templates/css/jquery.alerts.css">
<link href="templates/css/toastr.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="templates/css/jquery.loadingModal.css"> 
<script src="templates/js/jquery-3.3.1.min.js" ></script>   
<script src="templates/js/jquery.alerts.js" ></script>
<script type="text/javascript" language="javascript" src="../admin/templates/js1/script.js"></script>
<script src="../admin/templates/js1/jquery.metadata.js"></script>
<script src="../admin/templates/js1/jquery.validate.js"></script> 
<script type="text/javascript" src="templates/js/ajax.js"></script>
<script type="text/javascript" src="templates/js/function.js"></script>

<script type="text/javascript">
var fixed = false;

$(document).scroll(function() {
	var windowWidth = $(window).width();
	
    if( $(this).scrollTop() >=335 ) {
        if( !fixed ) {
            fixed = true;
            $('#bottom_header_outer').css({position:'fixed',top:0,'z-index':30}); // Or set top:20px; in CSS
        }                                           // It won't matter when static
    } else {
        if( fixed ) {
            fixed = false;
             $('#bottom_header_outer').css({position:'static'});
        }
   }
   
   if( windowWidth <=935) {
            fixed = false;
             $('#bottom_header_outer').css({position:'static'});
        }
	
  
});

</script>

<!-- menu css js -->
<script src="templates/js/vendor/modernizr-2.6.2.min.js"></script>
<script>
function showMessage(which) {
if (which == 1) {
document.getElementById("fine").style.display = "block";
}else {
document.getElementById("fine").style.display = "none";
}
}

function submitform() {
$("#commentForm").valid();
if(!$("#commentForm").valid()){
return false
}else{
commentForm.submit();
}
}
</script>
<!----------------------------------------------popup start--------------------------------------------->
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<!--==-------------------------===popup end====--------------------------------------------------------=-->
<!--------------------------------tinymce script------------------------------------------>
<script type="text/javascript" src="../tiny_mce/tiny_mce.js" ></script>
<script type="text/javascript">
tinyMCE.init({
// General options
mode : "textareas",
editor_selector : "mceEditor",
theme : "advanced",
plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

// Theme options
theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|undo,redo,|link,unlink,anchor,image,cleanup,|insertdate,inserttime,preview,|,forecolor,backcolor,|,code",
theme_advanced_buttons3 : "",
theme_advanced_buttons4 : "",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,

// Example content CSS (should be your site CSS)
content_css : "css/content.css",

// Drop lists for link/image/media/template dialogs
template_external_list_url : "lists/template_list.js",
external_link_list_url : "lists/link_list.js",
external_image_list_url : "lists/image_list.js",
media_external_list_url : "lists/media_list.js",

// Style formats
style_formats : [
{title : 'Bold text', inline : 'b'},
{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
{title : 'Example 1', inline : 'span', classes : 'example1'},
{title : 'Example 2', inline : 'span', classes : 'example2'},
{title : 'Table styles'},
{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
],

// Replace values for the template plugin
template_replace_values : {
username : "Some User",
staffid : "991234"
}
});
</script>

<!-----------------------------old End---------------------------->
<script src="templates/js/organictabs.jquery.js"></script>
<script>
$(function() {
$("#example-one").organicTabs();
$("#example-two").organicTabs({
"speed": 200
});
});
</script>
</head>
<body>
<div class="wrapper">
<?php if($_SESSION['table_admin']!="admin_flag"){ 
if($logo_setting==1){ ?>
<div class="bg">
<div class="container">
<div class="row">
<div class="col-md-3">
<div class=" tc">
<div class=""><br><img src="templates/images/logo.png"></div>
<div class="dis_show"><img src="templates/images/logo_mobile.png"></div>
</div>
</div>

<div class="col-md-6">
<div  class="heading-text tc wc ">
<div class="content tc wc " style="line-height:22px;">
<h4 class="wc"> <?php 

$qryselect_event=mysqli_query($con,"select * from ".$prefix."O2O_Event_Info limit 1") or die(mysqli_fetch());
$select_event=mysqli_fetch_array($qryselect_event);
$title=$select_event["title"];
$description=$select_event["description"];
$location=$select_event["location"];
$time_zone=$select_event["time_zone"];
$start_time=date('l d F Y',$select_event["start_time"]);
$end_time=date('l d F Y',$select_event["end_time"]);
$allocate_table= $select_event["allocate_table"]; 
$maximum_table= $select_event["maximum_table"]; 
$alloted_member_type= $select_event["alloted_member_type"];  
$select=mysqli_query($con,"select * from ".$prefix."O2O_Event_Info")or die(mysqli_fetch());
$row=mysqli_fetch_array($select);
$short_company_name=$row["short_company_name"];
$logo=$row["logo"];
?>
<strong>One2One Meeting Scheduler</strong>
<?php if(isset($_SESSION['demo_live']) && $_SESSION['demo_live']!='' && $_SESSION['demo_live']=='DEMO'){ echo '(Live Demonstration)';} ?>  <br>
for <?php echo $title; ?> <?php //echo $description; ?>
 <?php   echo $location; ?> <br> <?php 
$start_time1 =  date('d',$select_event["start_time"]);
$end_time1 = date('d',$select_event["end_time"]);
if(isset($start_time1) && isset($end_time1) && $start_time1==$end_time1){
echo $start_time;
}else{
echo $start_time; ?>&nbsp;-&nbsp;<?php echo $end_time;
}?></h4>
</div>
</div>
</div>

<div class="col-md-3">
<div class="content dn1">
<img  src="<?php echo  $logo;?>" style="height:100px;">
</div>
</div>
</div>

</div>
</div>
<?php }else{ ?>
<div class="banner">
<div class="container">
<div class="row">
<div class="col-md-12"><img class="banner_img center-block" src="https://one2onescheduler.com/IFLN/admin/logo_image/Montreal2018Banner_FINAL.jpg" /></div>
</div></div></div>
<?php } } ?>



<?php if($session_id!=""){?>
<div class="menu-cus sidebar" id="bottom_header_outer">
<div class="container">
<div class="row">
<div class="col-md-12">
<div id="cssmenu">
<ul>
<?php } ?>
<!---------------------------------Tab Panel-------------------------------------->
<?php
if($session_id!=""){
$close_ind=0;
if($res =='' ){
if($close_ind!=1){  ?>
<li <?php  if($page== 'schedule_your_meetings0' || $page == 'search_new'){  echo 'class="active"';}?>>
<a id="#featured"   href="?page=schedule_your_meetings0" style="cursor:pointer;"><i class="menu-icon fa fa-table"></i><br />Schedule Your Meetings</a> 
</li>
<li <?php if($page== 'participant'){ echo 'class="active"';} ?>>
<a  id="#jquerytuts" href="?page=participant"   style="cursor:pointer;"><i class="menu-icon fa fa-list-alt"></i><br /> Participant List</a>
</li> 
<?php }?>
<li <?php if($page== 'report'){  echo 'class="active"';}  ?>>  
          
<a  id="#core" href="?page=report" style="cursor:pointer;"><i class="menu-icon fa  fa-bar-chart-o"></i><br />  Report</a> 
</li>
<?php if($close_ind!=1){?>
<li <?php if($page=='my_profile' || $page== 'my_profie_edit_part' || $page=='my_profile_edit_com'){ echo 'class="active"';}?>>
<a id="#classics"  href="?page=my_profile" style="cursor:pointer;"><i class="menu-icon fa fa-user"></i><br />My Profile</a> 
</li>
<li <?php if($page=='version4_help'){  echo 'class="active"';}  ?>>
<a href="?page=version4_help" ><i class="menu-icon fa fa-question"></i><br />Help</a>
</li><?php } } ?>
<li><a href="?page=logout" ><i class="menu-icon fa fa-power-off"></i><br />Logout</a></li>   
</ul>
</div>
</div>
</div>
</div>
</div>


<div id="page-wrapper">
<?php if($close_ind==1){ ?>
<div style="color:#FF0000;font-size:14px; padding:10px;" align="center"><strong>"<?php echo $short_company_name;?>"</strong> one2one meeting scheduler is now closed for <strong >&quot;<?=$title?>&quot;</strong> meetings. However, you can still log-in into the system and download your Final meeting report.</div><br />
<?php  } ?>
<div class="container">
<div class="row">
<div class="col-md-12  mt body_con">

<div class="portlet-title">
<div class="caption">
<?php  if($page == 'schedule_your_meetings0' || $page == 'search_new'){  
echo 'Schedule Your Meetings';
}else if($page == 'participant'){
echo 'Participant List';	
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

$pre_table_chk=mysqli_query($con,"select * from ".$prefix."O2O_Pre_Table where company_id='".$_SESSION['com_id']."'    order by id") or die(mysqli_fetch());
$num_pre_table = mysqli_num_rows($pre_table_chk);
while($fetch_pre_table=mysqli_fetch_array($pre_table_chk)) {
$part_id_chk[]=$fetch_pre_table['participant_id'];
}

$participant_id_list1='';
$se_1 = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Participants where company_id='".$_SESSION['com_id']."'") or die(mysqli_fetch());
while($fet_pre_participant = mysqli_fetch_array($se_1)){
$participant_id_list1[] = $fet_pre_participant['id'];
}

$participant_id_list = implode(',',$participant_id_list1);
$num_pre_part = mysqli_num_rows($se_1);

$se_pre_company = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Companies where id='".$_SESSION['com_id']."'") or die(mysqli_fetch());
$fetch_pre_company = mysqli_fetch_array($se_pre_company);
$table_required12 = $fetch_pre_company['table_required'];
$set_group = $fetch_pre_company['set_group'];
if($num_pre_part>$num_pre_table && $set_group==0){
echo 'Participant(s) <br><br> <span style="font-size:13px;">Your company has '.$num_pre_part.' participants and '.$table_required12.' meeting scheduler allocated. Please group up the participants by selecting the "Participant name" and "Group" and press "Submit" for each participant.<br><br> THIS IS ONE TIME PROCESS AND GETS COMPLETE ONCE YOU PRESS ON "FINISH GROUPING PARTICIPANTS" BUTTON.</span>';
}else{
echo 'Participant(s)';
}
}?>
</div>
<div class="cl"></div>

</div>
<div class="portlet-body"> 
<div class="table-scrollable">

<?php include($include); ?>
</div>
</div>

<!---------------------------------Company Image-------------------------------------->
<?php 
$select23  = mysqli_query($con,'select * from '.$prefix.'O2O_Sponsors_Details');
$fet23 =  mysqli_fetch_array($select23);
if($fet23['logo']==""){

echo '<br><br><br><br>';
}
if($session_id!="")
{ 
if($fet23['logo']!=""){  
?> 

<div class="cl"></div>
<div class="wi-100">
<div class=" mt  body_con ">
<div class="green-haze">
<div class="caption">Event Sponsors</div>
<div class="cl"></div>

</div>
<div class="content green-haze-body pl_30">

<style>
/*.grTypeName {
    background-color: red;
    color: white;
    padding: 3px;
    position: absolute;
    right: 1px;
}*/
</style>

<?php
$nn = 1;
$colClass = "";
$select2_group  = mysqli_query($con,'select * from '.$prefix.'O2O_Member_Types order by priority asc');

while ( $fetch_group12 = mysqli_fetch_array($select2_group)) {
$nn++; 
$getMemberType = $fetch_group12['member_type'];

if($nn==2){ $colClass = "2"; }
if($nn==3){ $colClass = "3"; }
if($nn==4){ $colClass = "4"; }



?>

<fieldset style="width: 100%; border: 1px solid #ccc; padding:5px; margin-left: -12px;">
    <legend style="width: auto; padding:0 5px;  color:#fff; margin:13px 5px; background-color: red;">
        <span ><?php echo ucfirst($getMemberType);?></span>
     </legend>

<?php
$select21  = mysqli_query($con,"select * from $prefix.O2O_Sponsors_Details where group_type='$getMemberType'");
		while($fetch112 = mysqli_fetch_array($select21)){
			$getWebsite = $fetch112['website'];
			$getLogo = $fetch112['logo'];
?>
		<div class="col-1-<?php echo $nn;?> tc pb" style="background-color: #fcf7f7;">
			<a href="<?php echo $getWebsite;?>" target="_blank">
				<img  height="100px" src="<?php echo $getLogo;?>">

			</a>
		</div>

<?php
}
?>
</fieldset>
    <?php } ?>

<div class="cl"></div>
<?php } ?>
<br>
</div>
</div> 
</div> </div>
</div>

<?php } ?>
</div>
<?php } 
if($session_id==""){
include($include);
}
?> 
</div>
<!----------------------------Footer----------------------------->
