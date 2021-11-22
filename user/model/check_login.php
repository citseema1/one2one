<?php
include "../../config/config.php";

$return = checkLoginFun($_POST);
$_SESSION['LOGIN_USER_SESSION'] = $return;

//echo "<pre>"; print_r($_SESSION); echo "</pre>";

$success = $return['success'];
$message = $return['message'];

$redirePage = "login";

if($success==1){
    $loginEmail = $return['loginEmail'];
    $loginCompanyId = $return['loginCompanyId'];
    $loginTableRequired = $return['loginTableRequired'];
    
    $_SESSION[$unique_user] = $loginEmail;
    $_SESSION['loginEmail'] = $loginEmail;
    $_SESSION['loginCompanyId'] = $loginCompanyId;
    $_SESSION['loginTableRequired'] = $loginTableRequired;
    
    $redirePage = "set_meeting";
    $redirePage = "dashboard";
    if(isset($return['loginTableId'])){
        $loginTableId = $return['loginTableId'];
        $_SESSION['loginTableId'] = $table_id;
        $redirePage = "dashboard";
    }
}

$redirePage = "../../?page=".$redirePage;
//echo $redirePage;
redirect($redirePage);

?>