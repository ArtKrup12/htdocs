<?php

include "../../config/connect.php";

// นับจำนวนผู้ใช้งานในแต่ละ role โดยที่ emp_status != 99
$checkQuery = "
    SELECT role_no, COUNT(*) AS count 
    FROM tb_employee 
    WHERE emp_status != '99' 
    GROUP BY role_no
";
$result = mysqli_query($mysqli, $checkQuery);

// ถ้าคิวรีสำเร็จ
if ($result) {
    // เก็บข้อมูลจำนวนผู้ใช้งานในแต่ละ role
    $roleCounts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // แปลง role_no เป็นคำที่ต้องการ
        switch ($row['role_no']) {
            case 1:
                $roleName = 'admin';
                break;
            case 2:
                $roleName = 'super';
                break;
            case 3:
                $roleName = 'emp';
                break;
            default:
                $roleName = 'unknown';
                break;
        }

        // เก็บจำนวนผู้ใช้งานในแต่ละ role (แสดงเป็นตัวเลข)
        $roleCounts[$roleName] = $row['count'];
    }

    // ส่งผลลัพธ์ออกเป็น JSON
    echo json_encode($roleCounts);
} else {
    echo json_encode(['error' => 'Error: ' . mysqli_error($mysqli)]);
}
?>
