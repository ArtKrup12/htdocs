<?php

// เปิด Session และเชื่อมต่อกับฐานข้อมูล
session_start();
include "../../config/connect.php";

// ปรับ SQL Query เพื่อรองรับหลายสถานะ
$sql_badge = "
    SELECT 
        COUNT(CASE WHEN assign_status IN (21, 22) THEN 1 END) AS assign,
        COUNT(CASE WHEN assign_status IN (31, 32) THEN 1 END) AS onprocess,
        COUNT(CASE WHEN assign_status IN (51, 52) THEN 1 END) AS unsuccess,
        COUNT(CASE WHEN assign_status IN (41, 42, 61, 62) THEN 1 END) AS success
    FROM 
        tb_assign 
    WHERE 
        tb_assign.delegatee_id = '" . $_SESSION['Member_IdLogin'] . "';
";

// รันคำสั่ง SQL
$query_badge = $mysqli->query($sql_badge);

// ดึงผลลัพธ์จาก Query
$row_badge = mysqli_fetch_object($query_badge);

// สร้างผลลัพธ์ที่จะแสดง
$result = array(
    'all' => $row_badge->assign + $row_badge->onprocess + $row_badge->unsuccess + $row_badge->success,
    'assign' => $row_badge->assign,
    'onprocess' => $row_badge->onprocess,
    'success' => $row_badge->success,
    'unsuccess' => $row_badge->unsuccess,
);

// ส่งผลลัพธ์ในรูปแบบ JSON
echo json_encode($result);

?>
