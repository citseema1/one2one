<?php
//require '../../config/mailgun-php/vendor/autoload.php';
//use Mailgun\Mailgun;


function sendMailgunMail($to,$message,$subject,$from_email,$bcc,$cc,$reply){
	include "../../config/mailgunMail.php";
	
	$arr[] = $messageId;
	$arr[] = $responseText;
	return $arr;
}

//function sendMail($to,$message,$subject,$from_name="notification@one2onescheduler.com",$bcc="seema.vaidya@cheshtainfotech.com",$cc=""){
//  $mgClient = new Mailgun('key-8788c657a8822dca7c784e5aeafe8f0a');
//$domain = "one2onescheduler.com";
//if($cc!=""){
//return $result = $mgClient->sendMessage($domain,  array(
//         'subject' => $subject,
//		// 'cc'     => $cc,
//         'bcc'     => $bcc,
//         'from'    => $from_name,
//    	 'to'      => $to,
//         'html' => "<div style='font-family:Arial;'>".$message."</div>"
//));
//}else{
//return $result = $mgClient->sendMessage($domain,  array(
//		'subject' => $subject,
//		'bcc'     => $bcc,
//		'from'    => $from_name,
//		'to'      => $to, 
//		'html' => "<div style='font-family:Arial;'>".$message."</div>"
//));
//}	  
//     
//}
//
//function sendAttachment($to,$message,$subject,$attachment,$from_name="notification@one2onescheduler.com",$bcc="seema.vaidya@cheshtainfotech.com",$cc=""){
//  $mgClient = new Mailgun('key-8788c657a8822dca7c784e5aeafe8f0a');
//$domain = "one2onescheduler.com";
////return 1;
// $result = $mgClient->sendMessage($domain,  array(
//         'subject' => $subject,
//		 'cc'     => $cc,
//         'bcc'     => $bcc,
//         'from'    => $from_name,
//    	 'to'      => $to,
//         'html' => "<div style='font-family:Arial;'>".$message."</div>"
//), array(
//    'attachment' => array($attachment)
//));
//   
//}
//
//
//
//
//$subject="Test Mail From One2One";
//$message="<div style='font-family:Arial;'>This Mail is for Testing Purpose only</div>";
//function test_mail($to='aakansha.jain@cheshtainfotech.com',$message,$subject){
//$from_name="Notification O2O Testing";
//$mgClient = new Mailgun('key-8788c657a8822dca7c784e5aeafe8f0a');
//$domain = "one2onescheduler.com";
//return $result = $mgClient->sendMessage($domain,  array(
//         'subject' => $subject,
//         'from'    => $from_name.'<notification@one2onescheduler.com>',
//    	 'to'      => $to,
//		 'html' => $message
//));
//}


?>