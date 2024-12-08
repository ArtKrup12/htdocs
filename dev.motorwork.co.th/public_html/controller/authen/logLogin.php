<?php

include "../../config/connect.php";

$action = $_POST['action'] ;

date_default_timezone_set('Asia/Bangkok');
$currentDateTime = date('Y-m-d H:i:s');

if ($action == 'login') {
            $insert_assign = "INSERT INTO `tb_history_login`(`emp_id`, `login_dt`, `logout_dt`) 
            VALUES ('[value-2]','[value-3]','[value-4]')";
            mysqli_query($mysqli,$insert_assign) ;
}

?>