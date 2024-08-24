<?php

    include('../auth/auth_login.php') ;
    include('../database_connect/conn.php') ;
    include('../database_connect/conn_log.php') ;
    
    $Emp_id =  $_SESSION['Emp_id'] ;
    echo $_GET['risk'] ;

    if(empty( $_GET['risk'])){
         if(empty($_GET['action'])) {
        if(isset($_POST['delete_toolid'])){
            
            $Tool_id =  $_POST['delete_toolid'] ;
            $delete_temp_list = "DELETE FROM temp_list WHERE Emp_id = $Emp_id AND Tool_id = $Tool_id " ;
            $delete = mysqli_query($conn, $delete_temp_list) ;

         
            $id = $_SESSION['Emp_id'] ;
            $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','ลบเครื่องมือในรายการชั่วคร่าว')";
            $log = mysqli_query($conn_log, $insert_log) ;

            $_SESSION['delete_tool'] = 'complete' ;
            header("location:../userpage/borrow") ;

        }else{
            header("location:../userpage/borrow?risk=$risk") ;
        }
       
    }else{
        $delete_temp_list = "DELETE FROM temp_list WHERE Emp_id = $Emp_id " ;
        $delete = mysqli_query($conn, $delete_temp_list) ;

        
        $id = $_SESSION['Emp_id'] ;
        $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','ลบเครื่องมือทั้งหมดในรายการชั่วคร่าว')";
        $log = mysqli_query($conn_log, $insert_log) ;

        $_SESSION['delete_tool'] = 'complete' ;
        header("location:../userpage/borrow") ;
    }
   
    }else{
         if(empty($_GET['action'])) {
        if(isset($_POST['delete_toolid'])){
            
            $Tool_id =  $_POST['delete_toolid'] ;
            $delete_temp_list = "DELETE FROM temp_list WHERE Emp_id = $Emp_id AND Tool_id = $Tool_id " ;
            $delete = mysqli_query($conn, $delete_temp_list) ;

            
            $id = $_SESSION['Emp_id'] ;
            $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','ลบเครื่องมือในรายการชั่วคร่าว')";
            $log = mysqli_query($conn_log, $insert_log) ;

            $risk = $_GET['risk'] ;

            $_SESSION['delete_tool'] = 'complete' ;
            header("location:../userpage/borrow?risk=$risk") ;

        }else{
            header("location:../userpage/borrow?risk=$risk") ;
        }
       
    }else{

        $delete_temp_list = "DELETE FROM temp_list WHERE Emp_id = $Emp_id " ;
        $delete = mysqli_query($conn, $delete_temp_list) ;
        $risk = $_GET['risk'] ;

        
        $id = $_SESSION['Emp_id'] ;
        $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','ลบเครื่องมือทั้งหมดในรายการชั่วคร่าว')";
        $log = mysqli_query($conn_log, $insert_log) ;

        $_SESSION['delete_tool'] = 'complete' ;
        header("location:../userpage/borrow?risk=$risk") ;
    }
   
    }

 
   

?>