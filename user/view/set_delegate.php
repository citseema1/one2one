<?php
session_start(); 
 
if(isset($_SESSION[$unique_user]) && $_SESSION[$unique_user]!="")
{
	
   if(isset($_POST['confirm_setting'])){
	   
	   $company_id = $_POST['hidden_company_id'];
	   
	   mysqli_query($con,"update ".$prefix."O2O_Pre_Companies set table_status='1' where id='".$login_companyId."'") or die(mysqli_error($con));
	   
	   $location="?page=set_meetings";
	   redirect($location);
  
   }
   
    if(isset($_POST['continue_with_current_setting'])){
    
	   $location="?page=set_meetings";
	   redirect($location);
  
   }
   
?>
<style type="text/css">
 
.todrag {
 cursor: pointer;
}
.dragging {
 border: 1px dashed #00f;
 background: #ff1;
 margin-top:20px;
}
.lbb2{
 border-left: 1px solid #CCCCCC;
}
</style>


  
<script type="text/javascript">
function drop(ev) {
  ev.preventDefault();
  var drag_data = ev.dataTransfer.getData('Text');
  ev.target.appendChild(document.getElementById(drag_data));
}

function allowDrop(ev) {
 
  ev.preventDefault();    // cancel the ev event
}

// function called when the drag operation starts
function dragStart(ev) {
	 
  // sets the data type and the value of the dragged data
  // This data will be returned by getData(). Here the ID of current dragged element 
  ev.dataTransfer.setData('Text', ev.target.id);

  // sets another css class
  ev.target.className = 'dragging';
}

// function called when the dragged element is dropped
function drop(ev,id) {
	 
  ev.preventDefault();  // the dragover event needs to be canceled to allow firing the drop event

  // gets data set by setData() for current drag-and-drop operation (the ID of current dragged element),
  // using for parameter a string with the same format set in setData
  var drag_data = ev.dataTransfer.getData('Text');
   
 	     $.ajax({
			 
			  url: "user/model/ajax_update_table_required.php",
			  type: "POST",
			  data: "id="+drag_data+"&auto_id_of_pre_table="+id,
			  success: function(msg){
				  // jAlert(msg,'Alert');
			   location.reload();  
		  } 
		  
	   });
		  

  // adds /appends the dropped element in the drop-target
  ev.target.appendChild(document.getElementById(drag_data));
 
  // sets another css class
  document.getElementById(drag_data).className = 'todrag';

  
}

 
</script>

 <br />
<div class="text_size" >&nbsp;Table Required Form  </div><hr />

<?php echo GetMessage(); 
 
 $com_id = $_SESSION['com_id'];

?>
   
   		<div align="center">
    	 	 <div class="tab_container" align="left">
             <div style="margin:10px; " >
          
               
 <fieldset style="width:98%; background:#C0D8F0; padding:5px; font-weight:bold; margin-top:20px; margin-bottom:15px; margin-left:5px; font-size:12px;" align="center">
 <legend style="background-color: #fff; font-size:12px; padding:0 5px;" align="left"> Instructions</legend>
					
		    <table width="100%" border="0" cellpadding="5" cellspacing="5" >

<tr>

<td   style="padding:3px;">
1.	Lorem Ipsum is simply dummy text of the printing and typesetting industry.


</td></tr>

 
</table>
		</fieldset>
        
           <table style="margin:20px;" width="70%" >
               <tr>
                  <td  width="45%" valign="top">
                        <table style="margin:20px;"  width="100%" cellpadding="0" cellspacing="0">
						<tr height="40px">
							<th style="padding-left:5px;"   class="lbb2 tbb rbb bbb">
                                Together
                            </th>
                            </tr>
                           
                             <?php
						    
							$select_2 = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Table where company_id='$login_companyId'") or die(mysqli_error($con));
							while($fetch_2 = mysqli_fetch_array($select_2)){
								
								 $a = explode(',',$fetch_2['participant_id']);
								 $count = count($a);
							 
								if($count>1){
									?>
                                     <tr>
                                    <td style="padding-left:5px;" class="lbb2 rbb bbb"> 
                                    
          <?php for($j=0;$j<$count;$j++){ 
										    
		  $select_3 = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Participants where id='".$a[$j]."'") or die(mysqli_error($con));
		  $fetch_3 = mysqli_fetch_array($select_3);
		  
		  ?>
          
              <a  draggable="true" ondragstart="dragStart(event)" id="<?php echo $a[$j].'/'.$fetch_2['id'];?>" class="todrag">
                     <? echo ucfirst($fetch_3['name']); ?>
              </a>
		  
		  <?  echo  '<br>'; }} echo ' </td></tr>';}?>
                              </table>
                            
                            
                            
                     
                  </td>
                  <td></td>
                  <td valign="top"  width="45%">
                  <table style="margin:20px;"  width="100%"  cellpadding="0" cellspacing="0" >
						<tr height="40px">
							<th style="padding-left:5px;"   class="lbb2 tbb rbb bbb">
                                Single
                            </th>
                            </tr>
                            
                             <?php
						    
							$select_21 = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Table where company_id='$login_companyId'") or die(mysqli_error($con));
							while($fetch_21 = mysqli_fetch_array($select_21)){
								
								 $a1 = explode(',',$fetch_21['participant_id']);
								 $count1 = count($a1);
								
								 
								  if($count1==1){ ?>
							 <tr height="40px">
                                 
      <td ondrop="drop(event,'<?php echo $fetch_21['id'];?>')" ondragover="allowDrop(event)" style="padding-left:5px;" class="lbb2 rbb bbb">	
                                 <?  
									   $b = implode(',',$a1);
									 
									 
		  $select_4 = mysqli_query($con,"select * from ".$prefix."O2O_Pre_Participants where id='".$b."'") or die(mysqli_error($con));
		  $fetch_4 = mysqli_fetch_array($select_4);
		  ?>
		 
		  <? echo ucfirst($fetch_4['name']); ?>
          
<br style="clear:both" /> 
							</td> 		  
									  </tr>  
									  
									  
								<?  }  
								 
								 
							}?>
                          
                           
                            
                            
                            </table>
                  </td>
               </tr>
           </table>       
                
                
                
              <form method="post"  action="" > 
                <input type="hidden" name="hidden_company_id" value="<?php echo $login_companyId;?>" />
      <table  width="90%" border="0" cellpadding="4" cellspacing="0" class="text" align="center" style="margin-left:50px;">
         <tr>  
            <td  align="left" style="height:40px;line-height:40px;">
               <input type="submit" style="padding:5px; margin-left:18%;" onclick="return confirm('Do you really want to continue....?')" name="confirm_setting" value="Confirm Settings"  class="report_page" />  
            </td>
            <td align="left">
                <input type="submit" style="padding:5px;margin-left:14%;"   name="continue_with_current_setting"  value="Continue With Current Setting"  class="report_page" />  
            </td>
          </tr>
      </table>
              </form>
         	    </div>
             </div>
              
        </div>
             
             
              
 <?php 
}
else
{
  $location="?page=login";
  redirect($location);
}

?>


 