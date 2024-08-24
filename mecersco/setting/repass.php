<?php
    include('../auth/auth_login.php') ;
    include('../database_connect/conn.php') ;
    include('../database_connect/conn_log.php') ;


    if(isset($_POST['repass'])){
        $newpass = $_POST['newPass'] ;
        $newrepass = $_POST['newRePass'] ;
        if($newpass == $newrepass){

            $Emp_id = $_SESSION['Emp_id'] ;
            $update =  "UPDATE emphss7 
            SET `Emp_pass`= $newpass
            WHERE Emp_id = '$Emp_id'  " ;
            $result = mysqli_query($conn,$update) ;

            $id = $_SESSION['Emp_id'] ;
            $insert_log = "INSERT INTO log_in_mecers(Who,Action) VALUES ('$id','มีการเปลี่ยนแปลงรหัสผ่าน')";
            $log = mysqli_query($conn_log, $insert_log) ;

            header("location:../userpage/setting") ;

        }else{
            header("location:../userpage/setting") ;
        }


    }else{
        header("location:../userpage/setting") ;
    }

?>