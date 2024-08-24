<?php
        include('auth/auth_login.php') ;
        include('database_connect/conn_log.php') ;
        include('database_connect/conn.php') ;


        $id = $_SESSION['Emp_id'] ;
        $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','ออกจากระบบ')";
        $log = mysqli_query($conn_log, $insert_log) ;

        $delete_temp_list = "DELETE FROM temp_list WHERE Emp_id = $id " ;
        $delete = mysqli_query($conn, $delete_temp_list) ;

        header("location:loginmecers") ;

?>