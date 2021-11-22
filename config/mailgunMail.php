<?php
require '../../config/mailgun-php/vendor/autoload.php';
use Mailgun\Mailgun;

//$mgClient = new Mailgun('pubkey-269544c6abf909e8bdd622a15ab69871');
////# Issue the call to the client.
//$result = $mgClient->get("address/validate", array('address' => $to));
//
//$isValid = $result->http_response_body->is_valid;
//
//if($isValid!=""){
$cc = "";
$bcc = "seema.vaidya@cheshtainfotech.com";

//$bcc = "cit.nikheelp2019@gmail.com";
//$to = "cit.nikheelp2019@gmail.com";
//$to = "cit.nikheelp2019@gmail.com"; //"cit.shoaibm2019@gmail.com";

//$from_email = "LFS one2one Scheduler<notification@one2onescheduler.com>";

/*$mgClient = new Mailgun('key-8788c657a8822dca7c784e5aeafe8f0a');
$domain = "one2onescheduler.com";
$result = $mgClient->sendMessage($domain,  array(
    //'cc'      => $cc,
    'bcc' => $bcc,
    //'h:sender'=> "",
    //'h:Reply-To' => 'info@activefreight.network', 
    'subject' => $subject,
    'from'    => $from_email,  //'The COOP Annual Conference 2018 <info@thecooperativelogisticsnetwork.com>',
    'to'      => $to,
    'html' => $message
));*/


$messageId = $result->http_response_body->id;
$messageId = str_replace("<","",$messageId);
$messageId = str_replace(">","",$messageId);
$responseText = $result->http_response_body->message;
//}
?>