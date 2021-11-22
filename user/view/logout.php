<?php 
//@session_start();
session_start();
//session_destroy();
/*unset($_SESSION['com_id']);
unset($_SESSION['_TaBlE_ID']);
unset($_SESSION[$unique_user]);
unset($_SESSION['table_required']); */
unset($_SESSION['login_company_name']);

$message= "Logout successfully..!";  
	  $type="succlogin";
	  
SetMessage($message, $type);

 
	// $location="login.php";
	$location="?page=login";
redirect($location);
?>