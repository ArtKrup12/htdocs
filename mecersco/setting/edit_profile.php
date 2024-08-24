<?php

include('../auth/auth_login.php') ;
include('../database_connect/conn.php') ;
include('../database_connect/conn_log.php') ;

        if(isset($_POST['editprofile'])){

            $Tel = $_POST['Tel'] ;
            $Email = $_POST['Email'] ;
            $Emp_id = $_SESSION['Emp_id'] ;

            if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                header("location:../userpage/setting") ; // อีเมลนี้ไม่มีอยู่
                exit ;
              }else{
                $update =  "UPDATE emphss7 
                SET `Tel`= '$Tel' , `Email` = '$Email'
                WHERE Emp_id = '$Emp_id'  " ;
                $result = mysqli_query($conn,$update) ;

                $id = $_SESSION['Emp_id'] ;
                $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','มีการเปลี่ยนแปลงข้อมูลผู้ใช้')";
                $log = mysqli_query($conn_log, $insert_log) ;

                header("location:../userpage/setting") ;
              }

             

        }else{
            header("location:../userpage/setting") ;
        }


?>