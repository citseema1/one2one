<?php
@session_start();
//error_reporting(E_ERROR | E_WARNING | E_PARSE );
error_reporting(0);
$servername = 'localhost';
$username = 'one2one_live';
$password = ')or@a8up0EJc';
$database = 'one2one_dev';
$_SESSION['limit']=1000;

$EVENT_TYPE = 'virtual';
define('EVENT_TYPE_DEF',$EVENT_TYPE);

$_SESSION["prefix"]="dev_";
$unique_user = "dev_user";
$unique_admin_user = "dev_admin_user";

$prefix = $_SESSION["prefix"];

$current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url = $current_url;
$urlParts = explode("/", $url);
$folder=$urlParts[3];
$current_folder=$urlParts[4];
$site_url = "https://$_SERVER[HTTP_HOST]/$folder/";
$admin_url = "https://$_SERVER[HTTP_HOST]/$folder/admin/";
$user_url = "https://$_SERVER[HTTP_HOST]/$folder/user/";

$_SESSION["app_url"]='https://virtual.one2onescheduler.com/';
$_SESSION["web_url"]='https://virtual.one2onescheduler.com/';
$_SESSION["base_dir"]=$folder;

$VIDEO_API_URL = "https://vid1.one2onemeetings.com";
$VIDEO_API_URL1 = "https://vid1.one2onemeetings.com";
$VIDEO_SECRET_KEY = "Ak4vR8IrP1RAS";

static $con;
$con = mysqli_connect($servername, $username, $password, $database);
if (mysqli_connect_errno()){
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


$clientsIpAddress = get_client_ip(); //"103.103.213.226"; //"160.202.40.203";//

$ipInfo = file_get_contents('http://ip-api.com/json/' . $clientsIpAddress);
$ipInfo = json_decode($ipInfo);
$timezone_login = $ipInfo->timezone;

$sqlGetUTC_login = mysqli_query($con,"select * from ".$prefix."timezone where country_timezone='$timezone_login'") or die(mysqli_error($con));
$fetchUTC_login = mysqli_fetch_array($sqlGetUTC_login);
$country_utc_login = $fetchUTC_login['country_utc'];


$tbl_date_format =  mysqli_query($con,'select * from '.$prefix.'O2O_tbl_date_format');
$tbl_date_format_res = mysqli_fetch_array($tbl_date_format);
$date_format = $tbl_date_format_res['date_format'];

$SQL_EVENT_INFO = mysqli_query($con,"select * from ".$prefix."O2O_Event_Info") or die(mysqli_error($con));
$FETCH_EVENT_INFO = mysqli_fetch_array($SQL_EVENT_INFO);
$EVENT_TITLE = $FETCH_EVENT_INFO['title'];
$EVENT_LOCATION = $FETCH_EVENT_INFO['location'];
$EVENT_LOGO = $FETCH_EVENT_INFO['logo'];
$EVENT_START_TIME_STR = $FETCH_EVENT_INFO['start_time'];
$EVENT_END_TIME_STR = $FETCH_EVENT_INFO['end_time'];
$EVENT_INFO_emsPanel = $FETCH_EVENT_INFO['emsPanel'];
$EVENT_CONCURRENT_MEETING = $FETCH_EVENT_INFO['concurrent_meeting'];

$EVENT_TIMEZONE = $FETCH_EVENT_INFO['time_zone'];
date_default_timezone_set($EVENT_TIMEZONE);

if($EVENT_TYPE=='physical'){
  mysqli_query($con,"update ".$prefix."O2O_Pre_Participants set meeting_location='$EVENT_TIMEZONE'");
}


function checkScheduler(){
    global $con,$prefix;
    $str_date=strtotime("now");
    $event_info=mysqli_query($con,"select close_date from $prefix.O2O_Event_Info");
    $data=mysqli_fetch_array($event_info);
    $close_date=$data['close_date'];
    if($close_date!='' && $close_date<=$str_date){
        //mysqli_query($con,"update $prefix.O2O_Event_Info set close_ind='1'");
    }
} 

function csrf_token(){
    global $folder;
    $sessionId = session_id();
    return sha1( $folder.$sessionId );
}
    
function tres($text){ 
    global $con;
	if(is_string($text)){
	    return trim(mysqli_real_escape_string($con,$text));
	}
} 	

/****************HEADER LOCATION******************/
    
function redirect($location){echo '<script>window.location.href="'.$location.'";</script>';}
	
/****************Set msg******************/	
	
function SetMessage($message, $type){
    $_SESSION['message']=$message;
    $_SESSION['type']=$type;
}

/****************get msg******************/

function getMessage(){
	//echo "<br/>";
	//echo $_SESSION['type'];
if(isset( $_SESSION['message']) &&  $_SESSION['message']!=''){
	//echo $_SESSION['message'];
	?>
<script>
window.onload = function(){
setTimeout(function(){
showToast('<?=$_SESSION['message'] ?>','<?=$_SESSION['type'] ?>');
},500);
};
</script>
<?php
$_SESSION['message']="";
$_SESSION['type']="";
}
}


function DOMreplaceImage($text, $dom) {
    foreach($dom->getElementsByTagName('img') as $img) {
        if ($img->getAttribute("alt") == $text) {
            $span = $dom->createElement("span", $text);
            $img->parentNode->replaceChild($span, $img); 
        };
    }
}

function DOMinnerHTML($element) { 
    $innerHTML = ""; 
    foreach ($element->childNodes as $child) { 
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }
    return $innerHTML; 
}

//$AA = mysqli_query($con,"SELECT * FROM `demo_O2O_Pre_Companies` GROUP by country") or die(mysqli_error($con));
//echo mysqli_num_rows($AA);

function getTimezoneList(){
  global $con;
  global $prefix;
  $fetchListArray = array();
  $getList = mysqli_query($con,"select * from ".$prefix."timezone GROUP by country_timezone order by country_name,country_utc asc");
  while($fetchList = mysqli_fetch_array($getList)){
    $fetchListArray[] = $fetchList;
  }
  
  return $fetchListArray;
}





function userTimeSlotList($timezone){
    global $con,$prefix,$event_timezone;
    
    $allDateData = array();
    $key =0;
    //echo "Select * from ".$prefix."O2O_Pre_Conferenceslots where start_time>='$get_date_start_scheduler' and start_time<='$get_date_end_scheduler' order by date,`start_time` ASC";
    $ConferenceslotArray_new=mysqli_query($con,"Select * from ".$prefix."O2O_Pre_Conferenceslots order by date,`start_time` ASC");
    while($Conferenceslot_new = mysqli_fetch_assoc($ConferenceslotArray_new)){
        
        $allDateData[] = $Conferenceslot_new;
        
        $purpose = $Conferenceslot_new['purpose'];
        $confID = $Conferenceslot_new['id'];
        $one2one = array();
       
        if($purpose=='one to one meeting'){
            $MeetingSlotArray_new=mysqli_query($con,"Select * from ".$prefix."O2O_Pre_Meetingslots where conferenceslot_id='$confID' order by `start_time` ASC");
            while($MeetingSlot_new = mysqli_fetch_assoc($MeetingSlotArray_new)){
                $allDateData[$key]['one2one'][] = $MeetingSlot_new;
            }
        }
        $key++;
    }
   
   
    date_default_timezone_set($timezone);
    $dateArray = array();
   
    foreach ($allDateData as $key => $value) {
        $purpose = $value['purpose'];
        $start_time = $value['start_time'];
        $dateFormat = date("d F Y",$start_time);
      
        if($purpose=='one to one meeting'){
            $one2oneArray = $value['one2one'];
            $newOne2oneArray = array();
            foreach ($one2oneArray as $key1 => $value1) {
                $start_time1 = $value1['start_time'];
                $dateFormat1 = date("d F Y",$start_time1);
                
                      
                if($dateFormat == $dateFormat1){
                    $newOne2oneArray['one2one_new'][] = $one2oneArray[$key1];
                }else{
                    
                    $dateArray[$dateFormat][] = $newOne2oneArray;
                    $dateFormat = $dateFormat1;
                    $newOne2oneArray = array();
                    $newOne2oneArray['one2one_new'][] = $one2oneArray[$key1];
                    //$newOne2oneArray['one2one_new'][] = $one2oneArray[$key1];
                    
                }
                
            }
            
            $dateArray[$dateFormat][] = $newOne2oneArray;
        }else{
            
            $dateArray[$dateFormat][] = $allDateData[$key];
        }
    }
    //echo "<pre>"; print_r($dateArray); echo "</pre>";
    return $dateArray;
}


function get_availaleTimeSlot($firstTableId,$timezone,$secondTableId){
 
    global $con,$prefix;
 
    $firstTableId = $firstTableId; //$_REQUEST['firstTableId'];
    $myTimezone = $timezone; //$_REQUEST['myTimezone'];
    
    $condition = "";
    if($secondTableId!=""){
       //$secondTableId = $secondTableId; //$_REQUEST['secondTableId'];
       $condition = " or table_id='$secondTableId' or scheduled_with_table_id='$secondTableId'";
    }
    
    $sqlAllScheduleMeeting = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Scheduledmeetings where table_id='$firstTableId' or scheduled_with_table_id='$firstTableId' $condition");
    
    $meetingslots_id_array = array();
    while($fetch = mysqli_fetch_array($sqlAllScheduleMeeting)){
       $meetingslots_id_array[] = $fetch['meetingslots_id'];
    }
    
    $meetingslots_id_list_where = "";
    if(count($meetingslots_id_array)>0){
      $meetingslots_id_list = implode(",", $meetingslots_id_array);  
      $meetingslots_id_list_where = "where id not in($meetingslots_id_list)";
    }
    
    
    date_default_timezone_set($myTimezone);
    
    $allDateData = array();
    $MeetingSlotArray_new=mysqli_query($con,"Select * from ".$prefix."O2O_Pre_Meetingslots $meetingslots_id_list_where order by `start_time` ASC");
    while($MeetingSlot_new = mysqli_fetch_assoc($MeetingSlotArray_new)){
       $allDateData[] = $MeetingSlot_new;    
    }
    
    return $allDateData;
}


include("database.php");
include("functions/fn_user_model.php");
include("functions/fn_delegates.php");

?>
