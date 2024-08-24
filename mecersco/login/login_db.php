<?php

    session_start() ;
include('../database_connect/conn.php') ;
include('../database_connect/conn_log.php') ;

    //if(isset($_POST['login'])){

        $Emp_id =  $_GET['Emp_id'] ; 
        $Emp_pass =  $_GET['Emp_pass'] ;
        $query_Emp_id = $conn->query ( "SELECT * FROM emphss7 WHERE Emp_id = $Emp_id " ) ;
        $query_Emp = mysqli_fetch_assoc($query_Emp_id) ;
        if($Emp_pass == $query_Emp['Emp_pass']){
            if($query_Emp['Role'] == 'user' ){
                echo 'user' ;
                $id = $query_Emp['Emp_id'] ;
                $_SESSION['Role'] = $query_Emp['Role'] ;
                $_SESSION['Emp_id'] = $query_Emp['Emp_id'] ;
                $_SESSION['login_complete'] = 'success_login' ;

                $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','เข้าสู่ระบบ')";
                $log = mysqli_query($conn_log, $insert_log) ;


                header("location:../userpage/home?id=$id") ;
            }else if($query_Emp['Role'] == 'app'){
                echo 'app' ;
                $id = $query_Emp['Emp_id'] ;
                $_SESSION['Role'] = $query_Emp['Role'] ;
                $_SESSION['Emp_id'] = $query_Emp['Emp_id'] ;
                $_SESSION['login_complete'] = 'success_login' ;

                $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','เข้าสู่ระบบ')";
                $log = mysqli_query($conn_log, $insert_log) ;

                header("location:../userpage/home") ;
            }else if($query_Emp['Role'] == 'admin'){
                 
                echo 'admin' ;
            }
        }else{
            $_SESSION['err_password'] = 'password_uncorrect' ;
            header("location:../loginmecers") ;
        }
        
        
      

   // }else{
     //   header("location:../login.php") ;
  //  }

?>