<link href="user/templates/css/boot.css" rel="stylesheet">
<link rel="stylesheet" href="user/templates/css/login.css">

<link rel="stylesheet" href="user/templates/css/custom.css">


<span id="login"></span>
<script type="text/javascript"> 
// $(document).ready(function() {
 
// $("#frm").validate({});
//  });
</script>
<?php 
	@session_start(); 
?>
<style>
 /* body {
    background: url(https://one2onescheduler.com/FL/webservice/picture/login_bg.jpg);
    background-size: cover;
    background-repeat: no-repeat; height:100vh;
  }*/
/*body{background:#fff;}*/
/*#F3F4F6*/
.container_login{
	margin: 3% auto;
}
</style><br />
 <div class="container_login">
<div class="profile">

<div class="profile__form">
<div class="tc"><b class="f20">Delegate Area - Login</b>
</div>
<br><br>
<form  class="cmxform" id="frm" name="CompanyAdd_form" method="post" action="user/model/check_login.php"> 
<div class="profile__fields">
<div class="field">
<!--<input type="text" id="fieldUser" class="input" required pattern=.*\S.* />-->
<b style="padding-bottom:5px; display:block;">User Name</b>
<input type="text" name="email" id="fieldUser"  class="input" required value="<?php if(isset($_COOKIE["user_username_cookie"])){ echo $_COOKIE["user_username_cookie"];}?>">
<!--<label for="fieldUser" class="label">Username</label>-->
</div>
<div class="field mbn">
<!-- <input type="password" id="fieldPassword" class="input" required pattern=.*\S.* />-->
<b style="padding-bottom:5px; display:block;">Password</b>
<input type="password"  name="password" id="fieldPassword" required class="input" value="<?php if(isset($_COOKIE["user_password_cookie"])){ echo $_COOKIE["user_password_cookie"];}?>">

<!--<label for="fieldPassword" class="label">Password</label>-->
</div>

<input type="checkbox" name="remember" id="fieldRemember" class="" <?php if(isset($_COOKIE["user_username_cookie"])){ ?> checked <?php } ?>>
<label for="fieldRemember" class="remember">Remember me?</label>





<div class="profile__footer">
<!-- <button class="btn">Login</button>-->
<input type="submit" name="submit" id="submit" value="Login" class="btn" />
</div>
</div>

</form> 


</div>
</div>
</div>


<div class="footer_bg mt">
<div class="container">

<div class="row">
<div class="col-md-12">
&copy; <?php echo date('Y'); ?> Powered by one2onescheduler.com - All rights reserved 
</div>
</div>
</div>
</div>

<style>
.sideContent {
    width: 35%;
    font-size: 16px;
    position: absolute;
    top: 29%;
    right: 1%;
    
}
.sideTitle{
    color: #3C8DBC;font-size: 28px;font-weight: bold;font-style: italic;
}
.contentHighlight {
    color: #3C8DBC;
    font-weight: 700;
}
@media screen and (max-width: 1100px){
    .container_login {
        margin: 3% 20% 3% 28%;
    }
    .sideContent {
        width: 33%;
        font-size: 14px;
    }
}

@media screen and (max-width: 975px){
    .container_login {
        margin: 3% 23%;
    }
    .sideContent {
        width: 39%;
        font-size: 14px;
    }
}
@media screen and (max-width: 890px){
    .container_login {
        margin: 3% 10%;
    }
    .sideContent {
        width: 46%;
        font-size: 15px;
        right: 3%; 
    }
}
@media screen and (max-width: 830px){
    .sideContent {
        width: 41%;
        top: 41%;
        font-size: 14px;
    }
}
@media (min-width: 768px)
    .container {
        width: 100%;
    }
}
@media screen and (max-width: 750px){
    .sideContent {
        width: 40%;
        font-size: 13px;
    }
}

@media screen and (max-width: 680px){
    .sideContent {
        width: 33%;
        font-size: 12px;
    }
}
@media screen and (max-width: 630px){
    .container_login {
        margin: 3% auto;
    }
    .sideContent {
        margin: 1% 15% 6% 6%;
        width: 90%;
        font-size: 15px;
        position: relative;
        top: 0%;
        right: 0%;
    }
}
    
</style>


 <link href="templates/css/toastr.css" rel="stylesheet" type="text/css" />
<script src="templates/js/toastr.js"></script>
<script type="text/javascript">
function showToast(message,type='info'){
 //alert(message);
  toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "8000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
  };
toastr[type](message);
}
showToast(GetMessage());
</script>
<?php getMessage(); ?>