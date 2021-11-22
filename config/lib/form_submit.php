<? 	if(!session_start()){ session_start(); ini_set('session.gc_maxlifetime', '288000');}
include('/home/one2one/public_html/phpmailer/class.phpmailer.php');

if(isset($_POST['username']) && isset($_POST['password']) && $_POST['Login']=='Submit'){

	$LoginPerson='admin';	

	if($_POST['LoginPerson']=='User Login')

	$LoginPerson='user';

	MemberLogin($_POST,$LoginPerson);

}elseif($_REQUEST['logout']==session_id().'_'.$BaseDir.'AdminID'){

	unset($_SESSION[session_id().'_'.$BaseDir.'AdminID']);

	redirect('index.php');

}elseif($_REQUEST['logout']==session_id().'_'.$BaseDir.'UserID'){

	unset($_SESSION[session_id().'_'.$BaseDir.'UserID']);

	redirect('index.php');

}elseif(isset($_POST['NextFace'])){

	if($_POST['NextFace']=='Continue'){

		SkipedComleted(0,1);

	}elseif($_POST['NextFace']=='Continue and do the rest of setup later'){

		//SkipedComleted(0,1);


		$ValueArray=array(
			"booth_settings=1",
			"sponsors_settings=1",

			"skiped=0",

			"completed=1"

		);

		Update('config_settings',$ValueArray, "where 1 limit 1");

		redirect('index.php');

	


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

}elseif(isset($_POST['ISBOOTH']) && $_POST['ISBOOTH']=='Save')
{
	if($_POST['is_booth']==1)
	{
		Update('pre_conference', "is_bootth=1", "where 1 limit 1");
		$ValueArray=array("booth_settings=1",
							"booth=1");
	}	
	else
	{
	$ValueArray=array(
			"booth_settings=1",
			"booth=0"
			);
	}
	Update('config_settings', $ValueArray, "where 1 limit 1");
	return true;
}



elseif(isset($_POST['SaveSponsorsDetails']) && $_POST['SaveSponsorsDetails']=='Save'){ //1 if_1

	$SponsorsSttings='';

	$sponsors_settings=0;

	if(SaveSponsorsDetails($_POST)){

		$SponsorsSttings='none';

		$sponsors_settings=1;

	}

	$msg=$SponsorsMsg =$arrow.GetMessage();

}
elseif(isset($_POST['ISSPONSOR']) && $_POST['ISSPONSOR']=='Save')
{
	if($_POST['is_sponsors']==1)
	{
		Update('pre_conference', "is_sponsors=1", "where 1 limit 1");
		$ValueArray=array("sponsors_settings=1",
							"sponsor =1");
	}	
	else
	{
	$ValueArray=array(
			"sponsors_settings=1",
			"sponsor =0"
			);
	}
	Update('config_settings', $ValueArray, "where 1 limit 1");
	return true;
}

elseif(isset($_POST['SaveEmailMessge']) && $_POST['SaveEmailMessge']=='Save'){ //1 if_1

	SaveEmailMessge($_POST);

	$msg=$arrow.GetMessage();

}elseif(isset($_POST['UpdateEmailMessge']) && $_POST['UpdateEmailMessge']=='Save'){ //1 if_1

	UpdateEmailMessge($_POST);

	$msg=$arrow.GetMessage();

}elseif(isset($_POST['ChangeLogo'])){ //1 if_1

	if(($_POST['ChangeLogo']=='Upload Logo') && (($_POST['user']=='ADMIN'))){

		$table='pre_user'; $filed='logo'; $where='where 1 limit 1'; $dir='logo/';

	}elseif(($_POST['ChangeLogo']=='Upload Logo') && (($_POST['user']=='USER'))){

		$table='pre_company'; $filed='logo';

		if($_POST['user_id']!="")

		{

		$where='where id='.$_POST['user_id'].' limit 1'; 

		$dir='images/company_logo/';

		 $_SESSION['company_image_upload']=$_POST['user_id'];

		}

		else

		{

		$where='where id='.$_SESSION[session_id().'_'.$BaseDir.'UserID'].' limit 1'; 

			$dir='admin/images/company_logo/';

		}

	}elseif(($_POST['ChangeLogo']=='Upload Photo') && ($_POST['PID'] > 0)){

	

		$table='pre_participant'; $filed='photo';

		$where='where id='.$_POST['PID'].' limit 1';

		if($_POST['BID']!="")

		{

		$dir='images/user_photo/';

		$_SESSION['company_image_upload']=$_POST['BID'];

		}

		else

		{

		$dir='admin/images/user_photo/';

		}

	}

	ChangeLogo($table,$filed,$_FILES[$filed],$where,$dir);

	$msg=$arrow.GetMessage();

}elseif(isset($_POST['DeleteLogo'])){ //1 if_1

	if(($_POST['DeleteLogo']=='Delete Logo') && (($_POST['user']=='ADMIN'))){

		$table='pre_user'; $filed='logo'; $where='where 1 limit 1'; 

	}elseif(($_POST['DeleteLogo']=='Delete Logo') && (($_POST['user']=='USER'))){

		$table='pre_company'; $filed='logo';

		if($_POST['USER_ID']!="")

		{

		$where='where id='.$_POST['USER_ID'].' limit 1';

		

		$_SESSION['company_image_upload']=$_POST['BID'];

		}

		else

		{

		$where='where id='.$_SESSION[session_id().'_'.$BaseDir.'UserID'].' limit 1'; 

		}

	}

	

	elseif(($_POST['DeleteLogo']=='Delete Photo') && ($_POST['PID'] > 0)){

		$table='pre_participant'; $filed='photo';

		$where='where id='.$_POST['PID'].' limit 1'; 

		$_SESSION['company_image_upload']=$_POST['BID'];

	}

	DeleteLogo($table,$filed,$where);

	$msg=$arrow.GetMessage();

}elseif(isset($_POST['FeeadBack'])){

	FeeadBack($_POST);

}



$AdminDataArray =Select('pre_user','*',"WHERE 1 LIMIT 1");

if(count($AdminDataArray)){

	extract($AdminDataArray[0]);

	if($logo!=''){
		$AdminCompanyLogo="<a href='https://www.one2onescheduler.com/".$BaseDir."'><img src='https://www.one2onescheduler.com/".$BaseDir."/admin/logo/Thumbs/".$logo."' border='0'/></a>";
		//$AdminCompanyLogo1="<a href='https://www.one2onescheduler.com/".$BaseDir."'><img src='cid:AdminCompanyLogo' border='0'/></a>";
$AdminCompanyLogoemail="<a href='https://www.one2onescheduler.com/".$BaseDir."'><img src=\"cid:1001\" border='0'/></a>";
			

				function imageResize($w, $h,$w1,$h1, $scale_ratio) { 			
			if($w1 > $w) {
    $scale_ratio = $w / $w1;    
	$w=round($scale_ratio*$w1);   
	$h=round($scale_ratio*$h1);
	if($h1 > $h) {
	$scale_ratio = $h / $h1;
	$w=round($scale_ratio*$w1);
	$h=round($scale_ratio*$h1);
	}
  }
 else if($h1 > $h) {
    $scale_ratio = $h / $h1;
	$w=round($scale_ratio*$w1);
	$h=round($scale_ratio*$h1);
  }
  else
  {
  $w=$w1;
  $h=$h1;
  }

return "width=\"$w\" height=\"$h\""; 


} 



		$logo_w_h_array =@getimagesize($ADMIN.'logo/'.$logo);

	$ACL="<a href='https://www.one2onescheduler.com/".$BaseDir."/".$admin."'><img src='".$ADMIN."logo/".$logo."' border='0'  /></a>";

		

		list($LogoWidth, $LogoHeight, $type, $attr) = @getimagesize($ADMIN.'logo/'.$logo);	

	}

	$address=str_replace('\\','',$address);

$Address=$address;

if($city!='')

	$address.=',&nbsp;'.str_replace('\\','',$city);

	if($country!='' && $country!=$city)

	$address.=',&nbsp;'.str_replace('\\','',$country);

	if($_REQUEST['LoginDetails']=='LoginDetails'){

		print_r($AdminDataArray);

	}

}

$EventDataArray =Select('pre_conference','*',"WHERE 1 LIMIT 1");

if(count($EventDataArray)){

	extract($EventDataArray[0]);

	$EventName=$EventDataArray[0]['title'];	

	$ConferenceStart=date('d',$start_time);

	$ConferenceEnd=date('d F Y',$end_time);

	$ConferenceStartEndDate= $ConferenceStart.'-'.$ConferenceEnd;

}

$namee=$BaseDir." One2One meeting scheduler";

$star='<span class="red b f16">*</span>';

/* ----------------------  form post date end----------------------------------------------------       */	

function MemberLogin($logindetail,$UserType){

   extract($logindetail);

   global $BaseDir;

   if($UserType=='admin'){

   









		if($log_id=Select('pre_user','id','where username = "'.trim($username).'" and password = "'.(trim($password)).'" LIMIT 1')){

		

				extract($log_id[0]);

				$_SESSION[session_id().'_'.$BaseDir.'AdminID']=$id;

				$_SESSION[session_id().'_'.$BaseDir.'AdminName']=trim($username);

		}else{

			SetMessage('Invalid Username or Password','error');

			return false;

		}

	}elseif($UserType=='user'){

   		if($log_id=Select('pre_company','id','where email = "'.trim($username).'" and access_code = "'.trim($password).'" LIMIT 1')){

				extract($log_id[0]);

				$_SESSION[session_id().'_'.$BaseDir.'UserID']=$id;

		}else{

			SetMessage('Invalid Login E-mail or Access Code.<br />

<font size="2"> Please click on "Forget password?" link to get your Login Details on the Signup E-mail Address.</font>','error');

			return false;

		}

   }else{

   		SetMessage('Invalid Username or Password','error');

		return false;

   }

}function AdminDetilsUpdate($data_array=array()){

	global $BaseDir;     

	if(count($data_array)){

		$logo_dir='logo/';

		$PrevMemberType=array();

		$MemberType=array();  

		extract($data_array);

		foreach($country as $key=>$value)

			{

			 $country1=$value;

			$country2.=$country1.",";

			}

			$country2= substr($country2, 0, -1); 

		$prev_short_company_name_array=Select('pre_user','short_company_name',' where 1 limit 1');

		$prev_short_company_name=tres($prev_short_company_name_array[0]['short_company_name']);

		$short_company_name=tres(ucwords($short_company_name));

		$MemberType[]=$short_company_name.' Member';

		$MemberType[]='Non '.$short_company_name.' Member';

		$PrevMemberType[]=$prev_short_company_name.' Member';

		$PrevMemberType[]='Non '.$prev_short_company_name.' Member';

		$ValueArray=array(

			"name='".tres(ucwords($name))."'",

			"username='".tres($username)."'",

			"password='".tres(base64_encode($password))."'",

			"company='".tres(ucwords($company))."'",

			"short_company_name='".$short_company_name."'",

			"email='".$email."'",

			"address='".tres(ucwords($address))."'",

			"city='".tres(ucwords($city))."'",

			"country='".$country2."'",

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

		

	$_SESSION[session_id().'_'.$BaseDir.'AdminName']=tres($username);

		if(Update('pre_user', $ValueArray, "where id ='".$_SESSION[session_id().'_'.$BaseDir.'AdminID']."' limit 1")){

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

			SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysql_error().' ........', 'red b f12');

			return false; 

		}

	}

}function DeleteLogo($table,$filed,$where){

	if(Update($table, $filed."=''",$where)){

		SetMessage('Image is successfully deleted', 'green b f12');

	}else{

		SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysql_error().' ........', 'red b f12');

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

				SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysql_error().' ........', 'red b f12');

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

		

		$StartTime=strtotime($start_time);

		$EndTime=strtotime($end_time);

		$where.="where (( '$StartTime' > `start_time` ) OR ( '$EndTime' < `end_time` ) ) ";

			$SelectTimeSlot=Select('pre_conferenceslot','*',$where);

			

			if(count($SelectTimeSlot)){ 

			SetMessage('Please delete all Time slot(s) which are set on this Date', 'red b f12');

			return false; 

			}

		if(Update('pre_conference', $ValueArray, "where 1 limit 1")){

			Update('config_settings', 'event_settings=1', "where 1 limit 1");

			SetMessage('Event details are successfully updated', 'green b f12');

			return true; 

		}else{

			SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysql_error().' ........', 'red b f12');

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

		if(Insert('pre_conference',$FiledArray,$ValueArray)){

			Update('config_settings', 'event_settings=1', "where 1 limit 1");

			SetMessage('Event details are successfully added', 'green b f12');

			return true; 

		}else{

			SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysql_error().' ........', 'red b f12');

			return false; 

		}

	}

}function TimeSlotAdd($data_array=array()){

if(count($data_array)){

	extract($data_array);

	$ConferenceDetail=Select('pre_conference','start_time,end_time','where 1 limit 1');

	$Conf_start_time=$ConferenceDetail[0]['start_time']; 

	$Conf_end_time=$ConferenceDetail[0]['end_time'];

	$StartTime= strtotime(date('Y-m-d ',$date).$start_hh.':'.$start_mm);

	$StartTime=($StartTime*1);

	if($purpose=='one to one meeting')

	{

	$EndTime= strtotime(date('Y-m-d ',$date).$end_time);

	}

	else

	{

	$EndTime= strtotime(date('Y-m-d ',$date).$end_hh.':'.$end_mm);

	}

	$EndTime=($EndTime*1);

	if($Conf_start_time <= $StartTime && $Conf_start_time < $EndTime && $StartTime < $Conf_end_time && $EndTime <= $Conf_end_time ){

		$where='where 1 ';

		if($conferenceslotID > 0){

			$where.=' AND id !='.$conferenceslotID;

		}

	$where.=" AND (( '$StartTime' >= `start_time` AND '$StartTime' < `end_time` AND ('$purpose'=`purpose`  || 'one to one meeting'=`purpose`) ) OR ( '$EndTime' > `start_time` AND  

			'$EndTime' < `end_time` AND ('$purpose'=`purpose`  || 'one to one meeting'=`purpose`)) ) LIMIT 1";

			

			$SelectTimeSlot=Select('pre_conferenceslot','*',$where);

			if(count($SelectTimeSlot)){ 

				SetMessage('This Time Slot is not Available!', 'red b f12');

				return false;

			}else{

				if($conferenceslotID > 0){

					if(IsTimeSlotInMeetings($conferenceslotID)){

						SetMessage('you must delete all meetings which is already set for this time slot', 'red b f12');

						return false;

					}

					Delete('pre_meetingslots', 'where conferenceslot_id='.$conferenceslotID);

					Delete('pre_conferenceslot', 'where id='.$conferenceslotID);

				}

				$w_code=$workshop_code;

				if($workshop_code=='Add'){

						$workshop_id=Insert('pre_workshop',"workshop_code","'".ucwords(tres($workshop_code1))."'");

						$w_code=$workshop_code1;

				}

				$SelectWC=Select('pre_conferenceslot','*',"where workshop_code='".$w_code."' and workshop_code!=''");

			if(count($SelectWC)){ 

				SetMessage('This Workshop code is already Exist!', 'red b f12');

				return false;

			}

				$FiledArray=array( 'purpose','date','start_time','end_time','meeting_duration','title','workshop_code');

				$ValueArray=array("'".$purpose."'", "'".$date."'", "'".$StartTime."'", "'".$EndTime."'","'".tres($meeting_duration)."'","'".tres($title)."'","'".ucwords(tres($w_code))."'");

				if($conferenceslot_id=Insert('pre_conferenceslot',$FiledArray,$ValueArray)){

				$meeting_duration_in_second=($meeting_duration*60);

				if($purpose=='one to one meeting')while($StartTime < $EndTime){

					$MeetingEndTime=($StartTime + $meeting_duration_in_second);

						$FiledArray1=array( 'conferenceslot_id','start_time','end_time','date');

						$ValueArray1=array("'".$conferenceslot_id."'", "'".$StartTime."'", "'".$MeetingEndTime."'", "'".$date."'");	

						Insert('pre_meetingslots',$FiledArray1,$ValueArray1);

						$StartTime=$MeetingEndTime;

					}

					Update('config_settings', 'time_slot_settings =1', "where 1 limit 1");

					if($purpose=='one to one meeting')

					{

					SetMessage('Time Slots details are successfully added, system will automatically break time slots for given duration.', 'green b f12');

					}

					else{

					SetMessage('Time Slots details are successfully added.', 'green b f12');

					}

					return true;

				}else{

					SetMessage('Sorry, Some Internal Problem! Try Again<br />'.mysql_error().' ........', 'red b f12');

					return false;

				}

			}

		}else{

			SetMessage('This "Time Slot" is not available!', 'red b f12');

			return false;

		}

	}	}

function CompanyImport($filename){

	global $verson;
	global $company_limit;

	move_uploaded_file($_FILES['import']['tmp_name'],$filename);

	$TotalLines = $TotalLinesAllowed = count(file($filename));
	$TotalCompany=Rows('pre_company','id','where 1');

	if($verson=='demo'){		

		$TotalLinesAllowed = (11-$TotalCompany);

	}
		$TotalLinesAllowed = (($company_limit+1)-$TotalCompany);
	$count=1; $noi=0; $flg=0;

	$error_line=array(); $dplicate_record=array();

	$handle = fopen($filename,"r");

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){ //3 while

		if($count==1){

			if(($data[0]!='company_name')&&($data[1]!='email')&&($data[2]!='website')&&($data[3]!='compnay_profile')&&($data[4]!='city')&&($data[5]!='country')&&($data[6]!='member_type')&&($data[7]!='participant_name')&&($data[8]!='job_title')&&($data[9]!='participant_email')&&($data[10]!='participant_contact_no')&&($data[11]!='number_of_table_required')&&($data[12]!='workshop_codes')){  

				$flg=1;

				break;

			}

		}

		if($count > 1  && $count <= $TotalLinesAllowed) {	//5 if_4

			$nol++;

			if(empty($data[0]) || empty($data[1]) || empty($data[5]) || is_numeric($data[6]) || 

			empty($data[6]) || empty($data[7]) || !is_numeric($data[11])){

				$error_line[]=$count;

			}elseif(!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,10}$", $data[1])){

				$error_line[]=$count;

			}else{ //6 else 1

				$where = "where (name='".ucwords(tres($data[0]))."' 

				And city='".ucwords(tres($data[4]))."' And country='".ucwords(tres($data[5]))."') 

				OR email='".tres($data[1])."'  limit 1";

				if(Rows('pre_company','id',$where)){

					$dplicate_record[]=$count;

				}else{ //7 else 2

					$MemberType=Select('member_type','id',"where member_type = '".ucwords(tres($data[6]))."' LIMIT 1");

					if(count($MemberType)){

						$member_id=$MemberType[0]['id'];

					}else{

						$member_id=Insert('member_type',"member_type","'".ucwords(tres($data[6]))."'");

					}

					$p_name=explode('|',$data[7]);

					if($data[11]>count($p_name))

					{

					$data[11]=count($p_name);

					}

					if($data[11]==0 || $data[11]=="")

					{

					$data[11]=1;

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

					$company_id=Insert('pre_company',$FiledArray,$ValueArray);

					$FiledArray1=array( 'company_id','name','designation','email','mobile','workshop_code');

					

					$w_code=$data[12];

	$a=explode("|",$w_code);

	foreach($a as $b)

	{

	$c= explode(",",$b);

	foreach($c as $v)

	{

	$work_code=Select('pre_workshop','*',"where workshop_code  = '".ucwords(tres($v))."' LIMIT 1");

					if(count($work_code)){

						$work_shop_code=$work_code[0]['workshop_code'];

					}else{

						$work_shop_id=Insert('pre_workshop',"workshop_code","'".ucwords(tres($v))."'");

						$work_shop_code=$v;

					}

				}

			}

				

					$p_email=explode('|',$data[8]);

					$p_designation=explode('|',$data[9]);

					$p_mobile=explode('|',$data[10]);	

					$p_wc=explode('|',$data[12]);											

					foreach($p_name as $k=>$name){

						$ValueArray1=array("'".tres($company_id)."'",

										  "'".tres(ucwords($name))."'",

										  "'".tres(ucwords($p_designation[$k]))."'",

										  "'".tres($p_email[$k])."'",

										  "'".tres($p_mobile[$k])."'",

										  "'".tres($p_wc[$k])."'");

						$participant_id=Insert('pre_participant',$FiledArray1,$ValueArray1);

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
	global $company_limit;
	

	if(count($data_array)){ 

		$CountCompany=Rows('pre_company','id','where 1');

		if($CountCompany >= 10 && $verson=='demo'){

			SetMessage('Sorry you cannot add more than ten(10) company(s) in demo version of one2one scheduler. To allow you to 

			add more company,please contact us at +852 8125 7221 or email us at: marketing@one2onescheduler.com: 

			<a href="mailto:marketing@one2onescheduler.com" target="_blank">marketing@one2onescheduler.com</a>', 'red b f12');

			return false;

		}
		else if($CountCompany >= $company_limit){

			SetMessage('Sorry you cannot add more than '.$company_limit.' company(s) in  one2one scheduler. To allow you to 

			add more company, please contact us at +852 8125 7221 or email us at: marketing@one2onescheduler.com: 

			<a href="mailto:marketing@one2onescheduler.com" target="_blank">marketing@one2onescheduler.com</a>', 'red b f12');

			return false;

		}
		else{

			extract($data_array);

			foreach(@$country as $key=>$value)

			{

			 $country1=$value;

			$country2.=$country1.",";

			}

			$country2= substr($country2, 0, -1); 

			$where = "where (name='".ucwords(tres($name))."' 

			And city='".ucwords(tres($city))."') 

			OR email='".tres($email)."'  limit 1";

			if(Rows('pre_company','id',$where)){

				SetMessage('System does not allow 2 or more companies to have same name and city or company email address. So cannot add the company &quot;'.$name.'&quot;', 'red b f12');
				

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

								  "'".$country2."'",

								  "'".tres($member_id)."'",

								  "'".tres($table_required)."'");

				$company_id=Insert('pre_company',$FiledArray,$ValueArray);

				$FiledArray1=array( 'company_id','name','designation','email','mobile','workshop_code');

				

				foreach($participant as $k=>$p_name){

					if(!empty($p_name)){		

							

						$ValueArray1=array("'".tres($company_id)."'",

										  "'".tres(ucwords($p_name))."'",

										  "'".tres(ucwords($designation[$k]))."'",

										  "'".tres($participant_email[$k])."'",

										  "'".tres($mobile[$k])."'",

										 "'".tres($w_s_c[$k])."'" );

						$participant_id=Insert('pre_participant',$FiledArray1,$ValueArray1);

					

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

		foreach($country as $key=>$value)

			{

			 $country1=$value;

			$country2.=$country1.",";

			}

			$country2= substr($country2, 0, -1); 

		$where = "where id!=".$CompanyID."  AND ((name='".ucwords(tres($name))."' 

			And city='".ucwords(tres($city))."' ) 

			OR email='".tres($email)."')  limit 1";

		if(Rows('pre_company','id',$where)){

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

							  "country='".$country2."'");

			if($ClientSide=='ClientSide'){

				$ValueArray[]="profile='".tres($profile)."'";

			}else{			  

				$ValueArray[]="email='".tres($email)."'";

				$ValueArray[]="member_id='".tres($member_id)."'";

			}				  

			Update('pre_company',$ValueArray,'where id = '.$CompanyID.' limit 1');

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

		Update('pre_participant',$ValueArray,'where id = '.$ParticipantID.' limit 1');

		SetMessage('Participant details are successfully updated', 'green b f12');

		return true;

	}

}function TableAllocation($data_array=array()){

	extract($data_array);

	Update('pre_conference', "allocate_table='".$allocate_table."', maximum_table='".$total_table."'", "where 1 limit 1");

	Update('member_type', "allocate_table=0", "where 1");

	if(count($member_type))foreach($member_type as $k=> $member){

		Update('member_type', "allocate_table=1", "where id=".$member);

	}

	Update('config_settings', 'table_allocation_settings=1', "where 1 limit 1");

	SetMessage('Table Allocation details are successfully updated', 'green b f12');

	return true;

}function SaveBoothDetails($data_array=array()){

	extract($data_array);
		$FiledArray=array( 'company_id','booth_name','is_meeting_in_booth');

		if(count($booth_name))foreach($booth_name as $k=> $booth){

			$CompanyName=Select('pre_company','name','where id='.trim($company[$k]).' LIMIT 1');

			if(!Rows('booth_details','id','where (company_id='.trim($company[$k]).' OR booth_name = "'.tres(ucwords($booth)).'") LIMIT 1')){

				$ID=array();

				if($is_meeting_in_booth[$k]){

					$TableIDArray=Select('pre_table', 'id', 'where company_id='.$company[$k]);

					if(count($TableIDArray))foreach($TableIDArray as $I=>$TableID){

						$ID[]=$TableID['id'];

					}

					$TblID=implode(',', $ID);

				}

				if((count($ID))&& (Rows('pre_scheduledmeeting','id','where (scheduled_with_table_id IN('.$TblID.') OR table_id IN('.$TblID.')) 

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

				$TableIDArray=Select('pre_table', 'id', 'where company_id IN('.$company_id.','.$company_id2.')');

				if(count($TableIDArray))foreach($TableIDArray as $I=>$TableID){

					$ID[]=$TableID['id'];

				}

				$TblID=implode(',', $ID);

				if(count($ID)){

					if(Rows('pre_scheduledmeeting','id','where (scheduled_with_table_id IN('.$TblID.') OR table_id IN('.$TblID.')) AND (booth_id = 0) LIMIT 1')){

						$company1=Value('pre_company', 'name', 'where id ='.$company_id.' limit 1 ');

						$company1=str_replace('\\','',$company1);

						$company2=Value('pre_company', 'name', 'where id ='.$company_id2.' limit 1 ');

						$company2=str_replace('\\','',$company2);

						SetMessage('you must delete all meetings which is already set for "'.$company1.'", "'.$company2.'"','red b f12');

						return false;

					}else{

						Delete('pre_table', 'where company_id IN('.$company_id.','.$company_id2.')');

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

			$CompanyName=Select('pre_company','name','where id='.$company_id2.' LIMIT 1');

			SetMessage('Booth name "'.$booth.'" is already exist OR booth is already allocated to company "'.$CompanyName[0]['name'].'"', 'red b f12');

		}

	}

	return true;

}function SaveSponsorsDetails($data_array=array()){

	extract($data_array);

	

		if($sponsors_participate_in_meetings==1){

			$logo_dir='images/company_logo/';

			if(count($companyID))foreach($companyID as $k=> $company){

				if(!Rows('sponsors_details','id','where SponsorsCompanyID='.$company.' LIMIT 1')){

					if($company > 0)Insert('sponsors_details', 'SponsorsCompanyID', $company);

					if(($_FILES['CompanyLogo']['name'][$k]!='') && $image=image_upload($_FILES['CompanyLogo'],$logo_dir,$k)){

						Update('pre_company', "logo='".trim($image)."'", "where id=".$company." limit 1");

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

	
	SetMessage('Sponsors details are successfully added', 'green b f12');

	return true;

}function SkipedComleted($skiped,$completed){

		$ValueArray=array(

			"skiped='".trim($skiped)."'",

			"completed='".trim($completed)."'"

		);

		Update('config_settings',$ValueArray, "where 1 limit 1");

		redirect('index.php');

	}function SaveEmailMessge($data_array=array()){

	extract($data_array);

	if(Rows('pre_emailsetting','id'," where `purpose` = '".tres($purpose)."' limit 1")){

		SetMessage("E-mail Purpose &quot;".$purpose."&nbsp; is already Exist!", 'red b f12');

		return false;

}

	else{

		$FiledArray=array( 'purpose','subject','message','from_email');

		$ValueArray=array("'".trim($purpose)."'",

						  "'".tres($subject)."'",

						  "'".tres($message)."'",

						  "'".tres($from_email)."'");

		Insert('pre_emailsetting', $FiledArray, $ValueArray);

		SetMessage('You have successfully added the E-mail Message.', 'green b f12');

		return true; 

	}

}function UpdateEmailMessge($data_array=array()){

	extract($data_array);

	if(Rows('pre_emailsetting','id'," where `purpose` = '".tres($purpose)."' AND id !=".$emailsettingID." limit 1")){

		SetMessage("E-mail Purpose &quot;".$purpose."&nbsp; is already Exist!", 'red b f12');

		return false;

	}

	else{

		$ValueArray=array("purpose='".trim($purpose)."'",

						  "subject='".tres($subject)."'",

						  "message='".tres($message)."'",

						  "from_email='".tres($from_email)."'");

		Update('pre_emailsetting', $ValueArray, "where id =".$emailsettingID." limit 1");

		SetMessage('You have Sucsessfully updated E-mail Message', 'green b f12');

		return true; 

	}

}function EmailMessageSent($ScheduledmeetingID,$purpose){
		if(($ScheduledmeetingID > 0)&&($purpose != ''))
		{
			$namee=$BaseDir." One2One meeting scheduler";
			global $name, $short_company_name,$title,$ConferenceStartEndDate,
			$email,$AdminCompanyLogo,$address,$contact_no,$fax,$sent_email,$table_no;
			$select_email = Select("pre_emailsetting","subject,message,from_email","where purpose = '".$purpose."' and deleted=0  LIMIT 1");	
			if(count($select_email) && !empty($select_email[0]['message']) && 
			!empty($select_email[0]['subject']) && !empty($select_email[0]['from_email']))
			{
				
				extract($select_email[0]);				
				$ScheduledmeetingArray=Select('pre_scheduledmeeting', 'table_id,table_no, scheduled_with_table_id, meetingslots_id','where id='.$ScheduledmeetingID.' LIMIT 1');
				
				$TableID=$ScheduledmeetingArray[0]['table_id'];
				
				$table_no=$ScheduledmeetingArray[0]['table_no'];
				
				$MWTID=$ScheduledmeetingArray[0]['scheduled_with_table_id'];
				
				$MsID=$ScheduledmeetingArray[0]['meetingslots_id'];
				
				$MeetingslotsArray=Select('pre_meetingslots','*','WHERE id ='.$MsID.'  LIMIT 1');
				
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
				
				$message=str_replace("{table no}",$table_no, $message);
				
				$message=str_replace("BaseDir",$_SESSION['base_dir'],$message);
				
				$message1=$message=str_replace("{end time}",$meeting_end_time, $message);
				
				$MeetingSet=Select('pre_company a,'.$prefix.'pre_table b','a.name,a.country,a.email, b.participant_id',"WHERE b.id =".$TableID." AND a.id=b.company_id LIMIT 1");	
				
				if(count($MeetingSet)){				
				
				$IPIdArray=explode(',', $MeetingSet[0]['participant_id']);
				
				$e=1;
				
				$IPN='';
				
				$Icompany=str_replace('\\','',$MeetingSet[0]['name']);
				
				$Icountry=str_replace('\\','',$MeetingSet[0]['country']);
				
				$Iemail=trim($MeetingSet[0]['email']);
				
				if($r=count($IPIdArray))foreach($IPIdArray as $PId){
				
				if(($PId > 0) && 
				
					($Pname=Value('pre_participant','name','where id='.$PId.' LIMIT 1')))
				
					{ 
				
					$Pemail=Value('pre_participant','email','where id='.$PId.' LIMIT 1');
					 $IPN.= str_replace('\\','',$Pname);
				
					  $IPNEMAIL.= str_replace('\\','',$Pemail);
				
						if($r > 1 && $e < $r)
				
						{ 
				
						$IPN.=  ','; 
				
						$IPNEMAIL.=  ','; 
				
						$e++;
				
						}
				
					}						}
				
					 
				
				}
				
				$MeetingSet=Select('pre_company a,'.$prefix.'pre_table b','a.name, a.country,a.email, b.participant_id',"WHERE b.id =".$MWTID." AND a.id=b.company_id LIMIT 1");	
				
				if(count($MeetingSet)){
				
				$MWPIdArray=explode(',', $MeetingSet[0]['participant_id']);
				
				$e=1;
				
				$MWPN='';
				
				$MWcompany=str_replace('\\','',$MeetingSet[0]['name']);
				
				$MWcountry=str_replace('\\','',$MeetingSet[0]['country']);
				
				$MWemail=trim($MeetingSet[0]['email']);
				
				if($r=count($MWPIdArray))foreach($MWPIdArray as $PId){
				
					if(($PId > 0) && ($Pname=Value('pre_participant','name','where id='.$PId.' LIMIT 1'))  ){
					 $Pemail=Value('pre_participant','email','where id='.$PId.' LIMIT 1');
				
						$MWPN.= str_replace('\\','',$Pname);
				
						$MWPEMAIL.= str_replace('\\','',$Pemail);
				
						if($r > 1 && $e < $r){ $MWPN.=  ',&nbsp;'; $MWPEMAIL.=  ',&nbsp;'; $e++; }
				
					}
				
				}
				
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
				
				//mail($Iemail,$subject,$message,"From: ".$namee." <".$from_email.">\n"."MIME-Version: 1.0\n" ."Content-type: text/html; charset=iso-8859-1");	
				
				$mail->Subject = $subject;
				$mail = & prepare_mailer($subject,$message,$namee,'','');				
				$mail->AddAddress($Iemail,'');
				
				$EachPEMAIL=explode(",",$IPNEMAIL);
				foreach($EachPEMAIL as $key_1=>$PEMAIL)				
				{				
				if($PEMAIL!="" && $PEMAIL!=$Iemail)				
				{				
				$PEMAIL=trim(str_replace('&nbsp;','',$PEMAIL));				
				//mail($PEMAIL,$subject,$message,"From: ".$namee." <".$from_email.">\n"."MIME-Version: 1.0\n" ."Content-type: text/html; charset=iso-8859-1");
				$mail->AddCC($PEMAIL,'');				
				}				
				}
				if($mail->Send()) 
				{
					$mail->ClearAddresses();
				}
				$mail = & prepare_mailer($subject,$message1,$namee,'','');	
				$mail->AddAddress($MWemail,'');
								
				//mail($MWemail,$subject,$message1,"From: ".$namee." <".$from_email.">\n"."MIME-Version: 1.0\n" ."Content-type: text/html; charset=iso-8859-1");			
				$EMWTPEMAIL=explode(",",$MWPEMAIL);
				$EachPEMAIL=array_unique($EachPEMAIL);				
				$EMWTPEMAIL=array_unique($EMWTPEMAIL);
				foreach($EMWTPEMAIL as $PEACHMAIL)				
				{				
				if($PEACHMAIL!="" && $PEACHMAIL!=$MWemail)				
				{				
				$PEACHMAIL=trim(str_replace('&nbsp;','',$PEACHMAIL));				
				//mail($PEACHMAIL,$subject,$message1,"From: ".$namee." <".$from_email.">\n"."MIME-Version: 1.0\n" ."Content-type: text/html; charset=iso-8859-1");
				$mail->AddCC($PEACHMAIL,'');	
				}				
				}
				if($mail->Send()) 
				{
					$mail->ClearAddresses();
				}				
				Update('pre_scheduledmeeting','email_sent=1','where id='.$ScheduledmeetingID.' limit 1');	
				
			}
 
	}

}function FeeadBack($data_array=array()){

	extract($data_array);

	$req_ratting=Value('ratings','total_value','where id =1 limit 1');

	$support_ratting=Value('ratings','total_value','where id =2 limit 1');

	include('contents/feedback.php');

	mysql_query('TRUNCATE TABLE `'.$prefix.'ratings`');

}?> 