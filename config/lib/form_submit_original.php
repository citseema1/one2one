<? 	//if(!session_start()){ session_start(); ini_set('session.gc_maxlifetime', '288000');}
/* ----------------------  form post date ---------------------------------------------------- */
$BaseDir=$folder;
if(isset($_POST['username']) && isset($_POST['password']) && $_POST['Login']=='Submit'){
$LoginPerson='admin';
if($_POST['LoginPerson']=='User Login')
$LoginPerson='user';
MemberLogin($_POST,$LoginPerson);
}elseif(isset($_REQUEST['logout']) && $_REQUEST['logout']==session_id().'_'.$BaseDir.'AdminID'){
unset($_SESSION[session_id().'_'.$BaseDir.'AdminID']);
redirect('index.php');
}elseif(isset($_REQUEST['logout']) && $_REQUEST['logout']==session_id().'_'.$BaseDir.'UserID'){
unset($_SESSION[session_id().'_'.$BaseDir.'UserID']);
redirect('index.php');
}elseif(isset($_POST['NextFace'])){
if($_POST['NextFace']=='Continue'){
SkipedComleted(0,1);
}elseif($_POST['NextFace']=='Continue and do the rest of setup later'){
SkipedComleted(1,0);
}elseif($_POST['NextFace']=='Complete setting up'){
SkipedComleted(0,0);
}
}elseif(isset($_POST['Admin_Details']) && ($_POST['Admin_Details']=='Save')){
$AdminSettings='';
$admin_settings=0;
if(AdminDetilsUpdate($_POST)){
$AdminSettings='none';
$admin_settings=1;
}
$msg=$AdminMsg =$arrow.GetMessage();
}elseif(isset($_POST['UpdateEvent']) && ($_POST['UpdateEvent']=='Save')){
$EventSettings='';
$event_settings=0;
if(EventDetilsUpdate($_POST)){
$EventSettings='none';
$event_settings=1;
}
$msg=$EventMsg =$arrow.GetMessage();
}elseif(isset($_POST['AddEvent']) && ($_POST['AddEvent']=='Save')){
$EventSettings='';
$event_settings=0;
if(EventDetilsAdd($_POST)){
$EventSettings='none';
$event_settings=1;
}
$msg=$EventMsg =$arrow.GetMessage();
}elseif(isset($_POST['AddTimeSlot']) && ($_POST['AddTimeSlot']=='Save')){

$TimeSlotSettings='';

$time_slot_settings=0;

if(TimeSlotAdd($_POST)){

$TimeSlotSettings='none';

$time_slot_settings=1;

}

$msg=$TimeSlotMsg =$arrow.GetMessage();

$purpose=$_POST['purpose'];

$schedul_date=$_POST['date'];

$schedul_start_time=$_POST['start_time'];

$start_hh=date('h', $schedul_start_time);

$start_mm=date('i', $schedul_start_time);

$schedul_end_time=date('H:i', $_POST['end_time']);

$meeting_duration=$_POST['meeting_duration'];

}elseif(isset($_POST['ImportCompany']) && $_POST['ImportCompany']=='Import'){ //1 if_1
$filename="upload/".$_FILES['import']['name'];
$ImportCompanySettings='';
$import_company_settings=0;
if($import=CompanyImport($filename)){
$ImportCompanySettings='none';
$import_company_settings=1;
}
$msg=$ImportCompanyMsg =$arrow.GetMessage();
}elseif(isset($_POST['AddCompany']) && $_POST['AddCompany']=='Save'){ //1 if_1
$ImportCompanySettings='';
$import_company_settings=0;
if($import=AddCompany($_POST)){
$ImportCompanySettings='none';
$import_company_settings=1;
}
$msg=$ImportCompanyMsg =$arrow.GetMessage();
}elseif(isset($_POST['UpdateCompany']) && $_POST['UpdateCompany']=='Save'){ //1 if_1
if($_POST['CompanyID'] > 0)UpdateCompany($_POST);
elseif($_POST['ParticipantID'] > 0)UpdateParticipant($_POST);
$msg=$arrow.GetMessage();
}elseif(isset($_POST['TableAllocation']) && $_POST['TableAllocation']=='Save'){ //1 if_1
$TableAllocationSettings='';
$table_allocation_settings=0;
if(TableAllocation($_POST)){
$TableAllocationSettings='none';
$table_allocation_settings=1;
}
$msg=$TableAllocationMsg =$arrow.GetMessage();
}elseif(isset($_POST['SaveBoothDetails']) && $_POST['SaveBoothDetails']=='Save'){ //1 if_1
$BoothSettings='';
$booth_settings=0;
if(SaveBoothDetails($_POST)){
$BoothSettings='none';
$booth_settings=1;
}
$msg=$BoothMsg =$arrow.GetMessage();
}elseif(isset($_POST['UpdateBoothDetails']) && $_POST['UpdateBoothDetails']=='Save'){ //1 if_1
$BoothSettings='';
$booth_settings=0;
if(UpdateBoothDetails($_POST)){
$BoothSettings='none';
$booth_settings=1;
}
$msg=$BoothMsg =$arrow.GetMessage();
}elseif(isset($_POST['SaveSponsorsDetails']) && $_POST['SaveSponsorsDetails']=='Save'){ //1 if_1
$SponsorsSttings='';
$sponsors_settings=0;
if(SaveSponsorsDetails($_POST)){
$SponsorsSttings='none';
$sponsors_settings=1;
}
$msg=$SponsorsMsg =$arrow.GetMessage();
}elseif(isset($_POST['SaveEmailMessge']) && $_POST['SaveEmailMessge']=='Save'){ //1 if_1
SaveEmailMessge($_POST);
$msg=$arrow.GetMessage();
}elseif(isset($_POST['UpdateEmailMessge']) && $_POST['UpdateEmailMessge']=='Save'){ //1 if_1
UpdateEmailMessge($_POST);
$msg=$arrow.GetMessage();
}elseif(isset($_POST['ChangeLogo'])){ //1 if_1
if(($_POST['ChangeLogo']=='Upload Logo') && (($_POST['user']=='ADMIN'))){
$table='O2O_Event_Info'; $filed='logo'; $where='where 1 limit 1'; $dir='logo/';
}elseif(($_POST['ChangeLogo']=='Upload Logo') && (($_POST['user']=='USER'))){
$table='O2O_Pre_Companies'; $filed='logo';
$where='where id='.$_SESSION[session_id().'_'.$BaseDir.'UserID'].' limit 1'; 
$dir='admin/images/company_logo/';
}elseif(($_POST['ChangeLogo']=='Upload Photo') && ($_POST['PID'] > 0)){
$table='O2O_Pre_Participants'; $filed='photo';
$where='where id='.$_POST['PID'].' limit 1';
$dir='admin/images/user_photo/';
}
ChangeLogo($table,$filed,$_FILES[$filed],$where,$dir);
$msg=$arrow.GetMessage();
}elseif(isset($_POST['DeleteLogo'])){ //1 if_1
if(($_POST['DeleteLogo']=='Delete Logo') && (($_POST['user']=='ADMIN'))){
$table='O2O_Event_Info'; $filed='logo'; $where='where 1 limit 1'; 
}elseif(($_POST['DeleteLogo']=='Delete Logo') && (($_POST['user']=='USER'))){
$table='O2O_Pre_Companies'; $filed='logo';
$where='where id='.$_SESSION[session_id().'_'.$BaseDir.'UserID'].' limit 1'; 
}elseif(($_POST['DeleteLogo']=='Delete Photo') && ($_POST['PID'] > 0)){
$table='O2O_Pre_Participants'; $filed='photo';
$where='where id='.$_POST['PID'].' limit 1'; 
}
DeleteLogo($table,$filed,$where);
$msg=$arrow.GetMessage();
}elseif(isset($_POST['FeeadBack'])){
FeeadBack($_POST);
}
$AdminDataArray =Select('O2O_Event_Info','*',"WHERE 1 LIMIT 1");
if(count($AdminDataArray)){
extract($AdminDataArray[0]);
if($logo!=''){
$AdminCompanyLogo="<a href='https://www.one2onescheduler.com/".$BaseDir."'><img src='".$logo."' border='0'/></a>";
$ACL="<a href='https://www.one2onescheduler.com/".$BaseDir."/user'><img src='".$logo."' border='0'/></a>";
list($LogoWidth, $LogoHeight, $type, $attr) = @getimagesize($ADMIN.'logo/'.$logo);
}
$address=str_replace('\\','',$address);

$Address=$address;

if($city!='')
$address.=',&nbsp;'.str_replace('\\','',$city);
if($country!='' && $country!=$city)
$address.=',&nbsp;'.str_replace('\\','',$country);
if(isset($_REQUEST['LoginDetails']) && $_REQUEST['LoginDetails']=='LoginDetails'){
print_r($AdminDataArray);
}
}
$EventDataArray =Select('O2O_Event_Info','*',"WHERE 1 LIMIT 1");
if(count($EventDataArray)){
extract($EventDataArray[0]);
$EventName=$EventDataArray[0]['title'];
$ConferenceStart=date('d F Y',$start_time);
$ConferenceEnd=date('d F Y',$end_time);

$con_start_date = date('d',$start_time);
$con_end_date = date('d',$end_time);

if(isset($con_start_date) && isset($con_end_date) && $con_start_date==$con_end_date){

$ConferenceStartEndDate= $ConferenceStart;

}else{

$ConferenceStartEndDate= $ConferenceStart.'-'.$ConferenceEnd;

}

}

$namee=$folder." One to One meeing scheduler";
$star='<span class="red b f16">*</span>';
/* ----------------------  form post date end----------------------------------------------------       */	
function MemberLogin($logindetail,$UserType){
global $prefix;
global $con;
extract($logindetail);
global $BaseDir;

if($UserType=='admin'){
if($log_id=Select('O2O_Event_Info','id','where username = "'.trim($username).'" and password = "'.trim($password).'" LIMIT 1')){
extract($log_id[0]);
$_SESSION[session_id().'_'.$BaseDir.'AdminID']=$id;
}else{
SetMessage('Invalid Username or Password','error');
return false;
}
}elseif($UserType=='user'){
if($log_id=Select('O2O_Pre_Companies','id','where email = "'.trim($username).'" and access_code = "'.trim($password).'" LIMIT 1')){
extract($log_id[0]);
$_SESSION[session_id().'_'.$BaseDir.'UserID']=$id;
}else{
SetMessage('Invalid Username or Password','error');
return false;
}
}else{
SetMessage('Invalid Username or Password','error');
return false;
}
}function AdminDetilsUpdate($data_array=array()){
global $prefix;
global $con;
global $BaseDir;     
if(count($data_array)){ 
$logo_dir='logo/';
$PrevMemberType=array();
$MemberType=array();  
extract($data_array);
$prev_short_company_name_array=Select('O2O_Event_Info','short_company_name',' where 1 limit 1');
$prev_short_company_name=tres($prev_short_company_name_array[0]['short_company_name']);
$short_company_name=tres(ucwords($short_company_name));
$MemberType[]=$short_company_name.' Member';
$MemberType[]='Non '.$short_company_name.' Member';
$PrevMemberType[]=$prev_short_company_name.' Member';
$PrevMemberType[]='Non '.$prev_short_company_name.' Member';
$ValueArray=array(
"name='".tres(ucwords($name))."'",
"username='".tres($username)."'",
"password='".tres($password)."'",
"company='".tres(ucwords($company))."'",
"short_company_name='".$short_company_name."'",
"email='".$email."'",
"address='".tres(ucwords($address))."'",
"city='".tres(ucwords($city))."'",
"country='".$country."'",
"contact_no='".$contact_no."'",
"fax='".$fax."'",
"active=1"
);
if(($_FILES['logo']['name']!='') && $logo=image_upload($_FILES['logo'],$logo_dir)){
$ValueArray[]= "logo='".$logo."'";
list($width,$height)=getimagesize($logo_dir.$logo);
if($width > 350){
createThumbs( $logo_dir.$logo, $logo_dir.$logo,350);
}
createThumbs( $logo_dir.$logo, $logo_dir.'Thumbs/'.$logo,64);
}
if(Update('O2O_Event_Info', $ValueArray, "where id 	='".$_SESSION[session_id().'_'.$BaseDir.'AdminID']."' limit 1")){
Update('config_settings', 'admin_settings=1', "where 1 limit 1");
if($prev_short_company_name != $short_company_name)foreach($MemberType as $k=>$member_type){
if(Rows('member_type','member_type',"where member_type='".$PrevMemberType[$k]."'")){
Update('member_type', "member_type='".$member_type."'", "where member_type='".$PrevMemberType[$k]."'");
}else{
Insert('member_type','member_type',"'".$member_type."'");
}
}
SetMessage('Admin details are successfully updated', 'green b f12');
return true; 
}else{
SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysqli_error($con).' ........', 'red b f12');
return false; 
}
}
}function DeleteLogo($table,$filed,$where){
global $prefix;
global $con;
if(Update($table, $filed."=''",$where)){
SetMessage('Image is successfully deleted', 'green b f12');
}else{
SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysqli_error($con).' ........', 'red b f12');
}
}function ChangeLogo($TableName,$FieldName,$Image=array(),$where='where 1 limit 1',$dir){
global $BaseDir;  //  echo $TableName; echo '<br>'; echo $FieldName; echo '<br>'; echo $where; echo '<br>'; echo $dir; echo '<br>'; print_r($Image); die();  
if(count($Image)){ 
if(($Image['name']!='') && $logo=image_upload($Image,$dir)){
$ValueArray = $FieldName."='".$logo."'";
createThumbs( $dir.$logo, $dir.'Thumbs/'.$logo,80);
if(Update($TableName, $ValueArray, $where)){
SetMessage('Image is successfully updated', 'green b f12');
}else{
SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysqli_error($con).' ........', 'red b f12');
}
}
}
}function EventDetilsUpdate($data_array=array()){
if(count($data_array)){ 
extract($data_array);
$ValueArray=array(
"title='".tres(ucwords($title))."'",
"description='".tres($description)."'",
"location='".tres($location)."'",
"time_zone='".tres($time_zone)."'",
"start_time='".strtotime($start_time)."'",
"end_time='".strtotime($end_time)."'",
"active=1"
);
if(Update('O2O_Event_Info', $ValueArray, "where 1 limit 1")){
Update('config_settings', 'event_settings=1', "where 1 limit 1");
SetMessage('Event details are successfully updated', 'green b f12');
return true; 
}else{
SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysqli_error($con).' ........', 'red b f12');
return false; 
}
}
}function EventDetilsAdd($data_array=array()){
if(count($data_array)){ 
extract($data_array);
$FiledArray=array( 'title','description','location','time_zone','start_time','end_time','active');
$ValueArray=array("'".tres(ucwords($title))."'",
"'".tres($description)."'",
"'".tres($location)."'",
"'".tres($time_zone)."'",
"'".strtotime($start_time)."'",
"'".strtotime($end_time)."'",
"'1'");
if(Insert('O2O_Event_Info',$FiledArray,$ValueArray)){
Update('config_settings', 'event_settings=1', "where 1 limit 1");
SetMessage('Event details are successfully added', 'green b f12');
return true; 
}else{
SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysqli_error($con).' ........', 'red b f12');
return false; 
}
}
}function TimeSlotAdd($data_array=array()){

if(count($data_array)){

extract($data_array);

$ConferenceDetail=Select('O2O_Event_Info','start_time,end_time','where 1 limit 1');

$Conf_start_time=$ConferenceDetail[0]['start_time']; 

$Conf_end_time=$ConferenceDetail[0]['end_time'];

$StartTime= strtotime(date('Y-m-d ',$date).$start_hh.':'.$start_mm);

$StartTime=($StartTime*1);

$EndTime= strtotime(date('Y-m-d ',$date).$end_time);

$EndTime=($EndTime*1);

if($Conf_start_time <= $StartTime && $Conf_start_time < $EndTime && $StartTime < $Conf_end_time && $EndTime <= $Conf_end_time){

$where='where 1 ';

if($conferenceslotID > 0){

$where.=' AND id !='.$conferenceslotID;

}

$where.=" AND (( '$StartTime' >= `start_time` AND '$StartTime' < `end_time` ) OR ( '$EndTime' > `start_time` AND  
'$EndTime' < `end_time` ) ) LIMIT 1";
$SelectTimeSlot=Select('O2O_Pre_Conferenceslots','*',$where);
if(count($SelectTimeSlot)){ 
SetMessage('This Time Slot is not Available!', 'red b f12');
return false;
}else{
if($conferenceslotID > 0){
if(IsTimeSlotInMeetings($conferenceslotID)){
SetMessage('you must delete all meetings which is already set for this time slot', 'red b f12');
return false;
}
Delete('O2O_Pre_Meetingslots', 'where conferenceslot_id='.$conferenceslotID);
Delete('O2O_Pre_Conferenceslots', 'where id='.$conferenceslotID);
}
$FiledArray=array( 'purpose','date','start_time','end_time','meeting_duration');
$ValueArray=array("'".$purpose."'", "'".$date."'", "'".$StartTime."'", "'".$EndTime."'","'".tres($meeting_duration)."'");
if($conferenceslot_id=Insert('O2O_Pre_Conferenceslots',$FiledArray,$ValueArray)){

$meeting_duration_in_second=($meeting_duration*60);

if($purpose=='one to one meeting')while($StartTime < $EndTime){

$MeetingEndTime=($StartTime + $meeting_duration_in_second);
$FiledArray1=array( 'conferenceslot_id','start_time','end_time','date');
$ValueArray1=array("'".$conferenceslot_id."'", "'".$StartTime."'", "'".$MeetingEndTime."'", "'".$date."'");	
Insert('O2O_Pre_Meetingslots',$FiledArray1,$ValueArray1);
$StartTime=$MeetingEndTime;
}
Update('config_settings', 'time_slot_settings =1', "where 1 limit 1");
SetMessage('Time Slots details are successfully added', 'green b f12');
return true;
}else{
SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysqli_error($con).' ........', 'red b f12');
return false;
}
}
}else{
SetMessage('This Time Slot is not Available!', 'red b f12');
return false;
}
}	}

function CompanyImport($filename){
global $verson;
move_uploaded_file($_FILES['import']['tmp_name'],$filename);
$TotalLines = $TotalLinesAllowed = count(file($filename));
if($verson=='demo'){
$TotalCompany=Rows('O2O_Pre_Companies','id','where 1');
$TotalLinesAllowed = (11-$TotalCompany);
}
$count=1; $noi=0; $flg=0;
$error_line=array(); $dplicate_record=array();
$handle = fopen($filename,"r");
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){ //3 while
if($count==1){
if(($data[0]!='company_name')&&($data[1]!='email')&&($data[2]!='website')&&($data[3]!='compnay_profile')&&($data[4]!='city')&&($data[5]!='country')&&($data[6]!='member_type')&&($data[7]!='participant_name')&&($data[8]!='job_title')&&($data[9]!='participant_email')&&($data[10]!='participant_contact_no')&&($data[11]!='number_of_table_required')){  
$flg=1;
break;
}
}
if($count > 1  && $count <= $TotalLinesAllowed) {	//5 if_4
$nol++;
if(empty($data[0]) || empty($data[1]) || empty($data[4]) || empty($data[5]) || is_numeric($data[6]) || 
empty($data[6]) || empty($data[7]) || !is_numeric($data[11]) || empty($data[11])){
$error_line[]=$count;
}elseif(!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,10}$", $data[1])){
$error_line[]=$count;
}else{ //6 else 1
$where = "where (name='".ucwords(tres($data[0]))."' 
And city='".ucwords(tres($data[4]))."' And country='".ucwords(tres($data[5]))."') 
OR email='".tres($data[1])."'  limit 1";
if(Rows('O2O_Pre_Companies','id',$where)){
$dplicate_record[]=$count;
}else{ //7 else 2
$MemberType=Select('member_type','id',"where member_type = '".ucwords(tres($data[6]))."' LIMIT 1");
if(count($MemberType)){
$member_id=$MemberType[0]['id'];
}else{
$member_id=Insert('member_type',"member_type","'".ucwords(tres($data[6]))."'");
}
$FiledArray=array( 'name','email','website','profile','city','country','member_id','table_required');
$ValueArray=array("'".tres(ucwords($data[0]))."'",
"'".tres($data[1])."'",
"'".tres($data[2])."'",
"'".tres($data[3])."'",
"'".tres(ucwords($data[4]))."'",
"'".tres(ucwords($data[5]))."'",
"'".tres($member_id)."'",
"'".tres($data[11])."'");
$company_id=Insert('O2O_Pre_Companies',$FiledArray,$ValueArray);
$FiledArray1=array( 'company_id','name','designation','email','mobile');
$p_name=explode('|',$data[7]);
$p_email=explode('|',$data[8]);
$p_designation=explode('|',$data[9]);
$p_mobile=explode('|',$data[10]);											
foreach($p_name as $k=>$name){
$ValueArray1=array("'".tres($company_id)."'",
"'".tres(ucwords($name))."'",
"'".tres(ucwords($p_designation[$k]))."'",
"'".tres($p_email[$k])."'",
"'".tres($p_mobile[$k])."'");
$participant_id=Insert('O2O_Pre_Participants',$FiledArray1,$ValueArray1);
}
$noi++;
} //7 end else 2							
} //6 end else 1							
}//5 end if_4
$count++;
}//3 end while
fclose($handle);
unset($filename);
if($flg==1){
$msg="The first line in the file must contain the field names as &quot; sample csv file &quot; and also given below:
<br />company_name, email, website, company_profile, city, country, member_type, participant_name, job_title, 
participant_email, participant_contact_no, number_of_table_required";
SetMessage($msg, 'red b f12');
}else{
Update('config_settings', 'import_company_settings=1', "where 1 limit 1");
$return='<span class="extra_text">Number of records: '.($TotalLines-1).'<br>
Imported: '.$noi.'<br>
Not imported: '.(($TotalLines-1)-$noi);
$nof=count($error_line); 
$nod=count($dplicate_record);
if($nof > 0){
$return.='<br>
These Lines have incomplete data:';
foreach($error_line as $key=>$ErrorInLine){
$return.=$ErrorInLine;
if($key < ($nof-1)) $return.=',&nbsp;';
}
} 
if($nod > 0){
$return.='<br>
These Lines are duplicates:';
foreach($dplicate_record as $key=>$DuplicateLine){
$return.=$DuplicateLine;
if($key < ($nod-1)) $return.=',&nbsp;';
}
} 
$return.='</span>';
return $return;
}
}function AddCompany($data_array=array()){
global $verson;  
if(count($data_array)){ 
$CountCompany=Rows('O2O_Pre_Companies','id','where 1');
if($CountCompany >= 10 && $verson=='demo'){
SetMessage('Sorry you cannot add more than ten(10) company in demo version of one2one scheduler. To allow you to 
add more company, please contact Allied International  Holdings Limited at +852 8125 7221 or email us at: 
<a href="mailto:info@alliedintholdings.com" target="_blank">info@alliedintholdings.com</a>', 'red b f12');
return false;
}else{
extract($data_array);
$where = "where (name='".ucwords(tres($name))."' 
And city='".ucwords(tres($city))."' And country='".ucwords(tres($country))."') 
OR email='".tres($email)."'  limit 1";
if(Rows('O2O_Pre_Companies','id',$where)){
SetMessage('company &quot;'.$name.'&quot; is already Exist', 'red b f12');
return false;
}else{ //7 else 2
$member_id=$member_type;
if($member_type=='Other'){
$member_id=Insert('member_type',"member_type","'".ucwords(tres($other))."'");
}
$FiledArray=array( 'name','email','website','city','country','member_id','table_required');
$ValueArray=array("'".tres(ucwords($name))."'",
"'".tres($email)."'",
"'".tres($website)."'",
"'".tres(ucwords($city))."'",
"'".tres(ucwords($country))."'",
"'".tres($member_id)."'",
"'".tres($table_required)."'");
$company_id=Insert('O2O_Pre_Companies',$FiledArray,$ValueArray);
$FiledArray1=array( 'company_id','name','designation','email','mobile');
foreach($participant as $k=>$p_name){
if(!empty($p_name)){
$ValueArray1=array("'".tres($company_id)."'",
"'".tres(ucwords($p_name))."'",
"'".tres(ucwords($designation[$k]))."'",
"'".tres($participant_email[$k])."'",
"'".tres($mobile[$k])."'");
$participant_id=Insert('O2O_Pre_Participants',$FiledArray1,$ValueArray1);
}
}
$noi++;
if(!$CountCompany)
Update('config_settings', 'import_company_settings=1', "where 1 limit 1");
SetMessage('Company details are successfully added', 'green b f12');
return true;
}
}
}
}function UpdateCompany($data_array=array()){
if(count($data_array) && ($data_array['CompanyID'] > 0)){ 
extract($data_array);
$where = "where id!=".$CompanyID."  AND ((name='".ucwords(tres($name))."' 
And city='".ucwords(tres($city))."' And country='".ucwords(tres($country))."') 
OR email='".tres($email)."')  limit 1";
if(Rows('O2O_Pre_Companies','id',$where)){
SetMessage('company &quot;'.$name.'&quot; is already Exist', 'red b f12');
return false;
}else{ //7 else 2
$member_id=$member_type;
if($member_type=='Other'){
$member_id=Insert('member_type',"member_type","'".ucwords(tres($other))."'");
}
$ValueArray=array("name='".tres(ucwords($name))."'",
"website='".tres($website)."'",
"city='".tres(ucwords($city))."'",
"country='".tres(ucwords($country))."'");
if($ClientSide=='ClientSide'){
$ValueArray[]="profile='".tres($profile)."'";
}else{			  
$ValueArray[]="email='".tres($email)."'";
$ValueArray[]="member_id='".tres($member_id)."'";
$ValueArray[]="table_required='".tres($table_required)."'";
}				  
Update('O2O_Pre_Companies',$ValueArray,'where id = '.$CompanyID.' limit 1');
SetMessage('Company details are successfully updated', 'green b f12');
return true;
}
}
}function UpdateParticipant($data_array=array()){
if(count($data_array) && ($data_array['ParticipantID'] > 0) && ($data_array['name'] !='')){ 
extract($data_array);
$ValueArray=array("name='".tres(ucwords($name))."'",
"email='".trim($email)."'",
"mobile='".tres($mobile)."'",
"designation='".tres(ucwords($designation))."'");
Update('O2O_Pre_Participants',$ValueArray,'where id = '.$ParticipantID.' limit 1');
SetMessage('Participant details are successfully updated', 'green b f12');
return true;
}
}function TableAllocation($data_array=array()){
extract($data_array);
Update('O2O_Event_Info', "allocate_table='".$allocate_table."'", "where 1 limit 1");
Update('member_type', "allocate_table=0", "where 1");
if(count($member_type))foreach($member_type as $k=> $member){
Update('member_type', "allocate_table=1", "where id=".$member);
}
Update('config_settings', 'table_allocation_settings=1', "where 1 limit 1");
SetMessage('Table Allocation details are successfully updated', 'green b f12');
return true;
}function SaveBoothDetails($data_array=array()){
extract($data_array);
if($is_booth==1){
Update('O2O_Event_Info', "is_bootth=1", "where 1 limit 1");
$FiledArray=array( 'company_id','booth_name','is_meeting_in_booth');
if(count($booth_name))foreach($booth_name as $k=> $booth){
$CompanyName=Select('O2O_Pre_Companies','name','where id='.trim($company[$k]).' LIMIT 1');
if(!Rows('booth_details','id','where (company_id='.trim($company[$k]).' OR booth_name = "'.tres(ucwords($booth)).'") LIMIT 1')){
$ID=array();
if($is_meeting_in_booth[$k]){
$TableIDArray=Select('O2O_Pre_Table', 'id', 'where company_id='.$company[$k]);
if(count($TableIDArray))foreach($TableIDArray as $I=>$TableID){
$ID[]=$TableID['id'];
}
$TblID=implode(',', $ID);
}
if((count($ID))&& (Rows('O2O_Pre_Scheduledmeetings','id','where (scheduled_with_table_id IN('.$TblID.') OR table_id IN('.$TblID.')) 
AND (booth_id = 0) LIMIT 1'))){
SetMessage('you must delete all meetings which is already set for "'.$CompanyName[0]['name'].'"', 'red b f12');
}else{
$ValueArray=array("'".$company[$k]."'",
"'".tres(ucwords($booth))."'",
"'".$is_meeting_in_booth[$k]."'");
if(!empty($booth)){
Insert('booth_details', $FiledArray, $ValueArray);
SetMessage('Booth details are successfully added', 'green b f12');
}
}
}else{
SetMessage('Booth name "'.$booth.'" is already exist OR booth is already allocated to company "'.$CompanyName[0]['name'].'"', 'red b f12');
}
}
}
Update('config_settings', 'booth_settings=1', "where 1 limit 1");
return true;
}function UpdateBoothDetails($data_array=array()){
extract($data_array);
if(count($booth_name))foreach($booth_name as $k=> $booth){
$company_id2=trim($company[$k]);
$IsTableAllocatin=0;
if(!Rows('booth_details','id','where (company_id='.$company_id2.' OR booth_name = "'.tres(ucwords($booth)).'") 
AND id !='.$BoothDetailsID.' LIMIT 1')){
$BoothDetails=Select('booth_details','*','where id='.$BoothDetailsID.' LIMIT 1');
extract($BoothDetails[0]);
if( ($company_id != $company_id2) || ($is_meeting_in_booth != $is_meeting_in_booth[$k]) ){
$ID=array();
$TableIDArray=Select('O2O_Pre_Table', 'id', 'where company_id IN('.$company_id.','.$company_id2.')');
if(count($TableIDArray))foreach($TableIDArray as $I=>$TableID){
$ID[]=$TableID['id'];
}
$TblID=implode(',', $ID);
if(count($ID)){
if(Rows('O2O_Pre_Scheduledmeetings','id','where (scheduled_with_table_id IN('.$TblID.') OR table_id IN('.$TblID.')) AND (booth_id = 0) LIMIT 1')){
$company1=Value('O2O_Pre_Companies', 'name', 'where id ='.$company_id.' limit 1 ');
$company1=str_replace('\\','',$company1);
$company2=Value('O2O_Pre_Companies', 'name', 'where id ='.$company_id2.' limit 1 ');
$company2=str_replace('\\','',$company2);
SetMessage('you must delete all meetings which is already set for "'.$company1.'", "'.$company2.'"','red b f12');
return false;
}else{
Delete('O2O_Pre_Table', 'where company_id IN('.$company_id.','.$company_id2.')');
$IsTableAllocatin=1;
}
}
}
$ValueArray=array(
"company_id='".$company_id2."'",
"booth_name='".tres(ucwords($booth))."'",
"is_meeting_in_booth='".$is_meeting_in_booth[$k]."'"
);

Update('booth_details',$ValueArray, "where id=".$BoothDetailsID." limit 1");

if($IsTableAllocatin){

AllocateTable($company_id);
AllocateTable($company_id2);

}

SetMessage('Booth details are successfully updated', 'green b f12');

}else{

$CompanyName=Select('O2O_Pre_Companies','name','where id='.$company_id2.' LIMIT 1');
SetMessage('Booth name "'.$booth.'" is already exist OR booth is already allocated to company "'.$CompanyName[0]['name'].'"', 'red b f12');
}
}
return true;
}


function SaveSponsorsDetails($data_array=array()){
extract($data_array);
if($is_sponsors==1){
Update('O2O_Event_Info', "is_sponsors=1", "where 1 limit 1");
if($sponsors_participate_in_meetings==1){
$logo_dir='images/company_logo/';
if(count($companyID))foreach($companyID as $k=> $company){
if(!Rows('sponsors_details','id','where SponsorsCompanyID='.$company.' LIMIT 1')){
if($company > 0)Insert('sponsors_details', 'SponsorsCompanyID', $company);
if(($_FILES['CompanyLogo']['name'][$k]!='') && $image=image_upload($_FILES['CompanyLogo'],$logo_dir,$k)){
Update('O2O_Pre_Companies', "logo='".trim($image)."'", "where id=".$company." limit 1");
createThumbs( $logo_dir.$image, $logo_dir.'Thumbs/'.$image,123);
}
}
}
}else{
$logo_dir='images/SponsorsLogo/';
$FiledArray=array( 'SponsorsCompanyID','website','logo');
if(count($sponsors))foreach($sponsors as $k=> $sponsors_name){
$sponsors_name=tres(ucwords($sponsors_name));
if(!Rows('sponsors_details','id','where SponsorsCompanyID="'.$sponsors_name.'" LIMIT 1')){
if(($_FILES['SponsorsLogo']['name'][$k]!='') && $image=image_upload($_FILES['SponsorsLogo'],$logo_dir,$k)){
createThumbs( $logo_dir.$image, $logo_dir.'Thumbs/'.$image,123);
}else{
$image='';
}
$ValueArray=array("'".$sponsors_name."'",
"'".trim($website[$k])."'",
"'".trim($image)."'");
if(!empty($sponsors_name))Insert('sponsors_details', $FiledArray, $ValueArray);
}
}
}
}

Update('config_settings', 'sponsors_settings=1', "where 1 limit 1");
SetMessage('Sponsors details are successfully added', 'green b f12');
return true;
}

function SkipedComleted($skiped,$completed){
$ValueArray=array(
"skiped='".trim($skiped)."'",
"completed='".trim($completed)."'"
);
Update('config_settings',$ValueArray, "where 1 limit 1");
redirect('index.php');
}

function SaveEmailMessge($data_array=array()){
extract($data_array);
if(Rows('O2O_Pre_Email_Templates','id'," where `purpose` = '".tres($purpose)."' limit 1")){
SetMessage("E-mail Purpose &quot;".$purpose."&nbsp; is already Exist!", 'red b f12');
return false;
}
else{
$FiledArray=array( 'purpose','subject','message','from_email');
$ValueArray=array("'".trim($purpose)."'",
"'".tres($subject)."'",
"'".tres($message)."'",
"'".tres($from_email)."'");
Insert('O2O_Pre_Email_Templates', $FiledArray, $ValueArray);
SetMessage('You have successfully added the E-mail Message.', 'green b f12');
return true; 
}
}

function UpdateEmailMessge($data_array=array()){
extract($data_array);
if(Rows('O2O_Pre_Email_Templates','id'," where `purpose` = '".tres($purpose)."' AND id !=".$emailsettingID." limit 1")){
SetMessage("E-mail Purpose &quot;".$purpose."&nbsp; is already Exist!", 'red b f12');
return false;
}
else{
$ValueArray=array("purpose='".trim($purpose)."'",
"subject='".tres($subject)."'",
"message='".tres($message)."'",
"from_email='".tres($from_email)."'");
Update('O2O_Pre_Email_Templates', $ValueArray, "where id =".$emailsettingID." limit 1");
SetMessage('You have Sucsessfully updated E-mail Message', 'green b f12');
return true; 
}
}

function EmailMessageSent($ScheduledmeetingID,$purpose){
    global $prefix;
    global $con;
    if(($ScheduledmeetingID > 0)&&($purpose != '')){
        $select_1=mysqli_query($con,"select * from ".$prefix."O2O_Event_Info");
        $row_1=mysqli_fetch_array($select_1);
        
        $short_name=$row_1["short_company_name"];
        
        $logo_admin=$row_1["logo"];
        
        global $name, $short_company_name,$title,$ConferenceStartEndDate,$email,$AdminCompanyLogo,$address,$contact_no,$fax,$sent_email;

        $tmp_img_path=$logo_admin;
        $message_image = '<img src='.$tmp_img_path.'>';
        
        $select_email = Select("O2O_Pre_Email_Templates","subject,message,from_email","where purpose = '".$purpose."' and deleted=1  LIMIT 1");
        if(count($select_email) && !empty($select_email[0]['message']) && !empty($select_email[0]['subject'])){
            extract($select_email[0]);             
            $ScheduledmeetingArray=Select('O2O_Pre_Scheduledmeetings', 'table_id,table_no, scheduled_with_table_id, meetingslots_id','where id='.$ScheduledmeetingID.' LIMIT 1');
            
            $TableID=$ScheduledmeetingArray[0]['table_id'];
            $table_no=$ScheduledmeetingArray[0]['table_no'];
            $MWTID=$ScheduledmeetingArray[0]['scheduled_with_table_id'];
            $MsID=$ScheduledmeetingArray[0]['meetingslots_id'];
            
            
            ////append
            $subject=str_replace("\\","", $subject);
               
            $subject=str_replace("{company short name}",$short_company_name,$subject);
           
            $subject=str_replace("{conference name}",$title, $subject);
           
            $subject=str_replace("{conference start end date}",$ConferenceStartEndDate, $subject);
           
            $subject=str_replace("\\","", $subject);
           
            $from_email=str_replace("\\","", $from_email);
           
            $from_email=str_replace("AdminEmail",$email, $from_email);
           
            $from_email=str_replace("\\","", $from_email);
           
            $message=str_replace("\\","", $message);
               
                
				  
            ////append
            $MeetingSet=Select('O2O_Pre_Companies a,'.$prefix.'O2O_Pre_Table b','a.name,a.country,a.email, b.participant_id',"WHERE b.id =".$TableID." AND a.id=b.company_id LIMIT 1");   

            if(count($MeetingSet)){
                $IPIdArray=explode(',', $MeetingSet[0]['participant_id']);
                $e=1;
                $IPN='';
                
                $Icompany=str_replace('\\','',$MeetingSet[0]['name']);
                $Icompany = str_replace("&", "&amp;", $Icompany);
                $Icountry=str_replace('\\','',$MeetingSet[0]['country']);
                $Iemail=trim($MeetingSet[0]['email']);
            
                if($r=count($IPIdArray))
                foreach($IPIdArray as $PId){
                    if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))){
                        $Pemail=Value('O2O_Pre_Participants','email','where id='.$PId.' LIMIT 1');

                        
                        $IPN.= str_replace('\\','',$Pname);
                        $IPNEMAIL.= str_replace('\\','',$Pemail);
                        if($r > 1 && $e < $r){
                            $IPN.=  ',';
                            $IPNEMAIL.=  ',';
                            $e++;
                        }
                    }
                }
            }
    
            $MeetingSet1=Select('O2O_Pre_Companies a,'.$prefix.'O2O_Pre_Table b','a.name, a.country,a.email, b.participant_id',"WHERE b.id =".$MWTID." AND a.id=b.company_id LIMIT 1");

            if(count($MeetingSet1)){
                $MWPIdArray=explode(',', $MeetingSet1[0]['participant_id']);
                $e=1;
                $MWPN='';
                $MWcompany=str_replace('\\','',$MeetingSet1[0]['name']);
                $MWcompany = str_replace("&", "&amp;", $MWcompany);
                $MWcountry=str_replace('\\','',$MeetingSet1[0]['country']);
                
                $MWemail=$MeetingSet1[0]['email'];
                if($r=count($MWPIdArray))foreach($MWPIdArray as $PId){
                    if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))  ){
                        $Pemail=Value('O2O_Pre_Participants','email','where id='.$PId.' LIMIT 1');

                        

                        $MWPN.= str_replace('\\','',$Pname);
                        $MWPEMAIL.= str_replace('\\','',$Pemail);
                        if($r > 1 && $e < $r){ $MWPN.=  ','; $MWPEMAIL.=  ','; $e++; }
                
                    }
                }
            }

            //$MeetingslotsArray=Select('O2O_Pre_Meetingslots','*','WHERE id ='.$MsID.'  LIMIT 1');

		    //$meeting_date=date('d F Y',$MeetingslotsArray[0]['date']);
		    //
		    //$message=str_replace("{meeting date}",$meeting_date, $message);




            $message=str_replace("{conference name}",$title, $message);
               
            $message=str_replace("{company logo}",$message_image, $message);
           
            $message=str_replace("AdminEmail",$email, $message);
            $message=str_replace("{Admin Email}",$email, $message);
           
            $message=str_replace("{company short name}",$short_company_name, $message);
            $message=str_replace("{admin address}",$address,$message);
            $message=str_replace("{admin telephone}",$contact_no,$message);
            $message=str_replace("{admin fax}",$fax,$message);
            
            $message=str_replace("{table no}",$table_no, $message);
            $message1 = $message = str_replace("BaseDir",$_SESSION['base_dir'],$message);
            
            
            if($purpose=="Meeting Canceled Information")
			    {
					if($_SESSION['session_admin']!='')
				 {
				 $message1=str_replace("{canceled comp}","Administrator", $message1);
						$message=str_replace("{canceled comp}","Administrator", $message);
				 }
				 else{
			 //	echo $TableID;
			 	//echo "mw".$_SESSION["_TaBlE_ID"];die;
					if(trim($TableID)==trim($_SESSION["_TaBlE_ID"]))
					{	//echo "here1";die;				
						$message1=str_replace("{canceled comp}",$Icompany, $message1);
						$message=str_replace("{canceled comp}",$Icompany, $message);
						$message=str_replace("Meeting was cancelled by"," ", $message);
					}
					else
					{//echo "here";die;
						$message=str_replace("{canceled comp}",$MWcompany, $message);
						$message1=str_replace("{canceled comp}",$MWcompany, $message1);
						$message1=str_replace("Meeting was cancelled by"," ", $message1);
					}
				 }
					 
			   }
			   
                         //   echo $Icompany."mw".$MWcompany.$message;die;
                $message=str_replace("{company name}",$Icompany, $message);
               
                $message=str_replace("{participant name}",$IPN, $message);
               
                $message=str_replace("{other company participant name}",$MWPN, $message);
               
                $message=str_replace("{other company name}",$MWcompany, $message);
               
                $message=str_replace("{other company country}",$MWcountry, $message);
				
				$message=str_replace("{other company participant email}",$MWPEMAIL, $message);
				
				
				
			    $message1=str_replace("{other company participant email}",$MWPEMAIL, $message1); 
               
                $message1=str_replace("{company name}",$MWcompany, $message1);
               
                $message1=str_replace("{participant name}",$MWPN, $message1);
				
		        $message1=str_replace("{other company participant name}",$IPN, $message1);
                
                $message1=str_replace("{other company name}",$Icompany, $message1);
               
                $message1=str_replace("{other company country}",$Icountry, $message1);
               
                $message1=str_replace("{table no}",$table_no, $message1);
               
 
             $subject = $subject;

            $dom = new DOMDocument();
            $dom->loadHTML($message);

            //DOMreplaceImage($message_image, $dom);
            DOMreplaceImage("https://app.one2onescheduler.com/".$short_company_name, $dom);
            DOMreplaceImage($Icompany, $dom);
            DOMreplaceImage($title, $dom);
            DOMreplaceImage($email, $dom);
            DOMreplaceImage($short_company_name, $dom);
            DOMreplaceImage($address, $dom);
            DOMreplaceImage($contact_no, $dom);
            DOMreplaceImage($fax, $dom);
            DOMreplaceImage($table_no, $dom);
            DOMreplaceImage($meeting_date, $dom);
            DOMreplaceImage($meeting_start_time, $dom);
            DOMreplaceImage($meeting_end_time, $dom);
            DOMreplaceImage($IPN, $dom);
            DOMreplaceImage($MWPN, $dom);
            DOMreplaceImage($MWcompany, $dom);
            DOMreplaceImage($MWcountry, $dom);
            DOMreplaceImage($MWPEMAIL, $dom);
            
            
            $dom1 = new DOMDocument();
            $dom1->loadHTML($message1);

            //DOMreplaceImage($message_image, $dom1);
            DOMreplaceImage("https://app.one2onescheduler.com/".$short_company_name, $dom1);
            DOMreplaceImage($Icompany, $dom1);
            DOMreplaceImage($title, $dom1);
            DOMreplaceImage($email, $dom1);
            DOMreplaceImage($short_company_name, $dom1);
            DOMreplaceImage($address, $dom1);
            DOMreplaceImage($contact_no, $dom1);
            DOMreplaceImage($fax, $dom1);
            DOMreplaceImage($table_no, $dom1);
            DOMreplaceImage($meeting_date, $dom1);
            DOMreplaceImage($meeting_start_time, $dom1);
            DOMreplaceImage($meeting_end_time, $dom1);
            DOMreplaceImage($IPN, $dom1);
            DOMreplaceImage($MWPN, $dom1);
            DOMreplaceImage($MWcompany, $dom1);
            DOMreplaceImage($Icountry, $dom1);
            DOMreplaceImage($MWPEMAIL, $dom1);
            
            $subject = $subject;

            $message = DOMinnerHTML($dom->getElementsByTagName('body')->item(0));
            $message1 = DOMinnerHTML($dom1->getElementsByTagName('body')->item(0));

            $my_email_bcc[] = 'cit.seema@gmail.com';
            
            $my_email_bcc[] = 'seema.vidya@cheshtainfotech.com';

            $from_email = $title."<notification@one2onescheduler.com>";
            $from_name = $title;
            $date=date("Y-m-d");
            $time=date("H:i:s");
            $date_time=$date." ".$time;
            $bcc_email= "seema.vidya@cheshtainfotech.com";
            $EachPEMAIL=explode(",",$IPNEMAIL);
            $Pre_user = mysqli_query($con,"select * from ".$prefix."O2O_Event_Info") or die(mysqli_error($con));
            $Pre_user_data = mysqli_fetch_array($Pre_user);

            if($Pre_user_data["reply_to_status"]==1){
                $reply=$ADD_REPLY_to_ADMIN_EMAIL=$Pre_user_data["reply_to_email"];
            }
            if($Pre_user_data["reply_to_status"]==0){
                $reply=$ADD_REPLY_to_ADMIN_EMAIL='';
            }            
//echo $message."<br/><br/><br/>".$message1;die;

            

            foreach($EachPEMAIL as $key_1=>$PEMAIL){
                if($PEMAIL!=""  ){
                    
                    $message_new = $message;
                    
                    $IPIdArray_imp = implode(",",$IPIdArray);
                    
		            $get_part_name=mysqli_query($con,"select name,meeting_location from ".$prefix."O2O_Pre_Participants where id in($IPIdArray_imp) and  email='".$PEMAIL."'");
		            $fetch_name=mysqli_fetch_array($get_part_name);
		            $part_name=$fetch_name['name'];
		            $P_meeting_location = $fetch_name['meeting_location'];


		            date_default_timezone_set($P_meeting_location);
                    
                    $MeetingslotsArray=Select('O2O_Pre_Meetingslots','*','WHERE id ='.$MsID.'  LIMIT 1');
                    
                    $meeting_date=date('d F Y',$MeetingslotsArray[0]['start_time']);
                    $meeting_start_time=date('H:i',$MeetingslotsArray[0]['start_time']);
		            $meeting_end_time=date('H:i',$MeetingslotsArray[0]['end_time']);
                    
                    $message_new=str_replace("{meeting date}",$meeting_date, $message_new);
		            $message_new=str_replace("{start time}",$meeting_start_time, $message_new);
		            $message_new=str_replace("{end time}",$meeting_end_time, $message_new);
                    

		            $bcc = $cc = $reply = "";
		            sendMailgunMail($PEMAIL,$message_new,$subject,$from_email,$bcc,$cc,$reply);
                }
            }
            
            $EMWTPEMAIL=explode(",",$MWPEMAIL);
            
            foreach($EMWTPEMAIL as $PEACHMAIL){               
                if($PEACHMAIL!="" ){
                    
                    $message1_new = $message1;
                    $MWPIdArray_imp = implode(",",$MWPIdArray);
	                $get_part_name1=mysqli_query($con,"select name,meeting_location from ".$prefix."O2O_Pre_Participants where id in($MWPIdArray_imp) and  email='".$PEACHMAIL."'");
	                $fetch_name1=mysqli_fetch_array($get_part_name1);
	                $part_name1=$fetch_name1['name'];

		            $P_meeting_location1 = $fetch_name1['meeting_location'];

		            date_default_timezone_set($P_meeting_location1);
                    
                    $MeetingslotsArray1 = Select('O2O_Pre_Meetingslots','*','WHERE id ='.$MsID.'  LIMIT 1');
                    $meeting_date = date('d F Y',$MeetingslotsArray1[0]['start_time']);
                    $meeting_start_time = date('H:i',$MeetingslotsArray1[0]['start_time']);
		            $meeting_end_time = date('H:i',$MeetingslotsArray1[0]['end_time']);

                    $message1_new = str_replace("{meeting date}",$meeting_date, $message1_new);
		            $message1_new = str_replace("{start time}",$meeting_start_time, $message1_new);
		            $message1_new = str_replace("{end time}",$meeting_end_time, $message1_new);


	                $bcc = $cc = $reply = "";
	                sendMailgunMail($PEACHMAIL,$message1_new,$subject,$from_email,$bcc,$cc,$reply);
                }
            }
            
        }
    }
}

function EmailMessageSent_000($ScheduledmeetingID,$purpose){
    global $prefix;
    global $con;
    if(($ScheduledmeetingID > 0)&&($purpose != '')){
        $select_1=mysqli_query($con,"select * from ".$prefix."O2O_Event_Info");
        $row_1=mysqli_fetch_array($select_1);
        
        $short_name=$row_1["short_company_name"];
        
        $logo_admin=$row_1["logo"];
        
        global $name, $short_company_name,$title,$ConferenceStartEndDate,$email,$AdminCompanyLogo,$address,$contact_no,$fax,$sent_email;

        $tmp_img_path=$logo_admin;
        $message_image = '<img src='.$tmp_img_path.'>';
        
        $select_email = Select("O2O_Pre_Email_Templates","subject,message,from_email","where purpose = '".$purpose."' and deleted=1  LIMIT 1");
        if(count($select_email) && !empty($select_email[0]['message']) && !empty($select_email[0]['subject'])){
            extract($select_email[0]);             
            $ScheduledmeetingArray=Select('O2O_Pre_Scheduledmeetings', 'table_id,table_no, scheduled_with_table_id, meetingslots_id','where id='.$ScheduledmeetingID.' LIMIT 1');
            
            $TableID=$ScheduledmeetingArray[0]['table_id'];
            $table_no=$ScheduledmeetingArray[0]['table_no'];
            $MWTID=$ScheduledmeetingArray[0]['scheduled_with_table_id'];
            $MsID=$ScheduledmeetingArray[0]['meetingslots_id'];
            $MeetingslotsArray=Select('O2O_Pre_Meetingslots','*','WHERE id ='.$MsID.'  LIMIT 1');
            $meeting_date=date('d F Y',$MeetingslotsArray[0]['date']);
            $meeting_start_time=date('H:i',$MeetingslotsArray[0]['start_time']);
            $meeting_end_time=date('H:i',$MeetingslotsArray[0]['end_time']);
            ////append
            $subject=str_replace("\\","", $subject);
               
                $subject=str_replace("{company short name}",$short_company_name,$subject);
               
                $subject=str_replace("{conference name}",$title, $subject);
               
                $subject=str_replace("{conference start end date}",$ConferenceStartEndDate, $subject);
               
                $subject=str_replace("\\","", $subject);
               
                $from_email=str_replace("\\","", $from_email);
               
                $from_email=str_replace("AdminEmail",$email, $from_email);
               
                $from_email=str_replace("\\","", $from_email);
               
                $message=str_replace("\\","", $message);
               
                $message=str_replace("{conference name}",$title, $message);
               
                $message=str_replace("{company logo}",$message_image, $message);
               
                $message=str_replace("AdminEmail",$email, $message);
                $message=str_replace("{Admin Email}",$email, $message);
               
                $message=str_replace("{company short name}",$short_company_name, $message);
                $message=str_replace("{admin address}",$address,$message);
                $message=str_replace("{admin telephone}",$contact_no,$message);
                $message=str_replace("{admin fax}",$fax,$message);
                $message=str_replace("{meeting date}",$meeting_date, $message);
                $message=str_replace("{start time}",$meeting_start_time, $message);
                $message=str_replace("{table no}",$table_no, $message);
                $message=str_replace("BaseDir",$_SESSION['base_dir'],$message);
                $message1=$message=str_replace("{end time}",$meeting_end_time, $message);
				  
            ////append
            $MeetingSet=Select('O2O_Pre_Companies a,'.$prefix.'O2O_Pre_Table b','a.name,a.country,a.email, b.participant_id',"WHERE b.id =".$TableID." AND a.id=b.company_id LIMIT 1");   

            if(count($MeetingSet)){
                $IPIdArray=explode(',', $MeetingSet[0]['participant_id']);
                $e=1;
                $IPN='';
                
                $Icompany=str_replace('\\','',$MeetingSet[0]['name']);
                $Icountry=str_replace('\\','',$MeetingSet[0]['country']);
                $Iemail=trim($MeetingSet[0]['email']);
            
                if($r=count($IPIdArray))
                foreach($IPIdArray as $PId){
                    if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))){
                        $Pemail=Value('O2O_Pre_Participants','email','where id='.$PId.' LIMIT 1');
                        $IPN.= str_replace('\\','',$Pname);
                        $IPNEMAIL.= str_replace('\\','',$Pemail);
                        if($r > 1 && $e < $r){
                            $IPN.=  ',';
                            $IPNEMAIL.=  ',';
                            $e++;
                        }
                    }
                }
            }
    
            $MeetingSet1=Select('O2O_Pre_Companies a,'.$prefix.'O2O_Pre_Table b','a.name, a.country,a.email, b.participant_id',"WHERE b.id =".$MWTID." AND a.id=b.company_id LIMIT 1");

            if(count($MeetingSet1)){
                $MWPIdArray=explode(',', $MeetingSet1[0]['participant_id']);
                $e=1;
                $MWPN='';
                $MWcompany=str_replace('\\','',$MeetingSet1[0]['name']);
                $MWcountry=str_replace('\\','',$MeetingSet1[0]['country']);
                
                $MWemail=$MeetingSet1[0]['email'];
                if($r=count($MWPIdArray))foreach($MWPIdArray as $PId){
                    if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))  ){
                        $Pemail=Value('O2O_Pre_Participants','email','where id='.$PId.' LIMIT 1');
                        $MWPN.= str_replace('\\','',$Pname);
                        $MWPEMAIL.= str_replace('\\','',$Pemail);
                        if($r > 1 && $e < $r){ $MWPN.=  ','; $MWPEMAIL.=  ','; $e++; }
                
                    }
                }
            }
            
            if($purpose=="Meeting Canceled Information")
			    {
					if($_SESSION['session_admin']!='')
				 {
				 $message1=str_replace("{canceled comp}","Administrator", $message1);
						$message=str_replace("{canceled comp}","Administrator", $message);
				 }
				 else{
			 //	echo $TableID;
			 	//echo "mw".$_SESSION["_TaBlE_ID"];die;
					if(trim($TableID)==trim($_SESSION["_TaBlE_ID"]))
					{	//echo "here1";die;				
					$message1=str_replace("{canceled comp}",$Icompany, $message1);
						$message=str_replace("{canceled comp}",$Icompany, $message);
					$message=str_replace("Meeting was cancelled by"," ", $message);
					}
					else
					{//echo "here";die;
						$message=str_replace("{canceled comp}",$MWcompany, $message);
							$message1=str_replace("{canceled comp}",$MWcompany, $message1);
					$message1=str_replace("Meeting was cancelled by"," ", $message1);
					}
				 }
					 
			   }
			   
                         //   echo $Icompany."mw".$MWcompany.$message;die;
                $message=str_replace("{company name}",$Icompany, $message);
               
                $message=str_replace("{participant name}",$IPN, $message);
               
                $message=str_replace("{other company participant name}",$MWPN, $message);
               
                $message=str_replace("{other company name}",$MWcompany, $message);
               
                $message=str_replace("{other company country}",$MWcountry, $message);
				
				$message=str_replace("{other company participant email}",$MWPEMAIL, $message);
				
				
				
			    $message1=str_replace("{other company participant email}",$MWPEMAIL, $message1); 
               
                $message1=str_replace("{company name}",$MWcompany, $message1);
               
                $message1=str_replace("{participant name}",$MWPN, $message1);
				
		        $message1=str_replace("{other company participant name}",$IPN, $message1);
                
                $message1=str_replace("{other company name}",$Icompany, $message1);
               
                $message1=str_replace("{other company country}",$Icountry, $message1);
               
                $message1=str_replace("{table no}",$table_no, $message1);
               
 
             $subject = $subject;

            $dom = new DOMDocument();
            $dom->loadHTML($message);

            DOMreplaceImage($message_image, $dom);
            DOMreplaceImage("https://one2onescheduler.com/".$short_company_name, $dom);
            DOMreplaceImage($Icompany, $dom);
            DOMreplaceImage($title, $dom);
            DOMreplaceImage($email, $dom);
            DOMreplaceImage($short_company_name, $dom);
            DOMreplaceImage($address, $dom);
            DOMreplaceImage($contact_no, $dom);
            DOMreplaceImage($fax, $dom);
            DOMreplaceImage($meeting_date, $dom);
            DOMreplaceImage($meeting_start_time, $dom);
            DOMreplaceImage($table_no, $dom);
            DOMreplaceImage($meeting_end_time, $dom);  
            DOMreplaceImage($IPN, $dom);
            DOMreplaceImage($MWPN, $dom);
            DOMreplaceImage($MWcompany, $dom);
            DOMreplaceImage($MWcountry, $dom);
            DOMreplaceImage($MWPEMAIL, $dom);
            
            
            $dom1 = new DOMDocument();
            $dom1->loadHTML($message1);

            DOMreplaceImage($message_image, $dom1);
            DOMreplaceImage("https://one2onescheduler.com/".$short_company_name, $dom1);
            DOMreplaceImage($Icompany, $dom1);
            DOMreplaceImage($title, $dom1);
            DOMreplaceImage($email, $dom1);
            DOMreplaceImage($short_company_name, $dom1);
            DOMreplaceImage($address, $dom1);
            DOMreplaceImage($contact_no, $dom1);
            DOMreplaceImage($fax, $dom1);
            DOMreplaceImage($meeting_date, $dom1);
            DOMreplaceImage($meeting_start_time, $dom1);
            DOMreplaceImage($table_no, $dom1);
            DOMreplaceImage($meeting_end_time, $dom1);  
            DOMreplaceImage($IPN, $dom1);
            DOMreplaceImage($MWPN, $dom1);
            DOMreplaceImage($MWcompany, $dom1);
            DOMreplaceImage($Icountry, $dom1);
            DOMreplaceImage($MWPEMAIL, $dom1);
            
            $subject = $subject;

            $message = DOMinnerHTML($dom->getElementsByTagName('body')->item(0));
            $message1 = DOMinnerHTML($dom1->getElementsByTagName('body')->item(0));

            $my_email_bcc[] = 'cit.seema@gmail.com';
            
            $my_email_bcc[] = 'seema.vidya@cheshtainfotech.com';

            $from_email = $title."<notification@one2onescheduler.com>";
            $from_name = $title;
            $date=date("Y-m-d");
            $time=date("H:i:s");
            $date_time=$date." ".$time;
            $bcc_email= "seema.vidya@cheshtainfotech.com";
            $EachPEMAIL=explode(",",$IPNEMAIL);
            $Pre_user = mysqli_query($con,"select * from ".$prefix."O2O_Event_Info") or die(mysqli_error($con));
            $Pre_user_data = mysqli_fetch_array($Pre_user);

            if($Pre_user_data["reply_to_status"]==1){
                $reply=$ADD_REPLY_to_ADMIN_EMAIL=$Pre_user_data["reply_to_email"];
            }
            if($Pre_user_data["reply_to_status"]==0){
                $reply=$ADD_REPLY_to_ADMIN_EMAIL='';
            }            
//echo $message."<br/><br/><br/>".$message1;die;

            foreach($EachPEMAIL as $key_1=>$PEMAIL){
                if($PEMAIL!=""  ){
		            $get_part_name=mysqli_query($con,"select name from ".$prefix."O2O_Pre_Participants where email='".$PEMAIL."'");
		            $fetch_name=mysqli_fetch_array($get_part_name);
		            $part_name=$fetch_name['name'];

		            //$PEMAIL = "nikheel.pawale@cheshtainfotech.com";
		            //$PEMAIL = "cit.suyog@gmail.com";

		            $bcc = $cc = $reply = "";
		            sendMailgunMail($PEMAIL,$message,$subject,$from_email,$bcc,$cc,$reply);
                }
            }
            
            $EMWTPEMAIL=explode(",",$MWPEMAIL);
            foreach($EMWTPEMAIL as $PEACHMAIL){               
                if($PEACHMAIL!="" ){  
	                $get_part_name1=mysqli_query($con,"select name from ".$prefix."O2O_Pre_Participants where email='".$PEACHMAIL."'");
	                $fetch_name1=mysqli_fetch_array($get_part_name1);
	                $part_name1=$fetch_name1['name'];

	                $bcc = $cc = $reply = "";
	                sendMailgunMail($PEACHMAIL,$message1,$subject,$from_email,$bcc,$cc,$reply);
                }
            }
        }
    }
}

function EmailMessageSentOld($ScheduledmeetingID,$purpose){
    global $prefix;
    global $con;
    if(($ScheduledmeetingID > 0)&&($purpose != '')){
        $select_1=mysqli_query($con,"select * from ".$prefix."O2O_Event_Info");
        $row_1=mysqli_fetch_array($select_1);
        
        $short_name=$row_1["short_company_name"];
        
        $logo_admin=$row_1["logo"];
        
        global $name, $short_company_name,$title,$ConferenceStartEndDate,$email,$AdminCompanyLogo,$address,$contact_no,$fax,$sent_email;
        //	$short_name='DEMO_2014';
        
     //   print_r($title);die;
        $tmp_img_path=$logo_admin;
        $message_image = '<img src='.$tmp_img_path.'>';
        
        $select_email = Select("O2O_Pre_Email_Templates","subject,message,from_email","where purpose = '".$purpose."' and deleted=1  LIMIT 1");
        if(count($select_email) && !empty($select_email[0]['message']) && !empty($select_email[0]['subject'])){
        //&& !empty($select_email[0]['from_email'])
            extract($select_email[0]);             
            $ScheduledmeetingArray=Select('O2O_Pre_Scheduledmeetings', 'table_id,table_no, scheduled_with_table_id, meetingslots_id','where id='.$ScheduledmeetingID.' LIMIT 1');
            
            $TableID=$ScheduledmeetingArray[0]['table_id'];
            $table_no=$ScheduledmeetingArray[0]['table_no'];
            $MWTID=$ScheduledmeetingArray[0]['scheduled_with_table_id'];
            $MsID=$ScheduledmeetingArray[0]['meetingslots_id'];
            $MeetingslotsArray=Select('O2O_Pre_Meetingslots','*','WHERE id ='.$MsID.'  LIMIT 1');
            $meeting_date=date('d F Y',$MeetingslotsArray[0]['date']);
            $meeting_start_time=date('H:i',$MeetingslotsArray[0]['start_time']);
            $meeting_end_time=date('H:i',$MeetingslotsArray[0]['end_time']);

            $subject=str_replace("\\","", $subject);
            $subject=str_replace("{company short name}",$short_company_name,$subject);
            $subject=str_replace("{conference name}",$title, $subject);
            $subject=str_replace("{conference start end date}",$ConferenceStartEndDate, $subject);
            $subject=str_replace("\\","", $subject);
       // print_r($meeting_start_time);die;
            $from_email=str_replace("\\","", $from_email);
            //$from_email=str_replace("AdminEmail",$email, $from_email);
            $from_email=str_replace("{Admin Email}",$email, $from_email);
            $from_email=str_replace("\\","", $from_email);

            $message=str_replace("\\","", $message);
            $message=str_replace("{conference name}",$title, $message);
            $message=str_replace("{company logo}",$message_image, $message);
            //$message=str_replace("AdminEmail",$email, $message);
            $message=str_replace("{Admin Email}",$email, $message);
            $message=str_replace("{company short name}",$short_company_name, $message);
            $message=str_replace("{conference name}",$title, $message);
            $message=str_replace("{admin address}",$address,$message);
            $message=str_replace("{admin telephone}",$contact_no,$message);
            $message=str_replace("{admin fax}",$fax,$message);
            $message=str_replace("{meeting date}",$meeting_date, $message);
            $message=str_replace("{start time}",$meeting_start_time, $message);
            $message=str_replace("{table no}",$table_no, $message);
            $message=str_replace("BaseDir",$_SESSION['base_dir'],$message);
            $message1=$message=str_replace("{end time}",$meeting_end_time, $message);
            
            $MeetingSet=Select('O2O_Pre_Companies a,'.$prefix.'O2O_Pre_Table b','a.name,a.country,a.email, b.participant_id',"WHERE b.id =".$TableID." AND a.id=b.company_id LIMIT 1");   
            if(count($MeetingSet)){               
    
                $IPIdArray=explode(',', $MeetingSet[0]['participant_id']);
                $e=1;
                $IPN='';
                
                $Icompany=str_replace('\\','',$MeetingSet[0]['name']);
                $Icountry=str_replace('\\','',$MeetingSet[0]['country']);
                $Iemail=trim($MeetingSet[0]['email']);
            
                if($r=count($IPIdArray))
                foreach($IPIdArray as $PId){
                    if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))){
                        $Pemail=Value('O2O_Pre_Participants','email','where id='.$PId.' LIMIT 1');
                        $IPN.= str_replace('\\','',$Pname);
                        $IPNEMAIL.= str_replace('\\','',$Pemail);
                        if($r > 1 && $e < $r){
                            $IPN.=  ',';
                            $IPNEMAIL.=  ',';
                            $e++;
                        }
                    }
                }
            }
    
            $MeetingSet=Select('O2O_Pre_Companies a,'.$prefix.'O2O_Pre_Table b','a.name, a.country,a.email, b.participant_id',"WHERE b.id =".$MWTID." AND a.id=b.company_id LIMIT 1");   
            if(count($MeetingSet)){
                $MWPIdArray=explode(',', $MeetingSet[0]['participant_id']);
                $e=1;
                $MWPN='';
                $MWcompany=str_replace('\\','',$MeetingSet[0]['name']);
                $MWcountry=str_replace('\\','',$MeetingSet[0]['country']);
                
                $MWemail=$MeetingSet[0]['email'];
                if($r=count($MWPIdArray))foreach($MWPIdArray as $PId){
                    if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))  ){
                        $Pemail=Value('O2O_Pre_Participants','email','where id='.$PId.' LIMIT 1');
                        $MWPN.= str_replace('\\','',$Pname);
                        $MWPEMAIL.= str_replace('\\','',$Pemail);
                        if($r > 1 && $e < $r){ $MWPN.=  ','; $MWPEMAIL.=  ','; $e++; }
                
                    }
                }
            }
            if($purpose=="Meeting Canceled Information"){
                //	echo $TableID;
                //echo "mw".$_SESSION["_TaBlE_ID"];die;
                if(trim($TableID)==trim($_SESSION["_TaBlE_ID"])){	//echo "here1";die;				
                    $message1=str_replace("{canceled comp}",$Icompany, $message1);
                    $message=str_replace("{canceled comp}"," ", $message);
                    $message=str_replace("Meeting was cancelled by"," ", $message);
                }
                else{//echo "here";die;
                    $message=str_replace("{canceled comp}",$MWcompany, $message);
                    $message1=str_replace("{canceled comp}"," ", $message1);
                    $message1=str_replace("Meeting was cancelled by"," ", $message1);
                }
            }
    
            $message=str_replace("{company name}",$Icompany, $message);
            $message=str_replace("{company link}","https://one2onescheduler.com/".$short_company_name, $message);
            $message=str_replace("{participant name}",$IPN, $message);
            $message=str_replace("{other company participant name}",$MWPN, $message);
            $message=str_replace("{other company name}",$MWcompany, $message);
            $message=str_replace("{other company country}",$MWcountry, $message);
$message=str_replace("{company short name}",$short_company_name, $message);

$message=str_replace("{conference name}",$title, $message);


$message = str_replace("{Admin Email}" , $admin_email, $message);

            $message=str_replace("{other company participant email}",$MWPEMAIL, $message);
            $message1=str_replace("{other company participant email}",$MWPEMAIL, $message1); 
            $message1=str_replace("{company name}",$MWcompany, $message1);
            $message1=str_replace("{participant name}",$MWPN, $message1);
            $message1=str_replace("{other company participant name}",$IPN, $message1);
            $message1=str_replace("{other company name}",$Icompany, $message1);
            $message1=str_replace("{other company country}",$Icountry, $message1);
            $message1=str_replace("{table no}",$table_no, $message1);
            
            $subject = $subject;
    
    
            ///////////////////////kkkkkkkk
            
            /*  $message_image='<img src="' .*/
            
            $my_email_bcc[] = 'cit.seema@gmail.com';
            
            $my_email_bcc[] = 'seemavaidya999@gmail.com';
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $from_email = $title."<notification@one2onescheduler.com>";
            $from_name = $title;
            $date=date("Y-m-d");
            $time=date("H:i:s");
            $date_time=$date." ".$time;
            $bcc_email= "cit.seema@gmail.com";
            //$reply="cit.manishsharma@gmail.com";
            $EachPEMAIL=explode(",",$IPNEMAIL);
            $Pre_user = mysqli_query($con,"select * from ".$prefix."O2O_Event_Info") or die(mysqli_error($con));
            $Pre_user_data = mysqli_fetch_array($Pre_user);
            if($Pre_user_data["reply_to_status"]==1){
                $reply=$ADD_REPLY_to_ADMIN_EMAIL=$Pre_user_data["reply_to_email"];
            }
            if($Pre_user_data["reply_to_status"]==0){
                $reply=$ADD_REPLY_to_ADMIN_EMAIL='';
            }            
            
             //   print_r($message);die;
            foreach($EachPEMAIL as $key_1=>$PEMAIL){
                if($PEMAIL!=""  ){
                $get_part_name=mysqli_query($con,"select name from ".$prefix."O2O_Pre_Participants where email='".$PEMAIL."'");
                $fetch_name=mysqli_fetch_array($get_part_name);
                $part_name=$fetch_name['name'];
                //mailgun_msg_send($PEMAIL,$from_name,$from_email,$bcc_email,$reply,$subject,$message);
               // sendMail($PEMAIL,$message,$subject,$from_name,$bcc_email);
               
               $PEMAIL = "nikheel.pawale@cheshtainfotech.com";

                $bcc = $cc = $reply = "";
                //sendMailgunMail($PEMAIL,$message,$subject,$from_email,$bcc,$cc,$reply);
                sendMailgunMail("cit.suyog@gmail.com",$message,$subject,$from_email,$bcc,$cc,$reply);
                }
            }
            $EMWTPEMAIL=explode(",",$MWPEMAIL);
            foreach($EMWTPEMAIL as $PEACHMAIL){               
                if($PEACHMAIL!="" ){  
                $get_part_name1=mysqli_query($con,"select name from ".$prefix."O2O_Pre_Participants where email='".$PEACHMAIL."'");
                $fetch_name1=mysqli_fetch_array($get_part_name1);
                $part_name1=$fetch_name1['name'];
                //mailgun_msg_send($PEACHMAIL,$from_name,$from_email,$bcc_email,$reply,$subject,$message1);
                //sendMail($PEACHMAIL,$message1,$subject,$from_name,$bcc_email);

                $bcc = $cc = $reply = "";
                sendMailgunMail("cit.suyog@gmail.com",$message,$subject,$from_email,$bcc,$cc,$reply);
                //sendMailgunMail($PEACHMAIL,$message,$subject,$from_email,$bcc,$cc,$reply);
                }
            }
        }
    }
}


function EmailMessageSent_del($ScheduledmeetingID,$purpose){

global $prefix;
global $con;
global $folder;

if(($ScheduledmeetingID > 0)&&($purpose != '')){
$select_1=mysqli_query($con,"select * from  ".$prefix."O2O_Event_Info");
$row_1=mysqli_fetch_array($select_1);
$short_name=$row_1["short_company_name"];
$logo_admin=$row_1["logo"];
global $name, $short_company_name,$title,$ConferenceStartEndDate,$email,$AdminCompanyLogo,$address,$contact_no,$fax,$sent_email;
$tmp_img_path=$logo_admin;
$message_image = '<img src='.$tmp_img_path.'>';
$select_email = Select("O2O_Pre_Email_Templates","subject,message,from_email","where purpose = '".$purpose."' and deleted=1  LIMIT 1");	
//echo $select_email[0]['message'];
if(!empty($select_email[0]['message']) && !empty($select_email[0]['subject']) ){
$message=$select_email[0]['message'];
$subject=$select_email[0]['subject'];
$select_email[0];
//extract($select_email[0]);             
$ScheduledmeetingArray=Select('O2O_Pre_Scheduledmeetings', 'table_id,table_no, scheduled_with_table_id, meetingslots_id','where id='.$ScheduledmeetingID.' LIMIT 1');
$from_email="";
$TableID=$ScheduledmeetingArray[0]['table_id'];
$table_no=$ScheduledmeetingArray[0]['table_no'];
$MWTID=$ScheduledmeetingArray[0]['scheduled_with_table_id'];
$MsID=$ScheduledmeetingArray[0]['meetingslots_id'];
$MeetingslotsArray=Select('O2O_Pre_Meetingslots','*','WHERE id ='.$MsID.'  LIMIT 1');
$meeting_date=date('d F Y',$MeetingslotsArray[0]['date']);
$meeting_start_time=date('H:i',$MeetingslotsArray[0]['start_time']);
$meeting_end_time=date('H:i',$MeetingslotsArray[0]['end_time']);
$subject=str_replace("\\","", $subject);
$subject=str_replace("{company short name}",$short_company_name,$subject);
$subject=str_replace("{conference name}",$title, $subject);
$subject=str_replace("{conference start end date}",$ConferenceStartEndDate, $subject);
$subject=str_replace("\\","", $subject);
$from_email=str_replace("\\","", $from_email);
$from_email=str_replace("AdminEmail",$email, $from_email);
$from_email=str_replace("\\","", $from_email);

$message=str_replace("\\","", $message);
$message=str_replace("{conference name}",$title, $message);
$message=str_replace("{company logo}",$message_image, $message);
$message=str_replace("AdminEmail",$email, $message);
$message=str_replace("{company short name}",$short_company_name, $message);
$message=str_replace("{admin address}",$address,$message);
$message=str_replace("{admin telephone}",$contact_no,$message);
$message=str_replace("{admin fax}",$fax,$message);
$message=str_replace("{meeting date}",$meeting_date, $message);
$message=str_replace("{start time}",$meeting_start_time, $message);
$message=str_replace("{table no}",$table_no, $message);
$message=str_replace("BaseDir",$folder,$message);
$message1=$message=str_replace("{end time}",$meeting_end_time, $message);
$MeetingSet=Select('O2O_Pre_Companies a,'.$prefix.'O2O_Pre_Table b','a.name,a.country,a.email, b.participant_id',"WHERE b.id =".$TableID." AND a.id=b.company_id LIMIT 1");   

if(count($MeetingSet)){               
$IPIdArray=explode(',', $MeetingSet[0]['participant_id']);
$e=1;
$IPN='';
$Icompany=str_replace('\\','',$MeetingSet[0]['name']);
$Icountry=str_replace('\\','',$MeetingSet[0]['country']);
$Iemail=trim($MeetingSet[0]['email']);
if($r=count($IPIdArray))foreach($IPIdArray as $PId){
if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))){
$Pemail=Value('O2O_Pre_Participants','email','where id='.$PId.' LIMIT 1');
$IPN.= str_replace('\\','',$Pname);
$IPNEMAIL.= str_replace('\\','',$Pemail);
if($r > 1 && $e < $r){
$IPN.=  ',';
$IPNEMAIL.=  ',';
$e++;
}
}                       
}
}

$MeetingSet=Select('O2O_Pre_Companies a,'.$prefix.'O2O_Pre_Table b','a.name, a.country,a.email, b.participant_id',"WHERE b.id =".$MWTID." AND a.id=b.company_id LIMIT 1");   
if(count($MeetingSet)){
$MWPIdArray=explode(',', $MeetingSet[0]['participant_id']);
$e=1;
$MWPN='';
$MWcompany=str_replace('\\','',$MeetingSet[0]['name']);
$MWcountry=str_replace('\\','',$MeetingSet[0]['country']);
$MWemail=$MeetingSet[0]['email'];
if($r=count($MWPIdArray))foreach($MWPIdArray as $PId){
if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))  ){
$Pemail=Value('O2O_Pre_Participants','email','where id='.$PId.' LIMIT 1');
$MWPN.= str_replace('\\','',$Pname);
$MWPEMAIL.= str_replace('\\','',$Pemail);
if($r > 1 && $e < $r){ $MWPN.=  ','; $MWPEMAIL.=  ','; $e++; }
}
}
}

if($purpose=="Meeting Canceled Information"){
$message1=str_replace("{canceled comp}",$Icompany, $message1);
}
$message=str_replace("{company name}",$Icompany, $message);
$message=str_replace("{participant name}",$IPN, $message);
$message=str_replace("{other company participant name}",$MWPN, $message);
$message=str_replace("{other company name}",$MWcompany, $message);
$message=str_replace("{other company country}",$MWcountry, $message);
$message1=str_replace("{company name}",$MWcompany, $message1);
$message1=str_replace("{participant name}",$MWPN, $message1);
$message1=str_replace("{other company participant name}",$IPN, $message1);
$message1=str_replace("{other company name}",$Icompany, $message1);
$message1=str_replace("{other company country}",$Icountry, $message1);
$message1=str_replace("{table no}",$table_no, $message1);

$subject = $subject;
///////////////////////kkkkkkkk
/*$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->Host = HOST;
$mail->Port = 80;
$mail->Username = SMTPUSERNAME;
$mail->Password = SMTPPASSWORD;
//$body=$message;
$mail->Subject =$subject;
$mail->SetFrom( FROM_SMTPEMAIL, $title);
$mail->AddReplyTo( FROM_SMTPEMAIL,$title);
$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
/*$mail->MsgHTML($body);
$mail->AddAddress($Iemail);
$EachPEMAIL=explode(",",$IPNEMAIL);
foreach($EachPEMAIL as $key_1=>$PEMAIL){               
if($PEMAIL!="" && $PEMAIL!=$Iemail){              
$PEMAIL=$PEMAIL; 
$mail->AddCC(trim($PEMAIL));
}               
}
$mail->Send();
*/
// $bcc_email="";
// sendMail($Iemail,$body,$subject,$title,$bcc_email);

                $bcc = $cc = $reply = "";
             // sendMailgunMail($Iemail,$message,$subject,$from_email,$bcc,$cc,$reply);

/*$mail->SetFrom(FROM_SMTPEMAIL, $title);
$mail->AddAddress($MWemail);
$mail->MsgHTML($message1);
$EMWTPEMAIL=explode(",",$MWPEMAIL);
/*   $EachPEMAIL=array_unique($EachPEMAIL);   ////            
foreach($EMWTPEMAIL as $PEACHMAIL){               
if($PEACHMAIL!="" && $PEACHMAIL!=$MWemail){               
$PEACHMAIL=($PEACHMAIL);               
/*$PEACHMAIL_1[]=$PEACHMAIL;/
//	echo "PEACHMAIL". $PEACHMAIL."<br>";  
$mail->AddCC(($PEACHMAIL));
}               
}              
$numSent = $mail->Send()   ;       
//Update('O2O_Pre_Scheduledmeetings','email_sent=1','where id='.$ScheduledmeetingID.' limit 1');  
$mail->ClearAddresses();  // each AddAddress add to list
$mail->ClearCCs();
$mail->ClearBCCs();*/
 // sendMail($MWemail,$message1,$subject,$title,$bcc_email); 

                $bcc = $cc = $reply = "";
                sendMailgunMail($MWemail,$message,$subject,$from_email,$bcc,$cc,$reply);
}

}

}	

/*function EmailMessageSent($ScheduledmeetingID,$purpose){
echo $ScheduledmeetingID;

//echo "<li>".$ScheduledmeetingID;die();
if(($ScheduledmeetingID > 0)&&($purpose != '')){
global $name, $short_company_name,$title,$ConferenceStartEndDate,$email,$AdminCompanyLogo,$address,$contact_no,$fax,$sent_email;
$select_email = Select("O2O_Pre_Email_Templates","subject,message,from_email","where purpose = '".$purpose."' and deleted=1  LIMIT 1");	
if(count($select_email) && !empty($select_email[0]['message']) && !empty($select_email[0]['subject']) && !empty($select_email[0]['from_email'])){
extract($select_email[0]);
$ScheduledmeetingArray=Select('O2O_Pre_Scheduledmeetings', 'table_id, scheduled_with_table_id, meetingslots_id','where id='.$ScheduledmeetingID.' LIMIT 1');
echo "<br>tbl".	$TableID=$ScheduledmeetingArray[0]['table_id'];
echo "<br>mwti".	$MWTID=$ScheduledmeetingArray[0]['scheduled_with_table_id'];
echo "<br>msid".$MsID=$ScheduledmeetingArray[0]['meetingslots_id'];
//exit;
$MeetingslotsArray=Select('O2O_Pre_Meetingslots','*','WHERE id ='.$MsID.'  LIMIT 1');
$meeting_date=date('d F Y',$MeetingslotsArray[0]['date']);
$meeting_start_time=date('H:i',$MeetingslotsArray[0]['start_time']);
$meeting_end_time=date('H:i',$MeetingslotsArray[0]['end_time']);
$subject=str_replace("\\","", $subject);
$subject=str_replace("{company short name}",$short_company_name,$subject);
$subject=str_replace("{conference name}",$title, $subject);
$subject=str_replace("{conference start end date}",$ConferenceStartEndDate, $subject);
$subject=str_replace("\\","", $subject);
$from_email=str_replace("\\","", $from_email);
$from_email=str_replace("AdminEmail",$email, $from_email);
$from_email=str_replace("\\","", $from_email);
$message=str_replace("\\","", $message);
$message=str_replace("{conference name}",$title, $message);
$message=str_replace("{company logo}",$AdminCompanyLogo, $message);
$message=str_replace("AdminEmail",$email, $message);
$message=str_replace("{company short name}",$short_company_name, $message);
$message=str_replace("{admin address}",$address,$message);
$message=str_replace("{admin telephone}",$contact_no,$message);
$message=str_replace("{admin fax}",$fax,$message);
$message=str_replace("{meeting date}",$meeting_date, $message);
$message=str_replace("{start time}",$meeting_start_time, $message);
$message=str_replace("BaseDir",$_SESSION['base_dir'],$message);
$message1=$message=str_replace("{end time}",$meeting_end_time, $message);
$MeetingSet=Select('O2O_Pre_Companies a,O2O_Pre_Table b','a.name,a.country,a.email, b.participant_id',"WHERE b.id =".$TableID." AND a.id=b.company_id LIMIT 1");	
if(count($MeetingSet)){
$IPIdArray=explode(',', $MeetingSet[0]['participant_id']);
$e=1;
$IPN='';
$Icompany=str_replace('\\','',$MeetingSet[0]['name']);
$Icountry=str_replace('\\','',$MeetingSet[0]['country']);
$Iemail=trim($MeetingSet[0]['email']);
if($r=count($IPIdArray))foreach($IPIdArray as $PId){
if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))){
$IPN.= str_replace('\\','',$Pname);
if($r > 1 && $e < $r){ $IPN.=  ',&nbsp;'; $e++; }
}						}
}


$MeetingSet=Select('O2O_Pre_Companies a,O2O_Pre_Table b','a.name, a.country,a.email, b.participant_id',"WHERE b.id =".$MWTID." AND a.id=b.company_id LIMIT 1");	
if(count($MeetingSet)){
$MWPIdArray=explode(',', $MeetingSet[0]['participant_id']);
$e=1;
$MWPN='';
$MWcompany=str_replace('\\','',$MeetingSet[0]['name']);
$MWcountry=str_replace('\\','',$MeetingSet[0]['country']);
$MWemail=trim($MeetingSet[0]['email']);
if($r=count($MWPIdArray))foreach($MWPIdArray as $PId){
if(($PId > 0) && ($Pname=Value('O2O_Pre_Participants','name','where id='.$PId.' LIMIT 1'))){
$MWPN.= str_replace('\\','',$Pname);
if($r > 1 && $e < $r){ $MWPN.=  ',&nbsp;'; $e++; }
}
}
}
//echo "comp".$Icompany;

$message=str_replace("{company name}",$Icompany, $message);

$message=str_replace("{participant name}",$IPN, $message);

$message=str_replace("{other company participant name}",$MWPN, $message);

$message=str_replace("{other company name}",$MWcompany, $message);

$message=str_replace("{other company country}",$MWcountry, $message);

$message1=str_replace("{company name}",$MWcompany, $message1);

$message1=str_replace("{participant name}",$MWPN, $message1);

$message1=str_replace("{other company participant name}",$IPN, $message1);

$message1=str_replace("{other company name}",$Icompany, $message1);

$message1=str_replace("{other company country}",$Icountry, $message1);

$message1=str_replace("{table no}",$table_no, $message1);

$subject=$subject;
$MWemail;

define("HOST", "smtpout.secureserver.net");
define("PORT", 80);
define("SMTPUSERNAME", "demo@one2onescheduler.com");
define("SMTPPASSWORD", "demo123");
define("FROM_SMTPEMAIL","demo@one2onescheduler.com");

$transport = Swift_SmtpTransport::newInstance("Smtpout.secureserver.net",80)
->setUsername(SMTPUSERNAME)
->setPassword(SMTPPASSWORD);

$mailer = Swift_Mailer::newInstance($transport);
$message_send = Swift_Message::newInstance($subject);
echo "<br>to ".$MWemail;
echo "<br>from ".$from_email;
echo "<br>to ADMIN".$email;

$message_send->setFrom(array( $from_email=> $namee))
->setBcc(array("cit.seema@gmail.com"  => "shoaib"))
->setTo($MWemail)
->setBody($message1,'text/html');
$numSent = $mailer->send($message_send);

$message_send->setFrom(array( $from_email=> $namee))
->setBcc(array("cit.seema@gmail.com"  => "shoaib"))
->setTo($email)
->setBody($message1,'text/html');
$numSent = $mailer->send($message_send);		


Update('O2O_Pre_Scheduledmeetings','email_sent=1','where id='.$ScheduledmeetingID.' limit 1');

}
} 
}*/function FeeadBack($data_array=array()){
global $prefix;
global $con;
extract($data_array);
$req_ratting=Value('ratings','total_value','where id =1 limit 1');
$support_ratting=Value('ratings','total_value','where id =2 limit 1');
include('contents/feedback.php');
mysqli_query($con,'TRUNCATE TABLE `'.$prefix.'ratings`');
}?>