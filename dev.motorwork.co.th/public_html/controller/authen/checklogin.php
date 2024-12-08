<?php
session_start();
include '../../config/connect.php' ;
header('Content-Type: application/json; charset=utf-8');

$username = $_POST['username'];
$password = $_POST['password'];

$query = $mysqli->query("
    SELECT * 
    FROM tb_employee 
    WHERE username = '$username' 
      AND password = '$password' 
      AND emp_status = '1'
");
$findmember = $query->num_rows;

if ($findmember != 0) {
    $member = $query->fetch_array();
    $_SESSION["role_no"] = $member['role_no'];
    $_SESSION["user_login"] = true;
    $_SESSION["MenuType"] = $member['role_no'] == 1 ? 'admin' : ($member['role_no'] == 2 ? 'หัวหน้า' : 'พนักงาน');
    $_SESSION["Member_IdLogin"] = $member['emp_id'];
    $_SESSION["Member_pic"] = $member['pic_name'];
    $_SESSION["Member_name"] = $member['emp_name'];
    $_SESSION["Member_last_name"] = $member['emp_surname'];
    $_SESSION["member_type"] = $member['role_no'];
    $_SESSION["logpass"] = 101;

    $redirectUrl = $member['role_no'] == 3 ? 'app' : 'supervisior';

    echo json_encode([
        'status' => 'success',
        'message' => 'เข้าสู่ระบบสำเร็จ! กำลังพาท่านไปยังหน้าแรก...',
        'redirect' => $redirectUrl,
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ไม่สามารถเข้าสู่ระบบได้! โปรดตรวจสอบชื่อผู้ใช้และรหัสผ่าน',
    ]);
}
?>