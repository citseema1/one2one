<div class="menu-cus sidebar" id="bottom_header_outer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="cssmenu">
                    <ul style="float:left;">
                    <?php 
                    //if($session_id!="" && $res==''){
                        if($close_ind==0){
                        ?>
                            <li <?php if($page== 'dashboard' || $page == 'search_new'){  echo 'class="active"';}?>>
                                <a id="#featured" href="?page=dashboard" style="cursor:pointer;"><i class="menu-icon fa fa-tachometer"></i><br />Dashboard</a> 
                            </li>
                            <li <?php if($page== 'schedule_your_meetings0' || $page == 'search_new'){  echo 'class="active"';}?>>
                                <a id="#featured" href="?page=schedule_your_meetings" style="cursor:pointer;"><i class="menu-icon fa fa-table"></i><br />Schedule By Time-slot</a> 
                            </li>
                            <li <?php if($page== 'participant'){ echo 'class="active"';} ?>>
                                <a  id="#jquerytuts" href="?page=participant" style="cursor:pointer;"><i class="menu-icon fa fa-list-alt"></i><br /> Schedule By Delegates</a>
                            </li>
                        <?php   } ?>
                        <li <?php if($page== 'report'){  echo 'class="active"';}  ?>>  
                            <a  id="#core" href="?page=report_v1" style="cursor:pointer;"><i class="menu-icon fa  fa-bar-chart-o"></i><br /> My Agenda</a> 
                        </li>
                        <?php if($close_ind==0){?>
                            
                            <li <?php if($page=='version4_help'){  echo 'class="active"';}  ?>>
                                <a href="?page=version4_help" ><i class="menu-icon fa fa-question"></i><br />Help / Support</a>
                            </li>
                    <?php } ?>
                        <!--<li><a href="?page=logout" ><i class="menu-icon fa fa-power-off"></i><br />Logout</a></li>-->
                        <li>
                            
                        </li>
                <?php //} ?>
                    </ul>
                    
                    <div class="rightBox">
                        <div class="iconMenu">
                            <a href="?page=messages" >
                                <i class="menu-icon fa fa-bell"></i>
                            </a>
                            <a href="?page=cart">
                                <i class="menu-icon fa fa-shopping-cart"></i>
                            </a>
                        </div>
                        
                        <a href="javascript:void(0)" class="companyPhotoTag">
                            <img class="topPhoto" src="<?php echo $login_company_logo; ?>">
                        </a>
                        <a href="javascript:void(0)" class="participantPhotoTag">
                            <img class="topPhoto" src="<?php echo $login_participant_photo; ?>">
                        </a>
                        
                        <div class="participantDetailDiv" style="display:none;">
                            <div class="boxButtonDiv rightBoxPart">
                                <input type="button" value="My Profile">
                            </div>
                            <div class="boxButtonDiv leftBoxPart">
                                <i class="menu-icon fa fa-power-off"></i>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rightBox {
    float: right;
    padding: 15px 5px;
}
.topPhoto{
    width: 40px;
    border-radius: 25px;
    margin-right: 10px;
}

.iconMenu .fa {
    padding: 0px 5px;
    color: #fff;
}
.iconMenu {
    display: inline;
    font-size: 21px;
    margin-right: 15px;
}
</style>

<script>
$(document).on("mouseover",".participantPhotoTag",function(){
    //$(".participantDetailDiv").show();
});
$(document).ready(function(){
    
});
</script>