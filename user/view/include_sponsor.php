<div class="wi-100">
    <div class=" mt  body_con ">
        <div class="green-haze">
            <div class="caption">Event Sponsors</div>
            <div class="cl"></div>
        </div>
        <div class="content green-haze-body p10">
        <?php
        $nn = 1;
        $colClass = "";
        $select2_group  = mysqli_query($con,'select * from '.$prefix.'O2O_Sponsors_Groups order by priority asc');

        while ( $fetch_group12 = mysqli_fetch_array($select2_group)) {
            $nn++; 
            $getMemberType = $fetch_group12['member_type'];

            if($nn==2){ $colClass = "2"; }
            if($nn==3){ $colClass = "3"; }
            if($nn==4){ $colClass = "4"; }

            $select21  = mysqli_query($con,"select * from ".$prefix."O2O_Sponsors_Details where group_type='$getMemberType'");
            while($fetch112 = mysqli_fetch_array($select21)){
                $getLogo = $fetch112['logo'];

                if(isset($getLogo) && !empty($getLogo)){ ?>
                    <fieldset style="width: 100%; border: 1px solid #ccc; padding:5px; ">
                        <legend style="width: auto; padding:0 5px;  color:#fff; margin:10px 5px; background-color: red;">
                            <span ><?php echo ucfirst($getMemberType);?></span>
                         </legend>

                        <?php
                        $select21  = mysqli_query($con,"select * from ".$prefix."O2O_Sponsors_Details where group_type='$getMemberType'");
                        while($fetch112 = mysqli_fetch_array($select21)){
                            $getWebsite = $fetch112['website'];
                            $getLogo = $fetch112['logo'];
                        ?>
                            <div class="col-1-<?php echo $nn;?> tc pb" style="background-color: #fcf7f7;">
                                <a href="<?php echo $getWebsite;?>" target="_blank">
                                    <img  height="100px" src="<?php echo $getLogo;?>">

                                </a>
                            </div>
                  <?php } ?>
                    </fieldset>
            <?php 
                } 
            } 
        } ?>
        <div class="cl"></div>
        </div>
    <br>
    </div> 
</div>