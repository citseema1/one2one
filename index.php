<?php
include('config/config11.php'); 

if (isset($_SESSION[$unique_user]) && !empty($_SESSION[$unique_user])) {
	if(isset($_REQUEST['page'])){
		$page=$_REQUEST['page'];
		$include='user/view/'.$page.'.php';
		if(!is_file($include)){
			$include='view/401.php';	
		}else{
			if($page=="login" || $page==""){
				$include='user/view/schedule_your_meetings0.php';
			}
		}
	}else{
		$include='user/view/schedule_your_meetings0.php';
	}
}else{
	$include='view/login.php';
}

//include('templates/loged.php'); 
include('user/index.php');

?>
