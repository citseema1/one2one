var xmlHttp
function add_datetime_ajax(PageName, DivId,val1,val2,val3)
{ 
//alert(PageName);
//alert(DivId);
//alert(val1);
//alert(val2);
//alert(val3);

if(val2=='tmp')
{
 
	document.getElementById("tmplink1").style.display='none';
}

if ((val3==''))

                {

                  document.getElementById(DivId).innerHTML="";

                  return;

                }

                xmlHttp=GetXmlHttpObject();

                if (xmlHttp==null)

                {

                                alert ("Browser does not support HTTP Request");

                                return;

                }

           var url=PageName;

                url=url+"?val1="+val1;

                url=url+"&val2="+val2;
				url=url+"&val3="+val3;
				// var url='customer.php'
				// url=url+"?value="+value;



                url=url+"&sid="+Math.random();
  // alert(url);
                xmlHttp.onreadystatechange=function()

                {

                                if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

                                {
									
								
 
											document.getElementById(DivId).innerHTML=xmlHttp.responseText;
											document.getElementById("loader").innerHTML=' ';
											 $(function() { 
	$(".sf").change(function(){
	  
            var element = $("option:selected", this);
            var param = element.attr("contnt");
			var params=param.split(",");
			var val1=params[0];
			var val2=params[1];
			var val3=params[2];
			var val4=params[3];
			var val5=params[4];

            add_datetime_ajax(val1,val2,val3,val4,val5);
        });
		});
											 
											 
	$(function(){
		//Call the edit function
		if(DivId!="load_data"){
		$('#'+val1).click(function(){
								  
			// Get the id name
			var element=this;
			var id=element.id;
			//var n=id.split("_");
			
			var p_id=$("span#succ_"+id+" select option:selected").val();

var old_val=$( '#'+id ).attr( "data" );

			//New text box with id and name according to position
			var textboxs='<input type="text" name="text'+id+'" id="text'+id+'" placeholder="'+old_val+'" class="textbox" >'
			
			//Place textbox in page to enter value 
			$('#'+id).html('').html(textboxs);

			//Set value of hidden field
			$('#hidden').val(id);
			$('#old').val(old_val);
			
			$('#part').val(p_id);
			//Focus the newly created textbox
			$('#text'+id).focus();
			
			
		});

		// Even to save the data - When user clicks out side of textbox
		    $('#'+val1).focusout(function(){
			//Get the value of hidden field (Currently editing field)
			var field = $('#hidden').val();
			var p_m_id = $('#part').val();
			//get the value on text box (New value entred by user)
			var value = $('#text'+field).val();
			var table_id=$('#tab_id').val();
			var old_field = $('#old').val();
			//var value = $('#text'+field).val();
//alert(value);

			//Update if the value in not empty
			if(value!='')
			{
				//Post to a php file - To update at backend
				$.post('user/view/savetag.php',{action:this.id,value:value,part_met_id:p_m_id,table_id:table_id}, function(response){
				
				
				});
				//Set the data attribue with new value
				$(this).html(value).attr('data',value);
				//$('#hidden'+id).val("dgf");
				document.getElementById('hidden'+field).value=value;
			}
			if(value=='')
			{
				
				$(this).html(old_field).attr('data',old_field);
				
			}

			// If user exists with out making any changs
			

		});
	 }})
	 
	
$(function(){
		//Call the edit function
		
		$('.update').click(function(){
			// Get the id name
			
			var element=this;
			var id=element.id;
var old_val=$( '#'+id ).attr( "data" );
			//New text box with id and name according to position
			var textboxs='<input type="text" name="text'+id+'" id="text'+id+'" placeholder="'+old_val+'" class="textbox" >'
			
			//Place textbox in page to enter value 
			$('#'+id).html('').html(textboxs);

			//Set value of hidden field
			$('#hide').val(id);
			$('#old').val(old_val);
			//Focus the newly created textbox
			$('#text'+id).focus();
		});

		// Even to save the data - When user clicks out side of textbox
		$('.update').focusout(function(){
			//Get the value of hidden field (Currently editing field)
			var field = $('#hide').val();
var old_field = $('#old').val();
			//get the value on text box (New value entred by user)
			var value = $('#text'+field).val();

			//Update if the value in not empty
			if(value!='')
			{
				//Post to a php file - To update at backend
				$.post('user/view/update_loc.php',{action:this.id,value:value}, function(response){
				
				});
				//Set the data attribue with new value
				$(this).html(value).attr('data',value);
			}
			if(value=='')
			{
				
				$(this).html(old_field).attr('data',old_field);
				
			}

		});
		})
			  
											if(PageName!='view/ajax/update_status.php' && PageName!='config/meeting_slot_endtime.php' )
											{   
											
											$("#selectall").click(function () {
        $('.case').attr('checked', this.checked);
  });
  // if all checkbox are selected, check the selectall checkbox
  // and viceversa
  $(".case").click(function(){
      if($(".case").length == $(".case:checked").length) {
          $("#selectall").attr("checked", "checked");
      } else {
          $("#selectall").removeAttr("checked");
      }

});
											
											
												$('#example').dataTable( {
																		
												"iDisplayLength": 50,
												"aoColumnDefs": [ 
												{ "bSortable": false, "aTargets": [ 0 ] }
												] ,
												"aaSorting": [[ 2, 'asc' ]], 
												
												} );
											
											
											
											$("#example_length").hide();
											/*$("#example_filter").hide();*/
											}
											  // add multiple select / deselect functionality
 

  // add multiple select / deselect functionality
  

		  
		                      
								}

                                else

                                {
									//alert('d');

                                                //document.getElementById(DivId).innerHTML="";

                                }

                };

                xmlHttp.open("GET",url,true);

                xmlHttp.send(null);

}

 

 

function GetXmlHttpObject()
{
       var objXMLHttp=null;
       if (window.XMLHttpRequest)
       {
               objXMLHttp=new XMLHttpRequest();
       }
       else if (window.ActiveXObject)
       {
               objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP");
       }
       return objXMLHttp;
}