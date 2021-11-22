<?php
require '../../phpmailer/mailgun-php/vendor/autoload.php';
use Mailgun\Mailgun;

function mailgun_msg_send($to,$message,$subject,$from_name,$bcc,$cc,$reply){
    $mgClient = new Mailgun('key-8788c657a8822dca7c784e5aeafe8f0a');
    $domain = "one2onescheduler.com";
    $to = "cit.suyogbhavsar2019@gmail.com";
    $result = $mgClient->sendMessage($domain,  array(
        'subject' => $subject,
        //'bcc'     => $bcc,  //'cit.nikheel@gmail.com',
        // 'h:Reply-To' => $reply,  //'cit.nikheel@gmail.com', 
        'from'    => $from_name.'<notification@one2onescheduler.com>',  //'Excited User <notification@one2onescheduler.com>',
    	'to'      => $to,  //'manish <cit.manishsharma@gmail.com>', replyTo
        'html' => $message
    ));
}
?>