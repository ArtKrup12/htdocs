<?php
include('../auth/auth_login.php') ;
include('../database_connect/conn.php') ;

$ToolId =  $_POST['add_tool'] ;
$Emp_id =  $_POST['Emp_id'] ;

$i=0 ;
$check=0 ;
$query_tool_temp = $conn->query("SELECT * FROM temp_list  WHERE Emp_id = $Emp_id");
while($row = mysqli_fetch_assoc($query_tool_temp)) {

   $Tool_id =  $row['Tool_id'] ;
   $numbers[$i] = ($Tool_id) ;  
   if($numbers[$i]==$ToolId){
    $check++ ;
   }
}

if(empty($_GET['risk'])){
    $risk = $_POST['test'] ;
}else{
    $risk = $_GET['risk'] ;
}

if($check != 0){
    $_SESSION['repeat_tool'] = 'repeat' ;
    header("location:../userpage/borrow?risk=$risk") ;
}else{
    $insert = "INSERT INTO temp_list(Tool_id,Emp_id) VALUES ('$ToolId','$Emp_id')";
    $insertprocess = mysqli_query($conn, $insert) ;

    include('../database_connect/conn_log.php') ;
    $id = $_SESSION['Emp_id'] ;
    $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','เพิ่มเครื่องมือลงในรายการชั่วคร่าว')";
    $log = mysqli_query($conn_log, $insert_log) ;
    $_SESSION['add_tool'] = 'complete' ;

    header("location:../userpage/borrow?risk=$risk") ;      
}

?>