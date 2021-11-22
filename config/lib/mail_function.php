<?php
require '../../../phpmailer/mailgun-php/vendor/autoload.php';
use Mailgun\Mailgun;

function mailgun_msg_send($to,$from_name,$from_email,$bcc,$reply_to,$subject,$message){
  $mgClient = new Mailgun('key-8788c657a8822dca7c784e5aeafe8f0a');
$domain = "one2onescheduler.com";
$result = $mgClient->sendMessage($domain,  array(
         'subject' => $subject,
        // 'bcc'     => $bcc,  //'cit.nikheel@gmail.com',
        // 'h:Reply-To'     => $reply_to,  //'cit.nikheel@gmail.com', 
         'from'    => $from_name.'<notification@one2onescheduler.com>',  //'Excited User <notification@one2onescheduler.com>',
    	 'to'      => $to,  //'manish <cit.manishsharma@gmail.com>', replyTo
         //'html' => $message
		 'html' => "<div style='font-family:Arial;'>".$message."</div>"
));	  
     
}

function mailgun_msg_send1(){
$mgClient = new Mailgun('key-8788c657a8822dca7c784e5aeafe8f0a');
$domain = "one2onescheduler.com";

# Make the call to the client.
$result = $mgClient->sendMessage($domain, array(
    'from'    => 'Excited User <notification@one2onescheduler.com>',
    'to'      => 'manish <cit.manishsharma@gmail.com>',
    'subject' => 'Hello',
    'text'    => 'Testing some Mailgun awesomness! via function'
));
    
}


?>