<?php
//include "../config/config.php";
//session_destroy();

function checkLoginFun($_POSTDATA=''){
    global $con,$prefix;
    
    $RETURN_DATA = array();
    
    $RETURN_DATA['success'] = 0;
    $RETURN_DATA['message'] = "Invalid Credentials";
    
    $email = $_POSTDATA['email'];
    $access_code = $_POSTDATA['password'];
    
    $select = "SELECT id,table_status,table_required FROM ".$prefix."O2O_Pre_Companies WHERE access_code='$access_code' and email='$email'";
    $exe = mysqli_query($con,$select) or die(mysqli_error($con));
    $num_rows = mysqli_num_rows($exe);
    if($num_rows > 0){
        $fetch = mysqli_fetch_assoc($exe);
        $id = $fetch['id'];
        $table_required = $fetch['table_required'];
        $select_table = "SELECT id FROM ".$prefix."O2O_Pre_Table WHERE company_id='$id'";
        $exe_table = mysqli_query($con,$select_table) or die(mysqli_error($con));
        $num_table_rows = mysqli_num_rows($exe);
        if($num_table_rows>0){
            
            $RETURN_DATA['success'] = 1;
            $RETURN_DATA['message'] = "Successfully Login";
            $RETURN_DATA['loginEmail'] = $email;
            $RETURN_DATA['loginCompanyId'] = $id;
            $RETURN_DATA['loginTableRequired'] = $table_required;
            
            /*if($table_required==1){
                $fetch_table = mysqli_fetch_assoc($exe_table);
                $table_id = $fetch_table['id'];
                $RETURN_DATA['loginTableId'] = $table_id;
                
            }*/
        }
    }
    
    return $RETURN_DATA;
}

function getResultDataFun($MY_SQL){
    global $con,$prefix;
    
    $RETURN_DATA = array();
    $RETURN_DATA['success'] = 0;
    $RETURN_DATA['message'] = "Invalid Credentials";
    
    $SQL_EXE = mysqli_query($con,$MY_SQL);
    $NUM_RECORD = mysqli_num_rows($SQL_EXE);
    if($NUM_RECORD>0){
        
        $RETURN_DATA['success'] = 1;
        $RETURN_DATA['message'] = "Record found";
        $RETURN_DATA['numRecord'] = $NUM_RECORD;
        
        while($FETCH_DATA = mysqli_fetch_assoc($SQL_EXE)){
            $RETURN_DATA['result'][] = $FETCH_DATA;
        }
    }
    return $RETURN_DATA;
    
}

/*$_POST['login_email'] = 'x2_elaine@aceglobal.uk';
$_POST['access_code'] = '100200';*/


/*checkLoginFun($_POST);

echo "<pre>"; print_r($_SESSION);*/
?>