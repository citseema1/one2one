<?php  if(!session_start()){ session_start(); ini_set('session.gc_maxlifetime', '288000');} ?>
<?

define('SALT', 'whateveryouwant'); 
/****************Decrypt function******************/
  
function encrypt($text) 
{ 
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))); 
} 

function decrypt($text) 
{ 
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))); 
} 
/****************find current directory location******************/
$dir='';
$uri=$_SERVER['REQUEST_URI'];
for($ct=0; $ct < (count(explode('/',$uri))-2); $ct++ ){
	$dir.='../';
}
/****************mysql_real_escape_string and trim******************/
function tres($text){ 
		   return trim(mysql_real_escape_string($text));
} 
/****************HEADER LOCATION******************/
function redirect($location){
	echo '<script>window.location.href="'.$location.'";</script>';

}
/****************Find IP address******************/
function ip(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	  $ip=$_SERVER['HTTP_CLIENT_IP']; 
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
	  $ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
/****************DATE RETURN IN INTEGER FORMAT******************/ 	
function cur_date_str(){
	return strtotime(date('Y-m-d h:i:s'));
}
/****************DATE RETURN IN COMMON FORMAT******************/ 
function datef($date_str){
  return date('jS F Y',$date_str);
}
/****************DATE RETURN IN TIME FORMAT******************/ 
function timef($date_str){
  return date('h:i:s',$date_str);
}
/****************FILE UPLOAD IN SERVER******************/ 	
function image_upload($file,$dir,$k=''){
	if(is_numeric($k)){	
		$ext=explode('/',$file['type'][$k]);
		$img_ext=strtolower(trim($ext[1]));
		$img_size=$file['size'][$k];
		if(($img_ext=="jpg" || $img_ext=="jpeg"|| $img_ext=="pjpeg" || $img_ext=="png" || $img_ext=="x-png" || $img_ext=="gif")){
			$img_name="logo_".(cur_date_str()+$k).".".$img_ext;
			$img_path=$dir.$img_name;
			if(move_uploaded_file($file['tmp_name'][$k],$img_path)){
				return $img_name;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}else{
	
		
		$ext=explode('/',$file['type']);
		$img_ext=strtolower(trim($ext[1]));
		$img_size=$file['size'];
		if(($img_ext=="jpg" || $img_ext=="jpeg" || $img_ext=="pjpeg" || $img_ext=="png" || $img_ext=="x-png" || $img_ext=="gif")){
		
		if( $img_ext=="pjpeg" )
		{
			$img_ext="jpeg";
		}
		if( $img_ext=="x-png" )
		{
			$img_ext="png";
		}
			 $img_name="logo_".cur_date_str().".".$img_ext;
			 $img_path=$dir.$img_name;
			if(move_uploaded_file($file['tmp_name'],$img_path)){
				return $img_name;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}
/****************Set Message******************/ 
function SetMessage($message, $type){
	$_SESSION['SetMessage']='<span class="'.$type.'">'.$message.'</span>';
}
/****************Get Message******************/ 
function GetMessage(){
	$GetMessage = $_SESSION['SetMessage'];
	unset($_SESSION['SetMessage']);
	return $GetMessage; 
}
/****************DROP DOWN FOR COUNTRY LIST******************/ 
function countryList($select_country,$name='country',$class='drop_down_212' ,$dir=''){
	include($dir.''.SOFTWARE.'/common/country_list.php');
	$out='<select name="country[]" id="country[]" class="'.$class.'" multiple="multiple" size="4" >
	<option value="">Select Country</option>';
	if(count($CountryArray)){
		foreach($CountryArray as $key=>$value){ 
			$country = $value;
			if(trim(strtolower($select_country))==trim(strtolower($country))){
				$selected="selected";
			}
			else{
				$selected="";
			}
			$out.='<option value="'.$country.'" '.$selected.'>'.$country.'</option> ';  
		}
	}
	$out.='</select>';
	return $out;
}

/****************DROP DOWN FOR WORKSHOP CODE******************/ 

function WorkShopCode($Workshop_code,$name='workshop_code[][]',$class='drop_down_212'){

	$WorkShopCodeArray=Select('pre_workshop','*','where active = 1 order by workshop_code');

	$out='<select name="'.$name.'" id="'.$name.'" class="'.$class.'" multiple="multiple" size="4" onchange="OtherMember(\'OtherMember\',\'other\', this.value)">

	<option value="0">None</option>';

	if(count($WorkShopCodeArray))foreach($WorkShopCodeArray as $k=> $WorkShop){

		$selected="";

		if($WorkShop['workshop_code']==$Workshop_code)

			$selected="selected";

		$out.='<option value="'.$WorkShop['workshop_code'].'" '.$selected.'>'.$WorkShop['workshop_code'].'</option> ';  

	}

	$out.='<option value="Other">Add new WorkShop</option>';

	$out.='</select>';

	return $out;

}
/****************DROP DOWN FOR MEMBER LIST******************/ 
function MemberType($member_type,$name='member_type',$class='drop_down_212'){
	$MemberTypeArray=Select('member_type','*','where deleted = 0 order by member_type');
	$out='<select name="'.$name.'" id="'.$name.'" class="'.$class.'" onchange="OtherMember(\'OtherMember\',\'other\', this.value)">
	<option value="0">None</option>';
	if(count($MemberTypeArray))foreach($MemberTypeArray as $k=> $MemberType){
		$selected="";
		if($MemberType['id']==$member_type)
			$selected="selected";
		$out.='<option value="'.$MemberType['id'].'" '.$selected.'>'.$MemberType['member_type'].'</option> ';  
	}
	$out.='<option value="Other">Add new network</option>';
	$out.='</select>';
	return $out;
}
/**************** CHECK TIME SLOT IS AVAILABLE ******************/ 
function IsTimeSlotInMeetings($ID){
	$meetingslots_id=0;
	$meetingslots_id_array=Select('O2O_Pre_Meetingslots','id','where conferenceslot_id='.$ID);
	if($r=count($meetingslots_id_array)){
		$meetingslots_id='';
		foreach($meetingslots_id_array as $k=> $meetingslots){
			$meetingslots_id.=$meetingslots['id'];
			if($k < ($r-1))
				$meetingslots_id.=',';
		}
	}
	return Rows('O2O_Pre_Scheduledmeetings','id',"Where meetingslots_id IN(".$meetingslots_id.") LIMIT 1");
}
/**************** FIND FREE TABLE ******************/ 

/**************** ALLOCATE TABLE ******************/ 
function AllocateTable($CompanyID){
	$data_event = Select("O2O_Event_Info","allocate_table,maximum_table,is_bootth","where 1 limit 1");
	$allocate_table=$data_event[0]['allocate_table'];
	
	$is_bootth=$data_event[0]['is_bootth'];
	
	$data_c = Select("O2O_Pre_Companies","*","where id='".$CompanyID."' limit 1");
	$member_id=$data_c[0]['member_id'];
	$table_required=$data_c[0]['table_required'];
	$data_p = Select("O2O_Pre_Participants","id, name, email","where company_id='".$CompanyID."' ORDER BY email DESC ");
	$p_id=array();
	if($nop=count($data_p)){
		foreach($data_p as $p){
			$p_id[]=$p['id'];
		}
		$p_id_string=implode(',',$p_id);
	}
	if(!Rows('O2O_Pre_Table','id','where company_id='.$CompanyID.' LIMIT 1') && ($nop > 0)){
		$booth_id=0;
		$table_no=0;
		$FieldArray=array(
			"table_no",
			"booth_id",
			"participant_id",
			"company_id"
		);
		$data_booth = Select("booth_details","*","where company_id='".$CompanyID."' limit 1");
		if(count($data_booth) && $data_booth[0]['is_meeting_in_booth']){
			$booth_id=$data_booth[0]['id'];
		}if( ($booth_id > 0) && ($is_bootth)){
			$ValueArray=array(
				"'".$table_no."'",
				"'".$booth_id."'",
				"'".trim($p_id_string)."'",
				"'".$CompanyID."'"
			);
			Insert('O2O_Pre_Table',$FieldArray,$ValueArray);
		}elseif($table_required <=1){
			if(($allocate_table==1) && ( Rows("member_type","allocate_table","where id='".$member_id."' AND allocate_table=1 limit 1") ) ){ 
				// 1-table allocate to particular member
				$table_no=TableNuber();
			}elseif($allocate_table==2){
			 // 2- table allocate to each member
				$table_no=TableNuber();
				
			}
			if($table_no>$max_table && $max_table!=0)
			{$table_no=0;}
			$ValueArray=array(
				"'".$table_no."'",
				"'".$booth_id."'",
				"'".trim($p_id_string)."'",
				"'".$CompanyID."'"
			);
			Insert('O2O_Pre_Table',$FieldArray,$ValueArray);
		}elseif($table_required >= $nop){
			foreach($p_id as $ParticipantID){
				if(($allocate_table==1)&&(Rows("member_type","allocate_table","where id='".$member_id."' AND allocate_table=1 limit 1"))){ 
					// 1-table allocate to particular member
					$table_no=TableNuber();
				}elseif($allocate_table==2){ // 2- table allocate to each member
					$table_no=TableNuber();
				}
				if($table_no>$max_table && $max_table!=0)
			{$table_no=0;}
				$ValueArray=array(
					"'".$table_no."'",
					"'".$booth_id."'",
					"'".$ParticipantID."'",
					"'".$CompanyID."'"
				);
				Insert('O2O_Pre_Table',$FieldArray,$ValueArray);
			}
		}elseif( ($table_required > 1) && ($table_required < $nop) ){
			$p_id1=$p_id;
			for($c=0; $c < $table_required; $c++){
				if($c < ($table_required-1)){
					$ParticipantID=$p_id[$c];
					unset($p_id1[$c]);
				}else{
					$ParticipantID=implode(',',$p_id1);
				}
				if(($allocate_table==1)&&( Rows("member_type","allocate_table","where id='".$member_id."' AND allocate_table=1 limit 1"))){ 					$table_no=TableNuber();
				}elseif($allocate_table==2){ // 2- table allocate to each member
					$table_no=TableNuber();
				}
				if($table_no>$max_table && $max_table!=0)
			{$table_no=0;}
				$ValueArray=array(
					"'".$table_no."'",
					"'".$booth_id."'",
					"'".$ParticipantID."'",
					"'".$CompanyID."'"
				);
				Insert('O2O_Pre_Table',$FieldArray,$ValueArray);
			}
		}
	}
}
/**************** CREATE THUMBS OF IMAGE ******************/
function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth){
  if(is_file($pathToImages)){
    list($width,$height)=getimagesize($pathToImages);
    $new_height = floor( $height * ( $thumbWidth / $width ) );
	$info = pathinfo($pathToImages);
    if ( (strtolower($info['extension']) == 'jpg') || (strtolower($info['extension']) == 'jpeg') || (strtolower($info['extension']) == 'pjpeg') ){
      $img = imagecreatefromjpeg($pathToImages);
      $tmp_img = imagecreatetruecolor( $thumbWidth, $new_height );
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $thumbWidth, $new_height, $width, $height );
      imagejpeg( $tmp_img,$pathToThumbs );
    }elseif ( strtolower($info['extension']) == 'png' ){
      $img = imagecreatefromjpeg($pathToImages);
      $tmp_img = imagecreatetruecolor( $thumbWidth, $new_height );
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $thumbWidth, $new_height, $width, $height );
      imagepng( $tmp_img,$pathToThumbs );
    }elseif ( strtolower($info['extension']) == 'gif' ){
      $img = imagecreatefromgif($pathToImages);
      $tmp_img = imagecreatetruecolor( $thumbWidth, $new_height );
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $thumbWidth, $new_height, $width, $height );
      imagegif( $tmp_img,$pathToThumbs );
    }
  }
}
$AdminDataArray =Select('O2O_Event_Info','*',"WHERE 1 LIMIT 1");
if(count($AdminDataArray)){
	extract($AdminDataArray[0]);
	}
function & prepare_mailer($subject,$body,$name,$path,$file) {
global $sent_email,$email;
	$mail = new PHPMailer();	
	$mail->IsSMTP();
	$mail->Host =HOST;
	$mail->SMTPAuth = true;
	$mail->Port = PORT;
	$mail->Username = SMTPUSERNAME;
	$mail->Password = decrypt(SMTPPASSWORD);	
	$mail->SetFrom(FROM_SMTPEMAIL,$name);
	$mail->AddReplyTo(FROM_SMTPEMAIL,$name);
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
    //$mail->AddAttachment($path,$file);		
    $mail->Subject    = $subject;
    $mail->MsgHTML($body);
	if($sent_email){
	$mail->AddCC($email,'');
	}
    return $mail;
}


/**************** special character filter ******************/

function xchars($str) {

	global $chartbl;

	$newstr="";

	for ($i=0;$i<strlen($str);$i++) {

		$chr=$str{$i};
		
		if(ord($chr)>127 ) {$chr=$chartbl[ord($chr)];}

		$newstr.=$chr;

	}
//echo $newstr;
//die();
	return $newstr;

}



$chartbl=Array("128"=>"&#8364;","130"=>"&#8218;","131"=>"&#402;","132"=>"&#8222;","133"=>"&#8230;",

	"134"=>"&#8224;","135"=>"&#8225;","136"=>"&#710;","137"=>"&#8240;","138"=>"&#352;","139"=>"&#8249;",

	"140"=>"&#338;","141"=>"","142"=>"&#381;","145"=>"&#8216;","146"=>"&#8217;","147"=>"&#8220;","148"=>"&#8221;",

	"149"=>"&#8226;","150"=>"&#8211;","151"=>"&#8212;","152"=>"&#732;","153"=>"&#8482;","154"=>"&#353;",

	"155"=>"&#8250;","156"=>"&#339;","158"=>"&#382;","159"=>"&#376;","160"=>"&nbsp;","161"=>"&iexcl;","162"=>"&cent;","239"=>"&iuml;",

        "163"=>"&pound;","164"=>"&curren;","165"=>"&yen;","166"=>"&brvbar;","167"=>"&sect;","168"=>"&uml;","169"=>"&copy;","170"=>"&ordf;",

        "171"=>"&laquo;","172"=>"&not;","173"=>"&shy;","174"=>"&reg;","175"=>"&macr;","176"=>"&deg;","177"=>"&plusmn;","178"=>"&sup2;","179"=>"&sup3;",

        "180"=>"&acute;","181"=>"&micro;","182"=>"&para;","183"=>"&middot;","184"=>"&cedil;","185"=>"&sup1;","186"=>"&ordm;","187"=>"&raquo;","188"=>"&frac14;",

        "189"=>"&frac12;","190"=>"&frac34;","191"=>"&iquest;","192"=>"&Agrave;","193"=>"&Aacute;","194"=>"&Acirc;","195"=>"&Atilde;","196"=>"&Auml;","197"=>"&Aring;",

        "198"=>"&AElig;","199"=>"&Ccedil;","200"=>"&Egrave;","201"=>"&Eacute;","202"=>"&Ecirc;","203"=>"&Euml;","204"=>"&Igrave;","205"=>"&Iacute;",

        "206"=>"&Icirc;","207"=>"&Iuml;","208"=>"&ETH;","209"=>"&Ntilde;","210"=>"&Ograve;","211"=>"&Oacute;","212"=>"&Ocirc;","213"=>"&Otilde;","214"=>"&Ouml;","215"=>"&times;","216"=>"&Oslash;","217"=>"&Ugrave;","218"=>"&Uacute;","219"=>"&Ucirc;","220"=>"&Uuml;","221"=>"&Yacute;","222"=>"&THORN;","223"=>"&szlig;","224"=>"&agrave;","225"=>"&aacute;","226"=>"&acirc;","227"=>"&atilde;","228"=>"&auml;","229"=>"&aring;","230"=>"&aelig;","231"=>"&ccedil;","232"=>"&egrave;","233"=>"&eacute;","234"=>"&ecirc;","235"=>"&euml;","236"=>"&igrave;","237"=>"&iacute;","238"=>"&icirc;","240"=>"&eth;","241"=>"&ntilde;","242"=>"&ograve;","243"=>"&oacute;","244"=>"&ocirc;","245"=>"&otilde;","246"=>"&ouml;","247"=>"&divide;","248"=>"&oslash;","249"=>"&ugrave;","250"=>"&uacute;","251"=>"&ucirc;","252"=>"&uuml;","253"=>"&yacute;","254"=>"&thorn;","255"=>"&yuml;"

	);



//$select_wc=mysql_query("select * from ".$prefix."O2O_Event_Infoslot where purpose='Workshop' order by date")or die(mysql_error());

?>
