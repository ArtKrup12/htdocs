<?php

include('../auth/auth_login.php');
include('../database_connect/conn.php') ;

include('../database_connect/conn_log.php') ;


    if(isset($_POST['app_borrow'])){

      $list_id =  $_POST['app_borrow'] ;
      $app = $_SESSION['Emp_id'] ;

      $update =  "UPDATE list 
      SET `app_id`= '$app' 
      WHERE List_id = '$list_id' " ;
      $result = mysqli_query($conn,$update) ;


      $update =  "UPDATE list 
      SET `List_status`= 'wait_app_return' 
      WHERE List_id = '$list_id' " ;
      $result = mysqli_query($conn,$update) ;

      $id = $_SESSION['Emp_id'] ;
      $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','อนุมัติการขอใช้')";
      $log = mysqli_query($conn_log, $insert_log) ;


      header("location:../userpage/confirm") ;

    }else{

    }

?>