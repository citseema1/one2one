<?php
include "../../config/config.php";

$active_participant_id = $_GET['active_participant_id'];
$active_table_id = $_GET['active_table_id'];

$_SESSION['LOGIN_USER_SESSION']['loginTableId'] = $active_table_id;
$_SESSION['LOGIN_USER_SESSION']['activeParticipantId'] = $active_participant_id;
$_SESSION['activeParticipantId'] = $active_participant_id;

$redirePage = "../../?page=dashboard";
//echo $redirePage;
redirect($redirePage);
?>