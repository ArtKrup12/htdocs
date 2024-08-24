<?php

    session_start() ;
include('../database_connect/conn.php') ;
include('../database_connect/conn_log.php') ;

    
        $Emp_id =  $_POST['Emp_id'] ; 
        $Emp_pass =  $_POST['Emp_pass'] ;
  
        $query_Emp_id = $conn->query ( "SELECT * FROM emphss7 WHERE Emp_id = $Emp_id " ) ;
        $query_Emp = mysqli_fetch_assoc($query_Emp_id) ;
        if($Emp_pass == $query_Emp['Emp_pass']){
            if($query_Emp['Role'] == 'admin' ){
                if($_POST['mode']=='user_mode'){
                    echo 'user' ;
                    $id = $query_Emp['Emp_id'] ;
                    $_SESSION['Role'] = $query_Emp['Role'] ;
                    $_SESSION['Emp_id'] = $query_Emp['Emp_id'] ;

                    $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','เข้าสู่ระบบ')";
                    $log = mysqli_query($conn_log, $insert_log) ;
                    
                    header("location:../userpage/home?id=$id") ;
                }else if($_POST['mode']=='admin_mode'){

                    $id = $query_Emp['Emp_id'] ;
                    $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','เข้าสู่ระบบ')";
                    $log = mysqli_query($conn_log, $insert_log) ;

                    echo 'admin' ;
                }elseif($_POST['mode']=='phpMyadmin_mode'){
                    $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','เข้าสู่ระบบ จัดการข้อมูล')";
                    $log = mysqli_query($conn_log, $insert_log) ;
                    header("location:../../phpmyadmin/") ;
                }else{
                    header("location:../loginloginmecers") ;
                }
               
            }else{
                header("location:../loginloginmecers") ;
            }
        }else{
            $_SESSION['err_password'] = 'password_uncorrect' ;
            header("location:../loginmecers") ;
        }
    

?>