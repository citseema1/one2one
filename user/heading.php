<div class="bg">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <div class=" tc">
                    <div class=""><br><img src="user/templates/images/logo.png"></div>
                </div>
            </div>

            <div class="col-md-7 col-sm-7 col-xs-7">
                <div class="heading-text tc wc ">
                    <div class="content tc wc " style="line-height:22px;">
                        <h4 class="wc">
                            <strong>One2One Meeting Scheduler</strong>
                            <?php if(isset($_SESSION['demo_live']) && $_SESSION['demo_live']!='' && $_SESSION['demo_live']=='DEMO'){ echo '(Live Demonstration)';} ?>  <br>
                            for <?php echo $EVENT_TITLE; ?>
                            <?php echo $EVENT_LOCATION; ?> <br>
                            <?php 
                            $start_time1 =  date('d',$EVENT_START_TIME_STR);
                            $end_time1 = date('d',$EVENT_END_TIME_STR);
                            if(isset($start_time1) && isset($end_time1) && $start_time1==$end_time1){
                                
                            }else{
                                echo date('l d F Y',$EVENT_START_TIME_STR)." - ".date('l d F Y',$EVENT_END_TIME_STR);
                            }?>
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="content dn1">
                    <img src="<?php echo $EVENT_LOGO;?>" style="height:100px;" class="center-block">
                </div>
            </div>
        </div>
    </div>
</div>