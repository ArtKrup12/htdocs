<?php

include "../../config/connect.php";

$username = $_POST['user'] ;

if(isset($_POST['emp_id'])) {
    $empId = $_POST['emp_id'] ;
    $checkQuery = "SELECT COUNT(*) AS count FROM `tb_employee` WHERE `username` = '$username' AND emp_status != '99' AND emp_id != '$empId'";
    $result = mysqli_query($mysqli, $checkQuery);
    $row = mysqli_fetch_assoc($result);
    if ($row['count'] > 0) {
        echo json_encode(['success' => false, 'message' => 'username นี้มีอยู่ในระบบแล้ว']);

    }else{
        echo json_encode(['success' => true, 'message' => 'username ไม่มีอยู่ในระบบแล้ว']);
    }
}else{
    $checkQuery = "SELECT COUNT(*) AS count FROM `tb_employee` WHERE `username` = '$username' AND emp_status != '99' ";
    $result = mysqli_query($mysqli, $checkQuery);
    $row = mysqli_fetch_assoc($result);
    if ($row['count'] > 0) {
        echo json_encode(['success' => false, 'message' => 'username นี้มีอยู่ในระบบแล้ว']);

    }else{
        echo json_encode(['success' => true, 'message' => 'username ไม่มีอยู่ในระบบแล้ว']);
    }
}

?>